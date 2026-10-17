<?php

namespace App\Http\Livewire\Public\Tools;

use Livewire\Component;
use App\Classes\BacklinkCheckerClass;
use App\Models\Admin\General;
use App\Rules\VerifyRecaptcha;
use Illuminate\Support\Facades\RateLimiter;

class BacklinkChecker extends Component
{
    public $link;
    public $compare;
    public $data = [];
    public $comparison = [];
    public $backlinks = [];
    public $linksLoaded = false;
    public $hasMoreLinks = false;
    public $linkSearch = '';
    public $linkType = 'all';
    public $linkSort = 'authority';
    public $recaptcha;
    public $generalSettings;

    public function mount()
    {
        $this->generalSettings = General::first();
    }

    public function render()
    {
        $filtered = collect($this->backlinks)->filter(function ($row) {
            $matchesType = $this->linkType === 'all'
                || ($this->linkType === 'nofollow' && $row['nofollow'])
                || ($this->linkType === 'follow' && !$row['nofollow']);
            $search = mb_strtolower(trim((string) $this->linkSearch));
            return $matchesType && ($search === '' || str_contains(mb_strtolower($row['source'] . ' ' . $row['target'] . ' ' . $row['anchor']), $search));
        });
        $filtered = $this->linkSort === 'recent'
            ? $filtered->sortByDesc('last_seen') : $filtered->sortByDesc('domain_authority');
        return view('livewire.public.tools.backlink-checker', ['filteredLinks' => $filtered->values()]);
    }

    private function allowLookup(): bool
    {
        $key = 'backlink-lookup:' . hash('sha256', request()->ip());
        if (RateLimiter::tooManyAttempts($key, 10)) {
            $this->addError('error', __('Please wait a minute before requesting another backlink report.'));
            return false;
        }
        RateLimiter::hit($key, 60);
        return true;
    }

    public function onBacklinkChecker()
    {
        $this->resetErrorBag();
        $rules = ['link' => 'required|string|max:255', 'compare' => 'nullable|string|max:255'];
        if ($this->generalSettings->captcha_status && ($this->generalSettings->captcha_for_registered || !auth()->check())) {
            $rules['recaptcha'] = ['required', new VerifyRecaptcha];
        }
        $this->validate($rules);
        try {
            $domain = BacklinkCheckerClass::normalizeDomain($this->link);
            $compare = trim((string) $this->compare) !== '' ? BacklinkCheckerClass::normalizeDomain($this->compare) : null;
        } catch (\InvalidArgumentException $e) {
            $this->addError('error', $e->getMessage());
            return;
        }
        if (!$this->allowLookup()) return;
        $this->reset(['data', 'comparison', 'backlinks', 'linksLoaded', 'hasMoreLinks', 'linkSearch', 'linkType', 'linkSort']);
        session()->forget('backlink-report.' . $this->id);
        $service = new BacklinkCheckerClass();
        try {
            $this->data = $service->get_data($domain);
            session()->put('backlink-report.' . $this->id, $this->data['link']);
            // Usage logging must not prevent a valid report from reaching the visitor.
            try {
                $history = new \App\Models\Admin\History();
                $history->tool_name = 'Backlink Checker';
                $history->client_ip = request()->ip();
                $history->save();
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('Backlink usage history could not be saved.');
            }
            if ($compare) {
                $this->comparison = $compare === $domain ? $this->data : $service->get_data($compare);
            }
        } catch (\RuntimeException $e) {
            $this->addError('error', $e->getMessage());
        } finally {
            $this->dispatchBrowserEvent('resetReCaptcha');
        }
    }

    public function loadBacklinks()
    {
        $this->resetErrorBag();
        $domain = session('backlink-report.' . $this->id);
        if (!$domain || $domain !== ($this->data['link'] ?? null) || !$this->allowLookup()) return;
        try {
            $result = (new BacklinkCheckerClass())->get_links($domain);
            $this->backlinks = $result['links'];
            $this->hasMoreLinks = $result['has_more'];
            $this->linksLoaded = true;
        } catch (\RuntimeException | \InvalidArgumentException $e) {
            $this->addError('error', $e->getMessage());
        }
    }

    private static function csvCell($value): string
    {
        $value = (string) ($value ?? '');
        return preg_match('/^[\s]*[=+@-]/u', $value) ? "'" . $value : $value;
    }

    public function exportCsv()
    {
        if (empty($this->data)) return;
        $data = $this->data;
        $comparison = $this->comparison;
        $backlinks = $this->backlinks;
        return response()->streamDownload(function () use ($data, $comparison, $backlinks) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Domain', 'Domain Authority', 'Referring domains', 'External linking pages', 'Nofollow linking pages', 'Report retrieved (UTC)'], ',', '"', '');
            foreach (array_filter([$data, $comparison]) as $row) {
                fputcsv($file, array_map([self::class, 'csvCell'], [$row['link'], $row['domain_authority'], $row['linking_domains'], $row['total_links'], $row['nofollow_links'], $row['checked_at']]), ',', '"', '');
            }
            if ($backlinks) {
                fputcsv($file, [], ',', '"', '');
                fputcsv($file, ['Source page', 'Target page', 'Anchor text', 'Source DA', 'Link attribute', 'Redirect involved', 'First seen', 'Last seen'], ',', '"', '');
                foreach ($backlinks as $row) {
                    fputcsv($file, array_map([self::class, 'csvCell'], [$row['source'], $row['target'], $row['anchor'], $row['domain_authority'], $row['nofollow'] ? 'nofollow' : 'follow', $row['redirect'] ? 'yes' : 'no', $row['first_seen'], $row['last_seen']]), ',', '"', '');
                }
            }
            fclose($file);
        }, 'backlink-report.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function onSample()
    {
        $this->link = 'moz.com';
        $this->compare = '';
    }

    public function onReset()
    {
        session()->forget('backlink-report.' . $this->id);
        $this->reset(['link', 'compare', 'data', 'comparison', 'backlinks', 'linksLoaded', 'hasMoreLinks', 'linkSearch', 'linkType', 'linkSort', 'recaptcha']);
        $this->resetErrorBag();
    }
}
