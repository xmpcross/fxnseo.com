@php
  $navLanguages = \App\Models\Admin\Languages::where('status', true)->get();
  $navToolCount = \App\Models\Admin\Page::where('type', 'tool')->where('tool_status', true)->count();
@endphp
  <header class="nav-header site-home-header">
    <div class="wrap nav-inner">
      <a href="{{ route('home') }}" class="brand-logo" aria-label="fxnSEO">
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
        <a href="{{ route('tools') }}" class="nav-link">{{ __('Tools') }} <span class="nav-badge">{{ $navToolCount }}</span></a>

        <div class="nav-item-dropdown">
          <a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/blog') }}" class="nav-link" aria-haspopup="true" aria-expanded="false">
            <span>{{ __('Guides') }}</span>
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-left: 2px;"><polyline points="6 9 12 15 18 9"></polyline></svg>
          </a>
          <div class="nav-dropdown-menu" role="menu">
            <a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/backlink-monitoring-guide') }}" class="nav-dropdown-item" role="menuitem">
              <span class="dropdown-icon">🔗</span>
              <div>
                <div class="nav-drop-title">{{ __('Backlink Monitoring Guide') }}</div>
                <div class="nav-drop-sub">{{ __('Detect lost links and audit link profiles') }}</div>
              </div>
            </a>
            <a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/link-opportunity-guide') }}" class="nav-dropdown-item" role="menuitem">
              <span class="dropdown-icon">🎯</span>
              <div>
                <div class="nav-drop-title">{{ __('Link Building Guide') }}</div>
                <div class="nav-drop-sub">{{ __('Prospecting & high-impact outreach') }}</div>
              </div>
            </a>
            <a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/seo-audit-guide') }}" class="nav-dropdown-item" role="menuitem">
              <span class="dropdown-icon">📈</span>
              <div>
                <div class="nav-drop-title">{{ __('SEO Audit & Reporting Hub') }}</div>
                <div class="nav-drop-sub">{{ __('Technical health check & diagnostic workflows') }}</div>
              </div>
            </a>
            <div class="nav-dropdown-divider"></div>
            <a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/blog') }}" class="nav-dropdown-item" role="menuitem">
              <span class="dropdown-icon">📰</span>
              <div>
                <div class="nav-drop-title">{{ __('All SEO Guides & Tutorials') }}</div>
                <div class="nav-drop-sub">{{ __('Explore the full knowledge repository') }}</div>
              </div>
            </a>
          </div>
        </div>

        <a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/blog') }}" class="nav-link">{{ __('Blog') }}</a>
        <a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/faqs') }}" class="nav-link">{{ __('FAQ') }}</a>
        <a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/contact') }}" class="nav-link">{{ __('Contact') }}</a>

        @foreach($autoNavPages as $autoPage)
          @php
            $autoPageTrans = $autoPage->translate(app()->getLocale());
            $autoPageTitle = $autoPageTrans->title ?? $autoPageTrans->page_title ?? ucwords(str_replace('-', ' ', $autoPage->slug));
          @endphp
          <a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/' . $autoPage->slug) }}" class="nav-link">{{ $autoPageTitle }}</a>
        @endforeach
      </nav>

      <div class="nav-actions">
        <details class="nav-language-switcher">
          <summary aria-label="{{ __('Language') }}">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M3 12H21M12 3C16 7 16 17 12 21C8 17 8 7 12 3Z"/></svg>
            <span>{{ strtoupper(app()->getLocale()) }}</span>
          </summary>
          <nav class="nav-language-menu" aria-label="{{ __('Language') }}">
            @foreach($navLanguages as $navLanguage)
              <a href="{{ localization()->getLocalizedURL($navLanguage->code, url()->current(), [], false) }}" lang="{{ $navLanguage->code }}" hreflang="{{ $navLanguage->code }}" @if(app()->getLocale() === $navLanguage->code) aria-current="page" @endif>
                <span>{{ ['en' => 'English', 'de' => 'Deutsch', 'es' => 'Español', 'fr' => 'Français', 'it' => 'Italiano'][$navLanguage->code] ?? $navLanguage->name }}</span>
                <span class="nav-language-code">{{ strtoupper($navLanguage->code) }}</span>
              </a>
            @endforeach
          </nav>
        </details>
        @guest
          <a href="{{ route('login') }}" class="btn btn-ghost nav-login">{{ __('Login') }}</a>
        @else
          <a href="{{ auth()->user()->is_admin ? route('admin.dashboard.index') : route('user.profile') }}" class="btn btn-ghost nav-login d-none-mobile">{{ auth()->user()->is_admin ? __('Dashboard') : __('My account') }}</a>
          <a href="{{ route('user.logout') }}" class="btn btn-ghost nav-login">{{ __('Logout') }}</a>
        @endguest
        <button class="theme-toggle-btn" type="button" onclick="toggleSiteTheme()" title="{{ __('Toggle Light / Dark mode') }}" aria-label="{{ __('Toggle Theme') }}">
          <span id="theme-icon">🌙</span>
        </button>
        <a href="{{ route('tools') }}" class="btn btn-primary d-none-mobile">{{ __('All') }} {{ $navToolCount }} {{ __('tools') }}</a>
        <button class="mobile-toggle-btn" type="button" onclick="toggleMobileNavDrawer()" aria-controls="homeMobileDrawer" aria-expanded="false" aria-label="{{ __('Toggle Navigation Menu') }}">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
        </button>
      </div>
    </div>

    <!-- Mobile Drawer -->
    <div id="homeMobileDrawer" class="home-mobile-drawer" style="display: none;">
      <div class="wrap py-3" style="display: flex; flex-direction: column; gap: 4px;">
        <a href="{{ route('tools') }}" class="mobile-nav-link">
          <span>{{ __('Tools') }}</span>
          <span class="nav-badge">{{ $navToolCount }}</span>
        </a>
        <a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/blog') }}" class="mobile-nav-link">{{ __('Guides & Tutorials') }}</a>
        <a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/blog') }}" class="mobile-nav-link">{{ __('Blog') }}</a>
        <a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/faqs') }}" class="mobile-nav-link">{{ __('FAQs') }}</a>
        <a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/contact') }}" class="mobile-nav-link">{{ __('Contact') }}</a>
        @auth
          <a href="{{ auth()->user()->is_admin ? route('admin.dashboard.index') : route('user.profile') }}" class="mobile-nav-link">{{ auth()->user()->is_admin ? __('Dashboard') : __('My account') }}</a>
        @endauth
        @foreach($autoNavPages as $autoPage)
          @php
            $autoPageTrans = $autoPage->translate(app()->getLocale());
            $autoPageTitle = $autoPageTrans->title ?? $autoPageTrans->page_title ?? ucwords(str_replace('-', ' ', $autoPage->slug));
          @endphp
          <a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/' . $autoPage->slug) }}" class="mobile-nav-link">{{ $autoPageTitle }}</a>
        @endforeach
        <a href="{{ route('tools') }}" class="btn btn-primary" style="margin-top: 10px; width: 100%;">{{ __('All') }} {{ $navToolCount }} {{ __('tools') }}</a>
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
