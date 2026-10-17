<!-- Modern Site Footer Component (Matches Home Design • Outfit Font • Emerald Accent) -->
<footer class="site-footer">
  <div class="wrap">
    <div class="footer-columns">
      <!-- Brand Info -->
      <div class="footer-col-brand">
        <a href="{{ url('/') }}" class="brand-logo" aria-label="{{ config('app.name') }}">
          <img src="{{ asset('assets/img/logo-light.svg') }}?v={{ @filemtime(dirname(base_path()).'/assets/img/logo-light.svg') ?: '1' }}" alt="{{ config('app.name') }}" class="logo-light" height="38" width="auto">
          <img src="{{ asset('assets/img/logo-dark.svg') }}?v={{ @filemtime(dirname(base_path()).'/assets/img/logo-dark.svg') ?: '1' }}" alt="{{ config('app.name') }}" class="logo-dark" height="38" width="auto">
        </a>
        <p>
          {{ __('FXN SEO provides professional-grade, free diagnostic utilities for webmasters, creators, and agencies. Analyze domain authority, audit backlinks, inspect technical tags, and optimize content in real time.') }}
        </p>
        <div class="footer-trust-badges">
          <span>✓ {{ __('Verified Moz Data') }}</span> • <span>✓ {{ __('YouTube v3 API') }}</span>
        </div>
      </div>

      <!-- Col 1: Popular SEO Tools -->
      <div>
        <h4 class="footer-col-title">{{ __('Popular Tools') }}</h4>
        <ul class="footer-col-links">
          <li><a href="{{ url('/domain-authority-checker') }}">{{ __('Domain Authority') }}</a></li>
          <li><a href="{{ url('/page-authority-checker') }}">{{ __('Page Authority') }}</a></li>
          <li><a href="{{ url('/da-pa-checker') }}">{{ __('DA PA Checker') }}</a></li>
          <li><a href="{{ url('/backlink-checker') }}">{{ __('Backlink Checker') }}</a></li>
          <li><a href="{{ url('/meta-tags-analyzer') }}">{{ __('Meta Tags Analyzer') }}</a></li>
          <li><a href="{{ url('/keyword-density-checker') }}">{{ __('Keyword Density') }}</a></li>
          <li><a href="{{ url('/google-index-checker') }}">{{ __('Google Index Checker') }}</a></li>
          <li><a href="{{ url('/robots-txt-generator') }}">{{ __('Robots.txt Generator') }}</a></li>
        </ul>
      </div>

      <!-- Col 2: YouTube Suite -->
      <div>
        <h4 class="footer-col-title">{{ __('YouTube Suite') }}</h4>
        <ul class="footer-col-links">
          <li><a href="{{ url('/youtube-title-extractor') }}">{{ __('Title Extractor') }}</a></li>
          <li><a href="{{ url('/youtube-tag-extractor') }}">{{ __('Tag Extractor') }}</a></li>
          <li><a href="{{ url('/youtube-hashtag-extractor') }}">{{ __('Hashtag Extractor') }}</a></li>
          <li><a href="{{ url('/youtube-channel-statistics') }}">{{ __('Channel Statistics') }}</a></li>
          <li><a href="{{ url('/youtube-video-statistics') }}">{{ __('Video Statistics') }}</a></li>
          <li><a href="{{ url('/youtube-money-calculator') }}">{{ __('Money Calculator') }}</a></li>
          <li><a href="{{ url('/youtube-trend') }}">{{ __('Trending Videos') }}</a></li>
        </ul>
      </div>

      <!-- Col 3: Knowledge Hub -->
      <div>
        <h4 class="footer-col-title">{{ __('Knowledge Hub') }}</h4>
        <ul class="footer-col-links">
          <li><a href="{{ url('/blog') }}">{{ __('SEO Blog') }}</a></li>
          <li><a href="{{ url('/backlink-monitoring-guide') }}">{{ __('Backlink Guide') }}</a></li>
          <li><a href="{{ url('/link-opportunity-guide') }}">{{ __('Link Building Guide') }}</a></li>
          <li><a href="{{ url('/seo-audit-guide') }}">{{ __('SEO Audit Hub') }}</a></li>
          <li><a href="{{ url('/faqs') }}">{{ __('Common FAQs') }}</a></li>
          <li><a href="{{ url('/report') }}">{{ __('Report Broken Tool') }}</a></li>
        </ul>
      </div>

      <!-- Col 4: Trust & Legal -->
      <div>
        <h4 class="footer-col-title">{{ __('Trust & Legal') }}</h4>
        <ul class="footer-col-links">
          <li><a href="{{ url('/about-us') }}">{{ __('About Us') }}</a></li>
          <li><a href="{{ url('/contact') }}">{{ __('Contact Support') }}</a></li>
          <li><a href="{{ url('/privacy-policy') }}">{{ __('Privacy Policy') }}</a></li>
          <li><a href="{{ url('/terms-conditions') }}">{{ __('Terms of Service') }}</a></li>
          <li><a href="{{ url('/cookie-information') }}">{{ __('Cookie Information') }}</a></li>
          <li><a href="{{ url('/affiliate-disclosure') }}">{{ __('Affiliate Disclosure') }}</a></li>
        </ul>
      </div>
    </div>

    <!-- Compliance & Google AdSense Policy Notice -->
    <div class="footer-compliance-box">
      <p>
        <strong>{{ __('Publisher & Advertising Disclosure:') }}</strong> {{ __('FXN SEO is an independent digital marketing intelligence resource. This platform is supported by digital advertising, including Google AdSense and affiliate partnerships. In accordance with Google Publisher Policies and FTC guidelines, we may receive compensation when visitors interact with sponsored placements or acquire services through external links, at no additional cost to you.') }}
      </p>
      <p>
        <strong>{{ __('Data Privacy & GDPR Commitment:') }}</strong> {{ __('We do not log, retain, or commercialize individual website queries, target domains, or video URLs submitted to our tools. All third-party trademarks and brand logos (including Moz, YouTube, and Google) belong to their respective copyright holders.') }}
      </p>
    </div>

    <!-- Bottom Bar -->
    <div class="footer-bottom-bar">
      <div>
        © {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved.') }}
      </div>
      <div class="footer-bottom-links">
        <a href="{{ url('/privacy-policy') }}">{{ __('Privacy') }}</a>
        <a href="{{ url('/terms-conditions') }}">{{ __('Terms') }}</a>
        <a href="{{ url('/cookie-information') }}">{{ __('Cookies') }}</a>
        <a href="{{ url('/contact') }}">{{ __('Contact') }}</a>
        <a href="{{ url('/report') }}">{{ __('Report') }}</a>
      </div>
    </div>
  </div>
</footer>
