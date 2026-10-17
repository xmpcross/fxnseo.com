@php
  $navToolCount = \App\Models\Admin\Page::where('type', 'tool')->where('tool_status', true)->count();
@endphp
  <header class="nav-header site-home-header">
    <div class="wrap nav-inner">
      <a href="{{ url('/') }}" class="brand-logo" aria-label="fxnSEO">
        <img src="{{ asset('assets/img/logo-light.svg') }}?v={{ @filemtime(dirname(base_path()).'/assets/img/logo-light.svg') ?: '1' }}" alt="fxnSEO" class="logo-light" height="38" width="auto">
        <img src="{{ asset('assets/img/logo-dark.svg') }}?v={{ @filemtime(dirname(base_path()).'/assets/img/logo-dark.svg') ?: '1' }}" alt="fxnSEO" class="logo-dark" height="38" width="auto">
      </a>

      @php
        $autoNavPages = \App\Models\Admin\Page::with('translations')->whereIn('type', ['page', 'contact'])
          ->whereNotIn('slug', [
            'about-us', 'faqs', 'contact',
            'terms-conditions', 'privacy-policy', 'cookie-information', 'affiliate-disclosure',
            'backlink-monitoring-guide', 'link-opportunity-guide', 'seo-audit-guide'
          ])
          ->get();
      @endphp

      <nav class="nav-menu">
        <a href="{{ route('tools') }}" class="nav-link">Tools <span class="nav-badge">{{ $navToolCount }}</span></a>

        <div class="nav-item-dropdown">
          <a href="{{ url('/blog') }}" class="nav-link" aria-haspopup="true" aria-expanded="false">
            <span>Guides</span>
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-left: 2px;"><polyline points="6 9 12 15 18 9"></polyline></svg>
          </a>
          <div class="nav-dropdown-menu" role="menu">
            <a href="{{ url('/backlink-monitoring-guide') }}" class="nav-dropdown-item" role="menuitem">
              <span class="dropdown-icon">🔗</span>
              <div>
                <div class="nav-drop-title">Backlink Monitoring Guide</div>
                <div class="nav-drop-sub">Detect lost links and audit link profiles</div>
              </div>
            </a>
            <a href="{{ url('/link-opportunity-guide') }}" class="nav-dropdown-item" role="menuitem">
              <span class="dropdown-icon">🎯</span>
              <div>
                <div class="nav-drop-title">Link Building Guide</div>
                <div class="nav-drop-sub">Prospecting & high-impact outreach</div>
              </div>
            </a>
            <a href="{{ url('/seo-audit-guide') }}" class="nav-dropdown-item" role="menuitem">
              <span class="dropdown-icon">📈</span>
              <div>
                <div class="nav-drop-title">SEO Audit & Reporting Hub</div>
                <div class="nav-drop-sub">Technical health check & diagnostic workflows</div>
              </div>
            </a>
            <div class="nav-dropdown-divider"></div>
            <a href="{{ url('/blog') }}" class="nav-dropdown-item" role="menuitem">
              <span class="dropdown-icon">📰</span>
              <div>
                <div class="nav-drop-title">All SEO Guides & Tutorials</div>
                <div class="nav-drop-sub">Explore the full knowledge repository</div>
              </div>
            </a>
          </div>
        </div>

        <a href="{{ url('/blog') }}" class="nav-link">Blog</a>
        <a href="{{ url('/faqs') }}" class="nav-link">FAQ</a>
        <a href="{{ url('/contact') }}" class="nav-link">Contact</a>

        @foreach($autoNavPages as $autoPage)
          @php
            $autoPageTrans = $autoPage->translate(app()->getLocale());
            $autoPageTitle = $autoPageTrans->title ?? $autoPageTrans->page_title ?? ucwords(str_replace('-', ' ', $autoPage->slug));
          @endphp
          <a href="{{ url('/' . $autoPage->slug) }}" class="nav-link">{{ $autoPageTitle }}</a>
        @endforeach
      </nav>

      <div class="nav-actions">
        <button class="theme-toggle-btn" type="button" onclick="toggleSiteTheme()" title="Toggle Light / Dark mode" aria-label="Toggle Theme">
          <span id="theme-icon">🌙</span>
        </button>
        <a href="{{ route('tools') }}" class="btn btn-primary d-none-mobile">All {{ $navToolCount }} tools</a>
        <button class="mobile-toggle-btn" type="button" onclick="toggleMobileNavDrawer()" aria-controls="homeMobileDrawer" aria-expanded="false" aria-label="Toggle Navigation Menu">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
        </button>
      </div>
    </div>

    <!-- Mobile Drawer -->
    <div id="homeMobileDrawer" class="home-mobile-drawer" style="display: none;">
      <div class="wrap py-3" style="display: flex; flex-direction: column; gap: 4px;">
        <a href="{{ route('tools') }}" class="mobile-nav-link">
          <span>Tools</span>
          <span class="nav-badge">{{ $navToolCount }}</span>
        </a>
        <a href="{{ url('/blog') }}" class="mobile-nav-link">Guides & Tutorials</a>
        <a href="{{ url('/blog') }}" class="mobile-nav-link">Blog</a>
        <a href="{{ url('/faqs') }}" class="mobile-nav-link">FAQs</a>
        <a href="{{ url('/contact') }}" class="mobile-nav-link">Contact</a>
        @foreach($autoNavPages as $autoPage)
          @php
            $autoPageTrans = $autoPage->translate(app()->getLocale());
            $autoPageTitle = $autoPageTrans->title ?? $autoPageTrans->page_title ?? ucwords(str_replace('-', ' ', $autoPage->slug));
          @endphp
          <a href="{{ url('/' . $autoPage->slug) }}" class="mobile-nav-link">{{ $autoPageTitle }}</a>
        @endforeach
        <a href="{{ route('tools') }}" class="btn btn-primary" style="margin-top: 10px; width: 100%;">All {{ $navToolCount }} tools</a>
      </div>
    </div>
  </header>

<script>
  function toggleMobileNavDrawer() {
    const drawer = document.getElementById('homeMobileDrawer');
    if (!drawer) return;
    const isHidden = drawer.style.display === 'none' || drawer.style.display === '';
    drawer.style.display = isHidden ? 'block' : 'none';
    document.querySelector('.site-home-header .mobile-toggle-btn').setAttribute('aria-expanded', String(isHidden));
  }

  function toggleSiteTheme() {
    const html = document.documentElement;
    const body = document.body;
    const isDark = html.classList.contains('dark') || html.classList.contains('theme-dark') || (body && body.classList.contains('theme-dark'));
    const newTheme = isDark ? 'light' : 'dark';

    html.classList.remove('light', 'dark', 'theme-light', 'theme-dark');
    html.classList.add(newTheme);
    html.classList.add('theme-' + newTheme);

    if (body) {
      body.classList.remove('theme-light', 'theme-dark', 'light', 'dark');
      body.classList.add('theme-' + newTheme);
      body.classList.add(newTheme);
    }

    const icon = document.getElementById('theme-icon');
    if (icon) icon.textContent = newTheme === 'light' ? '🌙' : '☀️';

    localStorage.setItem('site_theme', newTheme);
    document.cookie = "theme_mode=theme-" + newTheme + "; path=/; max-age=31536000; SameSite=Lax";
  }

  (function() {
    try {
      const saved = localStorage.getItem('site_theme');
      if (saved) {
        document.documentElement.classList.remove('light', 'dark', 'theme-light', 'theme-dark');
        document.documentElement.classList.add(saved);
        document.documentElement.classList.add('theme-' + saved);
        if (document.body) {
          document.body.classList.remove('theme-light', 'theme-dark', 'light', 'dark');
          document.body.classList.add('theme-' + saved);
          document.body.classList.add(saved);
        }
        const icon = document.getElementById('theme-icon');
        if (icon) icon.textContent = saved === 'light' ? '🌙' : '☀️';
      }
    } catch(e) {}
  })();
</script>
