<!-- Top Advertisement Slot -->
@if ( $page->ads_status && $advertisement->sidebar_top_status && $advertisement->sidebar_top != null )
    <div class="mb-3 {{ $advertisement->sidebar_top_sticky ? 'sticky-top' : '' }}">
        <x-public.advertisement.sidebar-top :advertisement="$advertisement" /> 
    </div>
@endif

<!-- Widget 1: Real-Time API Status -->
<div class="yt-sidebar-card mb-3">
    <div class="yt-sidebar-card-header">
        <span class="yt-status-pulse"></span>
        <h3 class="yt-sidebar-card-title">{{ __('API Live Status') }}</h3>
    </div>
    <div class="yt-sidebar-card-body">
        <div class="yt-status-row">
            <span class="yt-status-label">{{ __('Engine:') }}</span>
            <span class="yt-status-value">YouTube Data v3</span>
        </div>
        <div class="yt-status-row">
            <span class="yt-status-label">{{ __('Dataset:') }}</span>
            <span class="yt-status-value">chart=mostPopular</span>
        </div>
        <div class="yt-status-row">
            <span class="yt-status-label">{{ __('Refresh Rate:') }}</span>
            <span class="yt-status-value text-emerald">Real-time live feeds</span>
        </div>
        <div class="yt-status-row">
            <span class="yt-status-label">{{ __('Cost:') }}</span>
            <span class="yt-status-value text-emerald">100% Free · No Sign-Up</span>
        </div>
    </div>
</div>

<!-- Widget 2: Contextual YouTube Creator Suite -->
<div class="yt-sidebar-card mb-3">
    <div class="yt-sidebar-card-header">
        <i class="fab fa-youtube text-danger me-2" style="font-size: 1.1rem;"></i>
        <h3 class="yt-sidebar-card-title">{{ __('YouTube Creator Suite') }}</h3>
    </div>
    <div class="yt-sidebar-card-body p-0">
        <div class="yt-suite-list">
            <a href="{{ url('/youtube-tag-extractor') }}" class="yt-suite-item">
                <div class="yt-suite-icon"><i class="fas fa-tags"></i></div>
                <div class="yt-suite-info">
                    <span class="yt-suite-name">{{ __('Tag Extractor') }}</span>
                    <span class="yt-suite-desc">{{ __('Pull public tags from any video URL') }}</span>
                </div>
                <i class="fas fa-chevron-right yt-suite-arrow"></i>
            </a>

            <a href="{{ url('/youtube-title-generator') }}" class="yt-suite-item">
                <div class="yt-suite-icon"><i class="fas fa-heading"></i></div>
                <div class="yt-suite-info">
                    <span class="yt-suite-name">{{ __('Title Generator') }}</span>
                    <span class="yt-suite-desc">{{ __('Generate click-worthy title hooks') }}</span>
                </div>
                <i class="fas fa-chevron-right yt-suite-arrow"></i>
            </a>

            <a href="{{ url('/youtube-description-generator') }}" class="yt-suite-item">
                <div class="yt-suite-icon"><i class="fas fa-align-left"></i></div>
                <div class="yt-suite-info">
                    <span class="yt-suite-name">{{ __('Description Generator') }}</span>
                    <span class="yt-suite-desc">{{ __('Format SEO copy with chapters') }}</span>
                </div>
                <i class="fas fa-chevron-right yt-suite-arrow"></i>
            </a>

            <a href="{{ url('/youtube-money-calculator') }}" class="yt-suite-item">
                <div class="yt-suite-icon"><i class="fas fa-coins"></i></div>
                <div class="yt-suite-info">
                    <span class="yt-suite-name">{{ __('Money Calculator') }}</span>
                    <span class="yt-suite-desc">{{ __('Estimate video RPM & ad revenue') }}</span>
                </div>
                <i class="fas fa-chevron-right yt-suite-arrow"></i>
            </a>

            <a href="{{ url('/youtube-channel-statistics') }}" class="yt-suite-item">
                <div class="yt-suite-icon"><i class="fas fa-chart-bar"></i></div>
                <div class="yt-suite-info">
                    <span class="yt-suite-name">{{ __('Channel Statistics') }}</span>
                    <span class="yt-suite-desc">{{ __('Audit views, subs & upload counts') }}</span>
                </div>
                <i class="fas fa-chevron-right yt-suite-arrow"></i>
            </a>

            <a href="{{ url('/youtube-video-statistics') }}" class="yt-suite-item">
                <div class="yt-suite-icon"><i class="fas fa-play-circle"></i></div>
                <div class="yt-suite-info">
                    <span class="yt-suite-name">{{ __('Video Statistics') }}</span>
                    <span class="yt-suite-desc">{{ __('Deep engagement & like audit') }}</span>
                </div>
                <i class="fas fa-chevron-right yt-suite-arrow"></i>
            </a>

            <a href="{{ url('/youtube-channel-banner-downloader') }}" class="yt-suite-item">
                <div class="yt-suite-icon"><i class="fas fa-image"></i></div>
                <div class="yt-suite-info">
                    <span class="yt-suite-name">{{ __('Banner Downloader') }}</span>
                    <span class="yt-suite-desc">{{ __('Inspect channel cover graphics') }}</span>
                </div>
                <i class="fas fa-chevron-right yt-suite-arrow"></i>
            </a>
        </div>
    </div>
</div>

<!-- Middle Advertisement Slot -->
@if ( $page->ads_status && $advertisement->sidebar_middle_status && $advertisement->sidebar_middle != null )
    <div class="mb-3 {{ $advertisement->sidebar_middle_sticky ? 'sticky-top' : '' }}">
        <x-public.advertisement.sidebar-middle :advertisement="$advertisement" />
    </div>
@endif

<!-- Widget 3: YouTube Video SEO Ranking Checklist -->
<div class="yt-sidebar-card mb-3">
    <div class="yt-sidebar-card-header">
        <i class="fas fa-check-double text-success me-2" style="font-size: 1.05rem;"></i>
        <h3 class="yt-sidebar-card-title">{{ __('Video SEO Checklist') }}</h3>
    </div>
    <div class="yt-sidebar-card-body">
        <ul class="yt-checklist">
            <li>
                <i class="fas fa-check-circle text-emerald"></i>
                <span>{{ __('Primary keyword in first 40 title chars') }}</span>
            </li>
            <li>
                <i class="fas fa-check-circle text-emerald"></i>
                <span>{{ __('High-contrast thumbnail with 3 focal points') }}</span>
            </li>
            <li>
                <i class="fas fa-check-circle text-emerald"></i>
                <span>{{ __('Timestamp chapters in description') }}</span>
            </li>
            <li>
                <i class="fas fa-check-circle text-emerald"></i>
                <span>{{ __('5–8 semantic tags matching intent') }}</span>
            </li>
            <li>
                <i class="fas fa-check-circle text-emerald"></i>
                <span>{{ __('Pinned comment with engagement question') }}</span>
            </li>
            <li>
                <i class="fas fa-check-circle text-emerald"></i>
                <span>{{ __('End screen linking to related playlist') }}</span>
            </li>
        </ul>
        <div class="mt-3 pt-2 text-center border-top">
            <a href="#tool-guide-section" class="yt-guide-link">
                <i class="fas fa-book-open me-1"></i> {{ __('Read Full Optimization Guide ↓') }}
            </a>
        </div>
    </div>
</div>

<!-- Widget 4: Top Trending Global Markets -->
<div class="yt-sidebar-card mb-3">
    <div class="yt-sidebar-card-header">
        <i class="fas fa-globe-americas text-primary me-2" style="font-size: 1.05rem;"></i>
        <h3 class="yt-sidebar-card-title">{{ __('Top Regional Feeds') }}</h3>
    </div>
    <div class="yt-sidebar-card-body">
        <p class="small text-muted mb-2">{{ __('Trending patterns vary significantly across key geographical markets:') }}</p>
        <div class="yt-market-chips">
            <span class="yt-market-badge">🇺🇸 United States</span>
            <span class="yt-market-badge">🇬🇧 United Kingdom</span>
            <span class="yt-market-badge">🇨🇦 Canada</span>
            <span class="yt-market-badge">🇦🇺 Australia</span>
            <span class="yt-market-badge">🇮🇳 India</span>
            <span class="yt-market-badge">🇩🇪 Germany</span>
            <span class="yt-market-badge">🇯🇵 Japan</span>
            <span class="yt-market-badge">🇧🇷 Brazil</span>
            <span class="yt-market-badge">🇫🇷 France</span>
            <span class="yt-market-badge">🇲🇽 Mexico</span>
        </div>
    </div>
</div>

<!-- Bottom Advertisement Slot -->
@if ( $page->ads_status && $advertisement->sidebar_bottom_status && $advertisement->sidebar_bottom != null )
    <div class="mb-3 {{ $advertisement->sidebar_bottom_sticky ? 'sticky-top' : '' }}">
        <x-public.advertisement.sidebar-bottom :advertisement="$advertisement" />
    </div>
@endif
