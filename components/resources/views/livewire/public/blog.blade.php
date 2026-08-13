<div class="row blog-card-grid">
  @foreach ($pageTrans as $pageTran)
        <div class="col-lg-4 col-sm-6 d-flex">
          <article class="card blog-entry-card mb-4 w-100">
            <div class="card-image border-radius-lg position-relative">
              <a href="{{ route('home') . '/blog/' . $pageTran->slug }}">
                <img class="w-100 {{ ($general->lazy_loading == true) ? 'lazyload' : '' }}" alt="{{ $pageTran->title }}" {{ ($general->lazy_loading == true) ? 'data-' : '' }}src="{{ ($pageTran->featured_image) ? $pageTran->featured_image : asset('assets/img/no-thumb.svg') }}">
              </a>
            </div>
            <div class="card-body">
              <h2 class="blog-entry-title">
                <a href="{{ route('home') . '/blog/' . $pageTran->slug }}" class="font-weight-bold">{{ $pageTran->title }}</a>
              </h2>
              {{-- description hidden on blog listing per request --}}

              <a href="{{ route('home') . '/blog/' . $pageTran->slug }}" class="blog-read-more icon-move-right">{{ __('Read More') }}
                <i class="fas fa-arrow-right text-sm" aria-hidden="true"></i>
              </a>
            </div>
          </article>
        </div>
  @endforeach

  <div class="d-flex justify-content-center">
    {{ $pageTrans->links() }}
  </div>
</div>
