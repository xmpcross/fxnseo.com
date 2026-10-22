@php
  $allTools = collect($tool_with_categories)->flatMap(function ($category) {
    return collect($category['pages'] ?? []);
  })->unique('slug')->values();
  $featuredTools = $allTools->take(9);
@endphp

<div class="home-content">
  <section class="home-hero">
    <div class="home-orb home-orb-one"></div>
    <div class="home-orb home-orb-two"></div>
    <div class="home-shell home-hero-grid">
      <div class="home-hero-copy">
        <span class="home-kicker">{{ __('Free tools for smarter SEO') }}</span>
        <h1 class="hero-title">{{ __('Turn search data into') }} <em>{{ __('clear next steps.') }}</em></h1>
        <p>{{ __('Check websites, research domains, improve metadata, and solve everyday SEO tasks with focused tools that are ready when you are.') }}</p>

        <form class="home-search" id="home-tool-search" role="search">
          <svg aria-hidden="true" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"></circle><path d="m16.5 16.5 4 4"></path></svg>
          <label class="home-sr-only" for="home-search-input">{{ __('Search SEO tools') }}</label>
          <input id="home-search-input" type="search" autocomplete="off" placeholder="{{ __('Search tools — try domain, metadata or YouTube') }}">
          <button type="submit">{{ __('Find a tool') }} <span aria-hidden="true">→</span></button>
        </form>

        <div class="home-trust"><span>{{ __('No installation') }}</span><span>{{ __('Focused results') }}</span><span>{{ $allTools->count() }} {{ __('tools available') }}</span></div>
      </div>

      <aside class="home-hero-visual" aria-label="{{ __('Launch your next SEO task') }}">
        <span class="home-visual-ring home-visual-ring-one"></span>
        <span class="home-visual-ring home-visual-ring-two"></span>
        <img src="{{ asset('assets/img/about-start-today.svg') }}" alt="SEO tools ready to launch" width="400" height="300">
        <div class="home-visual-badge"><i></i><span><b>{{ $allTools->count() }} {{ __('tools') }}</b><small>{{ __('Ready to use') }}</small></span></div>
      </aside>
    </div>
  </section>

  <section class="home-section" id="home-tools">
    <div class="home-shell">
      <div class="home-section-head">
        <div><span class="home-kicker">{{ __('Essential toolkit') }}</span><h2>{{ __('Popular tools, ready to use.') }}</h2></div>
        <div><p>{{ __('Start with a popular check or search the collection for exactly what you need.') }}</p><a href="{{ route('tools') }}">{{ __('View every tool') }} <span>→</span></a></div>
      </div>

      <div class="home-tool-grid" id="home-tool-grid">
        @forelse($allTools as $toolIndex => $tool)
          @php $toolDescription = $tool['short_description'] ?? $tool['subtitle'] ?? 'A fast, focused SEO tool.'; @endphp
          <a class="home-tool-card" data-featured="{{ $toolIndex < 9 ? 'true' : 'false' }}" data-search="{{ strtolower($tool['title'].' '.$toolDescription) }}" href="{{ empty($tool['custom_tool_link']) ? url('/'.$tool['slug']) : $tool['custom_tool_link'] }}" target="{{ $tool['target'] ?? '_self' }}" @if($toolIndex >= 9) hidden @endif>
            <span class="home-tool-icon">
              @if(!empty($tool['icon_image']))
                <img src="{{ $tool['icon_image'] }}" alt="" loading="lazy">
              @else
                {{ strtoupper(substr($tool['title'], 0, 1)) }}
              @endif
            </span>
            <span><b>{{ $tool['title'] }}</b><small>{{ Illuminate\Support\Str::limit($toolDescription, 76) }}</small></span>
            <i aria-hidden="true">→</i>
          </a>
        @empty
          <p class="home-empty">{{ __('Tools are being prepared. Please check back shortly.') }}</p>
        @endforelse
      </div>
      <p class="home-empty" id="home-no-results" hidden>{{ __('No matching tool was found.') }} <a href="{{ route('tools') }}">{{ __('Browse the complete collection.') }}</a></p>
    </div>
  </section>

  <section class="home-section home-process">
    <div class="home-shell">
      <div class="home-section-head home-section-head-compact"><div><span class="home-kicker">{{ __('Simple by design') }}</span><h2>{{ __('From question to answer in three steps.') }}</h2></div><p>{{ __('Each utility focuses on one job, keeping your workflow direct and understandable.') }}</p></div>
      <div class="home-steps">
        <article><span>01</span><div>⌕</div><h3>{{ __('Choose a tool') }}</h3><p>{{ __('Pick the checker, generator, or converter that matches the task.') }}</p></article>
        <article><span>02</span><div>↳</div><h3>{{ __('Add your input') }}</h3><p>{{ __('Enter the URL, domain, keyword, text, or details the tool requests.') }}</p></article>
        <article><span>03</span><div>✓</div><h3>{{ __('Use the result') }}</h3><p>{{ __('Review the answer, copy what you need, and move your work forward.') }}</p></article>
      </div>
    </div>
  </section>

  <section class="home-section home-resources">
    <div class="home-shell">
      <div class="home-section-head"><div><span class="home-kicker">{{ __('Learn the why') }}</span><h2>{{ __('Practical SEO resources.') }}</h2></div><a href="{{ route('public.resources') }}">{{ __('Explore all resources') }} <span>→</span></a></div>
      @php $__homeResourcePosts = collect($recent_posts)->take(5)->values(); @endphp
      @if ($__homeResourcePosts->isNotEmpty())
        <div class="home-resource-showcase">
          @php $__leadResource = $__homeResourcePosts->first(); @endphp
          <article class="home-resource-lead">
            <a class="home-resource-lead-image" href="{{ localization()->getLocalizedURL(app()->getLocale(), '/blog/'.$__leadResource['slug']) }}">
              <img class="post-featured-image" src="{{ !empty($__leadResource['featured_image']) ? $__leadResource['featured_image'] : asset('assets/img/no-thumb.svg') }}" alt="{{ $__leadResource['title'] }}" loading="lazy">
            </a>
            <div class="home-resource-lead-overlay"></div>
            <div class="home-resource-lead-copy">
              <span class="home-resource-category"><i class="far fa-folder-open" aria-hidden="true"></i> {{ $__leadResource['category_name'] ?? 'Blog' }}</span>
              <h3><a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/blog/'.$__leadResource['slug']) }}">{{ $__leadResource['title'] }}</a></h3>
              <p>{{ Illuminate\Support\Str::limit(strip_tags($__leadResource['short_description'] ?? $__leadResource['description'] ?? ''), 175) }}</p>
              <div class="home-resource-meta">
                <span>{{ $resource_author }}</span>
                @if (!empty($__leadResource['published_at']))<time datetime="{{ \Illuminate\Support\Carbon::parse($__leadResource['published_at'])->toDateString() }}">{{ \Illuminate\Support\Carbon::parse($__leadResource['published_at'])->format('F j, Y') }}</time>@endif
              </div>
            </div>
          </article>

          <div class="home-resource-side-grid">
            @foreach ($__homeResourcePosts->slice(1, 4) as $post)
              <article class="home-resource-card">
                <a class="home-resource-card-image" href="{{ localization()->getLocalizedURL(app()->getLocale(), '/blog/'.$post['slug']) }}">
                  <img class="post-featured-image" src="{{ !empty($post['featured_image']) ? $post['featured_image'] : asset('assets/img/no-thumb.svg') }}" alt="{{ $post['title'] }}" loading="lazy">
                </a>
                <div class="home-resource-card-copy">
                  <span class="home-resource-category"><i class="far fa-folder-open" aria-hidden="true"></i> {{ $post['category_name'] ?? 'Blog' }}</span>
                  <h3><a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/blog/'.$post['slug']) }}">{{ $post['title'] }}</a></h3>
                  <div class="home-resource-meta">
                    <span>{{ $resource_author }}</span>
                    @if (!empty($post['published_at']))<time datetime="{{ \Illuminate\Support\Carbon::parse($post['published_at'])->toDateString() }}">{{ \Illuminate\Support\Carbon::parse($post['published_at'])->format('F j, Y') }}</time>@endif
                  </div>
                </div>
              </article>
            @endforeach
          </div>
        </div>
      @else
        <div class="home-empty"><a href="{{ route('public.resources') }}">{{ __('Browse the resource library') }} →</a></div>
      @endif
    </div>
  </section>

  <section class="home-final"><div class="home-shell"><div><span class="home-kicker">{{ __('A clearer next step') }}</span><h2>{{ __('Put the right SEO tool to work.') }}</h2><p>{{ __('Choose a focused utility and turn uncertainty into something useful.') }}</p><a href="#home-tools">{{ __('Explore free tools') }} <span>→</span></a></div></div></section>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const form = document.getElementById('home-tool-search');
      const input = document.getElementById('home-search-input');
      const cards = Array.from(document.querySelectorAll('.home-tool-card'));
      const empty = document.getElementById('home-no-results');
      form?.addEventListener('submit', function (event) {
        event.preventDefault();
        const query = input.value.trim().toLowerCase();
        let matches = 0;
        cards.forEach(function (card) {
          const show = query ? card.dataset.search.includes(query) : card.dataset.featured === 'true';
          card.hidden = !show;
          if (show) matches++;
        });
        empty.hidden = matches > 0;
        document.getElementById('home-tools').scrollIntoView({ behavior: 'smooth' });
      });
    });
  </script>
</div>
