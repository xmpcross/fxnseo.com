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
        <span class="home-kicker">Free tools for smarter SEO</span>
        <h1>Turn search data into <em>clear next steps.</em></h1>
        <p>Check websites, research domains, improve metadata, and solve everyday SEO tasks with focused tools that are ready when you are.</p>

        <form class="home-search" id="home-tool-search" role="search">
          <svg aria-hidden="true" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"></circle><path d="m16.5 16.5 4 4"></path></svg>
          <label class="home-sr-only" for="home-search-input">Search SEO tools</label>
          <input id="home-search-input" type="search" autocomplete="off" placeholder="Search tools — try domain, metadata or YouTube">
          <button type="submit">Find a tool <span aria-hidden="true">→</span></button>
        </form>

        <div class="home-trust"><span>No installation</span><span>Focused results</span><span>{{ $allTools->count() }} tools available</span></div>
      </div>

      <aside class="home-hero-visual" aria-label="Launch your next SEO task">
        <span class="home-visual-ring home-visual-ring-one"></span>
        <span class="home-visual-ring home-visual-ring-two"></span>
        <img src="{{ asset('assets/img/about-start-today.svg') }}" alt="SEO tools ready to launch" width="400" height="300">
        <div class="home-visual-badge"><i></i><span><b>{{ $allTools->count() }} tools</b><small>Ready to use</small></span></div>
      </aside>
    </div>
  </section>

  <section class="home-section" id="home-tools">
    <div class="home-shell">
      <div class="home-section-head">
        <div><span class="home-kicker">Essential toolkit</span><h2>Popular tools, ready to use.</h2></div>
        <div><p>Start with a popular check or search the collection for exactly what you need.</p><a href="{{ route('tools') }}">View every tool <span>→</span></a></div>
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
          <p class="home-empty">Tools are being prepared. Please check back shortly.</p>
        @endforelse
      </div>
      <p class="home-empty" id="home-no-results" hidden>No matching tool was found. <a href="{{ route('tools') }}">Browse the complete collection.</a></p>
    </div>
  </section>

  <section class="home-section home-process">
    <div class="home-shell">
      <div class="home-section-head home-section-head-compact"><div><span class="home-kicker">Simple by design</span><h2>From question to answer in three steps.</h2></div><p>Each utility focuses on one job, keeping your workflow direct and understandable.</p></div>
      <div class="home-steps">
        <article><span>01</span><div>⌕</div><h3>Choose a tool</h3><p>Pick the checker, generator, or converter that matches the task.</p></article>
        <article><span>02</span><div>↳</div><h3>Add your input</h3><p>Enter the URL, domain, keyword, text, or details the tool requests.</p></article>
        <article><span>03</span><div>✓</div><h3>Use the result</h3><p>Review the answer, copy what you need, and move your work forward.</p></article>
      </div>
    </div>
  </section>

  <section class="home-section home-resources">
    <div class="home-shell">
      <div class="home-section-head"><div><span class="home-kicker">Learn the why</span><h2>Practical SEO resources.</h2></div><a href="{{ route('public.resources') }}">Explore all resources <span>→</span></a></div>
      <div class="home-resource-grid">
        @forelse(collect($recent_posts)->take(3) as $post)
          <a href="{{ url('/blog/'.$post['slug']) }}">
            <figure class="home-resource-image">
              <img src="{{ !empty($post['featured_image']) ? $post['featured_image'] : asset('assets/img/no-thumb.svg') }}" alt="{{ $post['title'] }}" loading="lazy">
            </figure>
            <div class="home-resource-copy">
              <span>Guide</span>
              <h3>{{ $post['title'] }}</h3>
              <p>{{ Illuminate\Support\Str::limit(strip_tags($post['short_description'] ?? $post['description'] ?? ''), 135) }}</p>
              <b>Read article →</b>
            </div>
          </a>
        @empty
          <a class="home-resource-feature" href="{{ route('public.resources') }}"><span>Resource library</span><h3>Build stronger search foundations.</h3><p>Explore practical guidance for improving visibility, content, and technical performance.</p><b>Browse resources →</b></a>
        @endforelse
      </div>
    </div>
  </section>

  <section class="home-final"><div class="home-shell"><div><span class="home-kicker">A clearer next step</span><h2>Put the right SEO tool to work.</h2><p>Choose a focused utility and turn uncertainty into something useful.</p><a href="#home-tools">Explore free tools <span>→</span></a></div></div></section>

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
