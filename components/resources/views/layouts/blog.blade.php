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
        <link rel="preload" href="{{ asset('assets/fonts/google/outfit-variable.woff2') }}" as="font" type="font/woff2" crossorigin>
        <link rel="preload" href="{{ asset('assets/fonts/google/urbanist-variable.woff2') }}" as="font" type="font/woff2" crossorigin>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="color-scheme" content="{{ (Cookie::get('theme_mode', $general->default_theme_mode ?? 'theme-light') === 'theme-dark') ? 'dark' : 'light' }}">
        <link rel="shortcut icon" href="{{ $header->favicon }}">
        <link rel="icon" type="image/svg+xml" href="{{ asset('assets/img/favicon.svg') }}?v={{ @filemtime(dirname(base_path()).'/assets/img/favicon.svg') ?: '1' }}">
        <link rel="apple-touch-icon" href="{{ asset('assets/img/favicon.png') }}?v={{ @filemtime(dirname(base_path()).'/assets/img/favicon.png') ?: '1' }}">

        @include('partials.meta-manager')

        @include('partials.seo-structured-data')

        @include('partials.hreflang')


        @if ( $general->adblock_detection )
          <!-- Sweet Alert 2 -->
          <link rel="preload" href="{{ asset('assets/css/sweetalert2.min.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
          <noscript><link rel="stylesheet" href="{{ asset('assets/css/sweetalert2.min.css') }}"></noscript>
        @endif

        <!-- Font Awesome -->
        <link rel="preload" href="{{ asset('assets/css/fontawesome.min.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link rel="stylesheet" href="{{ asset('assets/css/fontawesome.min.css') }}"></noscript>

        

        <!-- jQuery -->
        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>

        <!-- Popper -->
        <script src="{{ asset('assets/js/popper.min.js') }}" defer></script>

        <!-- Bootstrap -->
        <script src="{{ asset('assets/js/bootstrap.min.js') }}" defer></script>



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

      <link rel="stylesheet" href="{{ asset('assets/css/site-typography.css') }}?v={{ @filemtime(dirname(base_path()).'/assets/css/site-typography.css') ?: '1' }}">
  <link rel="stylesheet" href="{{ asset('assets/css/site-header.css') }}?v={{ @filemtime(dirname(base_path()).'/assets/css/site-header.css') ?: '1' }}">
  <link rel="stylesheet" href="{{ asset('assets/css/site-redesign.css') }}?v={{ @filemtime(dirname(base_path()).'/assets/css/site-redesign.css') ?: '1' }}">
  <link rel="stylesheet" href="{{ asset('assets/css/journal-redesign.css') }}?v={{ @filemtime(dirname(base_path()).'/assets/css/journal-redesign.css') ?: '1' }}">
  <link rel="stylesheet" href="{{ asset('assets/css/blog-listing.css') }}?v={{ filemtime(dirname(base_path()).'/assets/css/blog-listing.css') }}">
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

                      <main id="blog-content">
                        @if ($page->ads_status && $advertisement->area3_status && $advertisement->area3 != null)
                          <div class="wrap my-4"><x-public.advertisement.area3 :advertisement="$advertisement" /></div>
                        @endif
                        @if ($page->ads_status && $advertisement->area4_status && $advertisement->area4 != null)
                          <div class="wrap my-4"><x-public.advertisement.area4 :advertisement="$advertisement" /></div>
                        @endif
                        {{ $slot }}
                        @if ($page->ads_status && $advertisement->area5_status && $advertisement->area5 != null)
                          <div class="wrap my-4"><x-public.advertisement.area5 :advertisement="$advertisement" /></div>
                        @endif
                      </main>

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

                if (searchIcon && searchBox) {
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
                }
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
