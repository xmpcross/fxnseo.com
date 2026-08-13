<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddLinkOpportunityAndSeoAuditPillarPages extends Migration
{
    public function up()
    {
        $this->upsertPage(
            'link-opportunity-guide',
            'Link Building Opportunity Guide',
            'A practical system for link prospecting, qualifying websites, finding repeatable outreach angles, and turning research into relevant backlinks.',
            'Learn link prospecting from discovery through qualification and outreach with a repeatable link opportunity finder workflow.',
            $this->linkOpportunityContent()
        );

        $this->upsertPage(
            'seo-audit-guide',
            'SEO Audit & Reporting Hub',
            'Build an SEO audit workflow that connects technical findings, backlink reporting, priorities, and clear white-label reports.',
            'Learn how to use an SEO audit tool, organize backlink reporting, and create useful white-label SEO reports.',
            $this->seoAuditContent()
        );
    }

    private function upsertPage($slug, $title, $subtitle, $description, $content)
    {
        $now = now();
        $page = DB::table('pages')->where('slug', $slug)->first();
        $pageId = $page ? $page->id : DB::table('pages')->insertGetId([
            'slug' => $slug, 'target' => '_self', 'type' => 'page',
            'post_status' => 1, 'page_status' => 1, 'tool_status' => 1,
            'ads_status' => 0, 'popular' => 0, 'position' => 1,
            'created_at' => $now, 'updated_at' => $now,
        ]);

        DB::table('page_translations')->updateOrInsert(
            ['page_id' => $pageId, 'locale' => 'en'],
            [
                'page_title' => $title, 'robots_meta' => 1, 'sitename_status' => 1,
                'title' => $title, 'subtitle' => $subtitle,
                'short_description' => $description, 'description' => $content,
                'updated_at' => $now,
            ]
        );
    }

    private function linkOpportunityContent()
    {
        return <<<'HTML'
<div class="pillar-guide">
  <aside class="pillar-toc" aria-labelledby="linkTocTitle"><h2 id="linkTocTitle">In this guide</h2><ol>
    <li><a href="#what-is-link-prospecting">What link prospecting means</a></li>
    <li><a href="#opportunity-sources">Where opportunities come from</a></li>
    <li><a href="#prospect-qualification">How to qualify prospects</a></li>
    <li><a href="#prospecting-workflow">A repeatable workflow</a></li>
    <li><a href="#opportunity-finder">Choosing a finder</a></li>
    <li><a href="#outreach-system">From prospect to outreach</a></li>
    <li><a href="#link-opportunity-faq">Frequently asked questions</a></li>
  </ol></aside>
  <div class="pillar-body">
    <section class="pillar-intro"><p class="pillar-lead">Successful link building starts before the first email. It starts with finding websites where your expertise, data, tools, or content genuinely improves an existing page. This guide turns link prospecting into a focused research process instead of a race to collect the largest possible list.</p><div class="pillar-takeaways"><div><strong>Discover</strong><span>relevant sites and pages</span></div><div><strong>Qualify</strong><span>authority, fit, and intent</span></div><div><strong>Prioritize</strong><span>the strongest outreach angles</span></div></div></section>

    <section id="what-is-link-prospecting"><span class="pillar-step">01 · Foundations</span><h2>What is link prospecting?</h2><p><strong>Link prospecting</strong> is the process of finding and evaluating websites, pages, journalists, publishers, and organizations that may have a legitimate reason to link to your content. The objective is not to identify every website in a niche. It is to identify the subset where relevance, audience, editorial context, and your available asset overlap.</p><p>A useful prospect record includes the domain, exact target page, topic, author or editor, contact path, likely link angle, evidence of editorial standards, and a clear reason the link would help readers. This makes outreach specific and measurable.</p><div class="pillar-callout"><strong>Research the links that already work.</strong><p>Use the <a href="/backlink-checker">Backlink Checker</a> to study referring pages for competitors and comparable content before building your prospect list.</p></div></section>

    <section id="opportunity-sources"><span class="pillar-step">02 · Discovery</span><h2>Where strong link opportunities come from</h2><div class="pillar-card-grid"><article><span>⌕</span><h3>Competitor backlinks</h3><p>Find pages that already cite comparable companies, research, guides, or tools. Their linking behavior demonstrates topic interest.</p></article><article><span>◫</span><h3>Resource pages</h3><p>Look for curated lists, industry libraries, association pages, course materials, and recommended-tool collections that require useful additions.</p></article><article><span>↻</span><h3>Unlinked mentions</h3><p>Locate brand, product, research, and expert mentions that reference you without providing a navigable source link.</p></article><article><span>⚑</span><h3>Broken citations</h3><p>Find useful pages linking to expired resources, then offer a genuinely equivalent replacement that preserves the original context.</p></article><article><span>◉</span><h3>Journalist requests</h3><p>Contribute expert explanations, original data, examples, or commentary when a writer needs credible sources.</p></article><article><span>◇</span><h3>Linkable audiences</h3><p>Create assets for educators, researchers, publishers, communities, and professionals who routinely cite external evidence.</p></article></div></section>

    <section id="prospect-qualification"><span class="pillar-step">03 · Qualification</span><h2>How to qualify a link prospect</h2><div class="pillar-table-wrap"><table><thead><tr><th>Signal</th><th>Questions to ask</th><th>Why it matters</th></tr></thead><tbody><tr><td>Topical relevance</td><td>Does the site publish deeply in your subject?</td><td>Relevant links provide clearer context and a more suitable audience.</td></tr><tr><td>Editorial quality</td><td>Are articles original, maintained, and attributed?</td><td>Real editorial review separates publications from link-selling networks.</td></tr><tr><td>Page-level fit</td><td>Is there a natural section where your asset improves the page?</td><td>A precise placement reason makes outreach credible.</td></tr><tr><td>Organic visibility</td><td>Does the domain rank for meaningful topical queries?</td><td>Visibility can indicate search trust and potential referral discovery.</td></tr><tr><td>Outbound patterns</td><td>Does the site cite useful external sources naturally?</td><td>A site that never links externally is unlikely to change for your pitch.</td></tr><tr><td>Contactability</td><td>Can you identify the responsible writer or editor?</td><td>The right recipient matters more than a large generic mailing list.</td></tr></tbody></table></div></section>

    <section id="prospecting-workflow"><span class="pillar-step">04 · Process</span><h2>A repeatable link opportunity workflow</h2><div class="pillar-workflow"><article><b>1</b><div><h3>Define the page and audience</h3><p>Select the page you want to earn links to, identify who would cite it, and write down the value it offers that alternatives do not.</p></div></article><article><b>2</b><div><h3>Choose two discovery methods</h3><p>Combine a demonstrated source such as competitor backlinks with an open discovery source such as search operators, communities, or journalist requests.</p></div></article><article><b>3</b><div><h3>Collect page-level evidence</h3><p>Save the exact URL, relevant passage, author, last-updated date, and the reason your resource belongs there. Avoid domain-only lists.</p></div></article><article><b>4</b><div><h3>Score relevance before authority</h3><p>Use a simple score for topical fit, editorial quality, placement likelihood, audience value, and contact confidence.</p></div></article><article><b>5</b><div><h3>Group by outreach angle</h3><p>Separate broken-link replacements, resource additions, expert contributions, data citations, and relationship-based prospects so each message fits its context.</p></div></article></div></section>

    <section id="opportunity-finder"><span class="pillar-step">05 · Tools</span><h2>How to choose a link opportunity finder</h2><p>A useful <strong>link opportunity finder</strong> should reduce research time without hiding the evidence required for human judgment. Treat automated scores as filters, not final decisions.</p><div class="pillar-compare"><article><h3>Search-led research</h3><p>Best for precise niches and page types.</p><ul><li>Flexible search operators</li><li>Strong contextual control</li><li>More manual review</li></ul></article><article class="is-featured"><span>Best balanced workflow</span><h3>Backlink-led discovery</h3><p>Best for proven linking audiences and competitor gaps.</p><ul><li>Evidence of past links</li><li>Page and anchor context</li><li>Easy overlap analysis</li></ul></article><article><h3>Outreach platforms</h3><p>Best for teams managing discovery through follow-up.</p><ul><li>Contact enrichment</li><li>Pipeline organization</li><li>Automation needs oversight</li></ul></article></div><p>Evaluate export quality, index freshness, page-level filters, contact accuracy, list deduplication, collaboration features, and pricing. The tool should preserve enough context to explain why every prospect belongs on the list.</p></section>

    <section id="outreach-system"><span class="pillar-step">06 · Activation</span><h2>Turn opportunities into responsible outreach</h2><div class="pillar-problems"><details open><summary>Lead with the page-level reason</summary><p>Reference the exact article or resource and explain the reader problem your suggested addition solves. Generic praise does not demonstrate relevance.</p></details><details><summary>Offer evidence, not pressure</summary><p>Provide the useful asset, data source, correction, quotation, or replacement URL. Let the editor decide whether it strengthens the page.</p></details><details><summary>Use restrained follow-up</summary><p>One concise follow-up is often enough. Repeated messages to an uninterested publisher damage trust and deliver diminishing returns.</p></details><details><summary>Track outcomes by method</summary><p>Measure qualified prospects, replies, earned links, referral visits, and retained links. Compare outreach angles rather than celebrating email volume.</p></details></div></section>

    <section id="link-opportunity-faq" class="pillar-faq"><span class="pillar-step">07 · FAQ</span><h2>Link opportunity questions</h2><details><summary>How many prospects should a campaign include?</summary><p>Start with a small, well-qualified set. Twenty highly relevant page-level prospects can teach you more than hundreds of loosely filtered domains.</p></details><details><summary>Which metrics matter most for prospecting?</summary><p>Topical fit, editorial quality, page relevance, and placement likelihood should lead. Domain metrics are useful secondary filters, not substitutes for reviewing the site.</p></details><details><summary>Can link prospecting be automated?</summary><p>Discovery, enrichment, deduplication, and monitoring can be automated. Final qualification and the outreach angle still require human review.</p></details><details><summary>What makes a link opportunity legitimate?</summary><p>A legitimate opportunity exists when the destination helps the publisher's audience and the link fits naturally within editorial content.</p></details></section>

    <section class="pillar-cta"><span>Start with demonstrated opportunities</span><h2>Research the links your market already earns.</h2><p>Inspect competitor backlinks, identify relevant referring pages, and turn the strongest patterns into a qualified prospect list.</p><a href="/backlink-checker">Open the Backlink Checker <span>→</span></a></section>
  </div>
</div>
HTML;
    }

    private function seoAuditContent()
    {
        return <<<'HTML'
<div class="pillar-guide">
  <aside class="pillar-toc" aria-labelledby="auditTocTitle"><h2 id="auditTocTitle">In this hub</h2><ol>
    <li><a href="#what-is-an-seo-audit">What an SEO audit covers</a></li>
    <li><a href="#audit-framework">The audit framework</a></li>
    <li><a href="#audit-workflow">A repeatable workflow</a></li>
    <li><a href="#backlink-reporting">Backlink reporting</a></li>
    <li><a href="#white-label-reports">White-label reports</a></li>
    <li><a href="#choose-audit-tool">Choosing audit tools</a></li>
    <li><a href="#seo-audit-faq">Frequently asked questions</a></li>
  </ol></aside>
  <div class="pillar-body">
    <section class="pillar-intro"><p class="pillar-lead">An SEO audit should do more than produce a long list of warnings. It should explain what prevents search visibility, connect each finding to evidence and business impact, and give the team a prioritized path forward. This hub provides a practical structure for auditing, backlink reporting, and client-ready delivery.</p><div class="pillar-takeaways"><div><strong>Inspect</strong><span>technical, content, and authority signals</span></div><div><strong>Prioritize</strong><span>impact, confidence, and effort</span></div><div><strong>Report</strong><span>clear actions and measurable outcomes</span></div></div></section>

    <section id="what-is-an-seo-audit"><span class="pillar-step">01 · Foundations</span><h2>What is an SEO audit?</h2><p>An SEO audit is a structured evaluation of the factors affecting a website's organic discovery and performance. It combines technical crawling, indexation checks, on-page analysis, content evaluation, internal linking, structured data, performance, and off-site authority.</p><p>An <strong>SEO audit tool</strong> accelerates evidence collection, but the audit itself is the interpretation: which findings are real, which matter to this site, how they relate to one another, and what should happen first.</p><div class="pillar-callout"><strong>Use tools as evidence collectors.</strong><p>Explore the <a href="/tools">SEO tools library</a> for focused checks, generators, and diagnostics that support individual parts of your audit.</p></div></section>

    <section id="audit-framework"><span class="pillar-step">02 · Coverage</span><h2>A complete SEO audit framework</h2><div class="pillar-card-grid"><article><span>⌘</span><h3>Crawl and indexation</h3><p>Review status codes, robots directives, canonicals, XML sitemaps, crawl paths, index coverage, and accidental blocking.</p></article><article><span>⚡</span><h3>Performance and experience</h3><p>Assess Core Web Vitals, rendering, mobile usability, intrusive elements, accessibility barriers, and template-level bottlenecks.</p></article><article><span>¶</span><h3>Content and intent</h3><p>Map queries to pages, identify thin or overlapping content, assess freshness, and verify that pages satisfy their intended search task.</p></article><article><span>⌁</span><h3>Site architecture</h3><p>Evaluate navigation, internal links, click depth, orphan pages, breadcrumbs, taxonomy, and authority flow to important URLs.</p></article><article><span>↗</span><h3>Backlinks and authority</h3><p>Inspect referring domains, gained and lost links, anchors, target distribution, competitor gaps, and links to broken destinations.</p></article><article><span>✓</span><h3>Measurement quality</h3><p>Confirm analytics, conversions, Search Console, event tracking, annotations, and reporting definitions are dependable.</p></article></div></section>

    <section id="audit-workflow"><span class="pillar-step">03 · Process</span><h2>A repeatable SEO audit workflow</h2><div class="pillar-workflow"><article><b>1</b><div><h3>Define scope and success</h3><p>Document the business model, priority markets, conversions, important templates, recent migrations, known constraints, and the questions stakeholders need answered.</p></div></article><article><b>2</b><div><h3>Collect independent evidence</h3><p>Combine a crawler, Search Console, analytics, page-speed data, manual search checks, backlink sources, and CMS or server information.</p></div></article><article><b>3</b><div><h3>Validate findings manually</h3><p>Test representative URLs and templates. Remove false positives, group repeated issues by root cause, and preserve examples that demonstrate impact.</p></div></article><article><b>4</b><div><h3>Prioritize consistently</h3><p>Score each recommendation by expected impact, affected scale, confidence, effort, dependency, and implementation risk.</p></div></article><article><b>5</b><div><h3>Assign ownership and verify</h3><p>Translate recommendations into tasks, name an owner, define acceptance criteria, and schedule a post-release check.</p></div></article></div></section>

    <section id="backlink-reporting"><span class="pillar-step">04 · Authority</span><h2>Backlink reporting that supports decisions</h2><p>Useful <strong>backlink reporting</strong> explains change and significance instead of pasting an export into a spreadsheet. Start with a consistent baseline, then connect link changes to campaigns, content, rankings, referral traffic, and lost-page recovery.</p><div class="pillar-table-wrap"><table><thead><tr><th>Report section</th><th>Include</th><th>Decision supported</th></tr></thead><tbody><tr><td>Portfolio summary</td><td>Referring domains, total links, follow mix, and trend</td><td>Is authority moving in the right direction?</td></tr><tr><td>New links</td><td>Source page, target, anchor, quality, campaign</td><td>Which work earns durable coverage?</td></tr><tr><td>Lost links</td><td>Last seen, source status, target status, estimated value</td><td>Which links deserve reclamation?</td></tr><tr><td>Target distribution</td><td>Links by landing page, topic, and business priority</td><td>Are important pages receiving support?</td></tr><tr><td>Competitor comparison</td><td>Link gaps, shared domains, content patterns</td><td>Where are realistic growth opportunities?</td></tr><tr><td>Actions</td><td>Owner, priority, deadline, expected result</td><td>What happens after the report?</td></tr></tbody></table></div><p>For the monitoring layer behind these reports, use <a href="/backlink-monitoring-guide">The Complete Guide to Backlink Monitoring</a>.</p></section>

    <section id="white-label-reports"><span class="pillar-step">05 · Delivery</span><h2>How to build effective white-label reports</h2><p><strong>White-label reports</strong> should look and read like a natural extension of the agency or consultant delivering them. Branding matters, but clarity, evidence, and action matter more.</p><div class="pillar-compare"><article><h3>Executive layer</h3><p>Give decision-makers the short version.</p><ul><li>Goals and reporting period</li><li>Material changes</li><li>Risks and opportunities</li><li>Next priorities</li></ul></article><article class="is-featured"><span>Core report</span><h3>Strategy layer</h3><p>Connect evidence to recommendations.</p><ul><li>Finding and affected scope</li><li>Business/search impact</li><li>Priority and confidence</li><li>Recommended owner</li></ul></article><article><h3>Technical appendix</h3><p>Give implementers reproducible detail.</p><ul><li>Example URLs and exports</li><li>Rules and acceptance criteria</li><li>Testing instructions</li><li>Source definitions</li></ul></article></div><p>Use consistent colors, typography, terminology, date ranges, and metric definitions. Remove tool branding only when your license allows it, and never hide the data source when knowing it helps readers judge limitations.</p></section>

    <section id="choose-audit-tool"><span class="pillar-step">06 · Tooling</span><h2>How to choose an SEO audit tool</h2><div class="pillar-problems"><details open><summary>Match the crawler to the site</summary><p>Check URL limits, JavaScript rendering, authentication support, crawl controls, scheduling, segmentation, and export options against the actual website.</p></details><details><summary>Demand explainable findings</summary><p>A severity badge is not enough. The platform should expose affected URLs, detection rules, evidence, and enough context to validate the issue.</p></details><details><summary>Evaluate reporting flexibility</summary><p>Look for custom sections, annotations, date comparisons, saved filters, scheduled exports, branding controls, and stakeholder-friendly summaries.</p></details><details><summary>Plan for verification</summary><p>The strongest workflow can recrawl an affected set after implementation and show whether the issue is resolved without rebuilding the audit from scratch.</p></details></div></section>

    <section id="seo-audit-faq" class="pillar-faq"><span class="pillar-step">07 · FAQ</span><h2>SEO audit and reporting questions</h2><details><summary>How often should a site receive an SEO audit?</summary><p>Run a comprehensive audit at least annually and after migrations, redesigns, platform changes, or major traffic shifts. Use scheduled monitoring for critical signals between full audits.</p></details><details><summary>Can one SEO audit tool find every issue?</summary><p>No. Crawlers, search-engine data, analytics, performance tools, backlink indexes, and manual review observe different parts of the system. Strong audits combine them.</p></details><details><summary>What belongs in an executive SEO report?</summary><p>Include objectives, meaningful outcomes, material risks, the few metrics that explain progress, and prioritized next actions. Move raw exports into an appendix.</p></details><details><summary>Are white-label SEO reports only for agencies?</summary><p>No. Consultants, in-house teams, and multi-brand organizations also use branded reporting to create consistent communication for different stakeholders.</p></details></section>

    <section class="pillar-cta"><span>Build a focused audit stack</span><h2>Turn checks into a prioritized SEO plan.</h2><p>Use focused tools to gather evidence, validate issues, and create reporting that leads to clear implementation work.</p><a href="/tools">Explore all SEO tools <span>→</span></a></section>
  </div>
</div>
HTML;
    }

    public function down()
    {
        foreach (['link-opportunity-guide', 'seo-audit-guide'] as $slug) {
            $page = DB::table('pages')->where('slug', $slug)->first();
            if ($page) {
                DB::table('page_translations')->where('page_id', $page->id)->delete();
                DB::table('pages')->where('id', $page->id)->delete();
            }
        }
    }
}
