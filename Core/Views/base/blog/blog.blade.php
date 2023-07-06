@extends('core::base.layouts.master')

@section('title')
    {{ translate('Blog') }}
@endsection

@section('custom_css')
    <!-- ======= Data-Tables Styles ======= -->
    @include('core::base.includes.data_table.css')
    <!-- ======= Data-Tables Styles Endd ======= -->
@endsection

@push('plugin-breadcrumb')
    <!-- <li class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Homepage</a></li> -->
    <li class="breadcrumb-item" aria-current="page">@yield('title')</li>
@endpush

@section('main_content')
    <!-- Main Content -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        {{ translate('All Blogs') }}
                    </div>
                    <div class="d-flex">
                        @can('Create Blog')
                            <div class="me-3">
                                <a href="{{ route('core.add.blog') }}" class="btn btn-primary label-btn long">
                                <i class="bi bi-plus label-btn-icon me-2"></i>
                                {{ translate('Add Blog') }}</a>
                            </div>
                        @endcan
                        @php
                            $count = ['tl_blogs.id', '!=', null];
                            
                            if (request()->search) {
                                $if_search = '&search=' . request()->search;
                                $all_blog_request = '?status=search_text&search=' . request()->search;
                                $search = request()->search;
                            } else {
                                $if_search = '';
                                $all_blog_request = '';
                                $search = '';
                            }
                            
                        @endphp
                        <div>
                            <a href="javascript:void(0);" data-bs-toggle="dropdown" class="btn btn-icon btn-sm btn-light" aria-expanded="false"><i class="ti ti-dots"></i></a>
                            <ul class="dropdown-menu" style="">
                                <li><a href="{{ route('core.blog') . $all_blog_request }}" class="dropdown-item">{{ translate('All') }}({{ getBlogCount([$count], $search) }})</a></li>
                                <li><a href="{{ route('core.blog') . '?status=mine' . $if_search }}" class="dropdown-item">{{ translate('Mine') }}({{ getBlogCount([['tl_blogs.user_id', '=', Auth::user()->id]], $search) }})</a></li>
                                <li><a href="{{ route('core.blog') . '?status=publish' . $if_search }}" class="dropdown-item">{{ translate('Published') }}({{ getBlogCount([['tl_blogs.is_publish', '=', config('settings.blog_status.publish')], ['tl_blogs.publish_at', '<', currentDateTime()]], $search) }})</a></li>
                                <li><a href="{{ route('core.blog') . '?status=schedule' . $if_search }}" class="dropdown-item">{{ translate('Scheduled') }}({{ getBlogCount([['tl_blogs.publish_at', '>', currentDateTime()]], $search) }})</a></li>
                                <li><a href="{{ route('core.blog') . '?status=draft' . $if_search }}" class="dropdown-item">{{ translate('Drafts') }}({{ getBlogCount([['tl_blogs.is_publish', '=', config('settings.blog_status.draft')]], $search) }})</a></li>
                                <li><a href="{{ route('core.blog') . '?status=pending' . $if_search }}" class="dropdown-item">{{ translate('Pending') }}({{ getBlogCount([['tl_blogs.is_publish', '=', config('settings.blog_status.pending')]], $search) }})</a></li>
                                <li><a href="{{ route('core.blog') . '?status=featured' . $if_search }}" class="dropdown-item">{{ translate('Featured') }}({{ getBlogCount([['tl_blogs.is_featured', '=', 1]], $search) }})</a></li>
                            </ul>
                        </div>
                    </div>
                    
                </div>
                <div class="card-body">
                    {{-- Blog Filter Buttons --}}
                    <div class="filter_button row mb-4 pl-3">
                        
                        

                        @if (request()->input('search'))
                            <span class="ml-3 h4 my-2">{{ translate('Result For') }} :
                                ({{ request()->input('search') }})</span>
                        @endif
                    </div>
                    {{-- Blog Filter Buttons End --}}
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap" id="blog_table">
                            <thead>
                                <tr>
                                    <!-- Permission Check -->
                                    @can('Delete Blog')
                                        <th>
                                            <input type="checkbox" name="select-all" class="select-all" onchange="selectAll()">
                                        </th>
                                    @endcan
                                    <th scope="col">{{ translate('Image') }}</th>
                                    <th scope="col">{{ translate('Name') }}</th>
                                    <th scope="col">{{ translate('Author') }}</th>
                                    <th scope="col">{{ translate('Category') }}</th>
                                    <!-- Permission Check -->
                                    @can('Edit Blog')
                                        <th scope="col">{{ translate('Featured') }}</th>
                                    @endcan
                                    <!-- Permission Check -->
                                    @can('Manage Comment')
                                        <th scope="col">{{ translate('Comment') }} </th>
                                    @endcan
                                    <th scope="col">{{ translate('Status') }}</th>
                                    <!-- Permission Check if any-->
                                    @canany(['Edit Blog', 'Delete Blog'])
                                        <th scope="col">{{ translate('Actions') }}</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $key = 1;
                                @endphp
                                @foreach ($blogs as $blog)
                                    <tr>
                                        <!-- Permission Check -->
                                        @can('Delete Blog')
                                            <td>
                                                <input type="checkbox" class="blog_id" name="blog_id[]"
                                                    value="{{ $blog->id }}">
                                            </td>
                                        @endcan
                                        <td>
                                            <span class="avatar avatar-sm me-2 avatar-rounded">
                                                <img src="{{ asset(getFilePath($blog->image)) }}" alt="img">
                                            </span>
                                        </td>
                                        <td>
                                            <span class="blog-title">
                                                @php
                                                    $tlblog = Core\Models\TlBlog::where('id', $blog->id)->first();
                                                    $blog_name = $tlblog->translation('name', getLocale());
                                                @endphp
                                                @if ($blog->is_publish == config('settings.blog_status.publish'))
                                                    <a href="{{ url('/') }}/blog/{{ $blog->permalink }}"
                                                        target="_blank">{{ strlen($blog_name) > 35 ? mb_substr($blog_name, 0, 35, 'UTF-8') . '...' : $blog_name }}</a>
                                                @else
                                                    <a href="{{ url('/') }}/blog-preview?name={{ $blog->permalink }}"
                                                        target="_blank">{{ strlen($blog_name) > 35 ? mb_substr($blog_name, 0, 35, 'UTF-8') . '...' : $blog_name }}</a>
                                                @endif
                                                —
                                                <span>{{ $blog->visibility }}</span>
                                            </span>
                                        </td>
                                        <td>{{ $blog->user_name }}</td>
                                        <td>
                                            @if (isset($blog->category))
                                                @foreach (getBlogCategory($blog->id) as $item)
                                                    @php
                                                        $cat = Core\Models\TlBlogCategory::where('id', $item)->first();
                                                    @endphp
                                                    <p>{{ $cat->translation('name', getLocale()) }}</p>
                                                @endforeach
                                            @endif
                                        </td>
                                        <!-- Permission Check -->
                                        @can('Edit Blog')
                                            <td width="10%">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input change_featured" type="checkbox" role="switch" {{ $blog->is_featured == '1' ? 'checked' : '' }} name="is_featured"
                                                        data-blog="{{ $blog->id }}">
                                                </div>
                                            </td>
                                        @endcan
                                        <!-- Permission Check -->
                                        @can('Manage Comment')
                                            <td>
                                                <a href="{{ route('core.blog.comment') . '?status=singel_blog_comment&blog=' . $blog->id }}" class="avatar avatar-rounded">
                                                    <img src="{{ asset('/public/backend/assets/img/svg/message-icon.svg') }}" alt="img">
                                                    <span class="position-absolute top-0 start-100 translate-middle badge bg-secondary rounded-pill shadow-lg">
                                                        {{ getCommentCount([['tl_blog_comments.blog_id', '=', $blog->id], ['tl_blog_comments.status', '=', '1']]) }}
                                                        <span class="visually-hidden">New alerts</span>
                                                    </span>
                                                </a>
                                            </td>
                                        @endcan
                                        <td width="15%">
                                            @if ($blog->is_publish == config('settings.blog_status.publish'))
                                                @if ($blog->publish_at > currentDateTime())
                                                    <span class="badge bg-secondary-gradient">{{ translate('Schedule') }}</span>
                                                    <br>
                                                    <span>{{ date('d-m-Y h:m A', strtotime($blog->publish_at)) }}</span>
                                                @else
                                                    <span class="badge bg-success-gradient">{{ translate('Published') }}</span>
                                                    <br>
                                                    <span>{{ date('d-m-Y h:m A', strtotime($blog->publish_at)) }}</span>
                                                @endif
                                                <br>
                                            @elseif($blog->is_publish == config('settings.blog_status.pending'))
                                                <span class="badge bg-warning-gradient">{{ translate('Pending') }}</span>
                                                <br>
                                                <span>{{ translate('Last Modified') }}</span>
                                                <br>
                                                <span>{{ date('d-m-Y h:m A', strtotime($blog->publish_at)) }}</span>
                                            @else
                                                <span class="badge bg-orange-gradient">{{ translate('Draft') }}</span>
                                                <br>
                                                <span>{{ translate('Last Modified') }}</span>
                                                <br>
                                                <span>{{ date('d-m-Y h:m A', strtotime($blog->publish_at)) }}</span>
                                            @endif
                                        </td>
                                        <!-- Permission Check if any -->
                                        @canany(['Edit Blog', 'Delete Blog'])
                                            <td>
                                            
                                                
                                                        <!-- Permission Check -->
                                                        @can('Edit Blog')
                                                        <a href="{{ route('core.edit.blog', ['id' => $blog->id, 'lang' => getDefaultLang()]) }}" class="btn btn-icon btn-warning btn-wave waves-effect waves-light">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </a>
                                                            
                                                        @endcan
                                                        <!-- Permission Check -->
                                                        @can('Delete Blog')
                                                        <a href="#" onclick="deleteConfirmation('{{ $blog->permalink }}')" class="btn btn-icon btn-danger btn-wave waves-effect waves-light">
                                                            <i class="bi bi-trash"></i>
                                                        </a>
                                                        @endcan
                                            </td>
                                        @endcanany
                                    </tr>
                                    @php
                                        $key++;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if (!(request()->input('page') && request()->input('page') > $blogs->lastPage()))
                        {{-- pagination --}}
                        <div class="row mt-2 justify-content-between">
                            {{-- Blog Page Count Info --}}
                            <div class="col-md-4">
                                <p>{{ translate('Showing') }}
                                    @if (!request()->input('page') || request()->input('page') == 1)
                                        1 to {{ count($blogs) }}
                                    @else
                                        @php
                                            if (request()->input('per_page')) {
                                                $per_page_count = request()->input('per_page');
                                            } else {
                                                $per_page_count = 10;
                                            }
                                            $start_count = ((int) request()->input('page') - 1) * $per_page_count + 1;
                                            if (request()->input('page') == $blogs->lastPage()) {
                                                $end_count = $blogs->total();
                                            } else {
                                                $end_count = (int) request()->input('page') * $per_page_count;
                                            }
                                        @endphp
                                        {{ $start_count . ' to ' . $end_count }}
                                    @endif
                                    {{ translate('items of') }} {{ $blogs->total() }}
                                </p>
                            </div>

                            <div class="col-md-3">
                                <!-- Pagination -->
                                <nav aria-label="Page navigation" class="pagination-style-3">
                                    @php
                                        $url = route('core.blog');
                                        
                                        if (request()->input('status')) {
                                            if (request()->input('per_page')) {
                                                if (request()->input('search')) {
                                                    $route = $url . '?status=' . request()->input('status') . '&search=' . request()->input('search') . '&per_page=' . request()->input('per_page');
                                                } else {
                                                    $route = $url . '?status=' . request()->input('status') . '&per_page=' . request()->input('per_page');
                                                }
                                            } else {
                                                if (request()->input('search')) {
                                                    $route = $url . '?status=' . request()->input('status') . '&search=' . request()->input('search');
                                                } else {
                                                    $route = $url . '?status=' . request()->input('status');
                                                }
                                            }
                                        } else {
                                            if (request()->input('per_page')) {
                                                $route = $url . '?per_page=' . request()->input('per_page');
                                            } else {
                                                $route = $url . '?blog-list';
                                            }
                                        }
                                        $last_page = $blogs->lastPage();
                                        $current_page = request()->input('page') ? request()->input('page') : 1;
                                    @endphp

                                    <ul class="pagination mb-0 flex-wrap">
                                        {{-- Previous Button --}}
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $route . '&page=' . request()->input('page') - 1 }}"
                                                style="{{ !request()->input('page') || request()->input('page') == 1 ? 'pointer-events: none' : '' }}">
                                                <i class="ri-arrow-left-s-line align-middle"></i>
                                            </a>
                                        </li>
                                        {{-- Previous Button End --}}

                                        {{-- Pagination Number Start --}}
                                        @if ($current_page - 3 > 1)
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $route . '&page=' . 1 }}">1</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link">...</a>
                                            </li>
                                        @endif

                                        @if ($current_page - 3 == 1)
                                            <li class="page-item">
                                                <a class="page-link"href="{{ $route . '&page=' . 1 }}">1</a>
                                            </li>
                                        @endif

                                        @if ($current_page - 2 > 0)
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $route . '&page=' . $current_page - 2 }}">
                                                    {{ $current_page - 2 }}</a>
                                            </li>
                                        @endif

                                        @if ($current_page - 1 > 0)
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $route . '&page=' . $current_page - 1 }}">
                                                    {{ $current_page - 1 }}</a>
                                            </li>
                                        @endif

                                        <li class="page-item active">
                                            <a class="page-link" href="#" style="pointer-events: none;">{{ $current_page }}</a>
                                        </li>

                                        @if ($current_page + 1 <= $last_page)
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $route . '&page=' . $current_page + 1 }}">
                                                    {{ $current_page + 1 }}</a>
                                            </li>
                                        @endif

                                        @if ($current_page + 2 == $last_page)
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $route . '&page=' . $current_page + 2 }}">
                                                    {{ $current_page + 2 }}</a>
                                            </li>
                                        @endif

                                        @if ($current_page < $last_page - 2)
                                            <li class="page-item">
                                                <a>...</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $route . '&page=' . $last_page }}">{{ $last_page }}</a>
                                            </li>
                                        @endif

                                        {{-- Pagination Number Start end --}}

                                        {{-- Next Button --}}
                                        <li class="page-item">
                                            @if (request()->input('page'))
                                                <a class="page-link" href="{{ $route . '&page=' . request()->input('page') + 1 }}"
                                                    style="{{ request()->input('page') == $blogs->lastPage() ? 'pointer-events: none' : '' }}"><i class="ri-arrow-right-s-line align-middle"></i></i></a>
                                            @else
                                                <a class="page-link" href="{{ $route . '&page=2' }}"
                                                    style="{{ 1 == $blogs->lastPage() ? 'pointer-events: none' : '' }}">
                                                    <i class="ri-arrow-right-s-line align-middle"></i></a>
                                            @endif
                                        </li>
                                        {{-- Next Button end --}}

                                    </ul>
                                </nav>
                                <!-- End Pagination -->
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- End Main Content -->

    <!-- Blog Bulk Delete Modal-->
    <div id="blogbulkdelete-modal" class="blogbulkdelete-modal modal fade show" aria-modal="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title h6">{{ translate('Delete Confirmation') }}</h4>
                </div>
                <div class="modal-body text-center">
                    <p class="mt-1">{{ translate('Are you sure to delete this') }}?</p>
                    <button type="button" class="btn long mt-2  btn-danger"
                        data-dismiss="modal">{{ translate('cancel') }}</button>
                    <button class="btn long mt-2" onclick="bulkAction()">{{ translate('Delete') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!--Blog Bulk Delete Modal End-->

    <!--Blog Delete Modal-->
    <div id="delete-modal" class="delete-modal modal fade show" aria-modal="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title h6">{{ translate('Delete Confirmation') }}</h4>
                </div>
                <div class="modal-body text-center">
                    <p class="mt-1">{{ translate('Are you sure to delete this') }}?</p>
                    <form method="POST" action="{{ route('core.delete.blog') }}">
                        @csrf
                        <input type="hidden" id="permalink" name="permalink">
                        <button type="button" class="btn long mt-2  btn-danger"
                            data-dismiss="modal">{{ translate('cancel') }}</button>
                        <button type="submit" class="btn long mt-2">{{ translate('Delete') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--Blog Delete Modal End-->
@endsection

@section('custom_scripts')
    <!-- ======= Data-Tables Scripts ======= -->
    @include('core::base.includes.data_table.script')
    <!-- ======= Data-Tables Scripts Ends ======= -->

    <script  type="application/javascript">
        (function($) {
            "use strict";
            $(document).ready(function() {

                /**
                 * Set DataTable to Blog Table and append Bulk Selection
                **/
                let table = $("#blog_table").DataTable({
                    responsive: false,
                    scrollX: true,
                    lengthChange: true,
                    autoWidth: false,
                    lengthMenu: [
                        [10, 25, 50, -1],
                        [10, 25, 50, 'All'],
                    ],
                });

                // Show Entry Count on Per Page
                if('{{ request()->per_page }}'){
                    if('{{ request()->per_page }}' == '{{ $blogs->total() }}'){
                        table.page.len(-1).draw();
                    }else{
                        table.page.len('{{ request()->per_page }}').draw();
                    }
                }else{
                    table.page.len(10).draw();
                }

                // show search text 
                if('{{ request()->search }}'){
                    table.search('{{ request()->search }}');
                }

                // Hiding The Default Pagination
                $('#blog_table_paginate').closest(".row").hide();

                // Show Entry On Change
                $('#blog_table').on( 'length.dt', function ( e, settings, len ) {
                    let count = '';
                    if(len == '-1'){
                        count = '{{ $blogs->total() }}';
                    }else{
                        count = len;
                    }

                    if('{{ request()->status }}'){
                        if('{{ request()->search }}'){
                            window.location.replace('{{ route('core.blog') }}?status='+'{{ request()->status }}'+'&search='+'{{ request()->search }}'+'&per_page='+count);
                        }else{
                            window.location.replace('{{ route('core.blog') }}?status='+'{{ request()->status }}'+'&per_page='+count);
                        }
                    } else{
                        window.location.replace('{{ route('core.blog') }}?per_page='+count);
                    }
                } );

                // Search Form 
                $('.dataTables_filter input').unbind().keyup(function(e) {
                    var value = $(this).val();
                    if(e.which === 13){
                        if('{{ request()->status }}'){
                            window.location.replace('{{ route('core.blog') }}?status='+'{{ request()->status }}'+'&search='+value);
                        } else{
                            window.location.replace('{{ route('core.blog') }}?status=search_text&search='+value);
                        }
                    }
                });
                    // Bulk section added
                    var bulk_actions_dropdown =
                        `<br><div id="bulk-action" class="dataTables_length d-flex">
                            
                            <select class="form-select form-select-sm bulk-action-selection mr-3">
                                <option value="">{{ translate('Bulk Action') }}</option>
                                <option value="delete_all">{{ translate('Delete selection') }}</option>
                            </select>
                            <button class="btn btn-secondary btn-sm" onclick="bulkDeleteConfirmation()">{{ translate('Apply') }}</button>
                        </div>`;

                    let bulk_permission = '{{ auth()->user()->can("Delete Blog") }}';
                    if(bulk_permission){
                        $(bulk_actions_dropdown).insertAfter("#blog_table_wrapper #blog_table_length");
                    }
            });

            /**
             * Change featured  status 
             * */
            $('.change_featured').on('click', function(e)
            {
                e.preventDefault();
                let $this = $(this);
                let id = $this.data('blog');
                $.post('{{ route('core.update.blog.featured.status') }}', {
                    _token: '{{ csrf_token() }}',
                    id: id
                }, function(data) {

                    if(data.success){
                            switch (data.result) {
                            case 'on':
                                $this.prop('checked', true);
                                break;
                            case 'of':
                                $this.prop('checked', false);
                                break;
                        }
                        toastr.success( data.success, "Success!");
                    } else{
                        toastr.error( data.error, "Error!");
                    }

                })
            });
        })(jQuery);

        /**
        * show bulk delete confirmation modal
        */
        function bulkDeleteConfirmation()
        {
            "use strict";
            let action = $('.bulk-action-selection').val();
            if (action === 'delete_all') {
                $('#blogbulkdelete-modal').modal('show');

            } else {
                toastr.error('{{ translate('No Action Selected') }}', "Error!");
            }
        }

        /**
        * Bulk Delete For selected Blog
        **/
        function bulkAction()
        {
            "use strict";
            var selected_items = [];
            $('input[name^="blog_id"]:checked').each(function() {
                selected_items.push($(this).val());
            });

            if (selected_items.length > 0) {

                $.post('{{ route('core.bulk.delete.blog') }}', {
                    _token: '{{ csrf_token() }}',
                     data: selected_items
                }, function(data) {
                    if (data.demo_mode) {
                        toastr.error(data.message, "Alert!");
                    } else {
                        $(".category_id").prop("checked", false);
                        location.reload();
                    }
                });
            } else {
                toastr.error('{{ translate('No Item Selected') }}', "Error!");
            }
        }

        /**
        * Select all Blog
        **/
        function selectAll()
        {
            "use strict";
            if ($('.select-all').is(":checked")) {
                $(".blog_id").prop("checked", true);
            } else {
                $(".blog_id").prop("checked", false);
            }
        }

        /**
        * show blog delete confirmation modal
        */
        function deleteConfirmation(permalink)
        {
            "use strict";
            $("#permalink").val(permalink);
            $('#delete-modal').modal('show');
        }

    </script>
@endsection
