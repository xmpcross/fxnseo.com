@php
    $__seoSettings = \App\Models\Admin\SeoSetting::current();
    $__metaTitle = trim((string) \Artesaos\SEOTools\Facades\SEOMeta::getTitle());
    $__metaDescription = trim(strip_tags((string) \Artesaos\SEOTools\Facades\SEOMeta::getDescription()));
    $__metaCanonical = html_entity_decode(
        (string) (\Artesaos\SEOTools\Facades\SEOMeta::getCanonical() ?: url()->current()),
        ENT_QUOTES | ENT_HTML5,
        'UTF-8'
    );
    $__metaImage = data_get($pageTrans ?? null, 'featured_image')
        ?: data_get($page ?? null, 'featured_image')
        ?: data_get($header ?? null, 'logo_light')
        ?: $__seoSettings->default_image
        ?: config('meta.image');
    if ($__metaImage && ! \Illuminate\Support\Str::startsWith($__metaImage, ['http://', 'https://'])) {
        $__metaImage = url('/' . ltrim($__metaImage, '/'));
    }
    $__metaType = data_get($page ?? null, 'type') === 'post' ? 'article' : 'website';
    $__robotsSetting = data_get($pageTrans ?? null, 'robots_meta');
    $__metaRobots = isset($pageTrans) && $__robotsSetting !== null && ! (bool) $__robotsSetting
        ? 'noindex, follow'
        : 'index, follow, max-snippet:-1, max-video-preview:-1, max-image-preview:large';

    if (Route::is('tools')) {
        $__metaTitle = 'Free SEO Tools: 60+ Browser-Based Utilities - ' . config('app.name');
        $__metaDescription = 'Explore free SEO tools for backlinks, keywords, rank tracking, metadata, website analysis, content and YouTube optimization.';
        $__metaCanonical = route('tools');
        $__metaType = 'website';
    }

    if (request()->routeIs('login', 'register', 'password.*', 'verify.email', 'verification.verify', 'user.profile')) {
        $__metaCanonical = url()->current();
        $__metaRobots = 'noindex, nofollow';
    }
@endphp

@include('meta::manager', [
    'title' => $__metaTitle ?: ($__seoSettings->site_name ?: config('meta.title')),
    'description' => $__metaDescription ?: ($__seoSettings->site_description ?: config('meta.description')),
    'image' => $__metaImage,
    'type' => $__metaType,
    'robots' => $__metaRobots,
    'author' => $__seoSettings->author_name ?: config('meta.author'),
    'keywords' => config('meta.keywords'),
    'twitter_site' => $__seoSettings->twitter_site ?: config('meta.twitter_site'),
    'twitter_card' => config('meta.twitter_card'),
])
<link rel="canonical" href="{{ $__metaCanonical }}">
