<div class="blog-card-grid row">
  @foreach ($pageTrans as $pageTran)
    @php
      $summary = $pageTran->short_description ?: $pageTran->subtitle;
      $postDate = $pageTran->created_at ? \Illuminate\Support\Carbon::parse($pageTran->created_at)->format('M j, Y') : null;
      $isSpotlight = $loop->first && ($pageTrans->currentPage() == 1);
    @endphp

    @if ($isSpotlight)
      <!-- 1. Featured Spotlight Article (Top of Page 1) -->
      <div class="col-12 mb-4">
        <article class="blog-spotlight-card">
          <div class="blog-spotlight-media">
            <a href="{{ route('home') . '/blog/' . $pageTran->slug }}" aria-label="{{ $pageTran->title }}">
              <img 
                class="{{ ($general->lazy_loading == true) ? 'lazyload' : '' }}" 
                alt="{{ $pageTran->title }}" 
                {{ ($general->lazy_loading == true) ? 'data-' : '' }}src="{{ ($pageTran->featured_image) ? $pageTran->featured_image : asset('assets/img/no-thumb.svg') }}"
                loading="eager"
              >
            </a>
            <span class="blog-spotlight-badge">
              <i class="fas fa-star text-amber me-1"></i> {{ __('Featured Playbook') }}
            </span>
          </div>

          <div class="blog-spotlight-body">
            <div class="blog-meta-bar mb-2">
              <span class="blog-meta-tag"><i class="far fa-clock me-1 text-emerald"></i> {{ __('5 min read') }}</span>
              <span class="blog-meta-dot">•</span>
              <span class="blog-meta-tag"><i class="far fa-check-circle me-1 text-emerald"></i> {{ __('Verified SEO Strategy') }}</span>
              @if ($postDate)
                <span class="blog-meta-dot">•</span>
                <span class="blog-meta-tag"><i class="far fa-calendar-alt me-1"></i> {{ $postDate }}</span>
              @endif
            </div>

            <h2 class="blog-spotlight-title">
              <a href="{{ route('home') . '/blog/' . $pageTran->slug }}">{{ $pageTran->title }}</a>
            </h2>

            @if (!empty($summary))
              <p class="blog-spotlight-summary">{{ \Illuminate\Support\Str::limit($summary, 160) }}</p>
            @endif

            <div class="mt-auto pt-3">
              <a href="{{ route('home') . '/blog/' . $pageTran->slug }}" class="blog-spotlight-btn">
                <span>{{ __('Read Complete Guide') }}</span>
                <i class="fas fa-arrow-right" aria-hidden="true"></i>
              </a>
            </div>
          </div>
        </article>
      </div>
    @else
      <!-- 2. Standard Responsive Blog Card (2 per row on wide container) -->
      <div class="col-md-6 d-flex mb-4">
        <article class="card blog-entry-card w-100">
          <div class="card-image position-relative">
            <a href="{{ route('home') . '/blog/' . $pageTran->slug }}" aria-label="{{ $pageTran->title }}">
              <img 
                class="w-100 {{ ($general->lazy_loading == true) ? 'lazyload' : '' }}" 
                alt="{{ $pageTran->title }}" 
                {{ ($general->lazy_loading == true) ? 'data-' : '' }}src="{{ ($pageTran->featured_image) ? $pageTran->featured_image : asset('assets/img/no-thumb.svg') }}"
                loading="lazy"
              >
            </a>
            <span class="blog-pill-badge"><i class="fas fa-book-open me-1"></i> {{ __('Guide') }}</span>
          </div>

          <div class="card-body">
            <div class="blog-meta-bar mb-2">
              <span class="blog-meta-tag"><i class="far fa-clock me-1"></i> {{ __('4 min read') }}</span>
              <span class="blog-meta-dot">•</span>
              <span class="blog-meta-tag"><i class="far fa-check-circle me-1 text-emerald"></i> {{ __('Verified') }}</span>
              @if ($postDate)
                <span class="blog-meta-dot">•</span>
                <span class="blog-meta-tag">{{ $postDate }}</span>
              @endif
            </div>

            <h2 class="blog-entry-title">
              <a href="{{ route('home') . '/blog/' . $pageTran->slug }}">{{ $pageTran->title }}</a>
            </h2>

            @if (!empty($summary))
              <p class="blog-entry-summary">{{ \Illuminate\Support\Str::limit($summary, 105) }}</p>
            @endif

            <div class="blog-card-footer mt-auto pt-2">
              <a href="{{ route('home') . '/blog/' . $pageTran->slug }}" class="blog-read-more">
                <span>{{ __('Read Guide') }}</span>
                <i class="fas fa-arrow-right text-xs" aria-hidden="true"></i>
              </a>
            </div>
          </div>
        </article>
      </div>
    @endif
  @endforeach

  <!-- Modern Pagination Container -->
  <div class="col-12 d-flex justify-content-center mt-3 mb-5">
    {{ $pageTrans->links() }}
  </div>
</div>
