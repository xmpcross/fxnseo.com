<div class="journal">
  <section class="journal-intro">
    <div class="journal-shell">
      <nav class="journal-breadcrumb" aria-label="{{ __('Breadcrumb') }}"><a href="{{ route('home') }}">{{ __('Home') }}</a><span aria-hidden="true">/</span><span>{{ __('The journal') }}</span></nav>
      <div class="journal-intro-row">
        <div><h1>{{ __('Less guesswork.') }}<br><em>{{ __('Better search.') }}</em></h1></div>
        <div class="journal-intro-note"><p>{{ __('Practical ideas for the people doing the work. Explore clear guides to technical SEO, better backlinks, and videos worth finding.') }}</p><a href="#journal-library">{{ __('Find your next read') }}</a></div>
      </div>
    </div>
  </section>

  @if ($featuredPost && $search === '' && $topic === '' && $sort === 'newest' && $pageTrans->currentPage() === 1)
    @php
      $featureMinutes = max(1, (int) ceil(str_word_count(strip_tags($featuredPost->description ?? '')) / 200));
      $featureTopic = \App\Http\Livewire\Public\Blog::topicFor($featuredPost->slug);
    @endphp
    <section class="journal-feature-section journal-shell" aria-label="{{ __('Featured article') }}">
      <article class="journal-feature">
        <a class="journal-feature-image" href="{{ localization()->getLocalizedURL(app()->getLocale(), '/blog/'.$featuredPost->slug) }}" aria-label="{{ $featuredPost->title }}"><img class="post-featured-image" src="{{ $featuredPost->featured_image ?: asset('assets/img/no-thumb.svg') }}" alt="{{ $featuredPost->title }}" width="1200" height="675" fetchpriority="high"><span class="journal-feature-stamp">{{ __('Editor’s pick') }}</span></a>
        <div class="journal-feature-copy"><div class="journal-meta"><span>{{ __($featureTopic) }}</span><span aria-hidden="true">·</span><span>{{ $featureMinutes }} {{ __('min read') }}</span></div><h2><a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/blog/'.$featuredPost->slug) }}">{{ $featuredPost->title }}</a></h2><p>{{ \Illuminate\Support\Str::limit(strip_tags($featuredPost->short_description ?: $featuredPost->subtitle), 190) }}</p><a class="journal-feature-link" href="{{ localization()->getLocalizedURL(app()->getLocale(), '/blog/'.$featuredPost->slug) }}">{{ __('Read the story') }}</a></div>
      </article>
    </section>
  @endif

  <section class="journal-library journal-shell" id="journal-library" aria-labelledby="journal-library-heading">
    <div class="journal-library-heading"><div><h2 id="journal-library-heading">{{ __('Ideas you can put to work.') }}</h2></div><span class="journal-total">{{ $totalArticles }} {{ __('articles. Always free.') }}</span></div>
    <div class="journal-controls">
      <div class="journal-tabs" role="group" aria-label="{{ __('Filter articles by topic') }}">
        @foreach (['' => __('All articles'), 'backlinks' => __('Backlinks'), 'technical' => __('Technical SEO'), 'youtube' => __('YouTube')] as $topicKey => $topicLabel)
          <button type="button" wire:click="$set('topic', '{{ $topicKey }}')" class="{{ $topic === $topicKey ? 'is-active' : '' }}" aria-pressed="{{ $topic === $topicKey ? 'true' : 'false' }}">{{ $topicLabel }}</button>
        @endforeach
      </div>
      <label class="journal-search"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><circle cx="10.5" cy="10.5" r="6.5"/><path d="m16 16 4.5 4.5"/></svg><span class="journal-sr-only">{{ __('Search articles') }}</span><input type="search" wire:model.debounce.350ms="search" placeholder="{{ __('Find a guide…') }}" maxlength="150"></label>
    </div>
    <div class="journal-results-row"><span role="status" aria-live="polite">{{ $pageTrans->total() }} {{ __('articles') }} @if ($search !== '') {{ __('matching') }} “{{ $search }}” @endif</span><label>{{ __('Sort by') }} <select wire:model="sort" aria-label="{{ __('Sort articles') }}"><option value="newest">{{ __('Newest first') }}</option><option value="oldest">{{ __('Oldest first') }}</option></select></label></div>
    <div class="journal-grid" wire:loading.class="journal-is-loading" wire:target="search,topic,sort,gotoPage,nextPage,previousPage">
      @forelse ($pageTrans as $post)
        @php
          $minutes = max(1, (int) ceil(str_word_count(strip_tags($post->description ?? '')) / 200));
          $postTopic = \App\Http\Livewire\Public\Blog::topicFor($post->slug);
        @endphp
        <article class="journal-card" wire:key="journal-post-{{ $post->id }}">
          <a class="journal-card-image" href="{{ localization()->getLocalizedURL(app()->getLocale(), '/blog/'.$post->slug) }}" aria-label="{{ $post->title }}"><img class="post-featured-image" src="{{ $post->featured_image ?: asset('assets/img/no-thumb.svg') }}" alt="{{ $post->title }}" loading="lazy" decoding="async" width="1200" height="675"></a>
          <div class="journal-meta"><span>{{ __($postTopic) }}</span><span aria-hidden="true">·</span><span>{{ $minutes }} {{ __('min read') }}</span></div>
          <h3><a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/blog/'.$post->slug) }}">{{ $post->title }}</a></h3>
          <p>{{ \Illuminate\Support\Str::limit(strip_tags($post->short_description ?: $post->subtitle), 135) }}</p>
          <div class="journal-card-bottom"><time datetime="{{ $post->created_at->toDateString() }}">{{ $post->created_at->format('M j, Y') }}</time><a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/blog/'.$post->slug) }}" aria-label="{{ __('Read') }}: {{ $post->title }}">{{ __('Read article') }}</a></div>
        </article>
      @empty
        <div class="journal-empty"><span aria-hidden="true">⌕</span><h3>{{ __('A fresh search might help.') }}</h3><p>{{ __('Try a broader phrase or explore all our articles.') }}</p><button type="button" wire:click="clearFilters">{{ __('Show all articles') }}</button></div>
      @endforelse
    </div>
    @if ($pageTrans->hasPages())<div class="journal-pagination">{{ $pageTrans->links() }}</div>@endif
  </section>

  <section class="journal-toolbox journal-shell"><div class="journal-toolbox-inner"><div><h2>{{ __('Good advice. Useful tools.') }}</h2><p>{{ __('Put your next idea into practice with our free SEO toolkit.') }}</p></div><a href="{{ route('tools') }}">{{ __('Explore the tools') }}</a></div></section>
</div>
