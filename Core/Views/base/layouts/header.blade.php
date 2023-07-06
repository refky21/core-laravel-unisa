@php
    $logo_details = getGeneralSettingsDetails();
    $placeholder_info = getPlaceHolderImage();
    $placeholder_image = '';
    $placeholder_image_alt = '';
    
    if ($placeholder_info != null) {
        $placeholder_image = $placeholder_info->placeholder_image;
        $placeholder_image_alt = $placeholder_info->placeholder_image_alt;
    }
@endphp
 <!-- app-header -->
 <header class="app-header">
    <!-- Start::main-header-container -->
    <div class="main-header-container container-fluid">
        <!-- Start::header-content-left -->
        <div class="header-content-left">

            <!-- Start::header-element -->
            <div class="header-element">
                <div class="horizontal-logo">
                    @if ($mood == 'dark')
                        <a href="{{ route('admin.dashboard') }}" class="header-logo">
                            @if (sizeof($logo_details) > 0 && isset($logo_details['admin_dark_logo']))
                                <a href="{{ route('admin.dashboard') }}" class="default-logo"><img
                                        src="{{ project_asset($logo_details['admin_dark_logo']) }}" alt="logo" class="dark-logo"></a>
                            @else
                                <h3 class="default-logo">{{ $logo_details['system_name'] }}</h3>
                            @endif
                        </a>
                    @else
                        <a href="{{ route('admin.dashboard') }}" class="header-logo">
                            @if (sizeof($logo_details) > 0 && isset($logo_details['admin_dark_logo']))
                                <a href="{{ route('admin.dashboard') }}" class="default-logo"><img
                                        src="{{ project_asset($logo_details['admin_dark_logo']) }}" alt="logo" class="dark-logo"></a>
                            @else
                                <h3 class="default-logo">{{ $logo_details['system_name'] }}</h3>
                            @endif
                        </a>
                    @endif
                </div>
            </div>
            <!-- End::header-element -->

            <!-- Start::header-element -->
            <div class="header-element">
                <!-- Start::header-link -->
                <a aria-label="Hide Sidebar" class="sidemenu-toggle header-link animated-arrow hor-toggle horizontal-navtoggle" data-bs-toggle="sidebar" href="javascript:void(0);"><span></span></a>
                <!-- End::header-link -->
            </div>
            <!-- End::header-element -->

        </div>
        <!-- End::header-content-left -->
         
        <!-- Start::header-content-right -->
        <div class="header-content-right">
            <!-- Start::header-element -->
            <div class="header-element country-selector">
                <!-- Start::header-link|dropdown-toggle -->
                <a href="javascript:void(0);" class="header-link dropdown-toggle" data-bs-auto-close="outside" data-bs-toggle="dropdown">
                        @if (isset($active_lang->code))
                            <img src="{{ asset('/public/flags/') . '/' . $active_lang->code . '.png' }}"
                            class="rounded-circle" alt="{{ $active_lang->code }}">
                        @endif
                </a>
                <!-- End::header-link|dropdown-toggle -->
                <ul id="lang-change" class="main-header-dropdown dropdown-menu dropdown-menu-end" data-popper-placement="none">
                    @foreach ($active_langs as $lang)
                        <li>
                        <a href="#" class="dropdown-item d-flex align-items-center" data-lan="{{ $lang->code }}">
                            <img src="{{ asset('/public/flags/') . '/' . $lang->code . '.png' }}"
                                class="mr-2 w-20" alt="{{ $lang->code }}">
                            {{ $lang->native_name }}
                        </a>
                        </li>
                    @endforeach
                    
                </ul>
            </div>
            <!-- End::header-element -->

            <!-- Start::header-element -->
            <div class="header-element">
                 <!-- Start::header-link|layout-setting -->
                 <a href="javascript:void(0);" class="header-link layout-setting">
                    <span class="light-layout">
                        <!-- Start::header-link-icon -->
                    <i class="bx bx-moon header-link-icon"></i>
                        <!-- End::header-link-icon -->
                    </span>
                    <span class="dark-layout">
                        <!-- Start::header-link-icon -->
                    <i class="bx bx-sun header-link-icon"></i>
                        <!-- End::header-link-icon -->
                    </span>
                </a>
                <!-- End::header-link|layout-setting -->
            </div>
            <!-- End::header-element -->
            <!-- Start::header-element -->
            <div class="header-element">
                <!-- Start::header-link|layout-setting -->
                <a href="{{ route('core.admin.clear.system.cache') }}" class="header-link switcher-icon">
                    <i class="bx bx-refresh header-link-icon"></i>
                </a>
                <!-- End::header-link|layout-setting -->
            </div>
            <!-- End::header-element -->
            
            <!-- Start::header-element -->
            <div class="header-element ">
                <!-- Start::header-link -->
                <a target="_blank" title="Visit website" href="{{ url('/') }}" class="header-link">
                    <i class="bx bx-globe header-link-icon"></i>
                </a>
                <!-- End::header-link -->
            </div>
            <!-- End::header-element -->
            
            <!-- Start::header-element -->
            <div class="header-element header-fullscreen">
                <!-- Start::header-link -->
                <a onclick="openFullscreen();" href="#" class="header-link">
                    <i class="bx bx-fullscreen full-screen-open header-link-icon"></i>
                    <i class="bx bx-exit-fullscreen full-screen-close header-link-icon d-none"></i>
                </a>
                <!-- End::header-link -->
            </div>
            <!-- End::header-element -->
            @auth
            <!-- Start::header-element -->
            <div class="header-element">
                <!-- Start::header-link|dropdown-toggle -->
                <a href="#" class="header-link dropdown-toggle" id="mainHeaderProfile" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                    <div class="d-flex align-items-center">
                        <div class="me-sm-2 me-0">
                                @if (auth()->user()->image != null)
                                    <img src="{{ asset(getFilePath(auth()->user()->image)) }}"
                                        alt="{{ auth()->user()->name }}" width="32" height="32" class="rounded-circle">
                                @else
                                    <img src="{{ asset('/public/backend/assets/img/avatar/user.png') }}"
                                        alt="{{ auth()->user()->name }}" width="32" height="32" class="rounded-circle">
                                @endif
                        </div>
                        <div class="d-sm-block d-none">
                            <p class="fw-semibold mb-0 lh-1">{{ auth()->user()->name }}</p>
                            <span class="op-7 fw-normal d-block fs-11">{{ auth()->user()->email }}</span>
                        </div>
                    </div>
                </a>
                <!-- End::header-link|dropdown-toggle -->
                <ul class="main-header-dropdown dropdown-menu pt-0 overflow-hidden header-profile-dropdown dropdown-menu-end" aria-labelledby="mainHeaderProfile">
                    <li><a class="dropdown-item d-flex" href="{{ route('core.profile') }}"><i class="ti ti-user-circle fs-18 me-2 op-7"></i>{{ translate('My Profile') }}</a></li>
                    <li><a class="dropdown-item d-flex" href="{{ route('core.logout') }}"><i class="ti ti-logout fs-18 me-2 op-7"></i>{{ translate('Log Out') }}</a></li>
                </ul>
            </div>  
            <!-- End::header-element -->
            @endauth

             <!-- Start::header-element -->
            <div class="header-element">
                <!-- Start::header-link|switcher-icon -->
                <a href="#" class="header-link switcher-icon" data-bs-toggle="offcanvas" data-bs-target="#switcher-canvas">
                    <i class="bx bx-cog header-link-icon"></i>
                </a>
                <!-- End::header-link|switcher-icon -->
            </div>
            <!-- End::header-element -->

        </div>
        <!-- End::header-content-right -->
    </div>
    <!-- End::main-header-container -->
 </header>
<!-- /app-header -->