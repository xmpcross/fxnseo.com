<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddBacklinkMonitoringGuidePage extends Migration
{
    public function up()
    {
        $now = now();
        $page = DB::table('pages')->where('slug', 'backlink-monitoring-guide')->first();

        $pageId = $page ? $page->id : DB::table('pages')->insertGetId([
            'slug' => 'backlink-monitoring-guide',
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

        $description = <<<'HTML'
<div class="pillar-guide">
  <aside class="pillar-toc" aria-labelledby="pillarTocTitle">
    <h2 id="pillarTocTitle">In this guide</h2>
    <ol>
      <li><a href="#what-is-backlink-monitoring">What backlink monitoring means</a></li>
      <li><a href="#why-monitor-backlinks">Why backlinks need monitoring</a></li>
      <li><a href="#metrics-to-track">Metrics that matter</a></li>
      <li><a href="#monitoring-workflow">A repeatable workflow</a></li>
      <li><a href="#choose-software">Choosing tracking software</a></li>
      <li><a href="#common-problems">Common backlink problems</a></li>
      <li><a href="#backlink-faq">Frequently asked questions</a></li>
    </ol>
  </aside>

  <div class="pillar-body">
    <section class="pillar-intro">
      <p class="pillar-lead">Backlinks can strengthen rankings, referral traffic, and brand authority—but only while they remain live, relevant, and correctly attributed. This guide explains how to build a practical monitoring system that finds changes early and turns backlink data into useful SEO decisions.</p>
      <div class="pillar-takeaways">
        <div><strong>Monitor</strong><span>new, lost, and changed links</span></div>
        <div><strong>Evaluate</strong><span>authority, relevance, and risk</span></div>
        <div><strong>Act</strong><span>reclaim value and protect growth</span></div>
      </div>
    </section>

    <section id="what-is-backlink-monitoring">
      <span class="pillar-step">01 · Foundations</span>
      <h2>What is backlink monitoring?</h2>
      <p>Backlink monitoring is the ongoing process of discovering links that point to your website and checking whether those links remain available, indexable, relevant, and valuable. A backlink monitor records changes over time instead of providing only a one-time snapshot.</p>
      <p>A standard <strong>SEO backlink checker</strong> answers “Which sites link to me right now?” Monitoring adds the historical layer: “Which links appeared, disappeared, changed destination, became nofollow, or moved to a different page?” That difference turns a list of URLs into an operating system for link maintenance.</p>
      <div class="pillar-callout"><strong>Start with a current snapshot.</strong><p>Use the free <a href="/backlink-checker">Backlink Checker</a> to inspect a domain, then establish a recurring schedule for the links that matter most.</p></div>
    </section>

    <section id="why-monitor-backlinks">
      <span class="pillar-step">02 · Business value</span>
      <h2>Why backlink monitoring matters</h2>
      <div class="pillar-card-grid">
        <article><span>↗</span><h3>Protect earned authority</h3><p>Editorial links can disappear during redesigns, migrations, content pruning, or accidental URL changes. Early detection makes link reclamation more likely.</p></article>
        <article><span>◎</span><h3>Measure link-building work</h3><p>Track whether outreach, digital PR, partnerships, and content campaigns produce lasting links—not just initial placements.</p></article>
        <article><span>⌁</span><h3>Spot reputation risks</h3><p>Review suspicious link spikes, irrelevant domains, hacked pages, and manipulative anchors before they distort reporting or require investigation.</p></article>
        <article><span>◇</span><h3>Find growth patterns</h3><p>New-link trends reveal topics, assets, and pages that naturally attract citations so you can invest in what is already working.</p></article>
      </div>
    </section>

    <section id="metrics-to-track">
      <span class="pillar-step">03 · Measurement</span>
      <h2>The backlink metrics worth tracking</h2>
      <div class="pillar-table-wrap"><table><thead><tr><th>Metric</th><th>What it tells you</th><th>Recommended action</th></tr></thead><tbody>
        <tr><td>Link status</td><td>Whether the source page and link still resolve</td><td>Reclaim important lost or broken links</td></tr>
        <tr><td>Referring domain</td><td>The website responsible for the link</td><td>Prioritize relevant, trusted domains</td></tr>
        <tr><td>Target URL</td><td>Which page receives authority and traffic</td><td>Fix redirects and recover deleted targets</td></tr>
        <tr><td>Anchor text</td><td>The clickable context surrounding the link</td><td>Watch for misleading or over-optimized patterns</td></tr>
        <tr><td>Follow attribute</td><td>Whether the link can pass conventional ranking signals</td><td>Record changes without dismissing valuable nofollow traffic</td></tr>
        <tr><td>First/last seen</td><td>When the link entered or left the index</td><td>Connect changes to campaigns and site events</td></tr>
      </tbody></table></div>
    </section>

    <section id="monitoring-workflow">
      <span class="pillar-step">04 · Process</span>
      <h2>A repeatable backlink monitoring workflow</h2>
      <div class="pillar-workflow">
        <article><b>1</b><div><h3>Build a baseline</h3><p>Export links from Google Search Console and at least one independent crawler. Normalize domains, source URLs, target URLs, anchors, attributes, and discovery dates.</p></div></article>
        <article><b>2</b><div><h3>Set the right frequency</h3><p>Weekly checks suit active outreach and fast-moving sites. Monthly checks are usually enough for stable small-business sites. Read <a href="/blog/how-often-monitor-backlinks">how often to monitor backlinks</a> for a practical cadence.</p></div></article>
        <article><b>3</b><div><h3>Classify every change</h3><p>Separate genuinely lost links from temporary errors, crawler gaps, redirect changes, canonical changes, and pages blocked from indexing.</p></div></article>
        <article><b>4</b><div><h3>Prioritize by impact</h3><p>Start with high-relevance editorial links, pages that drive referral traffic, and links pointing to revenue or conversion pages.</p></div></article>
        <article><b>5</b><div><h3>Recover and document</h3><p>Contact the publisher with the correct replacement URL, repair your redirect, restore a useful resource, or update internal reporting. Record the outcome.</p></div></article>
      </div>
    </section>

    <section id="choose-software">
      <span class="pillar-step">05 · Tools</span>
      <h2>How to choose backlink tracking software</h2>
      <p>The best <strong>backlink tracking software</strong> is not necessarily the platform with the largest headline index. Choose the system that matches your site size, reporting needs, and response workflow.</p>
      <div class="pillar-compare">
        <article><h3>Free checks</h3><p>Best for occasional research, small sites, and validating a specific domain or URL.</p><ul><li>Low setup time</li><li>Useful current snapshot</li><li>Limited history and alerts</li></ul></article>
        <article class="is-featured"><span>Best for ongoing SEO</span><h3>Dedicated monitoring</h3><p>Best for teams that need scheduled checks, change history, alerts, exports, and campaign reporting.</p><ul><li>New and lost-link alerts</li><li>Historical comparison</li><li>Team-ready reporting</li></ul></article>
        <article><h3>Enterprise suites</h3><p>Best when backlink intelligence must connect to rankings, competitors, content, and large-scale reporting.</p><ul><li>Broader competitive index</li><li>APIs and integrations</li><li>Higher cost and complexity</li></ul></article>
      </div>
      <p>Before paying, compare coverage against links you already know exist. Evaluate crawl freshness, export limits, alert controls, pricing by monitored domains, and whether the interface makes follow-up work easier. Our guide to <a href="/blog/check-backlinks-for-free">checking backlinks for free</a> explains where no-cost tools help and where their limits begin.</p>
    </section>

    <section id="common-problems">
      <span class="pillar-step">06 · Troubleshooting</span>
      <h2>Common backlink problems and what to do</h2>
      <div class="pillar-problems">
        <details open><summary>A valuable link disappears</summary><p>Confirm the source page is live, check whether the content moved, and inspect the publisher's redirects. If the citation still makes sense, send a concise reclamation request with the correct URL.</p></details>
        <details><summary>The target page returns 404</summary><p>Restore the resource when it still serves users, or redirect the old URL to the closest relevant replacement. Avoid sending every broken URL to the homepage.</p></details>
        <details><summary>A followed link becomes nofollow</summary><p>Check whether the publisher changed sitewide policy. The link may still provide discovery, referral traffic, and credibility, so judge it by more than its attribute.</p></details>
        <details><summary>Suspicious links appear suddenly</summary><p>Review the domains, anchors, traffic, and scale of the pattern. Most low-quality links can be documented and ignored; investigate further before taking drastic action.</p></details>
      </div>
    </section>

    <section id="backlink-faq" class="pillar-faq">
      <span class="pillar-step">07 · FAQ</span>
      <h2>Backlink monitoring questions</h2>
      <details><summary>How often should backlinks be checked?</summary><p>Check weekly during active campaigns and monthly for stable sites. Monitor your most valuable placements more frequently when losing them would materially affect traffic or authority.</p></details>
      <details><summary>What is the difference between a backlink checker and a backlink monitor?</summary><p>A checker discovers links at a point in time. A monitor repeats that discovery, stores history, compares changes, and alerts you when links are gained, lost, or modified.</p></details>
      <details><summary>Can Google Search Console replace backlink tracking software?</summary><p>Search Console is an essential first-party source, but it provides a sampled view and limited change tracking. Dedicated software adds competitive research, historical comparisons, and automated alerts.</p></details>
      <details><summary>Should every lost backlink be reclaimed?</summary><p>No. Prioritize relevant editorial links, meaningful referral sources, and strong placements. Ignore links from obsolete, duplicated, or low-value pages when recovery effort would exceed likely benefit.</p></details>
    </section>

    <section class="pillar-cta">
      <span>Put the guide into practice</span>
      <h2>Start with a backlink snapshot.</h2>
      <p>Check a domain, identify its referring links, and build the baseline for your monitoring workflow.</p>
      <a href="/backlink-checker">Open the Backlink Checker <span>→</span></a>
    </section>
  </div>
</div>
HTML;

        DB::table('page_translations')->updateOrInsert(
            ['page_id' => $pageId, 'locale' => 'en'],
            [
                'page_title' => 'The Complete Guide to Backlink Monitoring',
                'robots_meta' => 1,
                'sitename_status' => 1,
                'title' => 'The Complete Guide to Backlink Monitoring',
                'subtitle' => 'Build a reliable system for finding new links, recovering lost authority, evaluating link quality, and choosing the right tracking software.',
                'short_description' => 'Learn how to monitor backlinks, use an SEO backlink checker, evaluate link changes, and choose backlink tracking software.',
                'description' => $description,
                'updated_at' => $now,
            ]
        );
    }

    public function down()
    {
        $page = DB::table('pages')->where('slug', 'backlink-monitoring-guide')->first();
        if ($page) {
            DB::table('page_translations')->where('page_id', $page->id)->delete();
            DB::table('pages')->where('id', $page->id)->delete();
        }
    }
}
