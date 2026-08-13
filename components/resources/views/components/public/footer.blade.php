      <footer class="footer default-footer">

       @if ( $general->social_status == true && count($socials) > 0 )
          <hr class="horizontal dark mb-4">
          <h4 class="text-center mb-3">{{ __('Follow us') }}</h4>
          <div class="social-share text-center">
            <div class="share-icons relative">
                @foreach ($socials as $key => $social)
                  <a href="{{ $social['url'] }}" class="btn btn-{{ $social['name'] }} btn-icon" target="_blank">
                      <span class="btn-inner--icon"><i class="fab fa-{{ $social['name'] }} fa-fw"></i></span>
                      <span class="btn-inner--text">{{ ucfirst($social['name']) }}</span>
                  </a>
                @endforeach
            </div>
          </div>
        @endif
        
        @if ( !empty($footer->layout) && $footer->layout != 'none' )
          <hr class="horizontal dark mb-5">
        @endif

        <div class="container">
          <div class="row footer-grid footer-layout-{{ $footer->layout ?? 'none' }}">
              @if ( !empty($footer->layout) )
              
                @switch( $footer->layout )

                    @case(1)

                        <div class="col-12 mb-3">
                          <div>
                            {!! GrahamCampbell\Security\Facades\Security::clean($footer->widget1) !!}
                          </div>
                        </div>

                    @break

                    @case(2)

                        <div class="col-md-6 mb-3">
                          <div>
                            {!! GrahamCampbell\Security\Facades\Security::clean($footer->widget1) !!}
                          </div>
                        </div>
                      
                        <div class="col-md-6 mb-3">
                          <div>
                            {!! GrahamCampbell\Security\Facades\Security::clean($footer->widget2) !!}
                          </div>
                        </div>

                    @break

                    @case(3)

                        <div class="col-md-6 mb-3">
                          <div>
                            {!! GrahamCampbell\Security\Facades\Security::clean($footer->widget1) !!}
                          </div>
                        </div>
                      
                        <div class="col-md-3 col-6 mb-3">
                          <div>
                            {!! GrahamCampbell\Security\Facades\Security::clean($footer->widget2) !!}
                          </div>
                        </div>

                        <div class="col-md-3 col-6 mb-3">
                          <div>
                            {!! GrahamCampbell\Security\Facades\Security::clean($footer->widget3) !!}
                          </div>
                        </div>

                    @break

                    @case(4)

                        <div class="col-md-3 mb-3">
                          <div>
                            {!! GrahamCampbell\Security\Facades\Security::clean($footer->widget1) !!}
                          </div>
                        </div>
                      
                        <div class="col-md-3 col-sm-4 col-12 mb-3">
                          <div>
                            {!! GrahamCampbell\Security\Facades\Security::clean($footer->widget2) !!}
                          </div>
                        </div>

                        <div class="col-md-3 col-sm-4 col-12 mb-3">
                          <div>
                            {!! GrahamCampbell\Security\Facades\Security::clean($footer->widget3) !!}
                          </div>
                        </div>

                        <div class="col-md-3 col-sm-4 col-12 mb-3">
                          <div>
                            {!! GrahamCampbell\Security\Facades\Security::clean($footer->widget4) !!}
                          </div>
                        </div>

                    @break

                    @case(5)

                        <div class="col-md-3 mb-3 ftr-col-main">
                          <div>
                            {!! GrahamCampbell\Security\Facades\Security::clean($footer->widget1) !!}
                          </div>
                        </div>

                        <div class="col-md-2 col-sm-6 col-6 mb-3 ftr-col">
                          <div>
                            @php
                              $footerWidget2 = GrahamCampbell\Security\Facades\Security::clean($footer->widget2);
                              $toolsFooterLink = '<li class="nav-item"><a class="nav-link ps-0" title="Tools" href="'.route('tools').'">Tools</a></li>';
                              $footerWidget2 = preg_replace_callback(
                                '#<li[^>]*>\s*<a[^>]*href=["\'][^"\']*/blog["\'][^>]*>.*?</a>\s*</li>#is',
                                function ($match) use ($toolsFooterLink) {
                                  $articlesLink = preg_replace('#>\s*(?:Our\s+)?Blog\s*<#i', '>Blog<', $match[0]);
                                  return $toolsFooterLink.$articlesLink;
                                },
                                $footerWidget2,
                                1
                              );
                            @endphp
                            {!! $footerWidget2 !!}
                          </div>
                        </div>

                        <div class="col-md-2 col-sm-6 col-6 mb-3 ftr-col footer-youtube-tools">
                          <div>
                            {!! str_replace('>Tag Tools<', '>YouTube Tag Tools<', GrahamCampbell\Security\Facades\Security::clean($footer->widget3)) !!}
                          </div>
                        </div>

                        <div class="col-md-2 col-sm-6 col-6 mb-3 ftr-col">
                          <div>
                            {!! str_replace('>Backwards Text Generator<', '>Backwards Generator<', GrahamCampbell\Security\Facades\Security::clean($footer->widget4)) !!}
                          </div>
                        </div>

                        <div class="col-md-2 col-sm-6 col-6 mb-3 ftr-col footer-website-tools me-auto">
                          <div>
                            {!! GrahamCampbell\Security\Facades\Security::clean($footer->widget5) !!}
                          </div>
                        </div>

                    @break

                    @default

                @endswitch
              
              @endif

          </div>

        </div>
      </footer>

      @php
          $footer_data = !empty($footer->bottom_text)
              ? str_replace('%year%', date('Y'), $footer->bottom_text)
              : 'Copyright &copy; ' . date('Y') . ' ' . config('app.name') . '. All rights reserved.';
      @endphp
      <div class="bottom-footer">
        <div class="container">
          <div class="footer-copyright">{!! htmlspecialchars_decode($footer_data) !!}</div>
          <nav class="bottom-footer-menu" aria-label="{{ __('Legal') }}">
            <a href="{{ url('/terms-conditions') }}">{{ __('Terms & Conditions') }}</a>
            <a href="{{ url('/privacy-policy') }}">{{ __('Privacy Policy') }}</a>
            <a href="{{ url('/cookie-information') }}">{{ __('Cookie Info') }}</a>
          </nav>
        </div>
      </div>
