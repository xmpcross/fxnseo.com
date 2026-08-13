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
        @if (isset($page) && (in_array($page->slug ?? '', ['about-us', 'faqs', 'contact', 'backlink-monitoring-guide', 'link-opportunity-guide', 'seo-audit-guide']) || ($page->type ?? '') === 'post'))
          <link type="text/css" href="{{ asset('assets/css/content-pages.css') }}?v={{ @filemtime(dirname(base_path()).'/assets/css/content-pages.css') ?: '1' }}" rel="stylesheet">
        @endif

        @if (Route::is('home'))
          <link type="text/css" href="{{ asset('assets/css/home-content.css') }}?v={{ @filemtime(dirname(base_path()).'/assets/css/home-content.css') ?: '1' }}" rel="stylesheet">
        @endif

        @if (Route::is('tools'))
          <link type="text/css" href="{{ asset('assets/css/tools-content.css') }}?v={{ @filemtime(dirname(base_path()).'/assets/css/tools-content.css') ?: '1' }}" rel="stylesheet">
        @endif

        <link type="text/css" href="{{ asset('assets/css/recap-color-scheme.css') }}?v={{ @filemtime(dirname(base_path()).'/assets/css/recap-color-scheme.css') ?: '1' }}" rel="stylesheet">

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

                      @if (($page->type ?? '') === 'post')
                          @php
                            $__postCategoryName = $post_category->name ?? $post_category->title ?? __('Blog');
                            $__postSummary = $pageTrans->short_description ?: $pageTrans->subtitle;
                            $__postDate = $page->created_at ? \Illuminate\Support\Carbon::parse($page->created_at) : null;
                            $__postUpdatedDate = $page->updated_at ? \Illuminate\Support\Carbon::parse($page->updated_at) : $__postDate;
                          @endphp
                          <header class="post-editorial-hero">
                            <div class="post-editorial-shell">
                              <nav class="post-editorial-breadcrumb" aria-label="{{ __('Breadcrumb') }}">
                                <a href="{{ route('home') }}">{{ __('Home') }}</a><span aria-hidden="true">›</span>
                                <a href="{{ url('/blog') }}">{{ $__postCategoryName }}</a><span aria-hidden="true">›</span>
                                <span>{{ __($pageTrans->title) }}</span>
                              </nav>

                              <div class="post-editorial-grid">
                                <div class="post-editorial-copy">
                                  <a class="post-editorial-category" href="{{ url('/blog') }}"><i class="far fa-folder-open" aria-hidden="true"></i>{{ $__postCategoryName }}</a>
                                  <h1>{{ __($pageTrans->title) }}</h1>
                                  @if (!empty($__postSummary))
                                    <p class="post-editorial-summary"><i class="fas fa-magic" aria-hidden="true"></i>{{ __($__postSummary) }}</p>
                                  @endif

                                  <div class="post-editorial-byline">
                                    @if (!empty($profile->avatar))
                                      <img src="{{ $profile->avatar }}" alt="" width="32" height="32">
                                    @endif
                                    <div>
                                      <span>{{ $profile->fullname ?? $profile->name ?? config('app.name') }}</span>
                                      <div class="post-editorial-meta">
                                        <span><i class="far fa-comment" aria-hidden="true"></i> 0</span>
                                        @if ($__postDate)
                                          <span aria-hidden="true">•</span><time datetime="{{ $__postDate->toDateString() }}">{{ $__postDate->format('F j, Y') }}</time>
                                        @endif
                                      </div>
                                    </div>
                                  </div>
                                </div>

                                <figure class="post-editorial-image">
                                  <img src="{{ !empty($page->featured_image) ? $page->featured_image : asset('assets/img/no-thumb.svg') }}" alt="{{ __($pageTrans->title) }}" width="900" height="510">
                                </figure>
                              </div>

                              <div class="post-editorial-share" aria-label="{{ __('Share article') }}">
                                <span>{{ __('Share') }}</span>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener noreferrer nofollow" aria-label="{{ __('Share on Facebook') }}"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
                                <a href="https://twitter.com/intent/tweet?text={{ urlencode($pageTrans->title) }}&url={{ urlencode(url()->current()) }}" target="_blank" rel="noopener noreferrer nofollow" aria-label="{{ __('Share on X') }}"><b aria-hidden="true">X</b></a>
                                <button type="button" aria-label="{{ __('Copy article link') }}" onclick="navigator.clipboard.writeText('{{ url()->current() }}');this.classList.add('is-copied');setTimeout(() => this.classList.remove('is-copied'), 1200);"><i class="fas fa-link" aria-hidden="true"></i></button>
                              </div>
                            </div>
                          </header>
                      @elseif (in_array($page->slug ?? '', ['backlink-monitoring-guide', 'link-opportunity-guide', 'seo-audit-guide']))
                          @php
                            $__pillarConfig = [
                              'backlink-monitoring-guide' => ['label' => __('Pillar guide · Backlink SEO'), 'anchor' => '#what-is-backlink-monitoring', 'primary' => __('Read the guide'), 'tool_url' => url('/backlink-checker'), 'tool_label' => __('Check backlinks'), 'proof' => [__('7 practical chapters'), __('Actionable workflow'), __('Free checker included')]],
                              'link-opportunity-guide' => ['label' => __('Pillar guide · Link building'), 'anchor' => '#what-is-link-prospecting', 'primary' => __('Find opportunities'), 'tool_url' => url('/backlink-checker'), 'tool_label' => __('Research backlinks'), 'proof' => [__('7 practical chapters'), __('Prospecting framework'), __('Qualification checklist')]],
                              'seo-audit-guide' => ['label' => __('Pillar guide · SEO operations'), 'anchor' => '#what-is-an-seo-audit', 'primary' => __('Build your audit'), 'tool_url' => route('tools'), 'tool_label' => __('Explore SEO tools'), 'proof' => [__('7 practical chapters'), __('Reporting workflow'), __('Client-ready framework')]],
                            ][$page->slug];
                          @endphp
                          <section class="pillar-hero">
                            <div class="pillar-hero-shell">
                              <nav aria-label="{{ __('Breadcrumb') }}"><a href="{{ route('home') }}">{{ __('Home') }}</a><span>›</span><span>{{ __('Backlink Monitoring Guide') }}</span></nav>
                              <span class="pillar-hero-kicker">{{ $__pillarConfig['label'] }}</span>
                              <h1>{{ __($pageTrans->title) }}</h1>
                              <p>{{ __($pageTrans->subtitle) }}</p>
                              <div class="pillar-hero-actions">
                                <a href="{{ $__pillarConfig['anchor'] }}">{{ $__pillarConfig['primary'] }} <span>↓</span></a>
                                <a href="{{ $__pillarConfig['tool_url'] }}">{{ $__pillarConfig['tool_label'] }} <span>→</span></a>
                              </div>
                              <div class="pillar-hero-proof">@foreach ($__pillarConfig['proof'] as $__proof)<span>{{ $__proof }}</span>@endforeach</div>
                            </div>
                          </section>
                      @elseif (($page->slug ?? '') === 'about-us')
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
                            $__isPillar = in_array($page->slug ?? '', ['backlink-monitoring-guide', 'link-opportunity-guide', 'seo-audit-guide']);
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
                            if (($page->type ?? '') === 'post' && $__renderedDescription !== '') {
                              // The editorial header already renders the post title as the page's sole H1.
                              // Remove the duplicate title stored in the post body, then normalize its
                              // remaining heading hierarchy without cascading h4 elements into h2 elements.
                              $__renderedDescription = preg_replace('#<h1\b[^>]*>.*?</h1>#is', '', $__renderedDescription, 1);
                              $__renderedDescription = preg_replace_callback(
                                '#<h([34])\b([^>]*)>(.*?)</h\1>#is',
                                function ($matches) {
                                  $level = ((int) $matches[1]) - 1;
                                  return '<h'.$level.$matches[2].'>'.$matches[3].'</h'.$level.'>';
                                },
                                $__renderedDescription
                              );
                              $__renderedDescription = preg_replace_callback(
                                '#<h2([^>]*)>\s*(?:FAQ|FAQs|Frequently Asked Questions)\s*</h2>((?:\s*<p[^>]*>.*?</p>)+)#is',
                                function ($matches) use ($related_posts) {
                                  preg_match_all('#<p[^>]*>\s*<strong[^>]*>(.*?)</strong>(.*?)</p>#is', $matches[2], $faqItems, PREG_SET_ORDER);
                                  if (!$faqItems) { return $matches[0]; }

                                  $html = '';
                                  if (!empty($related_posts)) {
                                    $html .= '<section class="post-related-showcase" aria-labelledby="postRelatedTitle"><h2 id="postRelatedTitle">'.e(__('Related Posts')).'</h2><div class="post-related-showcase-list">';
                                    foreach ($related_posts as $relatedPost) {
                                      $url = url('/blog/'.$relatedPost['slug']);
                                      $image = !empty($relatedPost['featured_image']) ? $relatedPost['featured_image'] : asset('assets/img/no-thumb.svg');
                                      $excerpt = \Illuminate\Support\Str::limit(strip_tags($relatedPost['short_description'] ?? ''), 145);
                                      $date = !empty($relatedPost['published_at']) ? \Illuminate\Support\Carbon::parse($relatedPost['published_at']) : null;
                                      $html .= '<article class="post-related-showcase-item"><a class="post-related-showcase-image" href="'.e($url).'" tabindex="-1" aria-hidden="true"><img src="'.e($image).'" alt="" width="500" height="310" loading="lazy"></a><div class="post-related-showcase-copy">';
                                      $html .= '<h3 class="post-related-showcase-title"><a href="'.e($url).'">'.e($relatedPost['title']).'</a></h3>';
                                      if ($excerpt !== '') { $html .= '<p>'.e($excerpt).'</p>'; }
                                      $html .= '<div class="post-related-showcase-meta"><span>'.($relatedPost['same_category'] ? '100% '.e(__('match')) : e(__('Recommended'))).'</span>';
                                      if ($date) { $html .= '<i aria-hidden="true">•</i><time datetime="'.$date->toDateString().'">'.$date->format('F j, Y').'</time>'; }
                                      $html .= '</div></div></article>';
                                    }
                                    $html .= '</div></section>';
                                  }

                                  $html .= '<section class="post-faq-showcase" aria-labelledby="postFaqTitle"><h2 id="postFaqTitle">'.e(__('Questions Answered')).'</h2><div class="post-faq-showcase-list">';
                                  foreach ($faqItems as $index => $faqItem) {
                                    $question = trim(strip_tags($faqItem[1]));
                                    $answer = trim(strip_tags($faqItem[2]));
                                    $html .= '<article class="post-faq-showcase-item'.($index === 0 ? ' is-featured' : '').'">';
                                    $html .= '<span class="post-faq-dot" aria-hidden="true"></span><div class="post-faq-showcase-copy"><h3 class="post-faq-question">'.e($question).'</h3><p>'.e($answer).'</p></div>';
                                    $html .= '<span class="post-faq-arrow" aria-hidden="true">→</span></article>';
                                  }
                                  return $html.'</div></section>';
                                },
                                $__renderedDescription
                              );
                            }
                            $__postToc = [];
                            $__postReadingMinutes = 1;
                            if (($page->type ?? '') === 'post' && $__renderedDescription !== '') {
                              $__postReadingMinutes = max(1, (int) ceil(str_word_count(strip_tags($pageTrans->description ?? '')) / 220));
                              $__headingIndex = 0;
                              $__renderedDescription = preg_replace_callback('#<h([23])([^>]*)>(.*?)</h\1>#is', function ($matches) use (&$__postToc, &$__headingIndex) {
                                if (preg_match('/post-related-showcase-title|post-faq-question/i', $matches[2]) || preg_match('/id=["\'](?:postRelatedTitle|postFaqTitle)["\']/i', $matches[2])) {
                                  return $matches[0];
                                }
                                $__headingIndex++;
                                $text = trim(html_entity_decode(strip_tags($matches[3]), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
                                $existingId = preg_match('/\sid=["\']([^"\']+)["\']/i', $matches[2], $idMatch) ? $idMatch[1] : '';
                                $id = $existingId ?: 'post-section-'.$__headingIndex;
                                if ((int) $matches[1] === 2) {
                                  $__postToc[] = ['id' => $id, 'text' => $text, 'level' => 2];
                                }
                                $attributes = $matches[2];
                                if (!$existingId) { $attributes .= ' id="'.e($id).'"'; }
                                return '<h'.$matches[1].$attributes.'>'.$matches[3].'</h'.$matches[1].'>';
                              }, $__renderedDescription);
                            }
                            $__postDescriptionBefore = $__renderedDescription;
                            $__postDescriptionAfter = '';
                            if (($page->type ?? '') === 'post' && !empty($read_also_posts) && $__renderedDescription !== '') {
                              $__postBlocks = preg_split('/(?=<(?:h[2-6]|p|ul|ol|table|div|section|blockquote|pre|figure)\b)/i', $__renderedDescription, -1, PREG_SPLIT_NO_EMPTY);
                              if (count($__postBlocks) > 1) {
                                $__postMidpoint = (int) ceil(count($__postBlocks) / 2);
                                $__h2Indexes = [];
                                foreach ($__postBlocks as $__blockIndex => $__postBlock) {
                                  if ($__blockIndex > 0 && preg_match('/^\s*<h2\b/i', $__postBlock)) {
                                    $__h2Indexes[] = $__blockIndex;
                                  }
                                }

                                // Insert directly before the H2 closest to the true content midpoint.
                                $__postInsertIndex = $__postMidpoint;
                                if (!empty($__h2Indexes)) {
                                  usort($__h2Indexes, function ($left, $right) use ($__postMidpoint) {
                                    return abs($left - $__postMidpoint) <=> abs($right - $__postMidpoint);
                                  });
                                  $__postInsertIndex = $__h2Indexes[0];
                                }

                                $__postDescriptionBefore = implode('', array_slice($__postBlocks, 0, $__postInsertIndex));
                                $__postDescriptionAfter = implode('', array_slice($__postBlocks, $__postInsertIndex));
                              }
                            }
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

                              <div class="{{ in_array(($page->type ?? ''), ['post']) || ($page->slug ?? '') === 'faqs' || $__isPillar ? 'col-12' : ($__showLegalToc ? 'col-lg-9' : ( ( $page->ads_status && ( ( $advertisement->sidebar_top_status && $advertisement->sidebar_top != null ) || ( $advertisement->sidebar_middle_status && $advertisement->sidebar_middle != null ) || ( $advertisement->sidebar_bottom_status && $advertisement->sidebar_bottom != null ) ) || $sidebar->tool_status || $sidebar->post_status ) ? 'col-lg-9' : 'col' )) }}">

                                  <div class="page">
                                    {{ $slot }}
                                  </div>

                                  <section id="content-box" class="mb-3 page-{{ $page->id }}">
                                      <div class="card">
                                          @if ( !$general->parallax_status && !in_array($page->type ?? '', ['tool', 'post']) && !in_array($page->slug ?? '', ['about-us', 'faqs', 'contact', 'backlink-monitoring-guide', 'link-opportunity-guide', 'seo-audit-guide']) )
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

                                              @if (($page->type ?? '') === 'post')
                                                <div class="single-post-reading-layout" id="singlePostReadingLayout">
                                                  <aside class="single-post-reading-sidebar" aria-label="{{ __('Article navigation') }}">
                                                    <div class="post-reading-time">
                                                      <div><i class="far fa-clock" aria-hidden="true"></i> <strong>{{ $__postReadingMinutes }} {{ $__postReadingMinutes === 1 ? __('min read') : __('mins read') }}</strong></div>
                                                      <span class="post-reading-progress" aria-hidden="true"><span id="postReadingProgressBar"></span></span>
                                                    </div>
                                                    @if (!empty($__postToc))
                                                      <nav class="post-contents" aria-labelledby="postContentsTitle">
                                                        <h2 id="postContentsTitle">{{ __('Contents') }}</h2>
                                                        <ol>
                                                          @foreach ($__postToc as $tocItem)
                                                            <li class="toc-level-{{ $tocItem['level'] }}"><a href="#{{ $tocItem['id'] }}">{{ $tocItem['text'] }}</a></li>
                                                          @endforeach
                                                        </ol>
                                                      </nav>
                                                    @endif
                                                  </aside>
                                                  <div class="single-post-reading-content" id="singlePostReadingContent">
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
                                                @if (($page->type ?? '') === 'post' && !empty($read_also_posts))
                                                  {!! $__postDescriptionBefore !!}
                                                  <aside class="post-read-also" aria-labelledby="postReadAlsoTitle">
                                                    <h2 id="postReadAlsoTitle">{{ __('Read Also') }}</h2>
                                                    <div class="post-read-also-list">
                                                      @foreach ($read_also_posts as $readAlsoPost)
                                                        <article class="post-read-also-item">
                                                          <a class="post-read-also-thumb" href="{{ url('/blog/'.$readAlsoPost['slug']) }}" tabindex="-1" aria-hidden="true">
                                                            <img src="{{ !empty($readAlsoPost['featured_image']) ? $readAlsoPost['featured_image'] : asset('assets/img/no-thumb.svg') }}" alt="" width="64" height="64" loading="lazy">
                                                          </a>
                                                          <div class="post-read-also-copy">
                                                            <h3><a href="{{ url('/blog/'.$readAlsoPost['slug']) }}">{{ $readAlsoPost['title'] }}</a></h3>
                                                            <div class="post-read-also-meta">
                                                              @if (!empty($readAlsoPost['published_at']))
                                                                <time datetime="{{ \Illuminate\Support\Carbon::parse($readAlsoPost['published_at'])->toDateString() }}">{{ \Illuminate\Support\Carbon::parse($readAlsoPost['published_at'])->format('F j, Y') }}</time>
                                                                <span aria-hidden="true">•</span>
                                                              @endif
                                                              <span><i class="far fa-comment" aria-hidden="true"></i> 0</span>
                                                            </div>
                                                          </div>
                                                        </article>
                                                      @endforeach
                                                    </div>
                                                  </aside>
                                                  {!! $__postDescriptionAfter !!}
                                                @else
                                                  {!! $__renderedDescription !!}
                                                @endif
                                              @endif

                                              @if (($page->type ?? '') === 'post')
                                                  <section class="post-after-article" aria-labelledby="postNextUpTitle">
                                                    @if (!empty($next_up_posts))
                                                      <div class="post-next-up">
                                                        <div class="post-next-up-heading">
                                                          <h2 id="postNextUpTitle">{{ __('Next Up') }}</h2>
                                                          <span><i class="fas fa-magic" aria-hidden="true"></i> {{ __('AI-generated') }}</span>
                                                        </div>
                                                        <div class="post-next-up-grid">
                                                          @foreach ($next_up_posts as $nextUpPost)
                                                            <article>
                                                              <a class="post-next-up-thumb" href="{{ url('/blog/'.$nextUpPost['slug']) }}" tabindex="-1" aria-hidden="true">
                                                                <img src="{{ !empty($nextUpPost['featured_image']) ? $nextUpPost['featured_image'] : asset('assets/img/no-thumb.svg') }}" alt="" width="48" height="48" loading="lazy">
                                                              </a>
                                                              <h3><a href="{{ url('/blog/'.$nextUpPost['slug']) }}">{{ $nextUpPost['title'] }}</a></h3>
                                                            </article>
                                                          @endforeach
                                                        </div>
                                                      </div>
                                                    @endif

                                                    <div class="post-after-meta">
                                                      <a href="{{ url('/blog') }}"><i class="far fa-folder-open" aria-hidden="true"></i> {{ $__postCategoryName }}</a>
                                                      <div>
                                                        <span><i class="far fa-eye" aria-hidden="true"></i> 0</span>
                                                        <span><i class="far fa-comment" aria-hidden="true"></i> 0</span>
                                                        @if ($__postUpdatedDate)
                                                          <time datetime="{{ $__postUpdatedDate->toDateString() }}">{{ __('Updated on') }} {{ $__postUpdatedDate->format('F j, Y') }}</time>
                                                        @endif
                                                      </div>
                                                    </div>

                                                    <div class="post-after-share" aria-label="{{ __('Share article') }}">
                                                      <span>{{ __('Share') }}</span>
                                                      <a class="post-share-facebook" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener noreferrer nofollow" aria-label="{{ __('Share on Facebook') }}"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
                                                      <a class="post-share-twitter" href="https://twitter.com/intent/tweet?text={{ urlencode($pageTrans->title) }}&url={{ urlencode(url()->current()) }}" target="_blank" rel="noopener noreferrer nofollow" aria-label="{{ __('Share on Twitter') }}"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                                                      <a class="post-share-pinterest" href="https://www.pinterest.com/pin/create/button/?url={{ urlencode(url()->current()) }}&media={{ urlencode($page->featured_image) }}&description={{ urlencode($pageTrans->title) }}" target="_blank" rel="noopener noreferrer nofollow" aria-label="{{ __('Share on Pinterest') }}"><i class="fab fa-pinterest-p" aria-hidden="true"></i></a>
                                                      <a class="post-share-linkedin" href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" target="_blank" rel="noopener noreferrer nofollow" aria-label="{{ __('Share on LinkedIn') }}"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a>
                                                      <a class="post-share-reddit" href="https://www.reddit.com/submit?url={{ urlencode(url()->current()) }}&title={{ urlencode($pageTrans->title) }}" target="_blank" rel="noopener noreferrer nofollow" aria-label="{{ __('Share on Reddit') }}"><i class="fab fa-reddit-alien" aria-hidden="true"></i></a>
                                                      <a class="post-share-tumblr" href="https://www.tumblr.com/widgets/share/tool?canonicalUrl={{ urlencode(url()->current()) }}&title={{ urlencode($pageTrans->title) }}" target="_blank" rel="noopener noreferrer nofollow" aria-label="{{ __('Share on Tumblr') }}"><i class="fab fa-tumblr" aria-hidden="true"></i></a>
                                                    </div>

                                                    @if (!empty($previous_post) || !empty($next_post))
                                                      <nav class="post-adjacent" aria-label="{{ __('Previous and next articles') }}">
                                                        @if (!empty($previous_post))
                                                          <article class="post-adjacent-prev">
                                                            <a class="post-adjacent-thumb" href="{{ url('/blog/'.$previous_post['slug']) }}" tabindex="-1" aria-hidden="true"><img src="{{ !empty($previous_post['featured_image']) ? $previous_post['featured_image'] : asset('assets/img/no-thumb.svg') }}" alt="" width="60" height="60" loading="lazy"></a>
                                                            <div class="post-adjacent-copy">
                                                              <span>{{ __('Prev Post') }}</span>
                                                              <h3><a href="{{ url('/blog/'.$previous_post['slug']) }}">{{ $previous_post['title'] }}</a></h3>
                                                            </div>
                                                          </article>
                                                        @endif
                                                        @if (!empty($next_post))
                                                          <article class="post-adjacent-next">
                                                            <div class="post-adjacent-copy">
                                                              <span>{{ __('Next Post') }}</span>
                                                              <h3><a href="{{ url('/blog/'.$next_post['slug']) }}">{{ $next_post['title'] }}</a></h3>
                                                            </div>
                                                            <a class="post-adjacent-thumb" href="{{ url('/blog/'.$next_post['slug']) }}" tabindex="-1" aria-hidden="true"><img src="{{ !empty($next_post['featured_image']) ? $next_post['featured_image'] : asset('assets/img/no-thumb.svg') }}" alt="" width="60" height="60" loading="lazy"></a>
                                                          </article>
                                                        @endif
                                                      </nav>
                                                    @endif

                                                    <div class="post-comments-cta" id="comments">
                                                      <h2>{{ __('Comments') }}</h2>
                                                      <button class="post-comment-toggle" type="button" aria-expanded="false" aria-controls="postCommentForm" onclick="const form=document.getElementById('postCommentForm');const opening=form.hidden;form.hidden=!opening;this.setAttribute('aria-expanded',opening?'true':'false');this.querySelector('span').textContent=opening?'⌃':'⌄';if(opening){form.querySelector('input').focus();}">{{ __('Add a comment') }} <span aria-hidden="true">⌄</span></button>
                                                      <form class="post-comment-form" id="postCommentForm" hidden onsubmit="event.preventDefault();">
                                                        <h3>{{ __('Leave a Reply') }}</h3>
                                                        <p>{{ __('Your email address will not be published.') }}<br>{{ __('Required fields are marked') }} *</p>
                                                        <div class="post-comment-fields">
                                                          <label for="postCommentName">{{ __('Name') }} *
                                                            <input id="postCommentName" name="name" type="text" placeholder="{{ __('Enter Your Name') }}" autocomplete="name" required>
                                                          </label>
                                                          <label for="postCommentEmail">{{ __('E-mail') }} *
                                                            <input id="postCommentEmail" name="email" type="email" placeholder="{{ __('Enter Your E-mail') }}" autocomplete="email" required>
                                                          </label>
                                                        </div>
                                                        <label for="postCommentMessage">{{ __('Message') }} *
                                                          <textarea id="postCommentMessage" name="message" rows="5" placeholder="{{ __('Your Message') }}" required></textarea>
                                                        </label>
                                                        <label class="post-comment-remember" for="postCommentRemember">
                                                          <input id="postCommentRemember" name="remember" type="checkbox" value="1">
                                                          <span>{{ __('Save my name and e-mail in this browser for the next time I comment.') }}</span>
                                                        </label>
                                                        <button class="post-comment-submit" type="submit">{{ __('Submit Comment') }}</button>
                                                      </form>
                                                    </div>
                                                  </section>
                                                  </div>
                                                  @if (!empty($spotlight_posts))
                                                    <aside class="post-spotlight" aria-labelledby="postSpotlightTitle">
                                                      <h2 id="postSpotlightTitle">{{ __('Spotlight') }}</h2>
                                                      <div class="post-spotlight-list">
                                                        @foreach ($spotlight_posts as $spotlightPost)
                                                          <article class="post-spotlight-item">
                                                            <div class="post-spotlight-copy">
                                                              <a class="post-spotlight-category" href="{{ url('/blog') }}"><i class="far fa-folder-open" aria-hidden="true"></i>{{ $spotlightPost['category'] }}</a>
                                                              <h3><a href="{{ url('/blog/'.$spotlightPost['slug']) }}">{{ $spotlightPost['title'] }}</a></h3>
                                                              @if (!empty($spotlightPost['published_at']))
                                                                <time datetime="{{ \Illuminate\Support\Carbon::parse($spotlightPost['published_at'])->toDateString() }}">{{ \Illuminate\Support\Carbon::parse($spotlightPost['published_at'])->format('F j, Y') }}</time>
                                                              @endif
                                                            </div>
                                                            <a class="post-spotlight-thumb" href="{{ url('/blog/'.$spotlightPost['slug']) }}" tabindex="-1" aria-hidden="true">
                                                              <img src="{{ !empty($spotlightPost['featured_image']) ? $spotlightPost['featured_image'] : asset('assets/img/no-thumb.svg') }}" alt="" width="84" height="84" loading="lazy">
                                                            </a>
                                                          </article>
                                                        @endforeach
                                                      </div>
                                                    </aside>
                                                  @endif
                                                </div>
                                                <script>
                                                  (function () {
                                                    const content = document.getElementById('singlePostReadingContent');
                                                    const bar = document.getElementById('postReadingProgressBar');
                                                    if (!content || !bar) return;
                                                    function updateReadingProgress() {
                                                      const rect = content.getBoundingClientRect();
                                                      const available = Math.max(1, content.offsetHeight - window.innerHeight * 0.35);
                                                      const progress = Math.min(100, Math.max(0, ((window.innerHeight * 0.25 - rect.top) / available) * 100));
                                                      bar.style.width = progress + '%';
                                                    }
                                                    updateReadingProgress();
                                                    window.addEventListener('scroll', updateReadingProgress, { passive: true });
                                                    window.addEventListener('resize', updateReadingProgress);

                                                    const tocLinks = Array.from(document.querySelectorAll('.post-contents a[href^="#"]'));
                                                    const tocHeadings = tocLinks.map(function (link) {
                                                      return document.getElementById(link.getAttribute('href').slice(1));
                                                    }).filter(Boolean);
                                                    function updateActiveContentsLink() {
                                                      let active = tocHeadings[0] || null;
                                                      tocHeadings.forEach(function (heading) {
                                                        if (heading.getBoundingClientRect().top <= 120) active = heading;
                                                      });
                                                      tocLinks.forEach(function (link) {
                                                        const selected = active && link.getAttribute('href') === '#' + active.id;
                                                        link.classList.toggle('is-active', selected);
                                                        if (selected) link.setAttribute('aria-current', 'location');
                                                        else link.removeAttribute('aria-current');
                                                      });
                                                    }
                                                    updateActiveContentsLink();
                                                    window.addEventListener('scroll', updateActiveContentsLink, { passive: true });
                                                  })();
                                                </script>
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

                                            @if ( $general->share_icons_status && !in_array($page->type ?? '', ['contact','page','report','post']) )
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

                                            @if ( $general->author_box_status && !in_array($page->type ?? '', ['tool','home','page','contact','report','post']) )
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

                                  @if ($__isPillar && !empty($related_pillar_posts))
                                    <section class="pillar-related" aria-labelledby="pillarRelatedTitle">
                                      <div class="pillar-related-head">
                                        <div><span>{{ __('Continue learning') }}</span><h2 id="pillarRelatedTitle">{{ __('Related guides and articles') }}</h2></div>
                                        <a href="{{ url('/blog') }}">{{ __('View all articles') }} <span>→</span></a>
                                      </div>
                                      <div class="pillar-related-grid">
                                        @foreach ($related_pillar_posts as $relatedPillarPost)
                                          <article>
                                            <a class="pillar-related-image" href="{{ url('/blog/'.$relatedPillarPost['slug']) }}">
                                              <img src="{{ !empty($relatedPillarPost['featured_image']) ? $relatedPillarPost['featured_image'] : asset('assets/img/no-thumb.svg') }}" alt="{{ $relatedPillarPost['title'] }}" width="640" height="400" loading="lazy">
                                            </a>
                                            <div class="pillar-related-copy">
                                              <span>{{ $relatedPillarPost['category'] }}</span>
                                              <h3><a href="{{ url('/blog/'.$relatedPillarPost['slug']) }}">{{ $relatedPillarPost['title'] }}</a></h3>
                                              @if (!empty($relatedPillarPost['short_description']))<p>{{ \Illuminate\Support\Str::limit(strip_tags($relatedPillarPost['short_description']), 105) }}</p>@endif
                                              @if (!empty($relatedPillarPost['published_at']))<time datetime="{{ \Illuminate\Support\Carbon::parse($relatedPillarPost['published_at'])->toDateString() }}">{{ \Illuminate\Support\Carbon::parse($relatedPillarPost['published_at'])->format('F j, Y') }}</time>@endif
                                            </div>
                                          </article>
                                        @endforeach
                                      </div>
                                    </section>
                                  @endif

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

                              @if ( !$__isLegal && !$__isPillar && ($page->type ?? '') !== 'post' && ( $page->ads_status && ( ( $advertisement->sidebar_top_status && $advertisement->sidebar_top != null ) || ( $advertisement->sidebar_middle_status && $advertisement->sidebar_middle != null ) || ( $advertisement->sidebar_bottom_status && $advertisement->sidebar_bottom != null ) ) || $sidebar->tool_status || $sidebar->post_status ) )
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

            @if (($page->type ?? '') === 'post' && !empty($spotlight_posts))
              <section class="post-recommended" aria-labelledby="postRecommendedTitle">
                <div class="post-recommended-shell">
                  <h2 id="postRecommendedTitle">{{ __('Recommended for You') }}</h2>
                  <div class="post-recommended-grid">
                    @foreach (array_slice($spotlight_posts, 0, 4) as $recommendedPost)
                      <article class="post-recommended-card">
                        <div class="post-recommended-media">
                          <a href="{{ url('/blog/'.$recommendedPost['slug']) }}" tabindex="-1" aria-hidden="true">
                            <img src="{{ !empty($recommendedPost['featured_image']) ? $recommendedPost['featured_image'] : asset('assets/img/no-thumb.svg') }}" alt="" width="640" height="420" loading="lazy">
                          </a>
                          <a class="post-recommended-category" href="{{ url('/blog') }}">{{ $recommendedPost['category'] }}</a>
                          <span class="post-recommended-corner" aria-hidden="true">
                            <a class="post-recommended-arrow" href="{{ url('/blog/'.$recommendedPost['slug']) }}" aria-label="{{ __('Read') }} {{ $recommendedPost['title'] }}" tabindex="-1">→</a>
                            <i class="post-recommended-curve-one"></i>
                            <i class="post-recommended-curve-two"></i>
                          </span>
                        </div>
                        <h3><a href="{{ url('/blog/'.$recommendedPost['slug']) }}">{{ $recommendedPost['title'] }}</a></h3>
                      </article>
                    @endforeach
                  </div>
                </div>
              </section>
            @endif

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
