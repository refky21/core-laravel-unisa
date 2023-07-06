@php
    $active_theme = getActiveTheme();
    $homepage = getThemeOption('home_page', $active_theme->id);
    $layout = $homepage['homepage_layout'];
    $generalSettings = getGeneralSettingsDetails();
    
    $title = $generalSettings['system_name'];
    $motto = $generalSettings['site_moto'];
    $rtl = getActiveFrontLangRTL();
@endphp
@extends('theme/default::frontend.layout.master')

@section('seo')
    {{-- SEO  --}}
    <title>{{ $title . '|' . $motto }}</title>
    <meta name="title" content="{{ $generalSettings['site_meta_title'] ? $generalSettings['site_meta_title'] : $title }}">
    <meta name="description" content="{{ $generalSettings['site_meta_description'] }}">
    <meta name="keywords" content="{{ $generalSettings['site_meta_keywords'] }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $generalSettings['site_meta_title'] }}">
    <meta property="og:description" content="{{ $generalSettings['site_meta_description'] }}">
    <meta name="twitter:card" content="{{ $generalSettings['site_meta_description'] }}">
    <meta name="twitter:title" content="{{ $generalSettings['site_meta_title'] }}">
    <meta name="twitter:description" content="{{ $generalSettings['site_meta_description'] }}">
    <meta name="twitter:image" content="{{ asset(getFilePath($generalSettings['site_meta_image'])) }}">
    <meta property="og:image" content="{{ asset(getFilePath($generalSettings['site_meta_image'])) }}">
@endsection

@section('custom-css')
    {!! homePageCss($sections) !!}
@endsection

@section('content')
    <!-- Banner -->
    @include('theme/default::frontend.includes.sections.slider-section', [
        'properties' => $sections[$slider_id],
        'id' => $slider_id,
    ])
    <!-- End of Banner -->

    <div class="container pt-120 pb-90">
        <div class="row">
            <div class="{{ $layout == 'full_layout' ? 'col-lg-12' : 'col-lg-8' }} {{ $layout == 'left_sidebar_layout' ? 'order-2' : 'order-1' }}"
                id="homepage_section">
                @foreach ($sections as $key => $properties)
                    @if ($properties['layout'] !== 'slider')
                        @if ($properties['layout'] == 'ads')
                            @include('theme/default::frontend.includes.sections.ads-section', [
                                'properties' => $properties,
                                'id' => $key,
                            ])
                        @else
                            @include('theme/default::frontend.includes.sections.blog-section', [
                                'properties' => $properties,
                                'id' => $key,
                            ])
                        @endif
                    @endif
                @endforeach
            </div>

            @if ($layout != 'full_layout')
                <div class="col-lg-4 {{ $layout == 'left_sidebar_layout' ? 'order-1' : 'order-2' }}">
                    @includeIf('theme/default::frontend.includes.sidebar.sidebar', [
                        'type' => 'home_page_sidebar',
                    ])
                </div>
            @endif
        </div>
    </div>
@endsection

@section('custom-js')
    <script>
        (function($) {
            'use strict';

            // Banner Slider Carousal Initialize
            let RTL = false;
            if ('{{ $rtl }}') {
                RTL = true;
            }

            // Slider Banner Carousel
            let sync1 = $(".banner-slider");
            sync1
                .owlCarousel({
                    rtl: RTL,
                    items: 4,
                    slideSpeed: 2000,
                    autoplay: true,
                    loop: true,
                    responsiveRefreshRate: 200,
                    animateIn: false,
                    animateOut: false,
                    margin: 0,
                    responsive: {
                        0: {
                            items: 1
                        },
                        768: {
                            items: 2
                        },
                        1024: {
                            items: 3
                        },
                        1440: {
                            items: 4
                        }
                    }
                });

            // blog category change
            $(document).on('change', '#category_field', function() {
                let value = $('#category_field option:selected').val();
                if (value) {
                    let url = '{{ route('theme.default.blogByCategory', 'permalink') }}';
                    url = url.replace("permalink", value);
                    window.location.href = url;
                }
            });

        })(jQuery);
    </script>
@endsection
