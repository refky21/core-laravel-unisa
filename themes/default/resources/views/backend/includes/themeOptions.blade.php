{{-- Theme Option Navbar --}}
@canany(['Manage Theme General settings', 'Manage Home Page Builder', 'Manage Widget'])
    <li class="slide has-sub {{ Request::routeIs(['theme.default.options', 'theme.default.widgets', 'theme.default.homePageSections', 'theme.default.homePageSection.new', 'theme.default.homePageSection.edit']) ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="side-menu__item {{ Request::routeIs(['theme.default.options', 'theme.default.widgets', 'theme.default.homePageSections', 'theme.default.homePageSection.new', 'theme.default.homePageSection.edit']) ? 'active' : '' }}">
                <i class="bx bxs-color side-menu__icon"></i>
                <span class="side-menu__label">{{ translate('Theme Options') }}</span>
                <i class="fe fe-chevron-right side-menu__angle"></i>
            </a>
        <ul class="slide-menu child1">
            @can('Manage Theme General settings')
                <li class="slide">
                    <a class="side-menu__item {{ Request::routeIs(['theme.default.options']) ? 'active ' : '' }}" href="{{ route('theme.default.options') }}">{{ translate('General Settings') }}</a>
                </li>
            @endcan

            @can('Manage Home Page Builder')
                <li class="slide">
                    <a class="side-menu__item {{ Request::routeIs(['theme.default.homePageSections', 'theme.default.homePageSection.new', 'theme.default.homePageSection.edit']) ? 'active ' : '' }}" href="{{ route('theme.default.homePageSections') }}">{{ translate('Home Page Builder') }}</a>
                </li>
            @endcan

            @can('Manage Widget')
                <li class="slide">
                    <a class="side-menu__item {{ Request::routeIs('theme.default.widgets') ? 'active ' : '' }}" href="{{ route('theme.default.widgets') }}">{{ translate('Widgets') }}</a>
                </li>
            @endcan
        </ul>
    </li>
@endcanany
