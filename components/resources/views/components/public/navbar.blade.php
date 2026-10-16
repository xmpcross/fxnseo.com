<!-- Modern Nav Header Component (Matches Home Design • Outfit Font • Emerald Accent) -->
<header class="nav-header">
  <div class="wrap nav-inner">
    <a href="{{ route('home') }}" class="brand-logo" aria-label="{{ config('app.name') }}">
      <img src="{{ asset('assets/img/logo-light.svg') }}" alt="{{ config('app.name') }}" class="logo-light" height="38" width="auto">
      <img src="{{ asset('assets/img/logo-dark.svg') }}" alt="{{ config('app.name') }}" class="logo-dark" height="38" width="auto">
    </a>

    <nav class="nav-menu" aria-label="{{ __('Main Navigation') }}">
      <!-- 1. All Tools -->
      <a href="{{ route('tools') }}" class="nav-link {{ Route::is('tools') ? 'active' : '' }}">
        <span>{{ __('Tools') }}</span>
        <span class="nav-badge">74</span>
      </a>

      <!-- 2. SEO Guides Dropdown Menu -->
      <div class="nav-item-dropdown">
        <a href="{{ url('/blog') }}" class="nav-link {{ Request::is('*guide') ? 'active' : '' }}" aria-haspopup="true" aria-expanded="false">
          <span>{{ __('Guides') }}</span>
          <i class="fas fa-chevron-down text-xs ms-1"></i>
        </a>
        <div class="nav-dropdown-menu" role="menu">
          <a href="{{ url('/backlink-monitoring-guide') }}" class="nav-dropdown-item" role="menuitem">
            <i class="fas fa-link text-emerald"></i>
            <div>
              <div class="nav-drop-title">{{ __('Backlink Monitoring Guide') }}</div>
              <div class="nav-drop-sub">{{ __('Detect lost links and audit link profiles') }}</div>
            </div>
          </a>
          <a href="{{ url('/link-opportunity-guide') }}" class="nav-dropdown-item" role="menuitem">
            <i class="fas fa-bullseye text-emerald"></i>
            <div>
              <div class="nav-drop-title">{{ __('Link Building Guide') }}</div>
              <div class="nav-drop-sub">{{ __('Prospecting & high-impact outreach') }}</div>
            </div>
          </a>
          <a href="{{ url('/seo-audit-guide') }}" class="nav-dropdown-item" role="menuitem">
            <i class="fas fa-chart-line text-emerald"></i>
            <div>
              <div class="nav-drop-title">{{ __('SEO Audit & Reporting Hub') }}</div>
              <div class="nav-drop-sub">{{ __('Technical health check & diagnostic workflows') }}</div>
            </div>
          </a>
          <div class="nav-dropdown-divider"></div>
          <a href="{{ url('/blog') }}" class="nav-dropdown-item" role="menuitem">
            <i class="fas fa-newspaper text-emerald"></i>
            <div>
              <div class="nav-drop-title">{{ __('All SEO Guides & Tutorials') }}</div>
              <div class="nav-drop-sub">{{ __('Explore the full knowledge repository') }}</div>
            </div>
          </a>
        </div>
      </div>

      <!-- 3. Blog -->
      <a href="{{ url('/blog') }}" class="nav-link {{ (Request::is('blog') || Request::is('blog/*')) ? 'active' : '' }}">
        <span>{{ __('Blog') }}</span>
      </a>

      <!-- 4. About Us -->
      <a href="{{ url('/about-us') }}" class="nav-link {{ Request::is('about-us') ? 'active' : '' }}">
        <span>{{ __('About') }}</span>
      </a>

      <!-- 5. FAQs -->
      <a href="{{ url('/faqs') }}" class="nav-link {{ Request::is('faqs') ? 'active' : '' }}">
        <span>{{ __('FAQ') }}</span>
      </a>

      <!-- 6. Contact -->
      <a href="{{ url('/contact') }}" class="nav-link {{ Request::is('contact') ? 'active' : '' }}">
        <span>{{ __('Contact') }}</span>
      </a>
    </nav>

    <div class="nav-actions">
      <button class="theme-toggle-btn" type="button" onclick="toggleSiteTheme()" title="{{ __('Toggle Light / Dark mode') }}" aria-label="{{ __('Toggle Theme') }}">
        <span id="theme-icon">🌙</span>
      </button>

      <a href="{{ route('tools') }}" class="btn btn-primary d-none d-sm-inline-flex">
        <span>{{ __('Browse 70+ Tools →') }}</span>
      </a>

      <!-- Mobile Hamburger Button -->
      <button class="mobile-menu-toggle d-lg-none" type="button" onclick="toggleMobileNavDrawer()" aria-label="{{ __('Toggle Navigation Menu') }}" aria-expanded="false">
        <i class="fas fa-bars"></i>
      </button>
    </div>
  </div>

  <!-- Mobile Collapsible Navigation Drawer -->
  <div class="mobile-nav-drawer" id="mobileNavDrawer" style="display: none;">
    <div class="wrap py-3">
      <a href="{{ route('home') }}" class="mobile-nav-link">{{ __('Home') }}</a>
      <a href="{{ route('tools') }}" class="mobile-nav-link d-flex justify-content-between align-items-center">
        <span>{{ __('All SEO Tools') }}</span>
        <span class="nav-badge">74</span>
      </a>
      
      <div class="mobile-nav-section-title">{{ __('Guides & Playbooks') }}</div>
      <a href="{{ url('/backlink-monitoring-guide') }}" class="mobile-nav-sublink">
        <i class="fas fa-link text-emerald me-2"></i> {{ __('Backlink Monitoring Guide') }}
      </a>
      <a href="{{ url('/link-opportunity-guide') }}" class="mobile-nav-sublink">
        <i class="fas fa-bullseye text-emerald me-2"></i> {{ __('Link Building Opportunity Guide') }}
      </a>
      <a href="{{ url('/seo-audit-guide') }}" class="mobile-nav-sublink">
        <i class="fas fa-chart-line text-emerald me-2"></i> {{ __('SEO Audit & Reporting Hub') }}
      </a>
      <a href="{{ url('/blog') }}" class="mobile-nav-sublink">
        <i class="fas fa-newspaper text-emerald me-2"></i> {{ __('All SEO Tutorials (Blog)') }}
      </a>

      <div class="mobile-nav-section-title">{{ __('Company & Support') }}</div>
      <a href="{{ url('/about-us') }}" class="mobile-nav-link">{{ __('About Us') }}</a>
      <a href="{{ url('/faqs') }}" class="mobile-nav-link">{{ __('Frequently Asked Questions') }}</a>
      <a href="{{ url('/contact') }}" class="mobile-nav-link">{{ __('Contact Support') }}</a>
      <a href="{{ url('/report') }}" class="mobile-nav-link">{{ __('Report Broken Link / Tool') }}</a>

      <div class="pt-3">
        <a href="{{ route('tools') }}" class="btn btn-primary w-100 text-center">{{ __('Browse 70+ Free Tools →') }}</a>
      </div>
    </div>
  </div>
</header>

<script>
  function toggleMobileNavDrawer() {
    const drawer = document.getElementById('mobileNavDrawer');
    if (!drawer) return;
    const isHidden = drawer.style.display === 'none' || drawer.style.display === '';
    drawer.style.display = isHidden ? 'block' : 'none';
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
