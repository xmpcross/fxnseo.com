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

      <h1 class="tool-editorial-title hero-title">{{ __('All :count free tools', ['count' => $toolCount]) }}</h1>
      <p class="tool-editorial-lead">{{ __('Domain authority, backlinks, technical checks, text utilities and YouTube research. Free, no account, results in your browser.') }}</p>
    </div>
  </section>

  <!-- Sticky Modern Filter & Search Bar -->
  <div class="tools-filter-wrap">
    <div class="tools-shell tools-filter-row">
      <label class="tools-search">
        <span class="tools-sr-only">{{ __('Search all tools') }}</span>
        <input id="tools-search-input" type="search" autocomplete="off" placeholder="{{ __('Search :count tools', ['count' => $toolCount]) }}">
        <kbd class="tools-search-kbd">/</kbd>
      </label>
      <nav class="tools-category-nav" aria-label="{{ __('Tool categories') }}">
        @foreach($categories as $category)
          <a href="#{{ $category['anchor'] }}">{{ __($category['title']) }}</a>
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
            <h2 class="tools-cat-title">{{ __($category['title']) }}</h2>
          </div>
          @if(!empty($category['description']))
            <p class="tools-cat-desc">{{ __($category['description']) }}</p>
          @endif
          <span class="tools-cat-badge" data-visible-count>{{ $category['pages']->count() }} {{ __('tools') }}</span>
        </div>

        <div class="tools-grid">
          @foreach($category['pages'] as $tool)
            @php $description = $tool['short_description'] ?? $tool['subtitle'] ?? __('Free online diagnostic tool.'); @endphp
            <a class="tools-card" data-tool-card data-search="{{ strtolower($tool['title'].' '.$description.' '.$category['title']) }}" href="{{ empty($tool['custom_tool_link']) ? localization()->getLocalizedURL(app()->getLocale(), '/'.$tool['slug']) : $tool['custom_tool_link'] }}" target="{{ $tool['target'] ?? '_self' }}">
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
