@php
    $__isTool = isset($page) && (($page->type ?? '') === 'tool');
    $__curSlug = $page->slug ?? '';
    $__isYtTool = str_contains($__curSlug, 'youtube');
@endphp

<!-- Top Advertisement Slot -->
@if ( $page->ads_status && $advertisement->sidebar_top_status && $advertisement->sidebar_top != null )
    <div class="mb-3 {{ $advertisement->sidebar_top_sticky ? 'sticky-top' : '' }}">
        <x-public.advertisement.sidebar-top :advertisement="$advertisement" /> 
    </div>
@endif

<!-- Tool Engine Status (Tool Pages Only) -->
@if ( $__isTool )
    <div class="yt-sidebar-card mb-3">
        <div class="yt-sidebar-card-header">
            <span class="yt-status-pulse"></span>
            <h3 class="yt-sidebar-card-title">{{ __('Tool Engine Status') }}</h3>
        </div>
        <div class="yt-sidebar-card-body">
            <div class="yt-status-row">
                <span class="yt-status-label">{{ __('Engine:') }}</span>
                <span class="yt-status-value">{{ $__isYtTool ? 'YouTube Data v3' : 'Cloud Diagnostics v2' }}</span>
            </div>
            <div class="yt-status-row">
                <span class="yt-status-label">{{ __('Speed / Latency:') }}</span>
                <span class="yt-status-value text-emerald">{{ __('< 0.25s Instant') }}</span>
            </div>
            <div class="yt-status-row">
                <span class="yt-status-label">{{ __('Privacy:') }}</span>
                <span class="yt-status-value text-emerald">{{ __('Browser First · No Logs') }}</span>
            </div>
            <div class="yt-status-row">
                <span class="yt-status-label">{{ __('Cost:') }}</span>
                <span class="yt-status-value text-emerald">{{ __('100% Free · No Sign-Up') }}</span>
            </div>
        </div>
    </div>
@endif

<!-- Popular Tools Widget -->
@if ( $sidebar->tool_status && !empty($popularTools) )
    <div class="yt-sidebar-card mb-3 {{ $sidebar->tool_sticky ? 'sticky-top' : '' }}">
        <div class="yt-sidebar-card-header">
            <i class="fas fa-fire text-danger me-2" style="font-size: 1rem;"></i>
            <h3 class="yt-sidebar-card-title">{{ __('Popular Tools') }}</h3>
        </div>
        <div class="yt-sidebar-card-body p-0">
            <div class="yt-suite-list">
                @foreach ($popularTools as $key => $value)
                    @php
                        $toolSlug = $value['slug'] ?? '';
                        $isYtItem = str_contains($toolSlug, 'youtube');
                        $toolIconClass = $isYtItem ? 'fab fa-youtube text-danger' : 'fas fa-bolt text-emerald';
                        $toolBgClass = $isYtItem ? '#fee2e2' : '#eef2ff';
                    @endphp
                    <a href="{{ ( empty( $value['custom_tool_link'] ) ) ? route('home') . '/' . $value['slug'] : $value['custom_tool_link'] }}" title="{{ $value['title'] }}" target="{{ $value['target'] }}" class="yt-suite-item">
                        <div class="yt-suite-icon" style="background: {{ $toolBgClass }};">
                            <i class="{{ $toolIconClass }}" style="font-size: 0.95rem;"></i>
                        </div>
                        <div class="yt-suite-info">
                            <span class="yt-suite-name">{{ $value['title'] }}</span>
                        </div>
                        <i class="fas fa-chevron-right yt-suite-arrow"></i>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endif

<!-- Middle Advertisement Slot -->
@if ( $page->ads_status && $advertisement->sidebar_middle_status && $advertisement->sidebar_middle != null )
    <div class="mb-3 {{ $advertisement->sidebar_middle_sticky ? 'sticky-top' : '' }}">
        <x-public.advertisement.sidebar-middle :advertisement="$advertisement" />
    </div>
@endif

<!-- Contextual Best Practices Checklist (Tool Pages Only) -->
@if ( $__isTool )
    <div class="yt-sidebar-card mb-3">
        <div class="yt-sidebar-card-header">
            <i class="fas fa-check-double text-emerald me-2" style="font-size: 1.05rem;"></i>
            <h3 class="yt-sidebar-card-title">{{ $__isYtTool ? __('Video SEO Checklist') : __('SEO Best Practices') }}</h3>
        </div>
        <div class="yt-sidebar-card-body">
            <ul class="yt-checklist">
                @if ($__isYtTool)
                    <li><i class="fas fa-check-circle text-emerald"></i><span>{{ __('Target keyword in first 40 title chars') }}</span></li>
                    <li><i class="fas fa-check-circle text-emerald"></i><span>{{ __('High-contrast thumbnail focal point') }}</span></li>
                    <li><i class="fas fa-check-circle text-emerald"></i><span>{{ __('Timestamp chapters in description') }}</span></li>
                    <li><i class="fas fa-check-circle text-emerald"></i><span>{{ __('Relevant semantic tags matching intent') }}</span></li>
                    <li><i class="fas fa-check-circle text-emerald"></i><span>{{ __('Pinned comment with engagement hook') }}</span></li>
                @else
                    <li><i class="fas fa-check-circle text-emerald"></i><span>{{ __('Target keyword in meta title & H1') }}</span></li>
                    <li><i class="fas fa-check-circle text-emerald"></i><span>{{ __('Compelling meta description (< 160 chars)') }}</span></li>
                    <li><i class="fas fa-check-circle text-emerald"></i><span>{{ __('Mobile-responsive & fast page load') }}</span></li>
                    <li><i class="fas fa-check-circle text-emerald"></i><span>{{ __('HTTPS / SSL encryption enabled') }}</span></li>
                    <li><i class="fas fa-check-circle text-emerald"></i><span>{{ __('Clean URL structure with canonical link') }}</span></li>
                @endif
            </ul>
        </div>
    </div>
@endif

<!-- Recent Posts Widget -->
@if ( $sidebar->post_status && !empty($recentPosts) )
    <div class="yt-sidebar-card mb-3 {{ $sidebar->post_sticky ? 'sticky-top' : '' }}">
        <div class="yt-sidebar-card-header">
            <i class="fas fa-newspaper text-emerald me-2" style="font-size: 1rem;"></i>
            <h3 class="yt-sidebar-card-title">{{ __('Recent Guides & Insights') }}</h3>
        </div>
        <div class="yt-sidebar-card-body p-0">
            <div class="yt-suite-list">
                @foreach ($recentPosts as $key => $value)
                    <a href="{{ route('home') . '/blog/' . $value['slug'] }}" class="yt-suite-item" title="{{ $value['title'] }}" target="{{ $value['target'] }}">
                        @if ( $general->featured_images_in_sidebar_status && !empty($value['featured_image']) )
                            <img class="post-featured-image rounded-2 {{ ($general->lazy_loading) ? 'lazyload' : '' }}" style="width: 44px; height: 44px; object-fit: cover; flex-shrink: 0;" data-src="{{ $value['featured_image'] }}" @if (!$general->lazy_loading) src="{{ $value['featured_image'] }}" @endif alt="{{ $value['title'] }}">
                        @else
                            <div class="yt-suite-icon" style="background: #f1f5f9; color: #64748b;">
                                <i class="far fa-file-alt"></i>
                            </div>
                        @endif
                        <div class="yt-suite-info">
                            <span class="yt-suite-name" style="font-size: 0.84rem; line-height: 1.35;">{{ $value['title'] }}</span>
                            <span class="yt-suite-desc mt-1">{{ \Carbon\Carbon::parse( ($value['updated_at']) ? $value['updated_at'] : $value['created_at'] )->format('M j, Y') }}</span>
                        </div>
                        <i class="fas fa-chevron-right yt-suite-arrow"></i>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endif

<!-- Bottom Advertisement Slot -->
@if ( $page->ads_status && $advertisement->sidebar_bottom_status && $advertisement->sidebar_bottom != null )
    <div class="mb-3 {{ $advertisement->sidebar_bottom_sticky ? 'sticky-top' : '' }}">
        <x-public.advertisement.sidebar-bottom :advertisement="$advertisement" />
    </div>
@endif