<!-- Start::app-sidebar -->
<aside class="app-sidebar sticky" id="sidebar">

    <!-- Start::main-sidebar-header -->
    <div class="main-sidebar-header">
        <a href="{{ route('admin.dashboard') }}" class="header-logo">
            <img src="{{asset('/public/backend/assets/images/brand-logos/desktop-logo.png')}}" alt="logo" class="desktop-logo">
            <img src="{{asset('/public/backend/assets/images/brand-logos/toggle-logo.png')}}" alt="logo" class="toggle-logo">
            <img src="{{asset('/public/backend/assets/images/brand-logos/desktop-dark.png')}}" alt="logo" class="desktop-dark">
            <img src="{{asset('/public/backend/assets/images/brand-logos/toggle-dark.png')}}" alt="logo" class="toggle-dark">
        </a>
    </div>
    <!-- End::main-sidebar-header -->

    <!-- Start::main-sidebar -->
    <div class="main-sidebar" id="sidebar-scroll">

        <!-- Start::nav -->
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path> </svg>
            </div>
            <ul class="main-menu">
                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">Main</span></li>
                <!-- End::slide__category -->

                @if (auth()->user()->can('Manage Dashboard'))
                <!-- Start::slide -->
                    <li class="slide {{ Request::routeIs('admin.dashboard') ? 'active ' : '' }}">
                        <a href="{{ route('admin.dashboard') }}" class="side-menu__item {{ Request::routeIs('admin.dashboard') ? 'active ' : '' }}">
                            <i class="bx bx-home side-menu__icon"></i>
                            <span class="side-menu__label">{{ translate('Dashboard') }}</span>
                        </a>
                    </li>
                    <!-- End::slide -->
                @endif
                @if (auth()->user()->can('Manage Media'))
                    <!--Media Module-->
                    <li class="slide {{ Request::routeIs(['core.media.page']) ? 'active ' : '' }}">
                        <a href="{{ route('core.media.page') }}" class="side-menu__item {{ Request::routeIs(['core.media.page']) ? 'active ' : '' }}">
                            <i class="bx bx-file side-menu__icon"></i>
                            <span class="side-menu__label">{{ translate('Media') }}</span>
                        </a>
                    </li>
                    <!--End Media module-->
                @endif

                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">Pages</span></li>
                <!-- End::slide__category -->

                <!-- Start::slide -->
                @canany(['Show Blog', 'Create Blog', 'Manage Category', 'Manage Tag', 'Manage Comment'])
                <li class="slide has-sub {{ Request::routeIs(['core.blog.category', 'core.add.blog.category', 'core.edit.blog.category', 'core.blog', 'core.add.blog', 'core.edit.blog', 'core.tag', 'core.edit.tag', 'core.add.tag', 'core.blog.comment', 'core.blog.comment.edit', 'core.blog.comment.setting', 'core.blog.ai.setting','core.blog.share.options']) ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="side-menu__item {{ Request::routeIs(['core.blog.category', 'core.add.blog.category', 'core.edit.blog.category', 'core.blog', 'core.add.blog', 'core.edit.blog', 'core.tag', 'core.edit.tag', 'core.add.tag', 'core.blog.comment', 'core.blog.comment.edit', 'core.blog.comment.setting', 'core.blog.ai.setting','core.blog.share.options']) ? 'active' : '' }}">
                        <i class="bx bxs-paper-plane side-menu__icon"></i>
                        <span class="side-menu__label">{{ translate('Blog') }}</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        @can('Show Blog')
                            <li class="slide">
                                <a href="{{ route('core.blog') }}" class="side-menu__item {{ Request::routeIs(['core.blog', 'core.edit.blog']) ? 'active ' : '' }}">{{ translate('All Blogs') }}</a>
                            </li>
                        @endcan
                        @can('Create Blog')
                            <li class="slide">
                                <a class="side-menu__item {{ Request::routeIs('core.add.blog') ? 'active ' : '' }}" href="{{ route('core.add.blog') }}">{{ translate('Add New Blog') }}</a>
                            </li>
                        @endcan
                        @can('Manage Category')
                            <li class="slide">
                                <a class="side-menu__item {{ Request::routeIs(['core.blog.category', 'core.add.blog.category', 'core.edit.blog.category']) ? 'active ' : '' }}" href="{{ route('core.blog.category') }}">{{ translate('Categories') }}</a>
                            </li>
                        @endcan
                        @can('Manage Tag')
                            <li class="slide">
                                <a class="side-menu__item {{ Request::routeIs(['core.tag', 'core.add.tag', 'core.edit.tag']) ? 'active ' : '' }}" href="{{ route('core.tag') }}">{{ translate('Tags') }}</a>
                            </li>
                        @endcan
                            @can('Manage Comment')
                                <li class="slide">
                                    <a class="side-menu__item {{ Request::routeIs(['core.blog.comment', 'core.blog.comment.edit']) ? 'active ' : '' }}" href="{{ route('core.blog.comment') }}">{{ translate('Comments') }}</a>
                                </li>
                                <li class="slide has-sub {{ Request::routeIs(['core.blog.comment.setting', 'core.blog.ai.setting', 'core.blog.share.options']) ? 'active open' : '' }}">
                                    <a href="javascript:void(0);" class="side-menu__item {{ Request::routeIs(['core.blog.comment.setting', 'core.blog.ai.setting', 'core.blog.share.options']) ? 'active' : '' }}">{{ translate('Settings') }}
                                            <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                    
                                    <ul class="slide-menu child2">
                                        <li class="slide">
                                            <a class="side-menu__item {{ Request::routeIs(['core.blog.share.options']) ? 'active' : '' }}" href="{{ route('core.blog.share.options') }}">{{ translate('Blog Share Settings') }}</a>
                                        </li>
                                        <li class="slide">
                                            <a class="side-menu__item {{ Request::routeIs(['core.blog.ai.setting']) ? 'active' : '' }}" href="{{ route('core.blog.ai.setting') }}">{{ translate('Open AI Settings') }}</a>
                                        </li>
                                        <li class="slide">
                                            <a class="side-menu__item {{ Request::routeIs(['core.blog.comment.setting']) ? 'active' : '' }}"
                                                href="{{ route('core.blog.comment.setting') }}">{{ translate('Comment Settings') }}</a>
                                        </li>
                                    </ul>
                                </li>
                            @endcan
                    </ul>
                </li>
                @endcanany
                <!--End Blog module-->
                <!-- End::slide -->

                  <!--Page Module-->
                    @canany(['Show Page', 'Create Page'])
                        <li class="slide has-sub {{ Request::routeIs(['core.page', 'core.page.add', 'core.page.edit']) ? 'active open' : '' }}">
                            <a href="javascript:void(0);" class="side-menu__item {{ Request::routeIs(['core.page', 'core.page.add', 'core.page.edit']) ? 'active' : '' }}">
                                <i class="bx bx-party side-menu__icon"></i>
                                <span class="side-menu__label">{{ translate('Pages') }}</span>
                                <i class="fe fe-chevron-right side-menu__angle"></i>
                            </a>
                            <ul class="slide-menu child1">
                                @can('Show Page')
                                    <li class="slide">
                                        <a class="side-menu__item {{ Request::routeIs(['core.page', 'core.page.edit']) ? 'active ' : '' }}" href="{{ route('core.page') }}">{{ translate('All Pages') }}</a>
                                    </li>
                                @endcan
                                @can('Create Page')
                                    <li class="slide">
                                        <a class="side-menu__item {{ Request::routeIs('core.page.add') ? 'active' : '' }}" href="{{ route('core.page.add') }}">{{ translate('Add New Page') }}</a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany
                    <!--End Blog module-->
                    <!-- Blog & Page -->
                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">Apperance</span></li>
                                <!-- End::slide__category -->
                <!-- Start::slide -->
                    <!--Appearances Modules-->
                        @if (auth()->user()->can('Manage Themes') ||
                                auth()->user()->can('Manage Menus'))
                            <li class="slide has-sub {{ Request::routeIs(['core.themes.index', 'core.manage.menus']) ? 'active open' : '' }}">
                                <a href="javascript:void(0);" class="side-menu__item {{ Request::routeIs(['core.themes.index', 'core.manage.menus']) ? 'active' : '' }}">
                                    <i class="bx bx-desktop side-menu__icon"></i>
                                    <span class="side-menu__label">{{ translate('Appearances') }}</span>
                                    <i class="fe fe-chevron-right side-menu__angle"></i>
                                </a>
                                
                                <ul class="slide-menu child1">
                                    @if (auth()->user()->can('Manage Themes'))
                                        <li class="slide">
                                            <a class="side-menu__item {{ Request::routeIs(['core.themes.index']) ? 'active ' : '' }}" href="{{ route('core.themes.index') }}">{{ translate('Themes') }}</a>
                                        </li>
                                    @endif
                                    @if (auth()->user()->can('Manage Menus'))
                                        <li class="slide">
                                            <a class="side-menu__item {{ Request::routeIs(['core.manage.menus']) ? 'active ' : '' }}" href="{{ route('core.manage.menus') }}">{{ translate('Menus') }}</a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                        <!--End Appearances Modules-->
                <!-- End::slide -->
                    <!--Theme otions-->
                    @includeIf(getActiveThemeOptions())
                    <!--End Theme options-->
                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">General</span></li>
                                                <!-- End::slide__category -->
                <!-- Start::slide -->
                    @if (auth()->user()->can('Manage General Settings') ||
                        auth()->user()->can('Manage Email Settings') ||
                        auth()->user()->can('Manage Email Templates') ||
                        auth()->user()->can('Manage Language') ||
                        auth()->user()->can('Manage Media Settings') ||
                        auth()->user()->can('Manage Seo Settings'))
                        <!--Settings Modules-->
                        <li class="slide has-sub {{ Request::routeIs(['core.seo.settings', 'core.email.smtp.configuration', 'core.language.frontend.translations', 'core.image.settings', 'core.email.templates', 'core.language.edit', 'core.language.key.values', 'core.languages', 'core.language.new', 'core.image.settings', 'core.social.media.login.settings', 'core.general.settings']) ? 'active open' : '' }}">
                            <a href="javascript:void(0);" class="side-menu__item {{ Request::routeIs(['core.seo.settings', 'core.email.smtp.configuration', 'core.language.frontend.translations', 'core.image.settings', 'core.email.templates', 'core.language.edit', 'core.language.key.values', 'core.languages', 'core.language.new', 'core.image.settings', 'core.social.media.login.settings', 'core.general.settings']) ? 'active' : '' }}">
                                <i class="bx bxs-cog side-menu__icon"></i>
                                <span class="side-menu__label">{{ translate('Settings') }}</span>
                                <i class="fe fe-chevron-right side-menu__angle"></i>
                            </a>
                        
                            <ul class="slide-menu child1">
                                @if (auth()->user()->can('Manage General Settings'))
                                    <li class="slide">
                                        <a class="side-menu__item {{ Request::routeIs(['core.general.settings']) ? 'active ' : '' }}" href="{{ route('core.general.settings') }}">{{ translate('General settings') }}</a>
                                    </li>
                                @endif

                                @if (auth()->user()->can('Manage Email Settings'))
                                    <li class="slide">
                                        <a class="side-menu__item {{ Request::routeIs(['core.email.smtp.configuration']) ? 'active ' : '' }}" href="{{ route('core.email.smtp.configuration') }}">{{ translate('Email settings') }}</a>
                                    </li>
                                @endif

                                @if (auth()->user()->can('Manage Email Templates'))
                                    <li class="slide">
                                        <a class="side-menu__item {{ Request::routeIs(['core.email.templates']) ? 'active ' : '' }}" href="{{ route('core.email.templates') }}">{{ translate('Email Templates') }}</a>
                                    </li>
                                @endif

                                @if (auth()->user()->can('Manage Language'))
                                    <li class="slide">
                                        <a class="side-menu__item {{ Request::routeIs(['core.language.edit', 'core.language.key.values', 'core.languages', 'core.language.new']) ? 'active ' : '' }}"
                                            href="{{ route('core.languages') }}">{{ translate('Languages') }}</a>
                                    </li>
                                @endif

                                @if (auth()->user()->can('Manage Media Settings'))
                                    <li class="slide">
                                        <a class="side-menu__item {{ Request::routeIs(['core.image.settings']) ? 'active ' : '' }}"
                                            href="{{ route('core.image.settings') }}">{{ translate('Media settings') }}</a>
                                    </li>
                                @endif

                                @if (auth()->user()->can('Manage Seo Settings'))
                                    <li class="slide">
                                        <a class="side-menu__item {{ Request::routeIs(['core.seo.settings']) ? 'active ' : '' }}"
                                            href="{{ route('core.seo.settings') }}">{{ translate('SEO settings') }}</a>
                                    </li>
                                @endif

                                <li class="slide">
                                    <a class="side-menu__item {{ Request::routeIs(['core.admin.sitemap']) ? 'active ' : '' }}"
                                        href="{{ route('core.admin.sitemap') }}">{{ translate('Generate Sitemap') }}</a>
                                </li>
                            </ul>
                        </li>
                        <!--End Settings Modules-->
                    @endif
                <!-- End::slide -->

                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">User and Permission</span></li>
                <!-- End::slide__category -->

                <!-- Start::slide -->
                @if (auth()->user()->can('Show User') ||
                    auth()->user()->can('Show Role') ||
                    auth()->user()->can('Show Permission'))
                    <li
                        class="slide has-sub {{ Request::routeIs(['core.roles', 'core.permissions', 'core.users', 'core.add.user', 'core.edit.user']) ? 'active open' : '' }}">
                        <a href="javascript:void(0);" class="side-menu__item {{ Request::routeIs(['core.roles', 'core.permissions', 'core.users', 'core.add.user', 'core.edit.user']) ? 'active open' : '' }}">
                            <i class="bx bx-user-circle side-menu__icon"></i>
                            <span class="side-menu__label">{{ translate('Users') }}</span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1">
                            @if (auth()->user()->can('Show User'))
                                <li class="slide">
                                    <a class="side-menu__item {{ Request::routeIs(['core.users', 'core.add.user', 'core.edit.user']) ? 'active ' : '' }}" href="{{ route('core.users') }}">{{ translate('Users') }}</a>
                                </li>
                            @endif

                            @if (auth()->user()->can('Show Role'))
                                <li class="slide"><a class="side-menu__item {{ Request::routeIs(['core.roles']) ? 'active ' : '' }}"
                                        href="{{ route('core.roles') }}">{{ translate('Roles') }}</a></li>
                            @endif

                            @if (auth()->user()->can('Show Permission'))
                                <li class="slide">
                                    <a class="side-menu__item {{ Request::routeIs(['core.permissions']) ? 'active ' : '' }}" 
                                        href="{{ route('core.permissions') }}">{{ translate('Permissions') }}</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
            <!--End users-->
                <!-- End::slide -->


                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">Logs</span></li>
                <!-- End::slide__category -->

                <!-- Start::slide -->
                <!--Activity Logs Module-->
                @if (auth()->user()->can('Manage Login activity'))
                    <li
                        class="slide has-sub {{ Request::routeIs(['core.activity.logs', 'core.get.login.activity']) ? 'active open' : '' }}">
                        <a href="javascript:void(0);" class="side-menu__item {{ Request::routeIs(['core.activity.logs', 'core.get.login.activity']) ? 'active' : '' }}">
                            <i class="bx bx-stats side-menu__icon"></i>
                            <span class="side-menu__label">{{ translate('Activity Logs') }}</span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide">
                                <a class="side-menu__item {{ Request::routeIs(['core.get.login.activity']) ? 'active ' : '' }}" href="{{ route('core.get.login.activity') }}">{{ translate('Login activity') }}</a>
                            </li>
                        </ul>
                    </li>
                @endif
                <!--Activity Logs Settings Module-->
                <!-- End::slide -->
            </ul>
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path> </svg></div>
        </nav>
        <!-- End::nav -->

    </div>
    <!-- End::main-sidebar -->

</aside>
<!-- End::app-sidebar -->