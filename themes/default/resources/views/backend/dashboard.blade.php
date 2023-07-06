@php
    $total_blog = getBlogCount();
    $publish_blog = getBlogCount([['tl_blogs.is_publish', '=', config('settings.blog_status.publish')], ['tl_blogs.publish_at', '<', currentDateTime()]]);
    $scheduled_blog = getBlogCount([['tl_blogs.publish_at', '>', currentDateTime()]]);
    $draft_blog = getBlogCount([['tl_blogs.is_publish', '=', config('settings.blog_status.draft')]]);
    $pending_blog = getBlogCount([['tl_blogs.is_publish', '=', config('settings.blog_status.pending')]]);
    $featured_blog = getBlogCount([['tl_blogs.is_featured', '=', 1]]);
    $total_pages = count(getPage());
    $total_categories = count(getCategory());
    $total_comment = getCommentCount([['tl_blog_comments.id', '!=', null]]);
    $recent_comments = Core\Models\TlBlogComment::with('blog:id,name,permalink')
        ->with('user:id,name,email,image')
        ->select(['id', 'user_id', 'blog_id', 'comment', 'parent', 'user_name', 'user_email', 'comment_date'])
        ->orderBy('id', 'desc')
        ->take(4)
        ->get();
    
    $popular_categories = Core\Models\TlBlogCategory::leftJoin('tl_blogs_categories', 'tl_blogs_categories.category_id', '=', 'tl_blog_categories.id')
        ->groupBy('tl_blog_categories.id')
        ->select(['tl_blog_categories.id', DB::raw('GROUP_CONCAT(distinct tl_blog_categories.name) as name'), DB::raw('COUNT(distinct tl_blogs_categories.blog_id) as blog_count')])
        ->orderBy('blog_count', 'desc')
        ->take(10)
        ->get();
    
    $latest_blogs = Core\Models\TlBlog::latest()
        ->select(['name', 'id', 'image', 'publish_at'])
        ->take(5)
        ->get();
    
    $latest_pages = Core\Models\TlPage::latest()
        ->select(['title', 'id', 'publish_at'])
        ->take(5)
        ->get();
    
@endphp
@push('head')
    {{-- Push custom script or style into head tag --}}
    <style>
        .summary-card {
            background: url('/public/backend/assets/img/summery-bg1.png');
            background-size: auto
        }

        .overflow-text {
            display: block;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .dash-image {
            min-width: 60px !important;
        }

        .order-couter-item {
            padding: 13px 0px;
        }

        .apexcharts-toolbar {
            top: -30px !important;
        }

        .img-20 {
            width: 20px !important;
            height: 20px !important;
        }

        .comment_img {
            max-width: 50px;
        }
    </style>
@endpush
@push('script')
    {{-- Push custom script or style bottom of body tag --}}
     <!-- Apex Charts JS -->
     <script src="{{ asset('/public/backend/assets/libs/apexcharts/apexcharts.min.js')}}"></script>
@endpush

@push('plugin-breadcrumb')
    <!-- <li class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Homepage</a></li> -->
    <li class="breadcrumb-item" aria-current="page">@yield('title')</li>
@endpush

<div class="row">
    <!--Total Customers-->
    <div class="col-xl-3">
        <div class="card custom-card border-top-card border-top-primary rounded-0">
            <div class="card-body">
                <div class="text-center">
                    <span class="avatar avatar-md bg-primary shadow-sm avatar-rounded mb-2">
                        <i class="ri-briefcase-2-line fs-16"></i>
                    </span>
                    <p class="fs-14 fw-semibold mb-2">{{ translate('Total Blogs') }}</p>
                    <div class="d-flex align-items-center justify-content-center flex-wrap">
                        <h5 class="mb-0 fw-semibold">{{ $total_blog }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End total customers-->
    <!--Total Orders-->
    <div class="col-xl-3">
        <div class="card custom-card border-top-card border-top-secondary rounded-0">
            <div class="card-body">
                <div class="text-center">
                    <span class="avatar avatar-md bg-secondary shadow-sm avatar-rounded mb-2">
                        <i class="ri-bill-line fs-16"></i>
                    </span>
                    <p class="fs-14 fw-semibold mb-2">{{ translate('Total Pages') }}</p>
                    <div class="d-flex align-items-center justify-content-center flex-wrap">
                        <h5 class="mb-0 fw-semibold">{{ $total_pages }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End total Orders-->
    <!--Total Products-->
    <div class="col-xl-3">
        <div class="card custom-card border-top-card border-top-success rounded-0">
            <div class="card-body">
                <div class="text-center">
                    <span class="avatar avatar-md bg-success shadow-sm avatar-rounded mb-2">
                        <i class="ri-wallet-2-line fs-16"></i>
                    </span>
                    <p class="fs-14 fw-semibold mb-2">{{ translate('Total Category') }}</p>
                    <div class="d-flex align-items-center justify-content-center flex-wrap">
                        <h5 class="mb-0 fw-semibold">{{ $total_categories }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Products-->
    <!--Total Comment-->
    <div class="col-xl-3">
        <div class="card custom-card border-top-card border-top-info rounded-0">
            <div class="card-body">
                <div class="text-center">
                    <span class="avatar avatar-md bg-info shadow-sm avatar-rounded mb-2">
                        <i class="ri-line-chart-line fs-16"></i>
                    </span>
                    <p class="fs-14 fw-semibold mb-2">{{ translate('Total Comments') }}</p>
                    <div class="d-flex align-items-center justify-content-center flex-wrap">
                        <h5 class="mb-0 fw-semibold">{{ $total_comment }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End total Comment-->
    <!--Visitor Reports-->
    <div class="col-xl-12">
        <div class="card custom-card overflow-hidden">
            <div class="card-header justify-content-between">
                <div class="card-title">{{ translate('Visitors Reports') }}</div>
                <div class="dropdown">
                    <a aria-label="anchor" href="javascript:void(0);" class="btn btn-icon btn-sm btn-light" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fe fe-more-vertical"></i>
                    </a>
                    <ul class="dropdown-menu" style="">
                        <li class="active chart-switcher" data-type="monthly"><a class="dropdown-item" href="javascript:void(0);">{{ translate('Monthly') }}</a></li>
                        <li class="chart-switcher" data-type="daily"><a class="dropdown-item" href="javascript:void(0);">{{ translate('Daily') }}</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div id="apex_sales_report_chart"></div>
            </div>
        </div>
    </div>
    <!--End Visitor Reports-->
    <!--Order Counter-->
    <div class="col-xl-4">
        <div class="card custom-card">
            <div class="card-header justify-content-between">
                <div class="card-title">
                    {{ translate('Blog Status') }}
                </div>
            </div>
            <div class="card-body">
            <ul class="list-unstyled mb-0 analytics-visitors-countries">
                <li>
                    <div class="d-flex align-items-center">
                        <div class="lh-1">
                            <span class="avatar avatar-sm avatar-rounded text-default">
                                <i class='bx bxs-calendar-check'></i>
                            </span>
                        </div>
                        <div class="ms-3 flex-fill lh-1">
                            <a href="{{ route('core.blog') . '?status=publish' }}">
                                <span class="fs-12">{{ translate('Published') }}</span>
                            </a>
                        </div>
                        <div>
                            <span class="text-default badge bg-light fw-semibold mt-2">{{ $publish_blog }}</span>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="d-flex align-items-center">
                        <div class="lh-1">
                            <span class="avatar avatar-sm avatar-rounded text-default">
                                <i class='bx bxs-calendar'></i>
                            </span>
                        </div>
                        <div class="ms-3 flex-fill lh-1">
                            <a href="{{ route('core.blog') . '?status=schedule' }}">
                                <span class="fs-12">{{ translate('Scheduled') }}</span>
                            </a>
                        </div>
                        <div>
                            <span class="text-default badge bg-light fw-semibold mt-2">{{ $scheduled_blog }}</span>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="d-flex align-items-center">
                        <div class="lh-1">
                            <span class="avatar avatar-sm avatar-rounded text-default">
                                <i class='bx bxs-archive'></i>
                            </span>
                        </div>
                        <div class="ms-3 flex-fill lh-1">
                            <a href="{{ route('core.blog') . '?status=draft' }}">
                                <span class="fs-12">{{ translate('Drafts') }}</span>
                            </a>
                        </div>
                        <div>
                            <span class="text-default badge bg-light fw-semibold mt-2">{{ $draft_blog }}</span>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="d-flex align-items-center">
                        <div class="lh-1">
                            <span class="avatar avatar-sm avatar-rounded text-default">
                                <i class='bx bx-loader-circle'></i>
                            </span>
                        </div>
                        <div class="ms-3 flex-fill lh-1">
                            <a href="{{ route('core.blog') . '?status=pedning' }}">
                                <span class="fs-12">{{ translate('Pending') }}</span>
                            </a>
                        </div>
                        <div>
                            <span class="text-default badge bg-light fw-semibold mt-2">{{ $pending_blog }}</span>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="d-flex align-items-center">
                        <div class="lh-1">
                            <span class="avatar avatar-sm avatar-rounded text-default">
                                <i class='bx bxs-purchase-tag'></i>
                            </span>
                        </div>
                        <div class="ms-3 flex-fill lh-1">
                            <a href="{{ route('core.blog') . '?status=featured' }}">
                                <span class="fs-12">{{ translate('Featured') }}</span>
                            </a>
                        </div>
                        <div>
                            <span class="text-default badge bg-light fw-semibold mt-2">{{ $featured_blog }}</span>
                        </div>
                    </div>
                </li>
            </ul>
            </div>
        </div>
    </div>
    <!--End order counter-->
    <!-- Popular Categories -->
    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4">
        <div class="card custom-card">
            <div class="card-header justify-content-between">
                <div class="card-title">
                {{ translate('Popular Categories') }}
                </div>
            </div>
            <div class="card-body">
                 @if (count($popular_categories) > 0)
                <ul class="list-unstyled mb-0">
                    @foreach ($popular_categories as $category)
                        @if ($category->blog_count > 0)
                        <li class="mb-3">
                            <a href="{{ route('core.edit.blog.category', ['id' => $category->id, 'lang' => getDefaultLang()]) }}">
                                <div class="d-flex algn-items-center">
                                        @php
                                            $name = $category->translation('name', getLocale());
                                        @endphp
                                    <div class="flex-fill ms-2">
                                        <p class="fw-semibold mb-0">{{ $name }}</p>
                                    </div>
                                    <div>
                                        <span class="text-success fw-semibold">{{ $category->blog_count . ' blog' }}</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        @endif
                    @endforeach
                </ul>
                @else
                    <p class="alert alert-danger text-center">{{ translate('Nothing Found') }}</p>
                @endif
            </div>
        </div>
    </div>
    <!--End Popular Categories-->
    
    <!--Recent Pages-->
    <div class="col-xl-4">
        <div class="card custom-card">
            <div class="card-header justify-content-between">
                <div class="card-title">
                {{ translate('Latest Pages') }}
                </div>
            </div>
            <div class="card-body">
            @if (count($latest_pages) > 0)
            <ul class="list-unstyled mb-0 analytics-visitors-countries">
                @foreach ($latest_pages as $page)
                    @php
                        $name = $page->translation('title', getLocale());
                    @endphp
                    <li>
                        <div class="d-flex align-items-center">
                            <div class="ms-3 flex-fill lh-1">
                                <a href="{{ route('core.edit.blog', ['id' => $page->id, 'lang' => getDefaultLang()]) }}">
                                    <span class="fs-12">{{ strlen($name) > 35 ? mb_substr($name, 0, 35, 'UTF-8') . '...' : $name }}</span>
                                </a>
                            </div>
                            <div>
                                <span class="text-default badge bg-light fw-semibold mt-2">{{ date('d-m-Y h:m A', strtotime($page->publish_at)) }}</span>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
            @else
                <p class="alert alert-danger text-center">{{ translate('Nothing Found') }}</p>
            @endif
            </div>
        </div>
    </div>   
    <!--End Recent Pages-->
    <!--Recent comments-->
    <div class="col-xxl-4 col-xl-6">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">{{ translate('Recent Comments') }}</div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table text-nowrap mb-0">
                        <thead>
                            <tr>
                                <th>{{ translate('Author') }}</th>
                                <th>{{ translate('Comment') }}</th>
                                <th>{{ translate('Blog') }}</th>
                                <th>{{ translate('Submitted on') }}</th>
                            </tr>
                        </thead>
                        <tbody class="top-selling">
                        @if (count($recent_comments) > 0)
                            @foreach ($recent_comments as $comment)
                            <tr>
                                <td class="text-center lh-1">
                                    @php
                                        $comment_setting = commentFormSettings();
                                        
                                        $author_image = isset($comment->user) ? $comment->user->image : null;
                                        $author_name = isset($comment->user) ? $comment->user->name : null;
                                        $author_email = isset($comment->user) ? $comment->user->email : null;
                                    @endphp
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-2 avatar-rounded">
                                            <img src="
                                                @if (isset($author_image)) {{ asset(getFilePath($author_image)) }}
                                            @else
                                                @if ($comment_setting['show_avatars'] == 1)
                                                    {{ asset('/public/comment-author-image/' . $comment_setting['avatar_default'] . '.png') }}
                                                @else
                                                    {{ asset(getFilePath($author_image)) }} @endif
                                            @endif
                                            " alt="img">
                                        </div>
                                        <div>
                                            <div class="lh-1">
                                                <span>{{ isset($author_name) ? $author_name : $comment->user_name }}</span>
                                            </div>
                                            <div class="lh-1">
                                                <span
                                                    class="fs-11 text-muted">
                                                    @if (isset($author_email))
                                                        <a href="javascript:void(0)" class="text-primary">
                                                            {{ $author_email }}
                                                        </a>
                                                        <br>
                                                    @else
                                                        @if ($comment->user_email != '')
                                                            <a href="javascript:void(0)" class="text-primary">
                                                                {{ $comment->user_email }}
                                                            </a>
                                                            <br>
                                                        @endif
                                                    @endif
                                                    <a href="{{ route('core.blog.comment') . '?status=user_ip_address&ip_address=' . $comment->user_ip_address }}"
                                                    class="text-primary">{{ $comment->user_ip_address }}</a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if (isset($comment->parent))
                                        @php
                                            $parent_comment = Core\Models\TlBlogComment::where('id', $comment->parent)->first()->user_name;
                                        @endphp
                                        <span class="d-block mb-1">{{ translate('In reply to') }}
                                            <a href="javascript:void(0)"
                                                class="text-primary">{{ $parent_comment }}</a>
                                        </span>
                                    @endif
                                    <span class="d-block mb-1">{{ $comment->comment }}</span>
                                </td>
                                <td>
                                        @php
                                            $blog = $comment->blog->translation('name', getLocale());
                                        @endphp
                                        <a
                                            href="{{ route('core.edit.blog', ['id' => $comment->blog_id, 'lang' => getDefaultLang()]) }}">{{ strlen($blog) > 20 ? mb_substr($blog, 0, 20, 'UTF-8') . '...' : $blog }}</a>
                                    </td>
                                <td>
                                    <span class="fw-semibold">{{ getFormatedDateTime($comment->comment_date, 'Y/m/d \a\t H:i a') }}</span>
                                    <span >10,234</span>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5">
                                    <p class="alert alert-danger text-center">{{ translate('Nothing found') }}</p>
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!--End recents comments-->
    <!--Recent Blogs-->
    <div class="col-xxl-4 col-xl-6">
        <div class="card custom-card">
            <div class="card-header justify-content-between">
                <div class="card-title">
                    {{ translate('Latest Blogs') }}
                </div>
            </div>
            <div class="card-body">
            @if (count($latest_blogs) > 0)
                <ul class="list-unstyled my-1">
                @foreach ($latest_blogs as $blog)
                    <li class="mb-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="me-2 lh-1">
                                    <span class="avatar avatar-md avatar-rounded p-2 bg-light">
                                        <img src="{{ asset(getFilePath($blog->image, true)) }}" alt="{{ $blog->name }}">
                                    </span>
                                </div>
                                <div>
                                    <p class="mb-0 fw-semibold">
                                    @php
                                        $name = $blog->translation('name', getLocale());
                                    @endphp
                                    <a href="{{ route('core.edit.blog', ['id' => $blog->id, 'lang' => getDefaultLang()]) }}">
                                        {{ strlen($name) > 35 ? mb_substr($name, 0, 35, 'UTF-8') . '...' : $name }}
                                    </a>
                                    </p>
                                   
                                </div>
                            </div>
                            <div class="text-end">
                                
                                <p class="mb-0 op-7 text-muted fs-11">
                                    {{ date('d-m-Y h:m A', strtotime($blog->publish_at)) }}
                                </p>
                            </div>
                        </div>
                    </li>
                @endforeach
                </ul>
            @else
                <p class="alert alert-danger text-center">{{ translate('Nothing Found') }}</p>
            @endif
            </div>
        </div>
    </div>
    <!--End Recent Blogs-->
</div>

@push('partial_scripts')
    <!-- Apex Charts JS -->
    <script src="{{ asset('/public/backend/assets/libs/apexcharts/apexcharts.min.js')}}"></script>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            let chart_data_type = "monthly";
            let categories = [];
            //change chart data type
            $(".chart-switcher").on('click', function(e) {
                e.preventDefault();
                $('.chart-switcher').removeClass('active');
                $(this).addClass('active');
                chart_data_type = $(this).data('type');
                getChartData();
            });

            //Get data from api
            function getChartData() {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: "POST",
                    data: {
                        type: chart_data_type
                    },
                    url: "{{ route('theme.default.visitor.reports') }}",
                    success: function(data) {
                        if (data.success) {
                            categories = data.times;
                            sales_chart.updateSeries([{
                                name: 'Visitors',
                                data: data.visitors
                            }])

                            sales_chart.updateOptions({
                                xaxis: {
                                    categories: data.times
                                }
                            })
                        }
                    }
                });
            }
            //chart options
            var sales_chart_options = {
                series: [],
                chart: {
                    height: 340,
                    type: 'line',
                    toolbar: {
                        show: true,
                    },
                    zoom: {
                        enabled: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 3,
                    dashArray: 3
                },
                colors: ['#FFBA5A', '#8381FD'],
                grid: {
                    borderColor: '#f5f5f5',
                },
                markers: {
                    size: 7,
                    colors: ["#67CF94"],
                    hover: {
                        size: 8,
                    }
                },
                xaxis: {
                    categories: [],
                },
                yaxis: {
                    tickAmount: 4,
                },
                responsive: [{
                    breakpoint: 576,
                    options: {
                        markers: {
                            size: 5,
                            colors: ["#67CF94"],
                            hover: {
                                size: 5,
                            }
                        },
                    }
                }],
            };
            //Render chart
            var sales_chart = new ApexCharts(document.querySelector(
                "#apex_sales_report_chart"), sales_chart_options);
            sales_chart.render();

            $(document).ready(function() {
                getChartData();
            });
        })(jQuery);
    </script>
@endpush
