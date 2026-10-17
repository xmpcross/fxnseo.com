<?php

namespace Tests\Feature;

use App\Classes\BacklinkCheckerClass;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class BacklinkCheckerTest extends TestCase
{
    private function service(): BacklinkCheckerClass
    {
        return new class extends BacklinkCheckerClass {
            protected function credentials()
            {
                return (object) ['moz_access_id' => 'test-access', 'moz_secret_key' => 'test-secret'];
            }
        };
    }

    public function test_domain_normalization_accepts_full_urls_and_modern_tlds()
    {
        $this->assertSame('example.technology', BacklinkCheckerClass::normalizeDomain('https://EXAMPLE.technology/a?b=c#d'));
        $this->assertSame('example.com', BacklinkCheckerClass::normalizeDomain('example.com'));
    }

    public function test_non_web_schemes_and_embedded_credentials_are_rejected()
    {
        foreach (['file://example.com/path', 'https://user:pass@example.com', 'localhost', '127.0.0.1', 'https://example.com:8080'] as $target) {
            try {
                BacklinkCheckerClass::normalizeDomain($target);
                $this->fail('Invalid target accepted: ' . $target);
            } catch (\InvalidArgumentException $e) {
                $this->assertNotEmpty($e->getMessage());
            }
        }
    }

    public function test_root_domain_metrics_preserve_zero_values_and_are_cached()
    {
        Http::fake(['lsapi.seomoz.com/v2/url_metrics' => Http::response(['results' => [[
            'domain_authority' => 0, 'root_domains_to_root_domain' => 0,
            'external_pages_to_root_domain' => 0, 'external_nofollow_pages_to_root_domain' => 0,
        ]]], 200)]);
        $service = $this->service();
        $data = $service->get_data('https://example.com/page');
        $this->assertSame(0, $data['domain_authority']);
        $this->assertSame(0, $data['total_links']);
        $this->assertSame('example.com', $data['link']);
        $this->assertNotEmpty($data['checked_at']);
        $this->assertSame($data, $service->get_data('example.com'));
        Http::assertSentCount(1);
    }

    public function test_provider_errors_do_not_expose_credentials_or_raw_responses()
    {
        Http::fake(['*' => Http::response(['error' => 'sensitive-provider-message test-secret'], 403)]);
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('This report is currently unavailable from our data provider.');
        $this->service()->get_data('example.com');
    }

    public function test_empty_provider_response_is_not_displayed_as_a_successful_report()
    {
        Http::fake(['*' => Http::response(['results' => []], 200)]);
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('No backlink metrics were returned');
        $this->service()->get_data('example.com');
    }

    public function test_backlink_sample_is_bounded_and_preserves_link_attributes()
    {
        Http::fake(['*' => Http::response(['results' => [[
            'source' => ['page' => 'source.example/page', 'domain_authority' => 42],
            'target' => ['page' => 'example.com/page'], 'anchor_text' => 'Example',
            'nofollow' => true, 'via_redirect' => true, 'date_last_seen' => '2026-10-16',
        ]], 'next_token' => 'more'], 200)]);
        $data = $this->service()->get_links('example.com');
        $this->assertTrue($data['has_more']);
        $this->assertTrue($data['links'][0]['nofollow']);
        $this->assertTrue($data['links'][0]['redirect']);
        $this->assertSame(42, $data['links'][0]['domain_authority']);
        Http::assertSent(function ($request) {
            return $request->url() === 'https://lsapi.seomoz.com/v2/links'
                && $request['limit'] === 25 && $request['target_scope'] === 'root_domain';
        });
    }
    public function test_source_links_allow_only_web_urls()
    {
        $this->assertSame('https://example.com/page', BacklinkCheckerClass::safePageUrl('example.com/page'));
        $this->assertNull(BacklinkCheckerClass::safePageUrl('javascript:alert(1)'));
        $this->assertNull(BacklinkCheckerClass::safePageUrl('data:text/html,test'));
        $this->assertNull(BacklinkCheckerClass::safePageUrl(''));
    }

    public function test_csv_cells_do_not_execute_spreadsheet_formulas()
    {
        $method = new \ReflectionMethod(\App\Http\Livewire\Public\Tools\BacklinkChecker::class, 'csvCell');
        $method->setAccessible(true);
        $this->assertSame("'=1+1", $method->invoke(null, '=1+1'));
        $this->assertSame("'  @SUM(A1)", $method->invoke(null, '  @SUM(A1)'));
        $this->assertSame('Example', $method->invoke(null, 'Example'));
    }

}
