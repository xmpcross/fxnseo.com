<?php

namespace Tests\Feature;

use Tests\TestCase;

class PublicSeoTest extends TestCase
{
    public function test_homepage_emits_shared_canonical_social_and_structured_data()
    {
        $response = $this->get('https://fxnseo.com/');
        $response->assertOk()->assertSee('<link rel="canonical" href="https://fxnseo.com">', false)
            ->assertSee('property="og:title"', false)->assertSee('application/ld+json', false)
            ->assertSee('"@type":"Organization"', false);
    }

    public function test_admin_login_is_noindex_and_does_not_canonicalize_to_home()
    {
        $this->get('https://fxnseo.com/admin/login')->assertOk()
            ->assertSee('content="noindex, nofollow"', false)
            ->assertSee('<link rel="canonical" href="https://fxnseo.com/admin/login">', false);
    }

    public function test_blog_pagination_has_crawlable_links_and_a_self_canonical()
    {
        $this->get('https://fxnseo.com/blog')->assertOk()
            ->assertSee('href="https://fxnseo.com/blog?page=2"', false);
        $this->get('https://fxnseo.com/blog?page=2')->assertOk()
            ->assertSee('<link rel="canonical" href="https://fxnseo.com/blog?page=2">', false);
    }

    public function test_filtered_blog_results_are_noindex()
    {
        $this->get('https://fxnseo.com/blog?search=redirect')->assertOk()
            ->assertSee('content="noindex, follow"', false);
    }

    public function test_article_only_advertises_existing_translations()
    {
        $this->get('https://fxnseo.com/blog/youtube-titles-descriptions-checklist')->assertOk()
            ->assertSee('hreflang="en"', false)->assertDontSee('hreflang="de"', false)
            ->assertDontSee('hreflang="es"', false)->assertDontSee('hreflang="fr"', false)
            ->assertDontSee('hreflang="it"', false);
    }

    public function test_sitemap_lists_hubs_and_omits_untranslated_homepage_variants()
    {
        $response = $this->get('https://fxnseo.com/sitemap.xml');
        $response->assertOk()->assertSee('<loc>https://fxnseo.com/tools</loc>', false)
            ->assertSee('<loc>https://fxnseo.com/blog</loc>', false)
            ->assertDontSee('<loc>https://fxnseo.com/de</loc>', false);
    }
}
