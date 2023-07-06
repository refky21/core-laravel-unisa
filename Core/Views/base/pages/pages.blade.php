@extends('core::base.layouts.master')

@section('title')
    {{ translate('Page') }}
@endsection

@section('custom_css')
    <!-- ======= Data-Tables Styles ======= -->
    @include('core::base.includes.data_table.css')
    <!-- ======= Data-Tables Styles Endd ======= -->
@endsection

@section('main_content')
    <!-- Main Content -->
    <div class="row">
        <div class="col-md-12">
            <div class="card custom-card mb-30">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        {{ translate('All Pages') }}
                    </div>
                    <div class="d-flex">
                        @can('Create Page')
                            <div class="me-3">
                                <a href="{{ route('core.page.add') }}" class="btn btn-primary label-btn long">
                                <i class="bi bi-plus label-btn-icon me-2"></i>
                                    {{ translate('Add Page') }}
                                </a>
                            </div>
                        @endcan
                        @php
                            $count = ['tl_pages.id', '!=', null];
                            if (request()->search) {
                                $search = request()->search;
                                $if_search = '&search=' . $search;
                                $all_page_request = '?status=search_text&search=' . $search;
                            } else {
                                $if_search = '';
                                $all_page_request = '';
                                $search = '';
                            }
                        @endphp
                        <div>
                            <a href="javascript:void(0);" data-bs-toggle="dropdown" class="btn btn-icon btn-sm btn-light" aria-expanded="false"><i class="ti ti-dots"></i></a>
                            <ul class="dropdown-menu" style="">
                                <li><a href="{{ route('core.page') . $all_page_request }}" class="dropdown-item"> {{ translate('All') }}({{ count(getPage([$count], $search)) }})</a></li>
                                <li><a href="{{ route('core.page') . '?status=mine' . $if_search }}" class="dropdown-item">{{ translate('Mine') }}({{ count(getPage([['tl_pages.user_id', '=', Auth::user()->id]], $search)) }})</a></li>
                                <li><a href="{{ route('core.page') . '?status=publish' . $if_search }}" class="dropdown-item">{{ translate('Published') }}({{ count(getPage([['tl_pages.publish_status', '=', config('settings.page_status.publish')], ['tl_pages.publish_at', '<', currentDateTime()]], $search)) }})</a></li>
                                <li><a href="{{ route('core.page') . '?status=schedule' . $if_search }}" class="dropdown-item">{{ translate('Scheduled') }}({{ count(getPage([['tl_pages.publish_at', '>', currentDateTime()]], $search)) }})</a></li>
                                <li><a href="{{ route('core.page') . '?status=draft' . $if_search }}" class="dropdown-item">{{ translate('Drafts') }}({{ count(getPage([['tl_pages.publish_status', '=', config('settings.page_status.draft')]], $search)) }})</a></li>
                                <li><a href="{{ route('core.page') . '?status=trash' . $if_search }}" class="dropdown-item">{{ translate('Trash') }}({{ count(getPage([['tl_pages.publish_status', '=', config('settings.page_status.trash')]], $search)) }})</a></li>
                            </ul>
                        </div>
                    </div>
                    
                </div>
                <div class="card-body">
                    {{-- Page Filter Buttons --}}
                    <div class="filter_button row mb-4 pl-3">
                       @if (request()->input('search'))
                            <span class="ml-3 h4 mt-2">{{ translate('Result For') }} :
                                ({{ request()->input('search') }})</span>
                        @endif
                    </div>
                    {{-- Page Filter Buttons End --}}
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap " id="page_table">
                            <thead>
                                <tr>
                                    @can('Delete Page')
                                        <th>
                                            <div class="form-check">
                                                <input type="checkbox" name="select-all" class="form-check-input select-all" onchange="selectAll()">
                                            </div>
                                        </th>
                                    @endcan
                                    <th>{{ translate('Title') }}</th>
                                    <th>{{ translate('Parent') }}</th>
                                    <th>{{ translate('Author') }}</th>
                                    <th>{{ translate('Date') }}</th>
                                    @canany(['Edit Page', 'Delete Page'])
                                        <th>{{ translate('Actions') }}</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $key = 1;
                                @endphp
                                @foreach ($pages as $page)
                                    <tr>
                                        @can('Delete Page')
                                            <td>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input page_id" name="page_id[]" value="{{ $page->id }}">
                                                </div>
                                            </td>
                                        @endcan
                                        <td>
                                            @php
                                                $tlpage = Core\Models\TlPage::where('id', $page->id)->first();
                                                $parentUrl = getParentUrl($tlpage);
                                            @endphp
                                            @if ($page->publish_status == config('settings.page_status.publish'))
                                                <a href="{{ url('/') }}/page/{{ $parentUrl . $page->permalink }}"
                                                    target="_blank">{{ $tlpage->translation('title', getLocale()) }}</a>
                                            @else
                                                <a href="{{ url('/') }}/page-preview?page={{ $page->permalink }}"
                                                    target="_blank">{{ $tlpage->translation('title', getLocale()) }}</a>
                                            @endif
                                            —
                                            <span>{{ $page->visibility }}</span>
                                        </td>
                                        <td>
                                            @if ($tlpage->parentPage != null)
                                                {{ $tlpage->parentPage->translation('title', getLocale()) }}
                                            @endif
                                        </td>
                                        <td>{{ $page->user_name }}</td>
                                        <td width="15%">
                                            @if ($page->publish_status == config('settings.page_status.publish'))
                                                @if ($page->publish_at > currentDateTime())
                                                    <span class="badge bg-secondary-gradient">{{ translate('Schedule') }}</span>
                                                    <br>
                                                    <span>{{ date('d-m-Y h:m A', strtotime($page->updated_at)) }}</span>
                                                @else
                                                    <span class="badge bg-success-gradient">{{ translate('Published') }}</span>
                                                    <br>
                                                    <span>{{ date('d-m-Y h:m A', strtotime($page->updated_at)) }}</span>
                                                @endif
                                                <br>
                                            @elseif ($page->publish_status == config('settings.page_status.draft'))
                                                <span class="badge bg-orange-gradient">{{ translate('Draft') }}</span>
                                                <br>
                                                <span>{{ translate('Last Modified') }}</span>
                                                <br>
                                                <span>{{ date('d-m-Y h:m A', strtotime($page->updated_at)) }}</span>
                                            @else
                                                <span class="badge bg-danger-gradient">{{ translate('Trash') }}</span>
                                            @endif
                                        </td>
                                        @canany(['Edit Page', 'Delete Page'])
                                            <td>
                                                <div class="dropdown-button">
                                                    <a href="#" class="d-flex align-items-center" data-toggle="dropdown">
                                                        <div class="menu-icon style--two mr-0">
                                                            <span></span>
                                                            <span></span>
                                                            <span></span>
                                                        </div>
                                                    </a>
                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                        @can('Edit Page')
                                                            @if (request()->status == 'trash')
                                                                <form class="btn-group"
                                                                    action="{{ route('core.page.status.change', ['permalink' => $page->permalink, 'status' => 'restore']) }}"
                                                                    method="post" id="changeStatus">
                                                                    @csrf
                                                                    <a href="javascript:;void(0)" class="btn btn-dark btn-wave waves-effect waves-light"
                                                                        onclick="document.getElementById('changeStatus').submit();" title="Restore"><i class="bi bi-recycle"></i></a>
                                                                </form>
                                                            @else
                                                                <a class="btn btn-warning btn-wave waves-effect waves-light" href="{{ route('core.page.edit', ['permalink' => $page->permalink, 'lang' => getDefaultLang()]) }}"><i class="bi bi-pencil-square"></i></a>
                                                                <form class="btn-group"
                                                                    action="{{ route('core.page.status.change', ['permalink' => $page->permalink, 'status' => 'trash']) }}"
                                                                    method="post" id="changeStatus">
                                                                    @csrf
                                                                    <a class="btn btn-dark btn-wave waves-effect waves-light" href="javascript:;void(0)"
                                                                        onclick="document.getElementById('changeStatus').submit();" title="Trash"><i class="bi bi-trash2-fill"></i></a>
                                                                </form>
                                                            @endif
                                                        @endcan
                                                        @can('Delete Page')
                                                            <a href="#" class="btn btn-danger btn-wave waves-effect waves-light"
                                                                onclick="deleteConfirmation('{{ $page->permalink }}')"><i class="bi bi-trash"></i></a>
                                                        @endcan
                                                    </div>
                                                </div>
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
                    @if (!(request()->input('page') && request()->input('page') > $pages->lastPage()))
                    <div class="row mt-2 justify-content-between">
                            {{-- Blog Page Count Info --}}
                            <div class="col-md-4">
                                <p>{{ translate('Showing') }}
                                    @if (!request()->input('page') || request()->input('page') == 1)
                                        1 to {{ count($pages) }}
                                    @else
                                        @php
                                            if (request()->input('per_page')) {
                                                $per_page_count = request()->input('per_page');
                                            } else {
                                                $per_page_count = 10;
                                            }
                                            
                                            $start_count = ((int) request()->input('page') - 1) * $per_page_count + 1;
                                            if (request()->input('page') == $pages->lastPage()) {
                                                $end_count = $pages->total();
                                            } else {
                                                $end_count = (int) request()->input('page') * $per_page_count;
                                            }
                                        @endphp
                                        {{ $start_count . ' to ' . $end_count }}
                                    @endif
                                    {{ translate('items of') }} {{ $pages->total() }}
                                </p>
                            </div>

                            <div class="col-md-3">
                                <!-- Pagination -->
                                <nav aria-label="Page navigation" class="pagination-style-3">
                                    @php
                                        $url = route('core.blog.category');
                                        
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
                                                $route = $url . '?category-list';
                                            }
                                        }
                                        
                                        $last_page = $pages->lastPage();
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
                                                    style="{{ request()->input('page') == $pages->lastPage() ? 'pointer-events: none' : '' }}"><i class="ri-arrow-right-s-line align-middle"></i></i></a>
                                            @else
                                                <a class="page-link" href="{{ $route . '&page=2' }}"
                                                    style="{{ 1 == $pages->lastPage() ? 'pointer-events: none' : '' }}">
                                                    <i class="ri-arrow-right-s-line align-middle"></i></a>
                                            @endif
                                        </li>
                                        {{-- Next Button End --}}
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

    <!-- page Bulk Delete Modal-->
    <div id="pagebulkdelete-modal" class="pagebulkdelete-modal modal fade show" aria-modal="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title h6">{{ translate('Delete Confirmation') }}</h4>
                </div>
                <div class="modal-body text-center">
                    <p class="mt-1">{{ translate('Are you sure to delete this') }}?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ translate('cancel') }}</button>
                    <button onclick="bulkAction()" class="btn btn-danger">{{ translate('Delete') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!--page Bulk Delete Modal End-->

    <!--Page Delete Modal-->
    <div id="delete-modal" class="delete-modal modal fade show" aria-modal="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title h6">{{ translate('Delete Confirmation') }}</h4>
                </div>
                <form method="POST" action="{{ route('core.page.delete') }}">
                @csrf
                <div class="modal-body text-center">
                    <input type="hidden" id="permalink" name="permalink">
                    <p class="mt-1">{{ translate('Are you sure to delete this') }}?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ translate('cancel') }}</button>
                    <button type="submit" class="btn btn-danger">{{ translate('Delete') }}</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!--Page Delete Modal End-->
@endsection

@section('custom_scripts')
    <!-- ======= Data-Tables Scripts ======= -->
    @include('core::base.includes.data_table.script')
    <!-- ======= Data-Tables Scripts Ends ======= -->

    <script  type="application/javascript">
        $(document).ready(function() {
            "use strict";

            /**
             * Set DataTable to page Table and append Bulk Selection
            **/
            let table = $("#page_table").DataTable({
                responsive: false,
                scrollX:true,
                lengthChange: true,
                autoWidth: false,
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, 'All'],
                ],
            });

            // Show Entry Count on Per Page
            if('{{ request()->per_page }}'){
                if('{{ request()->per_page }}' == '{{ $pages->total() }}'){
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
            $('#page_table_paginate').closest(".row").hide();

            // Show Entry On Change
            $('#page_table').on( 'length.dt', function ( e, settings, len ) {
                let count = '';
                if(len == '-1'){
                    count = '{{ $pages->total() }}';
                }else{
                    count = len;
                }

                if('{{ request()->status }}'){
                    if('{{ request()->search }}'){
                        window.location.replace('{{ route('core.page') }}?status='+'{{ request()->status }}'+'&search='+'{{ request()->search }}'+'&per_page='+count);
                    }else{
                        window.location.replace('{{ route('core.page') }}?status='+'{{ request()->status }}'+'&per_page='+count);
                    }
                } else{
                    window.location.replace('{{ route('core.page') }}?per_page='+count);
                }
            } );

            // Search Form 
            $('.dataTables_filter input').unbind().keyup(function(e) {
                var value = $(this).val();
                if(e.which === 13){
                    if('{{ request()->status }}'){
                        window.location.replace('{{ route('core.page') }}?status='+'{{ request()->status }}'+'&search='+value);
                    } else{
                        window.location.replace('{{ route('core.page') }}?status=search_text&search='+value);
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

            let bulk_permission = '{{ auth()->user()->can("Delete Page") }}';
            if(bulk_permission){
                $(bulk_actions_dropdown).insertAfter("#page_table_wrapper #page_table_length");
            }
        });

        /**
        * show bulk delete confirmation modal
        */
        function bulkDeleteConfirmation()
        {
            "use strict";
            let action = $('.bulk-action-selection').val();
            if (action === 'delete_all') {
                $('#pagebulkdelete-modal').modal('show');

            } else {
                toastr.error('{{ translate('No Action Selected') }}', "Error!");
            }
        }

        /**
        * Bulk Delete For selected page
        **/
        function bulkAction()
        {
            "use strict";
            var selected_items = [];
            $('input[name^="page_id"]:checked').each(function() {
                selected_items.push($(this).val());
            });

            if (selected_items.length > 0) {
                $.post('{{ route('core.bulk.delete.page') }}', {
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
        * Select all page
        **/
        function selectAll()
        {
            "use strict";
            if ($('.select-all').is(":checked")) {
                $(".page_id").prop("checked", true);
            } else {
                $(".page_id").prop("checked", false);
            }
        }

        /**
        * show page delete confirmation modal
        */
        function deleteConfirmation(permalink)
        {
            "use strict";
            $("#permalink").val(permalink);
            $('#delete-modal').modal('show');
        }

    </script>
@endsection
