<?php

namespace App\Classes;

use App\Models\Admin\ApiKeys;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use InvalidArgumentException;
use RuntimeException;

class BacklinkCheckerClass
{
    public static function normalizeDomain($input): string
    {
        $input = trim((string) $input);
        if (!preg_match('#^[a-z][a-z0-9+.-]*://#i', $input)) {
            $input = 'https://' . $input;
        }
        $parts = parse_url($input);
        $host = strtolower(rtrim($parts['host'] ?? '', '.'));
        if (function_exists('idn_to_ascii')) {
            $host = idn_to_ascii($host, IDNA_DEFAULT, INTL_IDNA_VARIANT_UTS46) ?: $host;
        }
        if (!in_array(strtolower($parts['scheme'] ?? ''), ['http', 'https'], true)
            || isset($parts['user']) || isset($parts['pass']) || isset($parts['port'])
            || !str_contains($host, '.') || !filter_var($host, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME)
            || filter_var($host, FILTER_VALIDATE_IP)) {
            throw new InvalidArgumentException(__('Enter a valid public website domain, such as example.com.'));
        }
        return $host;
    }

    public static function safePageUrl($page): ?string
    {
        $page = trim((string) $page);
        if ($page === '') return null;
        $url = preg_match('#^[a-z][a-z0-9+.-]*:#i', $page) ? $page : 'https://' . $page;
        return preg_match('#^https?://#i', $url) && filter_var($url, FILTER_VALIDATE_URL) ? $url : null;
    }

    protected function credentials()
    {
        return ApiKeys::find(1);
    }

    protected function request(string $endpoint, array $payload): array
    {
        $keys = $this->credentials();
        if (!$keys || empty($keys->moz_access_id) || empty($keys->moz_secret_key)) {
            throw new RuntimeException(__('Backlink data is temporarily unavailable. Please try again later.'));
        }
        $cacheKey = 'backlinks:v2:' . hash('sha256', $keys->moz_access_id . $endpoint . json_encode($payload));
        return Cache::remember($cacheKey, 600, function () use ($keys, $endpoint, $payload) {
            try {
                $response = Http::withBasicAuth($keys->moz_access_id, $keys->moz_secret_key)
                    ->acceptJson()->withOptions(['connect_timeout' => 5])->timeout(20)
                    ->post('https://lsapi.seomoz.com/v2/' . $endpoint, $payload);
            } catch (\Throwable $e) {
                throw new RuntimeException(__('The backlink provider could not be reached. Please try again shortly.'));
            }
            if (!$response->successful()) {
                if (in_array($response->status(), [401, 403])) {
                    throw new RuntimeException(__('This report is currently unavailable from our data provider. Please try another SEO tool below.'));
                }
                if ($response->status() === 429) {
                    throw new RuntimeException(__('The backlink service has reached its request limit. Please try again later.'));
                }
                throw new RuntimeException(__('The backlink provider could not complete this report. Please try again later.'));
            }
            $json = $response->json();
            if (!is_array($json) || !isset($json['results']) || !is_array($json['results'])) {
                throw new RuntimeException(__('The backlink provider returned an incomplete report. Please try again later.'));
            }
            $json['checked_at'] = now()->toIso8601String();
            return $json;
        });
    }

    public function get_data($link): array
    {
        $domain = self::normalizeDomain($link);
        $response = $this->request('url_metrics', ['targets' => [$domain]]);
        $metrics = $response['results'][0] ?? null;
        if (!is_array($metrics) || !array_key_exists('domain_authority', $metrics)) {
            throw new RuntimeException(__('No backlink metrics were returned for this domain.'));
        }
        return [
            'link' => $domain,
            'domain_authority' => $metrics['domain_authority'],
            'linking_domains' => $metrics['root_domains_to_root_domain'] ?? null,
            'total_links' => $metrics['external_pages_to_root_domain'] ?? null,
            'nofollow_links' => $metrics['external_nofollow_pages_to_root_domain'] ?? null,
            'checked_at' => $response['checked_at'],
        ];
    }

    public function get_links($link): array
    {
        $domain = self::normalizeDomain($link);
        $response = $this->request('links', [
            'target' => $domain, 'target_scope' => 'root_domain',
            'filter' => 'external', 'limit' => 25,
        ]);
        $links = [];
        foreach ($response['results'] as $row) {
            $links[] = [
                'source' => $row['source']['page'] ?? '',
                'target' => $row['target']['page'] ?? '',
                'anchor' => $row['anchor_text'] ?? '',
                'domain_authority' => $row['source']['domain_authority'] ?? null,
                'nofollow' => !empty($row['nofollow']),
                'redirect' => !empty($row['redirect']) || !empty($row['via_redirect']),
                'first_seen' => $row['date_first_seen'] ?? null,
                'last_seen' => $row['date_last_seen'] ?? null,
            ];
        }
        return ['links' => $links, 'has_more' => !empty($response['next_token']), 'checked_at' => $response['checked_at']];
    }
}
