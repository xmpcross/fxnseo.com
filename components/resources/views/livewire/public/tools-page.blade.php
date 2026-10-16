@php
  $categories = collect($tool_with_categories)->map(function ($category) {
    $category['anchor'] = \Illuminate\Support\Str::slug($category['title']);
    $category['pages'] = collect($category['pages'] ?? [])->values();
    return $category;
  })->filter(function ($category) {
    return $category['pages']->isNotEmpty();
  })->values();
  $toolCount = $categories->sum(function ($category) {
    return $category['pages']->count();
  });
@endphp

<div class="tools-content">
  <!-- Modern Editorial Hero (Matches Site Design) -->
  <section class="tool-editorial-hero tools-editorial-hero">
    <div class="tool-editorial-shell">
      <nav class="tool-editorial-breadcrumb" aria-label="{{ __('Breadcrumb') }}">
        <a href="{{ route('home') }}">{{ __('Home') }}</a>
        <span class="sep" aria-hidden="true">›</span>
        <span class="active">{{ __('Free SEO Tools Directory') }}</span>
      </nav>

      <div class="tool-editorial-badge">
        <span class="pulse-indicator"></span>
        <span class="badge-label"><i class="fas fa-cubes text-emerald me-1"></i> {{ __('Complete Free Utility Suite • 100% Free & Open Access') }}</span>
      </div>

      <h1 class="tool-editorial-title hero-title">{{ __('All SEO, Webmaster & Creator Tools') }}</h1>
      <p class="tool-editorial-lead">{{ __('Browse our complete directory of focused diagnostic utilities for domain authority, backlink analysis, technical auditing, content optimization, and YouTube channel growth.') }}</p>

      <div class="tool-editorial-chips">
        <div class="tool-chip"><i class="fas fa-bolt text-emerald"></i> <span>{{ $toolCount }} {{ __('Free Online Tools') }}</span></div>
        <div class="tool-chip"><i class="fas fa-layer-group text-emerald"></i> <span>{{ $categories->count() }} {{ __('Specialized Categories') }}</span></div>
        <div class="tool-chip"><i class="fas fa-shield-alt text-emerald"></i> <span>{{ __('100% Free · No Sign-Up') }}</span></div>
        <div class="tool-chip"><i class="fas fa-check-circle text-emerald"></i> <span>{{ __('Instant Browser Results') }}</span></div>
      </div>
    </div>
  </section>

  <!-- Sticky Modern Filter & Search Bar -->
  <div class="tools-filter-wrap">
    <div class="tools-shell tools-filter-row">
      <label class="tools-search">
        <i class="fas fa-search tools-search-icon" aria-hidden="true"></i>
        <span class="tools-sr-only">{{ __('Search all tools') }}</span>
        <input id="tools-search-input" type="search" autocomplete="off" placeholder="{{ __('Search 70+ tools (e.g. backlink, keyword, youtube)...') }}">
        <kbd class="tools-search-kbd">/</kbd>
      </label>
      <nav class="tools-category-nav" aria-label="{{ __('Tool categories') }}">
        @foreach($categories as $category)
          <a href="#{{ $category['anchor'] }}">{{ $category['title'] }}</a>
        @endforeach
      </nav>
    </div>
  </div>

  <!-- Main Tools Directory -->
  <main class="tools-shell tools-directory" id="tools-directory">
    @foreach($categories as $category)
      <section class="tools-category" id="{{ $category['anchor'] }}" data-tools-category>
        <div class="tools-category-head">
          <div class="tools-cat-title-wrap">
            <span class="tools-cat-num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
            <h2 class="tools-cat-title">{{ $category['title'] }}</h2>
          </div>
          @if(!empty($category['description']))
            <p class="tools-cat-desc">{{ $category['description'] }}</p>
          @endif
          <b class="tools-cat-badge" data-visible-count>{{ $category['pages']->count() }} {{ __('tools') }}</b>
        </div>

        <div class="tools-grid">
          @foreach($category['pages'] as $tool)
            @php $description = $tool['short_description'] ?? $tool['subtitle'] ?? __('Free online diagnostic tool.'); @endphp
            <a class="tools-card" data-tool-card data-search="{{ strtolower($tool['title'].' '.$description.' '.$category['title']) }}" href="{{ empty($tool['custom_tool_link']) ? url('/'.$tool['slug']) : $tool['custom_tool_link'] }}" target="{{ $tool['target'] ?? '_self' }}">
              <span class="tools-card-icon">
                @if(!empty($tool['icon_image']))
                  <img src="{{ $tool['icon_image'] }}" alt="" loading="lazy">
                @else
                  <span class="tools-card-fallback-letter">{{ strtoupper(substr($tool['title'], 0, 1)) }}</span>
                @endif
              </span>
              <span class="tools-card-copy">
                <span class="tools-card-heading">
                  <b>{{ $tool['title'] }}</b>
                  @if(!empty($tool['new']))
                    <small class="tools-new-badge">{{ __('New') }}</small>
                  @endif
                </span>
                <span class="tools-card-sub">{{ \Illuminate\Support\Str::limit($description, 85) }}</span>
              </span>
              <i class="fas fa-arrow-up-right-from-square tools-card-arrow" aria-hidden="true"></i>
            </a>
          @endforeach
        </div>
      </section>
    @endforeach

    <section class="tools-empty" id="tools-empty" hidden>
      <div class="tools-empty-icon"><i class="fas fa-search"></i></div>
      <h2>{{ __('No matching tools found') }}</h2>
      <p>{{ __('Try searching for general terms like "backlink", "keyword", "metadata", or "youtube".') }}</p>
    </section>
  </main>

  <!-- Bottom Action Card -->
  <section class="tools-cta">
    <div class="tools-shell">
      <div class="tools-cta-box">
        <div class="tools-cta-copy">
          <span class="tools-cta-badge"><i class="fas fa-bolt me-1"></i> {{ __('Start Exploring') }}</span>
          <h2>{{ __('One focused diagnostic can unlock your next organic breakthrough.') }}</h2>
          <p>{{ __('Pick any utility above or search for the exact research task you want to solve today. No sign-up, credit cards, or hidden limits.') }}</p>
        </div>
        <a href="#tools-directory" class="tools-cta-btn">
          <span>{{ __('Browse Full Directory') }}</span>
          <i class="fas fa-arrow-down ms-2"></i>
        </a>
      </div>
    </div>
  </section>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const input = document.getElementById('tools-search-input');
      const categories = Array.from(document.querySelectorAll('[data-tools-category]'));
      const empty = document.getElementById('tools-empty');

      function filterTools() {
        const query = input.value.trim().toLowerCase();
        let total = 0;
        categories.forEach(function (category) {
          let visible = 0;
          category.querySelectorAll('[data-tool-card]').forEach(function (card) {
            const show = !query || card.dataset.search.includes(query);
            card.hidden = !show;
            if (show) visible++;
          });
          category.hidden = visible === 0;
          const countBadge = category.querySelector('[data-visible-count]');
          if (countBadge) {
            countBadge.textContent = visible + (visible === 1 ? ' tool' : ' tools');
          }
          total += visible;
        });
        empty.hidden = total !== 0;
      }

      input?.addEventListener('input', filterTools);
      document.addEventListener('keydown', function (event) {
        if (event.key === '/' && document.activeElement !== input) {
          event.preventDefault();
          input.focus();
        }
      });
    });
  </script>
</div>
