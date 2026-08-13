@php
  $allTools = collect($tool_with_categories)->flatMap(function ($category) {
    return collect($category['pages'] ?? []);
  })->unique('slug')->values();
  $featuredTools = $allTools->take(9);
@endphp

<div>
  <header class="site-header" id="top">
    <div class="shell nav-wrap">
      <a class="brand" href="{{ route('home') }}" aria-label="fxnSEO home">
        <img src="{{ asset('assets/img/logo-light.svg') }}" alt="fxnSEO">
      </a>
      <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="primary-nav"><span></span><span></span><span></span><b class="sr-only">Toggle menu</b></button>
      <nav class="primary-nav" id="primary-nav" aria-label="Primary navigation">
        @if (Route::has('blog'))<a href="{{ route('blog') }}">Blog</a>@endif
        <a href="{{ url('/contact') }}">Contact</a>
        <a href="{{ route('tools.directory') }}">Tools</a>
      </nav>
      <div class="nav-actions">
        <button class="nav-icon nav-search" type="button" aria-label="Search tools"><svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="6.5"></circle><path d="m16 16 4 4"></path></svg></button>
        <button class="nav-icon theme-switch" type="button" aria-label="Toggle dark mode">☾</button>
        <div class="nav-dropdown language-menu">
          <button type="button" aria-expanded="false"><img src="{{ asset('assets/img/flags/'.localization()->getCurrentLocale().'.svg') }}" alt=""> {{ localization()->getCurrentLocaleNative() }} <span>⌄</span></button>
          <div class="dropdown-panel dropdown-right">
            @foreach(localization()->getSupportedLocales() as $properties)
              <a rel="alternate" hreflang="{{ $properties->key() }}" href="{{ localization()->getLocalizedURL($properties->key(), null, [], false) }}"><img src="{{ asset('assets/img/flags/'.$properties->key().'.svg') }}" alt="">{{ $properties->native() }}</a>
            @endforeach
          </div>
        </div>
        @guest
          <a class="login-link" href="{{ route('login') }}">Login</a>
          <a class="button button-solid register-button" href="{{ route('register') }}">Register</a>
        @endguest
      </div>
    </div>
  </header>

  <main>
    <section class="hero">
      <div class="hero-orbit orbit-one"></div><div class="hero-orbit orbit-two"></div>
      <div class="shell hero-grid">
        <div class="hero-copy">
          <span class="kicker">SEO clarity, without the clutter</span>
          <h1>Make every search decision <em>count.</em></h1>
          <p>Fast, focused SEO tools for checking authority, fixing technical issues, understanding links, and creating pages that deserve to rank.</p>
          <form class="tool-search" id="tool-search-form" role="search">
            <label class="sr-only" for="tool-search">Search SEO tools</label>
            <svg aria-hidden="true" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"></circle><path d="m16.5 16.5 4 4"></path></svg>
            <input id="tool-search" type="search" autocomplete="off" placeholder="Try “backlinks”, “metadata” or “redirects”">
            <button type="submit">Find a tool <span aria-hidden="true">→</span></button>
          </form>
          <div class="trust-row"><span>Free essential tools</span><span>No complex setup</span><span>Actionable results</span></div>
        </div>

        <aside class="toolbox-card" aria-label="Featured tools">
          <div class="card-top"><div><small>Your SEO toolbox</small><strong>Ready when you are.</strong></div><span class="status"><i></i> Online</span></div>
          <div class="stat-row"><div><b>{{ $allTools->count() ?: '60+' }}</b><span>web tools</span></div><div><b>1</b><span>URL to start</span></div><div><b>0</b><span>installs</span></div></div>
          <div class="quick-list">
            @foreach($featuredTools->take(3) as $tool)
              <a href="{{ empty($tool['custom_tool_link']) ? url('/'.$tool['slug']) : $tool['custom_tool_link'] }}" target="{{ $tool['target'] ?? '_self' }}">
                <span class="tool-mark">{{ strtoupper(substr($tool['title'], 0, 1)) }}</span>
                <span><b>{{ $tool['title'] }}</b><small>{{ Illuminate\Support\Str::limit($tool['short_description'] ?? $tool['subtitle'] ?? 'Open this free SEO tool.', 48) }}</small></span>
                <i aria-hidden="true">→</i>
              </a>
            @endforeach
          </div>
        </aside>
      </div>
    </section>

    <section class="section tools-section" id="tools">
      <div class="shell">
        <div class="section-heading"><div><span class="kicker">Start with the essentials</span><h2>Popular SEO tools</h2></div><div><p>Focused checks that give you useful answers without complicated software or a steep learning curve.</p><a href="{{ route('tools.directory') }}">Browse all {{ $allTools->count() }} tools <span>→</span></a></div></div>
        <div class="tool-grid" id="tool-grid">
          @forelse($allTools as $toolIndex => $tool)
            @php $toolDescription = $tool['short_description'] ?? $tool['subtitle'] ?? 'A fast, focused SEO check.'; @endphp
            <a class="tool-card" data-featured="{{ $toolIndex < 9 ? 'true' : 'false' }}" data-search="{{ strtolower($tool['title'].' '.$toolDescription) }}" href="{{ empty($tool['custom_tool_link']) ? url('/'.$tool['slug']) : $tool['custom_tool_link'] }}" target="{{ $tool['target'] ?? '_self' }}" @if($toolIndex >= 9) hidden @endif>
              <span class="tool-mark">{{ strtoupper(substr($tool['title'], 0, 1)) }}</span>
              <span class="tool-text"><b>{{ $tool['title'] }}</b><small>{{ Illuminate\Support\Str::limit($toolDescription, 74) }}</small></span>
              <span class="tool-arrow">↗</span>
            </a>
          @empty
            <p class="empty-state">Tools are being prepared. Please check back shortly.</p>
          @endforelse
        </div>
        <p class="no-results" id="no-results" hidden>No featured tool matched that search. <a href="{{ route('tools.directory') }}">Search the full directory →</a></p>
      </div>
    </section>

    <section class="section process-section" id="how-it-works">
      <div class="shell">
        <div class="section-heading compact"><div><span class="kicker">A simpler workflow</span><h2>From question to useful result.</h2></div><p>Every fxnSEO utility is built around one job, so you can move from uncertainty to a clear next step.</p></div>
        <div class="steps">
          <article><span>01</span><div class="step-icon">⌕</div><h3>Choose your tool</h3><p>Find the exact checker, generator, or converter for the job at hand.</p></article>
          <article><span>02</span><div class="step-icon">↳</div><h3>Add your input</h3><p>Paste a URL, domain, keyword, or text—whatever the selected tool needs.</p></article>
          <article><span>03</span><div class="step-icon">✓</div><h3>Act on the result</h3><p>Review, copy, or download a clear result and keep your work moving.</p></article>
        </div>
      </div>
    </section>

    <section class="section resource-section">
      <div class="shell">
        <div class="section-heading"><div><span class="kicker">Learn the why</span><h2>Practical SEO resources</h2></div><a class="text-link" href="{{ route('public.resources') }}">View all resources <span>→</span></a></div>
        <div class="resource-grid">
          @forelse(collect($recent_posts ?? [])->take(3) as $post)
            <a class="resource-card" href="{{ url('/blog/'.$post['slug']) }}"><span>Guide</span><h3>{{ $post['title'] }}</h3><p>{{ Illuminate\Support\Str::limit(strip_tags($post['short_description'] ?? $post['description'] ?? ''), 130) }}</p><b>Read article →</b></a>
          @empty
            <a class="resource-card resource-feature" href="{{ route('public.resources') }}"><span>Resource library</span><h3>Build stronger search foundations.</h3><p>Explore practical guides for improving visibility, content, and technical performance.</p><b>Explore the library →</b></a>
          @endforelse
        </div>
      </div>
    </section>

    <section class="final-cta"><div class="shell"><div class="cta-panel"><div><span class="kicker">Your next answer is one click away</span><h2>Know what to improve next.</h2><p>Choose a focused tool and turn SEO uncertainty into a concrete action.</p></div><a class="button button-light" href="#tools">Explore free SEO tools <span>→</span></a></div></div></section>
  </main>

  <script>
  document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.querySelector('.menu-toggle');
    const nav = document.querySelector('.primary-nav');
    toggle?.addEventListener('click', function () { const open = this.getAttribute('aria-expanded') === 'true'; this.setAttribute('aria-expanded', String(!open)); nav.classList.toggle('is-open', !open); });
    const form = document.getElementById('tool-search-form'); const input = document.getElementById('tool-search'); const cards = [...document.querySelectorAll('.tool-card')]; const empty = document.getElementById('no-results');
    function filterTools() { const q = input.value.trim().toLowerCase(); let count = 0; cards.forEach(card => { const show = q ? card.dataset.search.includes(q) : card.dataset.featured === 'true'; card.hidden = !show; if (show) count++; }); empty.hidden = count > 0; document.getElementById('tools').scrollIntoView({behavior:'smooth'}); }
    form?.addEventListener('submit', function (event) { event.preventDefault(); filterTools(); });
    document.querySelector('.nav-search')?.addEventListener('click', function () { input?.focus(); input?.scrollIntoView({behavior:'smooth', block:'center'}); });
    document.querySelectorAll('.nav-dropdown > button').forEach(button => button.addEventListener('click', function (event) { event.stopPropagation(); const item = this.parentElement; document.querySelectorAll('.nav-dropdown.is-open').forEach(open => { if (open !== item) open.classList.remove('is-open'); }); item.classList.toggle('is-open'); this.setAttribute('aria-expanded', String(item.classList.contains('is-open'))); }));
    document.addEventListener('click', () => document.querySelectorAll('.nav-dropdown.is-open').forEach(item => item.classList.remove('is-open')));
    const themeButton = document.querySelector('.theme-switch'); const savedTheme = localStorage.getItem('fxn-theme'); if (savedTheme === 'dark') document.body.classList.add('home-dark');
    themeButton?.addEventListener('click', function () { document.body.classList.toggle('home-dark'); localStorage.setItem('fxn-theme', document.body.classList.contains('home-dark') ? 'dark' : 'light'); this.textContent = document.body.classList.contains('home-dark') ? '☀' : '☾'; });
  });
  </script>
</div>
