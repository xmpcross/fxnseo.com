@if (empty($posts))
    <div class="text-center text-muted py-5">
        <i class="fas fa-inbox fa-2x mb-3 d-block"></i>
        <p class="mb-0">{{ __('No resources have been published yet. Check back soon.') }}</p>
    </div>
@else
    <div class="row g-4">
        @foreach ($posts as $post)
            <div class="col-md-6 col-lg-4 d-flex">
                <div class="card w-100 h-100 shadow-sm border-0">
                    <a href="{{ route('public.resource', $post['slug']) }}" class="text-decoration-none d-flex flex-column h-100">
                        @if (!empty($post['cover']))
                            <img src="{{ $post['cover'] }}" alt="{{ $post['title'] }}" class="card-img-top" style="height:180px;object-fit:cover;" loading="lazy">
                        @else
                            <div class="card-img-top d-flex align-items-center justify-content-center bg-gradient-primary text-white" style="height:180px;">
                                <i class="fas fa-file-lines fa-2x opacity-75"></i>
                            </div>
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h3 class="h6 fw-bold text-dark mb-2">{{ $post['title'] }}</h3>
                            @if (!empty($post['excerpt']))
                                <p class="text-sm text-secondary mb-0 flex-grow-1">{{ \Illuminate\Support\Str::limit($post['excerpt'], 120) }}</p>
                            @endif
                            <span class="text-primary text-sm fw-bold mt-3">{{ __('Read more') }} <i class="fas fa-arrow-right ms-1"></i></span>
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    @if (($pagination['pageCount'] ?? 1) > 1)
        <nav class="mt-4" aria-label="{{ __('Resources pagination') }}">
            <ul class="pagination justify-content-center">
                @for ($p = 1; $p <= $pagination['pageCount']; $p++)
                    <li class="page-item {{ ($pagination['page'] ?? 1) == $p ? 'active' : '' }}">
                        <a class="page-link" href="{{ route('public.resources') }}?page={{ $p }}">{{ $p }}</a>
                    </li>
                @endfor
            </ul>
        </nav>
    @endif
@endif
