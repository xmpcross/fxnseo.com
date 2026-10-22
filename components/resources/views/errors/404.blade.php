@php
  $header = \App\Models\Admin\Header::first();
  $general = \App\Models\Admin\General::first();
  $siteTitle = config('app.name');
  $menus = \App\Models\Admin\Menu::with('children')->where('parent_id', 0)->orderBy('sort','ASC')->get()->toArray();
  $footer = \App\Models\Admin\FooterTranslation::where('locale', app()->getLocale())->first();
  $socials = \App\Models\Admin\Social::orderBy('id', 'ASC')->get()->toArray();
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ localization()->getCurrentLocaleDirection() }}">
    <head>
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-JGE2B6YCEW"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'G-JGE2B6YCEW');
        </script>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="{{ $header->favicon ?? asset('assets/img/favicon.svg') }}">

        <title>{{ __('Page Not Found (Error 404)') }} - {{ config('app.name') }}</title>
        <meta name="robots" content="noindex, follow"/>
        
        @if ( $general->page_load )
            <!-- Pace -->
            <script src="{{ asset('assets/js/pace.min.js') }}" defer></script>
        @endif

        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.min.css') }}">

        <!-- Theme CSS -->
        <link type="text/css" href="{{ asset('assets/css/main.'.localization()->getCurrentLocaleDirection().'.min.css') }}" rel="stylesheet">

        <!-- Custom CSS -->
        <link type="text/css" href="{{ asset('assets/css/google-fonts-local.css') }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('assets/css/custom.'.localization()->getCurrentLocaleDirection().'.css') }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('assets/css/shared-public-components.css') }}?v={{ @filemtime(dirname(base_path()).'/assets/css/shared-public-components.css') ?: '1' }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('assets/css/tool-template.css') }}?v={{ @filemtime(dirname(base_path()).'/assets/css/tool-template.css') ?: '1' }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('assets/css/recap-color-scheme.css') }}?v={{ @filemtime(dirname(base_path()).'/assets/css/recap-color-scheme.css') ?: '1' }}" rel="stylesheet">

        <style>
          .error-404-container {
            min-height: 65vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 80px 20px;
            text-align: center;
            background: #f8fafc;
            font-family: var(--site-font-family);
          }
          .error-404-card {
            max-width: 680px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            padding: 50px 40px;
            box-shadow: 0 12px 36px -6px rgba(15, 23, 42, 0.06);
          }
          .error-404-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #eef2ff;
            color: #2447e0;
            border: 1px solid rgba(36, 71, 224, 0.25);
            border-radius: 20px;
            padding: 4px 14px;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 20px;
          }
          .error-404-code {
            font-size: 72px;
            font-weight: 800;
            line-height: 1;
            color: #0f172a;
            margin-bottom: 12px;
            letter-spacing: -0.03em;
          }
          .error-404-code span {
            color: #2447e0;
          }
          .error-404-title {
            font-size: 24px;
            font-weight: 800 !important;
            color: #0f172a;
            margin-bottom: 12px;
          }
          .error-404-text {
            color: #64748b;
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 30px;
          }
          .error-404-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
          }
          .error-btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: linear-gradient(135deg, #2447e0 0%, #1b38b8 100%);
            color: #ffffff !important;
            font-weight: 700;
            font-size: 14px;
            border-radius: 12px;
            text-decoration: none !important;
            box-shadow: 0 4px 14px rgba(36, 71, 224, 0.25);
            transition: all 0.2s ease;
          }
          .error-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(36, 71, 224, 0.35);
          }
          .error-btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            background: #ffffff;
            color: #334155 !important;
            border: 1px solid #e2e8f0;
            font-weight: 600;
            font-size: 14px;
            border-radius: 12px;
            text-decoration: none !important;
            transition: all 0.2s ease;
          }
          .error-btn-secondary:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
            color: #0f172a !important;
          }
        </style>
      <link rel="stylesheet" href="{{ asset('assets/css/site-typography.css') }}?v={{ @filemtime(dirname(base_path()).'/assets/css/site-typography.css') ?: '1' }}">
</head>
    <body class="antialiased {{ Cookie::get('theme_mode') }}">

      <div class="page">
        <!-- Site Header Navbar -->
        <x-public.navbar :header="$header" :siteTitle="$siteTitle" :menus="$menus" :general="$general" />

        <main class="error-404-container">
          <div class="error-404-card">
            <div class="error-404-badge">
              <span class="pulse-indicator"></span>
              <span><i class="fas fa-compass me-1"></i> {{ __('Page Not Found • Error 404') }}</span>
            </div>
            <div class="error-404-code">4<span>0</span>4</div>
            <h1 class="error-404-title hero-title">{{ __('Looking for a tool or guide?') }}</h1>
            <p class="error-404-text">
              {{ __('The page you are looking for may have been moved, renamed, or is temporarily unavailable. Browse our collection of 70+ free utilities or return home.') }}
            </p>
            <div class="error-404-actions">
              <a href="{{ route('tools') }}" class="error-btn-primary">
                <i class="fas fa-layer-group"></i>
                <span>{{ __('Browse 70+ Tools') }}</span>
              </a>
              <a href="{{ url('/') }}" class="error-btn-secondary">
                <i class="fas fa-home"></i>
                <span>{{ __('Return to Homepage') }}</span>
              </a>
              <a href="{{ url('/blog') }}" class="error-btn-secondary">
                <i class="fas fa-newspaper"></i>
                <span>{{ __('Read SEO Guides') }}</span>
              </a>
            </div>
          </div>
        </main>

        <!-- Site Footer -->
        <x-public.footer :footer="$footer" :general="$general" :socials="$socials" />
      </div>

    </body>
</html>
