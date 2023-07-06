@extends('core::base.layouts.master')

@section('title')
    {{ translate('Tag') }}
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
                        {{ translate('Tags') }}
                    </div>
                    <div class="d-flex">
                        @can('Create Blog')
                            <div class="me-3">
                                <a href="{{ route('core.add.tag') }}" class="btn btn-primary label-btn long">
                                <i class="bi bi-plus label-btn-icon me-2"></i>
                                    {{ translate('Add Tag') }}
                                </a>
                            </div>
                        @endcan
                        @php
                            $count = ['tl_blog_tags.id', '!=', null];
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
                                <li><a href="{{ route('core.tag') . $all_blog_request }}" class="dropdown-item"> {{ translate('All') }}({{ count(getTag(null, $search)) }})</a></li>
                                <li><a href="{{ route('core.tag') . '?status=publish' . $if_search }}" class="dropdown-item">{{ translate('Publish') }}({{ count(getTag([['is_publish', '1']], $search)) }})</a></li>
                            </ul>
                        </div>
                    </div>
                    
                </div>
                <div class="card-body">
                    {{-- Tag Filter Buttons --}}
                    <div class="filter_button row mb-4 pl-3">
                        @if (request()->input('search'))
                            <span class="ml-3 h4 mt-3">{{ translate('Result For') }} :
                                ({{ request()->input('search') }})</span>
                        @endif
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap " id="tag_table">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="form-check">
                                            <input type="checkbox" name="select-all" class="form-check-input select-all" onchange="selectAll()">
                                        </div>
                                    </th>
                                    <th>{{ translate('Name') }}</th>
                                    <th>{{ translate('Published') }}</th>
                                    <th>{{ translate('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $key = 1;
                                @endphp
                                @foreach ($tags as $tag)
                                    <tr>
                                        <th width="8%">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input tag_id" name="tag_id[]" value="{{ $tag->id }}">
                                            </div>
                                        </th>
                                        <td>
                                            <strong>{{ $tag->translation('name', getLocale()) }}</strong>
                                        </td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input change_publish" type="checkbox" role="switch" {{ $tag->is_publish == '1' ? 'checked' : '' }} name="is_publish" data-tag="{{ $tag->id }}">
                                            </div>
                                        </td>
                                        <td width="18%">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <a href="{{ route('core.edit.tag', ['id' => $tag->id, 'lang' => getDefaultLang()]) }}" class="btn btn-warning btn-wave waves-effect waves-light"><i class="bi bi-pencil-square"></i></a>
                                                <a href="#" onclick="deleteConfirmation('{{ $tag->id }}')" class="btn btn-danger btn-wave waves-effect waves-light"><i class="bi bi-trash"></i></a>
                                            </div>
                                            
                                        </td>
                                    </tr>
                                    @php
                                        $key++;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if (!(request()->input('page') && request()->input('page') > $tags->lastPage()))
                    <div class="row mt-2 justify-content-between">
                            {{-- Blog Page Count Info --}}
                            <div class="col-md-4">
                                <p>{{ translate('Showing') }}
                                    @if (!request()->input('page') || request()->input('page') == 1)
                                        1 to {{ count($tags) }}
                                    @else
                                        @php
                                            if (request()->input('per_page')) {
                                                $per_page_count = request()->input('per_page');
                                            } else {
                                                $per_page_count = 10;
                                            }
                                            
                                            $start_count = ((int) request()->input('page') - 1) * $per_page_count + 1;
                                            if (request()->input('page') == $tags->lastPage()) {
                                                $end_count = $tags->total();
                                            } else {
                                                $end_count = (int) request()->input('page') * $per_page_count;
                                            }
                                        @endphp
                                        {{ $start_count . ' to ' . $end_count }}
                                    @endif
                                    {{ translate('items of') }} {{ $tags->total() }}
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
                                        
                                        $last_page = $tags->lastPage();
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
                                                    style="{{ request()->input('page') == $tags->lastPage() ? 'pointer-events: none' : '' }}"><i class="ri-arrow-right-s-line align-middle"></i></i></a>
                                            @else
                                                <a class="page-link" href="{{ $route . '&page=2' }}"
                                                    style="{{ 1 == $tags->lastPage() ? 'pointer-events: none' : '' }}">
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


    <!-- Tag Bulk Delete Modal-->
    <div id="tagbulkdelete-modal" class="bulkdelete-modal modal fade show" aria-modal="true">
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
    <!--Tag Bulk Delete Modal End-->

    <!-- Tag Each Delete Modal-->
    <div id="delete-modal" class="delete-modal modal fade show" aria-modal="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title h6">{{ translate('Delete Confirmation') }}</h4>
                </div>
                <form method="POST" action="{{ route('core.delete.tag') }}">
                @csrf
                <div class="modal-body text-center">
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
    <!--Tag Each Delete Modal End-->
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
                let table = $("#tag_table").DataTable({
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
                    if('{{ request()->per_page }}' == '{{ $tags->total() }}'){
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
                $('#tag_table_paginate').closest(".row").hide();

                // Show Entry On Chnage
                $('#tag_table').on( 'length.dt', function ( e, settings, len ) {
                    let count = '';
                    if(len == '-1'){
                        count = '{{ $tags->total() }}';
                    }else{
                        count = len;
                    }

                    if('{{ request()->status }}'){
                        if('{{ request()->search }}'){
                            window.location.replace('{{ route('core.tag') }}?status='+'{{ request()->status }}'+'&search='+'{{ request()->search }}'+'&per_page='+count);
                        }else{
                            window.location.replace('{{ route('core.tag') }}?status='+'{{ request()->status }}'+'&per_page='+count);
                        }
                    } else{
                        window.location.replace('{{ route('core.tag') }}?per_page='+count);
                    }
                } );

                // Search Form 
                $('.dataTables_filter input').unbind().keyup(function(e) {
                    var value = $(this).val();
                    if(e.which === 13){
                        if('{{ request()->status }}'){
                            window.location.replace('{{ route('core.tag') }}?status='+'{{ request()->status }}'+'&search='+value);
                        } else{
                            window.location.replace('{{ route('core.tag') }}?status=search_text&search='+value);
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

                    $(bulk_actions_dropdown).insertAfter("#tag_table_wrapper #tag_table_length");
            });

            /**
             * Change Publish  status 
             * */
            $('.change_publish').on('click', function(e)
            {
                e.preventDefault();
                let $this = $(this);
                let id = $this.data('tag');
                $.post('{{ route('core.update.tag.publish.status') }}', {
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
        function bulkDeleteConfirmation() {
            "use strict";
            let action = $('.bulk-action-selection').val();
            if (action === 'delete_all') {

                $('#tagbulkdelete-modal').modal('show');

            } else {
                toastr.error('{{ translate('No Action Selected') }}', "Error!");
            }
         }

        /**
        * Bulk Delete For selected Tag
        **/
        function bulkAction() {
            "use strict";
            var selected_items = [];
            $('input[name^="tag_id"]:checked').each(function() {
                selected_items.push($(this).val());
            });

            if (selected_items.length > 0) {
                $.post('{{ route('core.bulk.delete.tag') }}', {
                    _token: '{{ csrf_token() }}',
                    data: selected_items
                }, function(data) {
                    if (data.demo_mode) {
                        toastr.error(data.message, "Alert!");
                    } else {
                        $(".tag_id").prop("checked", false);
                        location.reload();
                    }
                });

            } else {
                toastr.error('{{ translate('No Item Selected') }}', "Error!");
            }
        }

        /**
         * Select all Tag
         **/
         function selectAll() {
            "use strict";
            if ($('.select-all').is(":checked")) {
                $(".tag_id").prop("checked", true);
            } else {
                $(".tag_id").prop("checked", false);
            }
        }

        /**
        * show Tag delete confirmation modal
        */
        function deleteConfirmation(tag_id) {
            "use strict";
            $("#tag_id").val(tag_id);
            $('#delete-modal').modal('show');
         }
    </script>
@endsection
