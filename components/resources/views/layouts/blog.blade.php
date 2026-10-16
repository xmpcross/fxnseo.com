@php
  $__themeCookie = Cookie::get('theme_mode', $general->default_theme_mode ?? 'theme-light');
  $__isThemeDark = ($__themeCookie === 'theme-dark');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ localization()->getCurrentLocaleDirection() }}" class="{{ $__isThemeDark ? 'dark theme-dark' : 'light theme-light' }}" id="html-root">
    <head>
        <script>
          (function(){
            try {
              var s = localStorage.getItem('site_theme');
              if (s === 'dark' || (!s && {{ $__isThemeDark ? 'true' : 'false' }})) {
                document.documentElement.classList.add('dark', 'theme-dark');
                document.documentElement.classList.remove('light', 'theme-light');
              } else if (s === 'light') {
                document.documentElement.classList.add('light', 'theme-light');
                document.documentElement.classList.remove('dark', 'theme-dark');
              }
            } catch(e) {}
          })();
        </script>
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
        <link rel="shortcut icon" href="{{ $header->favicon }}">

        @include('partials.meta-manager')

        @include('partials.seo-structured-data')

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
        
        <link type="text/css" href="{{ asset('assets/css/shared-public-components.css') }}?v={{ @filemtime(dirname(base_path()).'/assets/css/shared-public-components.css') ?: '1' }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('assets/css/content-pages.css') }}?v={{ @filemtime(dirname(base_path()).'/assets/css/content-pages.css') ?: '1' }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('assets/css/tool-template.css') }}?v={{ @filemtime(dirname(base_path()).'/assets/css/tool-template.css') ?: '1' }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('assets/css/recap-color-scheme.css') }}?v={{ @filemtime(dirname(base_path()).'/assets/css/recap-color-scheme.css') ?: '1' }}" rel="stylesheet">

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

                      <!-- Modern Blog Hero System (Matches Homepage Aesthetics • Outfit Font • Emerald Accent) -->
                      <section class="blog-editorial-hero">
                        <div class="ambient-glow glow-1"></div>
                        <div class="ambient-glow glow-2"></div>

                        <div class="blog-editorial-shell">
                          <nav class="tool-editorial-breadcrumb" aria-label="{{ __('Breadcrumb') }}">
                            <a href="{{ route('home') }}">{{ __('Home') }}</a>
                            <span class="sep" aria-hidden="true">›</span>
                            <span class="active">{{ __('SEO Blog & Guides') }}</span>
                          </nav>

                          <div class="tool-editorial-badge">
                            <span class="pulse-indicator"></span>
                            <span class="badge-label"><i class="fas fa-newspaper text-emerald me-1"></i> {{ __('Practical SEO Playbooks • Real Diagnostics') }}</span>
                          </div>

                          <h1 class="blog-editorial-title hero-title">
                            Master Search &amp; Growth with <br>
                            <span class="blog-gradient-text">{{ __('Actionable SEO Guides') }}</span>
                          </h1>
                          <p class="blog-editorial-lead">{{ __('Step-by-step playbooks, backlink workflows, technical audit frameworks, and YouTube optimization tactics to sustainably grow your organic traffic.') }}</p>

                          <div class="tool-editorial-chips">
                            <div class="tool-chip"><i class="fas fa-check-circle text-emerald"></i> <span>{{ __('14 Free In-Depth Guides') }}</span></div>
                            <div class="tool-chip"><i class="fas fa-link text-emerald"></i> <span>{{ __('Backlink & Authority Focus') }}</span></div>
                            <div class="tool-chip"><i class="fab fa-youtube text-danger"></i> <span>{{ __('YouTube Growth Strategies') }}</span></div>
                            <div class="tool-chip"><i class="fas fa-shield-alt text-emerald"></i> <span>{{ __('100% Free · No Paywall') }}</span></div>
                          </div>
                        </div>
                      </section>

                      <!-- Main Blog Content Area (Wide Wrap Layout) -->
                      <div class="wrap py-4 my-2">
                          <div class="row g-4">
                              <div class="{{ ( $page->ads_status && ( ( $advertisement->sidebar_top_status && $advertisement->sidebar_top != null ) || ( $advertisement->sidebar_middle_status && $advertisement->sidebar_middle != null ) || ( $advertisement->sidebar_bottom_status && $advertisement->sidebar_bottom != null ) ) || $sidebar->tool_status || $sidebar->post_status ) ? 'col-lg-8' : 'col-12' }}">

                                <section id="blog-content">
                                  @if ( $page->ads_status && $advertisement->area3_status && $advertisement->area3 != null )
                                    <div class="mb-4">
                                      <x-public.advertisement.area3 :advertisement="$advertisement" />
                                    </div>
                                  @endif
                                  
                                  @if ( $page->ads_status && $advertisement->area4_status && $advertisement->area4 != null )
                                    <div class="mb-4">
                                      <x-public.advertisement.area4 :advertisement="$advertisement" />
                                    </div>
                                  @endif

                                  {{ $slot }}

                                  @if ( $page->ads_status && $advertisement->area5_status && $advertisement->area5 != null )
                                    <div class="mt-4">
                                      <x-public.advertisement.area5 :advertisement="$advertisement" />
                                    </div>
                                  @endif

                                </section>
                              </div>

                              @if ( $page->ads_status && ( ( $advertisement->sidebar_top_status && $advertisement->sidebar_top != null ) || ( $advertisement->sidebar_middle_status && $advertisement->sidebar_middle != null ) || ( $advertisement->sidebar_bottom_status && $advertisement->sidebar_bottom != null ) ) || $sidebar->tool_status || $sidebar->post_status)
                                <div class="col-lg-4 sidebars">
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
