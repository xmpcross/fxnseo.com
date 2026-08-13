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
            [ '@context' => 'https://schema.org', '@type' => 'Organization', 'name' => env('APP_NAME'), 'url' => url('/'), 'logo' => $__ldLogo, 'sameAs' => ['https://www.facebook.com/fxnseo/', 'https://x.com/fxnseo'] ],
            [ '@context' => 'https://schema.org', '@type' => 'WebSite', 'name' => env('APP_NAME'), 'url' => url('/'), 'description' => 'Free online SEO tools — 60+ browser-based utilities for keyword analysis, backlinks, rank tracking, meta tags, schema, and YouTube.' ],
          ];
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
        <link type="text/css" href="{{ asset('assets/css/content-pages.css') }}?v={{ @filemtime(dirname(base_path()).'/assets/css/content-pages.css') ?: '1' }}" rel="stylesheet">

        @if ( $advanced->header_status && $advanced->insert_header != null )
          {!! $advanced->insert_header !!}
        @endif

        @livewireStyles

    </head>
    <body class="antialiased {{ Cookie::get('theme_mode', $general->default_theme_mode) }} page-blog-listing">

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

                      <section class="blog-tools-hero">
                        <div class="blog-tools-shell blog-tools-hero-grid">
                          <div>
                            <nav class="blog-tools-breadcrumb" aria-label="Breadcrumb"><a href="{{ route('home') }}">{{ __('Home') }}</a><span>/</span><span>{{ __('Blog') }}</span></nav>
                            <span class="blog-tools-kicker">{{ __('Insights for better visibility') }}</span>
                            <h1>{{ __('SEO Insights & Guides') }}</h1>
                            <p>{{ __('Actionable SEO tips, tool tutorials, and how-to guides to help you improve your rankings and grow your organic traffic.') }}</p>
                          </div>
                          <div class="blog-tools-hero-stats" aria-label="Blog overview">
                            <div><b>{{ __('SEO') }}</b><span>{{ __('Practical guidance') }}</span></div>
                            <div><b>{{ __('Free') }}</b><span>{{ __('Expert resources') }}</span></div>
                            <div><b>{{ __('New') }}</b><span>{{ __('Ideas to apply') }}</span></div>
                          </div>
                        </div>
                      </section>

                      <div class="container py-4">

                          <div class="row">
                              <div class="{{ ( $page->ads_status && ( ( $advertisement->sidebar_top_status && $advertisement->sidebar_top != null ) || ( $advertisement->sidebar_middle_status && $advertisement->sidebar_middle != null ) || ( $advertisement->sidebar_bottom_status && $advertisement->sidebar_bottom != null ) ) || $sidebar->tool_status || $sidebar->post_status ) ? 'col-lg-9' : 'col' }}">

                                <section id="blog-content">
                                  <div class="row row-cards">
                                    @if ( $page->ads_status && $advertisement->area3_status && $advertisement->area3 != null )
                                      <x-public.advertisement.area3 :advertisement="$advertisement" />
                                    @endif
                                    
                                    @if ( $page->ads_status && $advertisement->area4_status && $advertisement->area4 != null )
                                      <x-public.advertisement.area4 :advertisement="$advertisement" />
                                    @endif

                                    {{ $slot }}
                                  </div>

                                  @if ( $page->ads_status && $advertisement->area5_status && $advertisement->area5 != null )
                                    <x-public.advertisement.area5 :advertisement="$advertisement" />
                                  @endif

                                </section>
                              </div>

                              @if ( $page->ads_status && ( ( $advertisement->sidebar_top_status && $advertisement->sidebar_top != null ) || ( $advertisement->sidebar_middle_status && $advertisement->sidebar_middle != null ) || ( $advertisement->sidebar_bottom_status && $advertisement->sidebar_bottom != null ) ) || $sidebar->tool_status || $sidebar->post_status)
                                <div class="col-lg-3 ml-auto sidebars">
                                    <x-public.sidebar :page="$page" :general="$general" :advertisement="$advertisement" :sidebar="$sidebar" :recentPosts="$recent_posts" :popularTools="$popular_tools" :advanced="$advanced" />
                                </div>
                              @endif
                          </div>
                      </div>
                  </div>
                  <!-- End::page-content -->
            </div>
            <!-- End::page-wrapper -->

            <x-public.footer :footer="$footer" :general="$general" :socials="$socials" />

            <!-- Theme JS -->
            <script src="{{ asset('assets/js/main.min.js') }}" defer></script>

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
                        <div class="col-md-12 col-lg-{{ ($notice->button) ? '10' : '12'}} my-auto {{ $notice->align }}">
                          {!! __(GrahamCampbell\Security\Facades\Security::clean($notice->notice)) !!}
                        </div>

                        @if ( $notice->button)
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
