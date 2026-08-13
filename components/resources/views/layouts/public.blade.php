<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ localization()->getCurrentLocaleDirection() }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="{{ $header->favicon }}">

        {!! SEO::generate() !!}

        {{-- Structured data: SEO / GEO / AEO --}}
        @php
          $__ldLogo = (isset($header) && !empty($header->logo_light)) ? $header->logo_light : url('/assets/img/logo-light.svg');
          $__schemas = [
            [
              '@context' => 'https://schema.org', '@type' => 'Organization',
              'name' => env('APP_NAME'), 'url' => url('/'),
              'logo' => $__ldLogo,
              'sameAs' => ['https://www.facebook.com/fxnseo/', 'https://x.com/fxnseo'],
            ],
            [
              '@context' => 'https://schema.org', '@type' => 'WebSite',
              'name' => env('APP_NAME'), 'url' => url('/'),
              'description' => 'Free online SEO tools — 60+ browser-based utilities for keyword analysis, backlinks, rank tracking, meta tags, schema, and YouTube.',
            ],
          ];
          if ( (($page->type ?? '') === 'tool') && isset($pageTrans) ) {
            $__schemas[] = [
              '@context' => 'https://schema.org', '@type' => 'WebApplication',
              'name' => __($pageTrans->title), 'url' => url()->current(),
              'applicationCategory' => 'BusinessApplication',
              'operatingSystem' => 'All (web-based)',
              'browserRequirements' => 'Requires JavaScript',
              'offers' => ['@type' => 'Offer', 'price' => '0', 'priceCurrency' => 'USD'],
              'description' => trim(strip_tags((string) ($pageTrans->short_description ?? ''))),
              'publisher' => ['@type' => 'Organization', 'name' => env('APP_NAME'), 'url' => url('/')],
            ];
          }
        @endphp
        @foreach ($__schemas as $__s)
        <script type="application/ld+json">{!! json_encode($__s, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
        @endforeach

        @foreach(localization()->getSupportedLocales() as $localeCode => $properties)
          <link rel="alternate" hreflang="{{ $properties->key() }}" href="{{ localization()->getLocalizedURL($properties->key(), null, [], false) }}">
        @endforeach

        @if ( $general->page_load )
            <!-- Pace -->
            <script src="{{ asset('assets/js/pace.min.js') }}" defer></script>
        @endif

        @if ( $general->adblock_detection )
          <!-- Sweet Alert 2 -->
          <link rel="preload" href="{{ asset('assets/css/sweetalert2.min.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
          <noscript><link rel="stylesheet" href="{{ asset('assets/css/sweetalert2.min.css') }}"></noscript>
        @endif

        <!-- Font Awesome -->
        <link rel="preload" href="{{ asset('assets/css/fontawesome.min.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link rel="stylesheet" href="{{ asset('assets/css/fontawesome.min.css') }}"></noscript>

        <!-- Nucleo Icons -->
        <link rel="preload" href="{{ asset('assets/css/nucleo-icons.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link rel="stylesheet" href="{{ asset('assets/css/nucleo-icons.css') }}"></noscript>
        
        <link rel="preload" href="{{ asset('assets/css/nucleo-svg.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link rel="stylesheet" href="{{ asset('assets/css/nucleo-svg.css') }}"></noscript>

        <!-- jQuery -->
        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>

        <!-- Popper -->
        <script src="{{ asset('assets/js/popper.min.js') }}" defer></script>

        <!-- Bootstrap -->
        <script src="{{ asset('assets/js/bootstrap.min.js') }}" defer></script>

        <!-- Perfect Scrollbar -->
        <script src="{{ asset('assets/js/perfect-scrollbar.min.js') }}" defer></script>

        <!-- Smooth Scrollbar -->
        <script src="{{ asset('assets/js/smooth-scrollbar.min.js') }}" defer></script>

        <!-- Theme CSS -->
        <link type="text/css" href="{{ asset('assets/css/main.'.localization()->getCurrentLocaleDirection().'.min.css') }}" rel="stylesheet">

        <!-- Custom CSS -->
        @php $customCssPath = dirname(base_path()).'/assets/css/custom.'.localization()->getCurrentLocaleDirection().'.css'; @endphp
        <link type="text/css" href="{{ asset('assets/css/google-fonts-local.css') }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('assets/css/custom.'.localization()->getCurrentLocaleDirection().'.css') }}?v={{ file_exists($customCssPath) ? filemtime($customCssPath) : '1' }}" rel="stylesheet">
        
        <style>
          body, p, button, input, select, textarea, .card, .card .card-body {
            font-family: "Outfit", ui-sans-serif, system-ui, -apple-system, "Segoe UI", sans-serif !important;
          }
        </style>

        <link type="text/css" href="{{ asset('assets/css/shared-public-components.css') }}?v={{ @filemtime(dirname(base_path()).'/assets/css/shared-public-components.css') ?: '1' }}" rel="stylesheet">
        @if (isset($page) && in_array($page->slug ?? '', ['about-us', 'faqs', 'contact']))
          <link type="text/css" href="{{ asset('assets/css/content-pages.css') }}?v={{ @filemtime(dirname(base_path()).'/assets/css/content-pages.css') ?: '1' }}" rel="stylesheet">
        @endif

        @if (Route::is('home'))
          <link type="text/css" href="{{ asset('assets/css/home-content.css') }}?v={{ @filemtime(dirname(base_path()).'/assets/css/home-content.css') ?: '1' }}" rel="stylesheet">
        @endif

        @if (Route::is('tools'))
          <link type="text/css" href="{{ asset('assets/css/tools-content.css') }}?v={{ @filemtime(dirname(base_path()).'/assets/css/tools-content.css') ?: '1' }}" rel="stylesheet">
        @endif

        @if ( $advanced->header_status && $advanced->insert_header != null )
          {!! $advanced->insert_header !!}
        @endif

        @livewireStyles

    </head>
    <body class="antialiased {{ Cookie::get('theme_mode', $general->default_theme_mode) }} {{ Route::is('home') ? 'route-home' : '' }} {{ Route::is('tools') ? 'route-tools' : '' }} {{ (isset($page) && isset($page->type)) ? 'page-type-'.$page->type : '' }} {{ (isset($page) && isset($page->slug)) ? 'page-slug-'.$page->slug : '' }}">

        @if ( $advanced->body_status && $advanced->insert_body != null )
          {!! $advanced->insert_body !!}
        @endif

      @if ( $general->maintenance_mode && ( !Auth::check() || Auth::user()->is_admin != 1 ) && !Route::is('login') && !Route::is('admin.login') )
          
          @livewire('public.maintenance')

      @else

         <div class="page">

            <x-public.navbar :header="$header" :siteTitle="$siteTitle" :menus="$menus" :general="$general" />

            <!-- Begin::page-wrapper -->
            <div class="page-wrapper">
                  <!-- Begin::page-content -->
                  <div class="page-content">

                      @if(Auth::user() && \App\Models\Admin\AuthPages::where('name', 'Verify Email')->first()->status && Auth::user()->email_verified_at == null)
                          <div class="alert alert-important alert-warning alert-dismissible mb-0 text-center rounded-0" role="alert">
                            {{ __('Your email address is not verified.') }} <a href="{{ route('verify.email') }}" class="alert-link text-decoration-underline">{{ __('Verify it here!') }}</a>
                          </div>
                      @endif

                      @if (($page->slug ?? '') === 'about-us')
                          <section class="about-tools-hero">
                            <div class="about-tools-shell about-tools-hero-grid">
                              <div>
                                <nav class="about-tools-breadcrumb" aria-label="Breadcrumb">
                                  <a href="{{ route('home') }}">{{ __('Home') }}</a><span>/</span><span>{{ __($pageTrans->title) }}</span>
                                </nav>
                                <span class="about-tools-kicker">{{ __('Built for clearer decisions') }}</span>
                                <h1>{{ __($pageTrans->title) }}</h1>
                                <p>{{ __($pageTrans->subtitle) }}</p>
                              </div>
                              <div class="about-tools-hero-stats" aria-label="Our principles">
                                <div><b>{{ __('Free') }}</b><span>{{ __('Tools to use') }}</span></div>
                                <div><b>{{ __('Fast') }}</b><span>{{ __('Focused results') }}</span></div>
                                <div><b>{{ __('Private') }}</b><span>{{ __('Browser first') }}</span></div>
                              </div>
                            </div>
                          </section>
                      @elseif (($page->slug ?? '') === 'faqs')
                          @php
                            $__faqDescription = $pageTrans->description ?? '';
                            $__faqQuestionCount = preg_match_all('/class=["\'][^"\']*accordion-item/i', $__faqDescription);
                            $__faqCategoryCount = preg_match_all('/class=["\'][^"\']*faq-category/i', $__faqDescription);
                          @endphp
                          <section class="faq-tools-hero">
                            <div class="faq-tools-shell faq-tools-hero-grid">
                              <div>
                                <nav class="faq-tools-breadcrumb" aria-label="Breadcrumb">
                                  <a href="{{ route('home') }}">{{ __('Home') }}</a><span>/</span><span>{{ __($pageTrans->title) }}</span>
                                </nav>
                                <span class="faq-tools-kicker">{{ __('The answer library') }}</span>
                                <h1>{{ __($pageTrans->title) }}</h1>
                                <p>{{ __($pageTrans->subtitle) }}</p>
                              </div>
                              <div class="faq-tools-hero-stats" aria-label="FAQ overview">
                                <div><b>{{ $__faqQuestionCount }}</b><span>{{ __('Answers') }}</span></div>
                                <div><b>{{ $__faqCategoryCount }}</b><span>{{ __('Topics') }}</span></div>
                                <div><b>0</b><span>{{ __('Sign-ups needed') }}</span></div>
                              </div>
                            </div>
                          </section>
                      @elseif (($page->slug ?? '') === 'contact')
                          <section class="contact-tools-hero">
                            <div class="contact-tools-shell contact-tools-hero-grid">
                              <div>
                                <nav class="contact-tools-breadcrumb" aria-label="Breadcrumb">
                                  <a href="{{ route('home') }}">{{ __('Home') }}</a><span>/</span><span>{{ __($pageTrans->title) }}</span>
                                </nav>
                                <span class="contact-tools-kicker">{{ __('Start a conversation') }}</span>
                                <h1>{{ __($pageTrans->title) }}</h1>
                                <p>{{ __($pageTrans->subtitle) }}</p>
                              </div>
                              <div class="contact-tools-hero-stats" aria-label="Contact overview">
                                <div><b>1–2</b><span>{{ __('Business days') }}</span></div>
                                <div><b>2</b><span>{{ __('Direct inboxes') }}</span></div>
                                <div><b>100%</b><span>{{ __('Human support') }}</span></div>
                              </div>
                            </div>
                          </section>
                      @elseif ($general->parallax_status && ($page->type ?? '') !== 'home' && ($page->slug ?? '') !== 'tools')
                          <section id="parallax" class="text-white">
                              <div class="position-relative overflow-hidden text-center bg-light">
                                <span class="mask" style="
                                      @if ( $general->overlay_type == 'solid' )

                                      background: {{ $general->solid_color }};opacity: {{ $general->opacity }};

                                      @elseif( $general->overlay_type == 'gradient' )

                                      background: {{ $general->gradient_first_color }};
                                      background: -moz-linear-gradient( {{ $general->gradient_position }}, {{ $general->gradient_first_color }}, {{ $general->gradient_second_color }}  );
                                      background: -webkit-linear-gradient( {{ $general->gradient_position }}, {{ $general->gradient_first_color }}, {{ $general->gradient_second_color }} );
                                      background: linear-gradient( {{ $general->gradient_position }}, {{ $general->gradient_first_color }}, {{ $general->gradient_second_color }} );
                                      opacity: {{ $general->opacity }};

                                      @endif

                                "></span>

                                @if ( !empty($general->parallax_image) )
                                  <img alt="{{ __($pageTrans->title) }}" class="position-absolute start-0 top-0 w-100 parallax-image {{ ($general->lazy_loading) ? 'lazyload' : '' }}" data-src="{{ $general->parallax_image }}" @if (!$general->lazy_loading) src="{{ $general->parallax_image }}" @endif style="filter: blur({{ $general->blur }}px)">
                                @endif

                                <div class="container position-relative zindex-1">
                                    <div class="col mx-auto" style="padding: 30px 0 30px 0;">

                                        @if ( $page->ads_status == true && $advertisement->area1_status == true && $advertisement->area1 != null )
                                          <x-public.advertisement.area1 :advertisement="$advertisement" />
                                        @endif
                                        <h1 class="text-white">{{ __($pageTrans->title) }}</h1>
                                        <h2 class="lead text-white letter-normal my-3 h4 fw-normal">{{ __($pageTrans->subtitle) }}</h2>

                                        @if ( $page->ads_status == true && $advertisement->area2_status == true && $advertisement->area2 != null )
                                          <x-public.advertisement.area2 :advertisement="$advertisement" />
                                        @endif
                                    </div>
                                </div>

                              </div>
                          </section>
                      @endif

                      <div class="container py-4">

                          @php
                            $__isLegal = in_array($page->slug ?? '', ['terms-conditions','privacy-policy','cookie-information','affiliate-disclosure','faqs']);
                            $__showLegalToc = $__isLegal && ($page->slug ?? '') !== 'faqs';
                            $__toc = [];
                            $__legalDesc = $pageTrans->description ?? '';
                            if ($__isLegal && $__legalDesc) {
                              // Prefer h2 sections; if the page uses a single h2 title + h3 sections, build the TOC from h3.
                              $__hl = (preg_match_all('/<h2[\s>]/i', $__legalDesc) >= 2) ? 2 : 3;
                              $__i = 0;
                              $__legalDesc = preg_replace_callback('#<h'.$__hl.'([^>]*)>(.*?)</h'.$__hl.'>#is', function($m) use (&$__toc, &$__i, $__hl){
                                $__i++; $id = 'sec-'.$__i; $text = trim(strip_tags($m[2]));
                                $__toc[] = ['id' => $id, 'text' => $text];
                                return '<h'.$__hl.' id="'.$id.'"'.$m[1].'>'.$m[2].'</h'.$__hl.'>';
                              }, $__legalDesc);
                            }

                            $__renderedDescription = $__isLegal ? $__legalDesc : ($pageTrans->description ?? '');
                            if (($page->slug ?? '') === 'about-us' && $__renderedDescription !== '' && class_exists('DOMDocument')) {
                              $__dom = new \DOMDocument('1.0', 'UTF-8');
                              $__previousLibxmlState = libxml_use_internal_errors(true);
                              $__dom->loadHTML('<?xml encoding="UTF-8"><div id="about-description-root">'.$__renderedDescription.'</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                              $__root = $__dom->getElementById('about-description-root');
                              if ($__root) {
                                $__nodes = [];
                                foreach ($__root->childNodes as $__node) { $__nodes[] = $__node; }
                                foreach ($__nodes as $__node) {
                                  if ($__node instanceof \DOMElement && preg_match('/(^|\s)about-section(\s|$)/', $__node->getAttribute('class'))) {
                                    $__container = $__dom->createElement('div');
                                    $__container->setAttribute('class', 'container about-section-container');
                                    $__root->replaceChild($__container, $__node);
                                    $__container->appendChild($__node);
                                  }
                                }
                                $__renderedDescription = '';
                                foreach ($__root->childNodes as $__node) { $__renderedDescription .= $__dom->saveHTML($__node); }
                              }
                              libxml_clear_errors();
                              libxml_use_internal_errors($__previousLibxmlState);
                            }
                          @endphp

                          @if (($page->slug ?? '') === 'faqs')
                            <section class="faq-search-panel" aria-label="Search frequently asked questions">
                              <div class="faq-search-copy">
                                <span>{{ __('Quick answers') }}</span>
                                <h2>{{ __('What can we help you find?') }}</h2>
                                <p>{{ __('Use this guide to understand what each fxnSEO tool does, what information it needs, and how its results can support your SEO, content, website, or YouTube workflow.') }}</p>
                              </div>
                              <label class="faq-search-box" for="faq-search-input">
                                <i class="fas fa-search" aria-hidden="true"></i>
                                <span class="visually-hidden">{{ __('Search questions') }}</span>
                                <input id="faq-search-input" type="search" autocomplete="off" placeholder="{{ __('Search questions, tools, or topics') }}">
                                <button id="faq-search-clear" type="button" hidden>{{ __('Clear') }}</button>
                              </label>
                              <p id="faq-search-status" aria-live="polite"></p>
                            </section>
                          @endif

                          <div class="row">

                              @if ( $__showLegalToc && count($__toc) )
                                <div class="col-lg-3 legal-toc-col">
                                  <nav class="legal-toc">
                                    <div class="legal-toc-title">{{ __('On this page') }}</div>
                                    <ul>
                                      @foreach ($__toc as $__t)
                                        <li><a href="#{{ $__t['id'] }}">{{ $__t['text'] }}</a></li>
                                      @endforeach
                                    </ul>
                                  </nav>
                                </div>
                              @endif

                              <div class="{{ ($page->slug ?? '') === 'faqs' ? 'col-12' : ($__showLegalToc ? 'col-lg-9' : ( ( $page->ads_status && ( ( $advertisement->sidebar_top_status && $advertisement->sidebar_top != null ) || ( $advertisement->sidebar_middle_status && $advertisement->sidebar_middle != null ) || ( $advertisement->sidebar_bottom_status && $advertisement->sidebar_bottom != null ) ) || $sidebar->tool_status || $sidebar->post_status ) ? 'col-lg-9' : 'col' )) }}">

                                  <div class="page">
                                    {{ $slot }}
                                  </div>

                                  <section id="content-box" class="mb-3 page-{{ $page->id }}">
                                      <div class="card">
                                          @if ( !$general->parallax_status && !in_array($page->type ?? '', ['tool', 'post']) && !in_array($page->slug ?? '', ['about-us', 'faqs', 'contact']) )
                                              <div class="card-header d-block {{ ($general->heading_background !== 'bg-white') ? $general->heading_background : 'bg-transparent' }}">
                                                    <h1 class="page-title h5 {{ ($general->heading_background !== 'bg-white') ? 'text-white' : ''}}">{{ __($pageTrans->title) }}</h1>
                                                    <p class="text-sm mb-0 {{ ($general->heading_background !== 'bg-white') ? 'text-white' : ''}}">{{ __($pageTrans->subtitle) }}</p>
                                              </div>
                                          @endif

                                          <div class="card-body {{ ($general->author_box_status && !in_array($page->type ?? '', ['tool','home','page','contact','report'])) ? 'pb-0' : ''}}">
                                              @if ( Auth::user() && Auth::user()->is_admin )
                                                <div class="d-flex justify-content-center mb-3">
                                                  @switch($page->type)
                                                    @case('post')
                                                      <a href="{{ route('admin.posts.translations.edit', $pageTrans->translations[0]['id']) }}" class="btn btn-primary">{{ __('Edit Page') }}</a>
                                                    @break

                                                    @case('tool')
                                                      <a href="{{ route('admin.tools.translations.edit', $pageTrans->translations[0]['id']) }}" class="btn btn-primary">{{ __('Edit Page') }}</a>
                                                    @break

                                                    @default
                                                      <a href="{{ route('admin.pages.translations.edit', $pageTrans->translations[0]['id']) }}" class="btn btn-primary">{{ __('Edit Page') }}</a>
                                                  @endswitch
                                                </div>
                                              @endif

                                              @if ( $page->ads_status && $advertisement->area4_status && $advertisement->area4 != null )
                                                <x-public.advertisement.area4 :advertisement="$advertisement" />
                                              @endif

                                              @if ( ($page->type ?? '') === 'post' && !empty($page->featured_image) )
                                                <figure class="single-post-featured">
                                                  <img
                                                    class="{{ $general->lazy_loading ? 'lazyload' : '' }}"
                                                    alt="{{ __($pageTrans->title) }}"
                                                    width="1200"
                                                    height="675"
                                                    @if ($general->lazy_loading)
                                                      data-src="{{ $page->featured_image }}"
                                                    @else
                                                      src="{{ $page->featured_image }}"
                                                    @endif
                                                  >
                                                </figure>
                                              @endif

                                              @if ( ($page->type ?? '') == 'report' && !empty($pageTrans->description) )
                                                @php
                                                  // Reveal ~25% of the report description, with a "View More" link.
                                                  $__rblocks = preg_split('/(?=<(?:h[1-6]|p|ul|ol|table|div|section|blockquote|pre)\b)/i', $pageTrans->description, -1, PREG_SPLIT_NO_EMPTY);
                                                  $__rshow   = (int) max(1, ceil(count($__rblocks) / 4));
                                                  $__rfirst  = implode('', array_slice($__rblocks, 0, $__rshow));
                                                  $__rrest   = trim(implode('', array_slice($__rblocks, $__rshow)));
                                                @endphp
                                                {!! $__rfirst !!}
                                                @if ( $__rrest !== '' )
                                                  <a href="javascript:void(0)" class="tool-desc-more-link" onclick="this.nextElementSibling.style.display='block';this.style.display='none';return false;">{{ __('View More') }}</a>
                                                  <div class="tool-desc-more-content" style="display:none;">{!! $__rrest !!}</div>
                                                @endif
                                              @else
                                                {!! $__renderedDescription !!}
                                              @endif

                                              @if ( $page->ads_status && $advertisement->area5_status && $advertisement->area5 != null )
                                                <x-public.advertisement.area5 :advertisement="$advertisement" />
                                              @endif

                                              @switch( $page->type )

                                                  @case('report')
                                                        <div class="report">
                                                          @livewire('public.report')
                                                        </div>
                                                      @break

                                                  @case('contact')
                                                        <div class="contact">
                                                          @livewire('public.contact')
                                                        </div>
                                                      @break

                                                  @default
                                              @endswitch

                                            @if ( $general->share_icons_status && !in_array($page->type ?? '', ['contact','page','report']) )
                                              <div class="social-share text-center">
                                                <div class="is-divider"></div>
                                                <div class="share-icons relative">

                                                    <a wire:ignore href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}"
                                                        onclick="window.open('https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}','facebook','height=500,width=800,resizable=1,scrollbars=yes'); return false;"
                                                        data-label="Facebook"
                                                        aria-label="Facebook"
                                                        rel="noopener noreferrer nofollow"
                                                        target="_blank"
                                                        class="btn btn-facebook btn-icon-only">
                                                        <i class="fab fa-facebook"></i>
                                                    </a>

                                                    <a wire:ignore href="https://twitter.com/intent/tweet?text={{ $pageTrans->title }}&url={{ url()->current() }}&counturl={{ url()->current() }}"
                                                        onclick="window.open('https://twitter.com/intent/tweet?text={{ $pageTrans->title }}&url={{ url()->current() }}&counturl={{ url()->current() }}','twitter','height=500,width=800,resizable=1,scrollbars=yes'); return false;"
                                                        aria-label="Twitter"
                                                        rel="noopener noreferrer nofollow"
                                                        target="_blank"
                                                        class="btn btn-twitter btn-icon-only">
                                                        <i class="fab fa-twitter"></i>
                                                    </a>

                                                    <a wire:ignore href="https://www.pinterest.com/pin-builder/?url={{ url()->current() }}&media={{ $page->featured_image }}&description={{ str_replace(' ', '%20', $pageTrans->title) }}"
                                                        onclick="window.open('https://www.pinterest.com/pin-builder/?url={{ url()->current() }}&media={{ $page->featured_image }}&description={{ str_replace(' ', '%20', $pageTrans->title) }}','pinterest','height=500,width=800,resizable=1,scrollbars=yes'); return false;"
                                                        aria-label="Pinterest"
                                                        rel="noopener noreferrer nofollow"
                                                        target="_blank"
                                                        class="btn btn-pinterest btn-icon-only">
                                                        <i class="fab fa-pinterest"></i>
                                                    </a>

                                                    <a wire:ignore href="https://www.linkedin.com/shareArticle?mini=true&ro=true&title={{ $pageTrans->title }}&url={{ url()->current() }}"
                                                        onclick="window.open('https://www.linkedin.com/shareArticle?mini=true&ro=true&title={{ $pageTrans->title }}&url={{ url()->current() }}','linkedin','height=500,width=800,resizable=1,scrollbars=yes'); return false;"
                                                        aria-label="Linkedin"
                                                        rel="noopener noreferrer nofollow"
                                                        target="_blank"
                                                        class="btn btn-linkedin btn-icon-only">
                                                        <i class="fab fa-linkedin"></i>
                                                    </a>

                                                    <a wire:ignore href="https://www.reddit.com/submit?url={{ url()->current() }}&title={{ str_replace(' ', '%20', $pageTrans->title) }}"
                                                        onclick="window.open('https://www.reddit.com/submit?url={{ url()->current() }}&title={{ str_replace(' ', '%20', $pageTrans->title) }}','reddit','height=500,width=800,resizable=1,scrollbars=yes'); return false;"
                                                        aria-label="Reddit"
                                                        rel="noopener noreferrer nofollow"
                                                        target="_blank"
                                                        class="btn btn-reddit btn-icon-only">
                                                        <i class="fab fa-reddit"></i>
                                                    </a>

                                                    <a wire:ignore href="https://tumblr.com/widgets/share/tool?canonicalUrl={{ url()->current() }}"
                                                        onclick="window.open('https://tumblr.com/widgets/share/tool?canonicalUrl={{ url()->current() }}','tumblr','height=500,width=800,resizable=1,scrollbars=yes'); return false;"
                                                        aria-label="Tumblr"
                                                        target="_blank"
                                                        class="btn btn-tumblr btn-icon-only"
                                                        rel="noopener noreferrer nofollow">
                                                        <i class="fab fa-tumblr"></i>
                                                    </a>

                                                </div>
                                              </div>
                                            @endif

                                            @if ( $general->author_box_status && !in_array($page->type ?? '', ['tool','home','page','contact','report']) )
                                              <hr class="horizontal dark">
                                              <div class="my-3">
                                                <div class="row">

                                                  <div class="col-lg-2">
                                                      <div class="position-relative mb-3">
                                                        <div class="blur-shadow-image">
                                                          <img class="w-100 rounded-3 shadow-sm {{ ($general->lazy_loading == true) ? 'lazyload' : '' }}" {{ ($general->lazy_loading == true) ? 'data-' : '' }}src="{{ $profile->avatar }}" alt="{{ __('Avatar') }}" width="100%" height="100%">
                                                        </div>
                                                      </div>
                                                  </div>

                                                  <div class="col-lg-10 ps-0">
                                                    <div class="card-body text-start py-0">

                                                      <div class="p-md-0 pt-3">
                                                        <h3 class="fw-bold h5">{{ $profile->fullname }}</h3>
                                                        <p class="text-uppercase text-sm font-weight-bold mb-2">{{ $profile->position }}</p>
                                                      </div>

                                                      <p class="mb-3">{{ __($profile->bio) }}</p>

                                                      @if ( ($profile->social_status == true) && !empty($profile->user_socials) )

                                                        @foreach ($profile->user_socials as $element)

                                                          <a class="btn btn-{{ $element->name }} btn-icon-only rounded-circle btn-sm" aria-label="{{ $element->name }}" href="{{ $element->url }}" target="blank">
                                                            <i class="fab fa-{{ $element->name }}" aria-hidden="true"></i>
                                                          </a>

                                                        @endforeach

                                                      @endif

                                                    </div>
                                                  </div>

                                                </div>
                                              </div>
                                            @endif

                                          </div>
                                      </div>
                                  </section>

                                  @if (($page->slug ?? '') === 'faqs')
                                    <section class="faq-help-guide">
                                      <div class="faq-help-guide-copy">
                                        <span>{{ __('Using these answers') }}</span>
                                        <h2>{{ __('Choose a question, understand the result, then put the right tool to work.') }}</h2>
                                        <p>{{ __('fxnSEOTools is designed for focused tasks. Start with the category that matches your goal, open a question for practical context, and follow its tool link when you are ready to run a check or generate an output. Most tools work directly in your browser and do not require an account or installation.') }}</p>
                                      </div>
                                      <div class="faq-help-guide-actions">
                                        <h3>{{ __('Still need help?') }}</h3>
                                        <p>{{ __('Browse the complete tool collection if you know the task you want to complete. If you have found an issue, need clarification, or want to suggest a tool, send our team a message.') }}</p>
                                        <div>
                                          <a href="{{ route('tools') }}">{{ __('Explore SEO Tools') }} <span>→</span></a>
                                          <a href="{{ url('/contact') }}">{{ __('Contact Us') }}</a>
                                        </div>
                                      </div>
                                    </section>
                                  @endif
                              </div>

                              @if ( !$__isLegal && ( $page->ads_status && ( ( $advertisement->sidebar_top_status && $advertisement->sidebar_top != null ) || ( $advertisement->sidebar_middle_status && $advertisement->sidebar_middle != null ) || ( $advertisement->sidebar_bottom_status && $advertisement->sidebar_bottom != null ) ) || $sidebar->tool_status || $sidebar->post_status ) )
                                <div class="col-lg-3 ml-auto sidebars">
                                    <x-public.sidebar :page="$page" :general="$general" :advertisement="$advertisement" :sidebar="$sidebar" :recentPosts="$recent_posts" :popularTools="$popular_tools" :advanced="$advanced" />
                                </div>
                              @endif
                          </div>
                      </div>
                      @if (($page->slug ?? '') === 'faqs')
                        <script>
                          document.addEventListener('DOMContentLoaded', function () {
                            const input = document.getElementById('faq-search-input');
                            const clear = document.getElementById('faq-search-clear');
                            const status = document.getElementById('faq-search-status');
                            const categories = Array.from(document.querySelectorAll('.page-slug-faqs .faq-category'));
                            const items = Array.from(document.querySelectorAll('.page-slug-faqs .faq-category .accordion-item'));
                            if (!input) return;

                            const categoryDescriptions = [
                              'Find clear answers about YouTube tags, channels, videos, thumbnails, metadata, restrictions, and the creator tools available on fxnSEO.',
                              'Learn how our text utilities analyze, compare, transform, count, and improve written content for everyday publishing and SEO tasks.',
                              'Understand the metrics and checks used to monitor domains, rankings, backlinks, authority, performance, and search visibility.',
                              'Get guidance on technical website utilities for metadata, redirects, sitemaps, robots files, structured data, diagnostics, and maintenance.'
                            ];
                            categories.forEach(function (category, index) {
                              const heading = category.querySelector(':scope > h2');
                              if (!heading) return;
                              const intro = document.createElement('div');
                              intro.className = 'faq-category-intro';
                              const description = document.createElement('p');
                              description.textContent = categoryDescriptions[index] || 'Explore answers to common questions about this group of free online tools.';
                              category.insertBefore(intro, heading);
                              intro.appendChild(heading);
                              intro.appendChild(description);
                            });

                            const collapsedGroups = [];
                            function addViewMore(category) {
                              if (!category) return;
                              const groupItems = Array.from(category.querySelectorAll('.accordion-item'));
                              if (groupItems.length <= 6) return;
                              const group = { expanded: false, items: groupItems, button: document.createElement('button') };
                              groupItems.slice(6).forEach(function (item) { item.dataset.faqExtra = String(collapsedGroups.length); item.hidden = true; });
                              group.button.type = 'button';
                              group.button.className = 'faq-view-more';
                              group.button.textContent = 'View more';
                              category.querySelector('.faq-accordion')?.appendChild(group.button);
                              group.button.addEventListener('click', function () {
                                group.expanded = !group.expanded;
                                group.items.slice(6).forEach(function (item) { item.hidden = !group.expanded; });
                                group.button.textContent = group.expanded ? 'View less' : 'View more';
                              });
                              collapsedGroups.push(group);
                            }
                            addViewMore(categories[0]);
                            addViewMore(categories[2]);

                            function filterFaqs() {
                              const query = input.value.trim().toLowerCase();
                              let visible = 0;
                              items.forEach(function (item) {
                                const groupIndex = item.dataset.faqExtra;
                                const isCollapsedItem = groupIndex !== undefined && !collapsedGroups[Number(groupIndex)].expanded;
                                const show = query ? item.textContent.toLowerCase().includes(query) : !isCollapsedItem;
                                item.hidden = !show;
                                if (show) visible++;
                              });
                              categories.forEach(function (category) {
                                category.hidden = !Array.from(category.querySelectorAll('.accordion-item')).some(function (item) { return !item.hidden; });
                              });
                              clear.hidden = !query;
                              collapsedGroups.forEach(function (group) { group.button.hidden = Boolean(query); });
                              status.textContent = query ? visible + (visible === 1 ? ' answer found' : ' answers found') : '';
                            }

                            input.addEventListener('input', filterFaqs);
                            clear.addEventListener('click', function () { input.value = ''; filterFaqs(); input.focus(); });
                          });
                        </script>
                      @endif
                  </div>
                  <!-- End::page-content -->
            </div>
            <!-- End::page-wrapper -->

            <x-public.footer :footer="$footer" :general="$general" :socials="$socials" />

            <!-- Theme JS -->
            <script src="{{ asset('assets/js/main.min.js') }}" defer></script>

            <!-- Sticky navbar shadow: only when the sticky menu is activated (scrolled) -->
            <script>
              (function(){
                var nav = document.querySelector('nav.navbar');
                if (!nav || !nav.classList.contains('position-sticky')) return;
                function onScroll(){
                  if (window.scrollY > 10) nav.classList.add('navbar-stuck');
                  else nav.classList.remove('navbar-stuck');
                }
                window.addEventListener('scroll', onScroll, { passive: true });
                onScroll();
              })();
            </script>

            @if ( $general->lazy_loading )
              <script src="{{ asset('assets/js/lazysizes.min.js') }}" async></script>
              <script src="{{ asset('assets/js/ls.unveilhooks.min.js') }}" async></script>
            @endif

            @if ( $general->search_box_status )
              <script>
                const searchIcon = document.getElementById('search-icon');
                const searchBox = document.getElementById('search-box');

                // Show/hide search box
                searchIcon.addEventListener('click', function () {
                  if (searchBox.style.display === 'none' || searchBox.style.display === '') {
                    searchBox.style.display = 'block';
                  } else {
                    searchBox.style.display = 'none';
                  }
                });

                // Hide search box when user clicks outside of it
                document.addEventListener('click', function (event) {
                  const isClickInsideSearchBox = searchBox.contains(event.target);
                  const isClickInsideSearchIcon = searchIcon.contains(event.target);
                  if (!isClickInsideSearchBox && !isClickInsideSearchIcon) {
                    searchBox.style.display = 'none';
                  }
                });
              </script>
            @endif

            @if ( $general->back_to_top )
                <!-- Scroll back to top -->
                <div id="backtotop"> 
                    <a href="#" class="backtotop"></a> 
                </div>

                <script type="text/javascript"> 
                    jQuery(document).ready(function ($) {
                        $("#backtotop").hide(); 
                        $(window).scroll(function () { 
                            if ($(this).scrollTop() > 500) { 
                                $('#backtotop').fadeIn(); 
                            } else { 
                                $('#backtotop').fadeOut(); 
                            } 
                        });   
                    });

                    jQuery('.backtotop').click(function () { 
                        jQuery('html, body').animate({ 
                            scrollTop: 0 
                        }, 'slow'); 
                    });
                </script> 
                <!-- End of Scroll back to top -->
            @endif

            @if ( $general->adblock_detection )

              <!-- Sweetalert2 -->
              <script src="{{ asset('assets/js/sweetalert2.min.js') }}"></script>

              <script>
              (function( $ ) {
                "use strict";

                    document.addEventListener("DOMContentLoaded", function () {
                      setTimeout(() => {
                        const el = document.querySelector(".ad-banner");

                        if (el && el.offsetHeight === 0) {
                          Swal.fire({
                            title: "You&#039;re blocking ads",
                            text: "Our website is made possible by displaying online ads to our visitors. Please consider supporting us by disabling your ad blocker.",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonText: "I have disabled Adblock",
                            cancelButtonText: "No, thanks!",
                          }).then((result) => {
                            if (result.isConfirmed) {
                              window.location.reload();
                            }
                          });
                        }
                      }, 100);
                    });

              })( jQuery );
              </script>

            @endif

            @if (Cookie::get('cookies') == null)

              <x-public.cookie-banner />

              @if ( false && $notice->status )

                      <div class="row cookies-wrapper alert {{ $notice->background }}" role="alert">
                        <div class="col-md-12 col-lg-{{ ($notice->button == true) ? '10' : '12'}} my-auto {{ $notice->align }}">
                          {!! __(GrahamCampbell\Security\Facades\Security::clean($notice->notice)) !!}
                        </div>

                        @if ( $notice->button == true)
                          <div class="col-md-12 col-lg-2 my-auto text-end p-2">
                              <button id="acceptCookies" target="_blank" class="btn btn-sm bg-white mb-0 text-capitalize"> {{ __('Accept all cookies') }} </button>
                          </div>
                        @endif
                        <button type="button" class="btn-close text-white" data-bs-dismiss="alert" aria-label="Close">x</button>
                      </div>

                  <script>
                     (function( $ ) {
                        "use strict";

                            jQuery("#acceptCookies").click(function(){
                                jQuery.ajax({
                                    type : 'get',
                                    url : '{{ url('/') }}/cookies/accept',
                                    success: function(e) {
                                        jQuery('.cookies-wrapper').remove();
                                    }
                                });
                            });

                    })( jQuery );
                  </script>
              @endif

            @endif

            @if ( $general->theme_mode )
              <script>
                 (function( $ ) {
                    "use strict";

                        jQuery(".btn-toggle-mode").click(function(){
                            jQuery.ajax({
                                type : 'get',
                                url : '{{ url('/') }}/theme/mode',
                                success: function(e) {
                                    window.location.reload();
                                }
                            });
                        });

                })( jQuery );
              </script>
            @endif
            
          </div>

          @livewireScripts

      @endif

    </body>
</html>
