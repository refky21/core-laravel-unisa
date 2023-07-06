@extends('core::base.layouts.master')

@section('title')
    {{ translate('Share Options') }}
@endsection

@section('custom_css')
    @include('core::base.includes.data_table.css')
@endsection

@section('main_content')
    <div class="row">
        <div class="col-12">
            <div class="card custom-card mb-30">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        {{ translate('Share Options') }}
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="shareOtionsTable" class="table table-bordered text-nowrap">
                            <thead>
                                <tr>
                                    <th>
                                        #
                                    </th>
                                    <th>{{ translate('Name') }}</th>
                                    <th>{{ translate('Status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($share_options as $key => $option)
                                    <tr>
                                        <td>
                                            {{ $key + 1 }}
                                        </td>
                                        <td>{{ $option->network_name }}</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input change-status" type="checkbox" role="switch" data-option="{{ $option->id }}"
                                                    {{ $option->status == '1' ? 'checked' : '' }}>
                                            </div>
                                        </td>
                                            
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('custom_scripts')
    @include('core::base.includes.data_table.script')
    <script>
        (function($) {
            "use strict";
            /**
             * Product share options table
             */
            $(function() {
                $("#shareOtionsTable").DataTable({
                    responsive: false,
                    scrollX:true,
                    lengthChange: true,
                    autoWidth: false,
                })
            });
            /**
             * 
             * Change status 
             * 
             * */
            $('.change-status').on('click', function(e) {
                e.preventDefault();
                let $this = $(this);
                let id = $this.data('option');
                $.post('{{ route('core.blog.share.options.update.status') }}', {
                    _token: '{{ csrf_token() }}',
                    id: id
                }, function(data) {
                    if (data.demo_mode) {
                        toastr.error(data.message, "Alert!");
                    } else {
                        location.reload();
                    }
                })
            });
        })(jQuery);
    </script>
@endsection
