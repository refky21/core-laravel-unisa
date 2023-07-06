@php
    $chink_size_object = getChunkSize();
    $chink_size = 256000000;
    if ($chink_size_object != null) {
        $chink_size = $chink_size_object->value;
    }
    
    $placeholder_info = getPlaceHolderImage();
    $placeholder_image = '';
    $placeholder_image_alt = '';
    
    if ($placeholder_info != null) {
        $placeholder_image = $placeholder_info->placeholder_image;
        $placeholder_image_alt = $placeholder_info->placeholder_image_alt;
    }
    
    $logo_details = getGeneralSettingsDetails();
@endphp
    @include('core::base.layouts.partials.main_head')
    <link rel="stylesheet" href="{{ asset('/public/backend/assets/libs/jsvectormap/css/jsvectormap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('/public/backend/assets/libs/swiper/swiper-bundle.min.css')}}">
     <!-- ======= TOASTER CSS======= -->
     <link rel="stylesheet" href="{{ asset('/public/backend/assets/css/toaster.min.css') }}">
    <!-- ======= TOASTER CSS======= -->

    <!-- ======= BEGIN PAGE LEVEL PLUGINS STYLES ======= -->
    <link rel="stylesheet" href="{{ asset('/public/backend/assets/libs/sweetalert2/sweetalert2.min.css') }}">
    <!-- ======= END BEGIN PAGE LEVEL PLUGINS STYLES ======= -->
    @yield('custom_css')
    <!-- End -->
    @stack('head')
</head>

<body>
    @include('core::base.layouts.partials.off_canvas')
    <div class="page">
        @include('core::base.layouts.header')
        @include('core::base.layouts.navbar')
            <div class="main-content app-content">
                <div class="container-fluid">

                    @include('core::base.layouts.partials.plugin_header')
                    @yield('main_content')
                </div>
            </div>
        @include('core::base.layouts.partials.footer')
    </div>
    <!-- End wrapper -->
        @include('core::base.layouts.partials.footer_js')

        <script src="{{ asset('/public/backend/assets/libs/dropzone/dropzone-min.js') }}"></script>
        @yield('partial_scripts')

         <!-- ======= Dom Purify ======= -->
        <script src="{{ asset('/public/backend/assets/libs/dompurify/purify.min.js') }}"></script>
        <!-- ======= Dom Purify ======= -->

        <!-- ======= TOASTER ======= -->
        <script src="{{ asset('/public/backend/assets/js/toaster.min.js') }}"></script>
        {!! Toastr::message() !!}
        <!-- ======= TOASTER ======= -->

        <!-- Custom-Switcher JS -->
        <script src="{{ asset('/public/backend/assets/js/custom-switcher.min.js')}}"></script>
        <!-- Custom JS -->
        @include('core::base.layouts.partials.footer_script')
        @yield('custom_scripts')
        @stack('script')

        <script src="{{ asset('/public/backend/assets/js/custom.js')}}"></script>
</body>

</html>
