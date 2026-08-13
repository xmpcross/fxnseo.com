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
  <section class="tools-hero">
    <div class="tools-shell tools-hero-grid">
      <div>
        <nav class="tools-breadcrumb" aria-label="Breadcrumb"><a href="{{ route('home') }}">Home</a><span>/</span>Tools</nav>
        <span class="tools-kicker">The complete collection</span>
        <h1>Find the right tool.<br><em>Get a clearer answer.</em></h1>
        <p>Browse focused utilities for SEO research, websites, domains, metadata, text, YouTube, and everyday digital work.</p>
      </div>
      <div class="tools-hero-stats">
        <div><b>{{ $toolCount }}</b><span>Free tools</span></div>
        <div><b>{{ $categories->count() }}</b><span>Categories</span></div>
        <div><b>0</b><span>Installs needed</span></div>
      </div>
    </div>
  </section>

  <div class="tools-filter-wrap">
    <div class="tools-shell tools-filter-row">
      <label class="tools-search">
        <svg aria-hidden="true" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"></circle><path d="m16.5 16.5 4 4"></path></svg>
        <span class="tools-sr-only">Search all tools</span>
        <input id="tools-search-input" type="search" autocomplete="off" placeholder="Search all tools">
        <kbd>/</kbd>
      </label>
      <nav class="tools-category-nav" aria-label="Tool categories">
        @foreach($categories as $category)
          <a href="#{{ $category['anchor'] }}">{{ $category['title'] }}</a>
        @endforeach
      </nav>
    </div>
  </div>

  <main class="tools-shell tools-directory" id="tools-directory">
    @foreach($categories as $category)
      <section class="tools-category" id="{{ $category['anchor'] }}" data-tools-category>
        <div class="tools-category-head">
          <div><span>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span><h2>{{ $category['title'] }}</h2></div>
          <p>{{ $category['description'] }}</p>
          <b data-visible-count>{{ $category['pages']->count() }} tools</b>
        </div>

        <div class="tools-grid">
          @foreach($category['pages'] as $tool)
            @php $description = $tool['short_description'] ?? $tool['subtitle'] ?? 'Open this free online tool.'; @endphp
            <a class="tools-card" data-tool-card data-search="{{ strtolower($tool['title'].' '.$description.' '.$category['title']) }}" href="{{ empty($tool['custom_tool_link']) ? url('/'.$tool['slug']) : $tool['custom_tool_link'] }}" target="{{ $tool['target'] ?? '_self' }}">
              <span class="tools-card-icon">
                @if(!empty($tool['icon_image']))
                  <img src="{{ $tool['icon_image'] }}" alt="" loading="lazy">
                @else
                  {{ strtoupper(substr($tool['title'], 0, 1)) }}
                @endif
              </span>
              <span class="tools-card-copy"><b>{{ $tool['title'] }} @if(!empty($tool['new']))<small>New</small>@endif</b><span>{{ \Illuminate\Support\Str::limit($description, 88) }}</span></span>
              <i aria-hidden="true">↗</i>
            </a>
          @endforeach
        </div>
      </section>
    @endforeach

    <section class="tools-empty" id="tools-empty" hidden><span>⌕</span><h2>No matching tools</h2><p>Try a broader search such as domain, text, metadata, or YouTube.</p></section>
  </main>

  <section class="tools-cta"><div class="tools-shell"><div><span class="tools-kicker">Start exploring</span><h2>One focused tool can unlock your next step.</h2><p>Choose a category above or search for the exact task you want to complete.</p><a href="#tools-directory">Browse the collection <span>↓</span></a></div></div></section>

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
          category.querySelector('[data-visible-count]').textContent = visible + (visible === 1 ? ' tool' : ' tools');
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
