<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddAffiliateDisclosurePage extends Migration
{
    public function up()
    {
        $now = now();
        $page = DB::table('pages')->where('slug', 'affiliate-disclosure')->first();

        if (!$page) {
            $pageId = DB::table('pages')->insertGetId([
                'slug' => 'affiliate-disclosure',
                'target' => '_self',
                'type' => 'page',
                'post_status' => 1,
                'page_status' => 1,
                'tool_status' => 1,
                'ads_status' => 0,
                'popular' => 0,
                'position' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        } else {
            $pageId = $page->id;
        }

        $description = <<<'HTML'
<p><strong>Last updated: August 13, 2026</strong></p>
<h2>The Short Version</h2>
<p>fxnSEOTools may include affiliate links in articles, guides, tool recommendations, or other content. If you follow an affiliate link and complete a purchase, we may receive a commission from the retailer or service provider. This does not increase the price you pay.</p>
<h2>How Affiliate Relationships Work</h2>
<p>Affiliate programs allow publishers to earn a referral fee when a reader purchases a product or service through a specially tracked link. These commissions can help support the operation, maintenance, research, and continued development of fxnSEOTools.</p>
<p>Affiliate partnerships may change over time. A link that is not currently monetized may become an affiliate link later, and an existing affiliate relationship may end without notice.</p>
<h2>Editorial Independence</h2>
<p>Compensation does not determine the conclusions, explanations, or recommendations published on fxnSEOTools. We aim to present useful and accurate information based on relevance to our readers. We may mention products or services for which we receive no compensation, and we may choose not to recommend an affiliate partner when we believe another option is more appropriate.</p>
<p>Where several providers offer a similar product or service, an affiliate relationship may influence which retailer link is provided, but it does not change our assessment of the underlying product or service.</p>
<h2>Identifying Commercial Links</h2>
<p>Where appropriate, pages containing affiliate links may include a visible disclosure near the relevant content. Affiliate links may also use attributes such as <code>rel=&quot;sponsored nofollow&quot;</code> so that search engines can recognize their commercial nature.</p>
<h2>Prices, Availability, and Third-Party Sites</h2>
<p>Prices, offers, product details, and availability can change at any time. Information displayed on fxnSEOTools is provided for general reference and may not reflect the current terms shown by a retailer or service provider. Please verify all details directly on the third-party website before making a purchase.</p>
<p>When you follow an external link, your purchase and any related support, cancellation, return, warranty, or refund request are governed by the third party's terms. fxnSEOTools is not the seller and is not a party to that transaction.</p>
<h2>No Additional Cost to You</h2>
<p>Affiliate commissions are paid by the participating retailer or service provider. Using an affiliate link should not add an extra charge to your order, although the final price, taxes, fees, and delivery costs are determined entirely by the third party.</p>
<h2>Questions</h2>
<p>If you have a question about an affiliate link or believe a commercial relationship has not been disclosed clearly, please <a href="/contact">contact us</a>. We value transparency and will review the relevant content.</p>
HTML;

        DB::table('page_translations')->updateOrInsert(
            ['page_id' => $pageId, 'locale' => 'en'],
            [
                'page_title' => 'Affiliate Disclosure',
                'robots_meta' => 0,
                'sitename_status' => 1,
                'title' => 'Affiliate Disclosure',
                'subtitle' => 'How affiliate links support fxnSEOTools and how we protect editorial independence',
                'short_description' => 'Learn how affiliate links work on fxnSEOTools, what they may influence, and what they never change.',
                'description' => $description,
            ]
        );
    }

    public function down()
    {
        $page = DB::table('pages')->where('slug', 'affiliate-disclosure')->first();
        if ($page) {
            DB::table('page_translations')->where('page_id', $page->id)->delete();
            DB::table('pages')->where('id', $page->id)->delete();
        }
    }
}
