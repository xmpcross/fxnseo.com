@php
    $alternates = [];
    $isModelPage = isset($page) && $page instanceof \App\Models\Admin\Page;
    if (request()->routeIs('home')) {
        $alternates['en'] = url('/');
    } elseif (!request()->routeIs('login', 'admin.login', 'register', 'password.*', 'verify.email', 'verification.verify', 'user.profile', 'blog')
        && $isModelPage && $page->type !== 'home') {
        foreach ($page->translations as $translation) {
            if (!$translation->robots_meta || !trim((string) $translation->title)) continue;
            if (!localization()->getSupportedLocales()->has($translation->locale)) continue;
            $alternates[$translation->locale] = localization()->getLocalizedURL($translation->locale, url()->current(), [], false);
        }
    }
@endphp
@foreach ($alternates as $code => $alternateUrl)
<link rel="alternate" hreflang="{{ $code }}" href="{{ $alternateUrl }}">
@endforeach
@if (isset($alternates['en']))
<link rel="alternate" hreflang="x-default" href="{{ $alternates['en'] }}">
@endif
