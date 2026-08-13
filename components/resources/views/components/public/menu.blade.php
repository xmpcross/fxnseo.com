@props(['childs', 'mega' => false])
@php
  $guideImages = [
    'backlink-monitoring-guide' => 'assets/img/mega-menu/backlink-monitoring-guide-light.webp',
    'link-opportunity-guide' => 'assets/img/mega-menu/link-opportunity-guide-light.webp',
    'seo-audit-guide' => 'assets/img/mega-menu/seo-audit-guide-light.webp',
  ];
  $isGuideMega = $mega && collect($childs)->contains(function ($item) use ($guideImages) {
    return isset($guideImages[$item['url'] ?? '']);
  });
@endphp
<div class="dropdown-menu px-2 mt-0 mt-lg-4 {{ $mega ? 'mega-menu-panel' : '' }} {{ $isGuideMega ? 'seo-guides-mega-panel' : '' }}">
        <ul class="list-group py-3 py-lg-0 {{ $mega ? 'mega-menu-grid' : '' }} {{ $isGuideMega ? 'seo-guides-mega-grid' : '' }}">

         @foreach($childs as $key => $child)

            @if(count($child['children']))

                <li class="nav-item dropdown dropdown-subitem list-group-item border-0 p-0">
                    <a class="dropdown-item py-2 ps-3 border-radius-md" href="#navbarDropdownMenuChild{{ $key }}" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                        <div class="d-flex">
                            <div class="w-100 d-flex align-items-center justify-content-between">
                                <p class="dropdown-header d-flex align-items-center p-0">
                                   @if ( !empty($child['icon']) )
                                     <i class="{{ $child['icon'] }} me-2"></i>
                                   @endif
                                    {{ __($child['text']) }}
                                </p>
                                <img src="{{ asset('assets/img/down-arrow.svg') }}" alt="down-arrow" class="arrow ms-1" />
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-menu mt-lg-0 p-2">
                        @foreach ($child['children'] as $key => $value)
                            <a class="dropdown-item ps-3 border-radius-md" href="{{ ( $value['menu_items']  == 'custom' ) ? $value['url'] : route('home') . '/' . $value['url'] }}">
                               @if ( !empty($value['icon']) )
                                 <i class="{{ $value['icon'] }} me-2"></i>
                               @endif
                                {{ __($value['text']) }}
                            </a>
                        @endforeach
                    </div>
                </li>

            @else
                @php $guideImage = $guideImages[$child['url'] ?? ''] ?? null; @endphp
                <li class="nav-item dropdown dropdown-subitem list-group-item border-0 p-0 {{ $guideImage ? 'seo-guide-menu-card' : '' }}">
                    <a class="dropdown-item py-2 ps-3 border-radius-md" href="{{ ( $child['menu_items']  == 'custom' ) ? $child['url'] : route('home') . '/' . $child['url'] }}">
                        @if ($guideImage)
                          <span class="seo-guide-menu-image"><img src="{{ asset($guideImage) }}" alt="" width="720" height="480" loading="lazy"></span>
                        @endif
                        <div class="d-flex">
                            <div class="w-100 d-flex align-items-center justify-content-between">
                                <p class="dropdown-header d-flex align-items-center p-0">
                                   @if ( !empty($child['icon']) )
                                     <i class="{{ $child['icon'] }} me-2"></i>
                                   @endif
                                    {{ __($child['text']) }}
                                </p>
                            </div>
                        </div>
                    </a>
                </li>
            @endif

         @endforeach

        </ul>
</div>
