@extends('core::base.layouts.master')
@section('title')
    {{ translate('Users') }}
@endsection
@section('custom_css')
    <!-- ======= BEGIN PAGE LEVEL PLUGINS STYLES ======= -->
   <!-- ======= Data-Tables Styles ======= -->
   @include('core::base.includes.data_table.css')
    <!-- ======= Data-Tables Styles Endd ======= -->
    <!-- ======= END BEGIN PAGE LEVEL PLUGINS STYLES ======= -->
@endsection
@section('main_content')
<div class="row">
    <div class="col-md-12">
        <div class="card custom-card mb-30">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                    {{ translate('Users') }}
                    </div>
                    <div class="d-flex">
                        @if (auth()->user()->can('Create User'))
                            <div class="me-3">
                                <a href="{{ route('core.add.user') }}" class="btn btn-primary label-btn long">
                                <i class="bi bi-plus label-btn-icon me-2"></i>
                                {{ translate('Add New User') }}
                                </a>
                            </div>
                        @endcan
                       
                    </div>
                    
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap" id="user_table">
                        <thead>
                            <tr>
                                <th>#
                                <th>{{ translate('Image') }}</th>
                                <th>{{ translate('UID') }}</th>
                                <th>{{ translate('Name') }} </th>
                                <th>{{ translate('Email') }}</th>
                                <th>{{ translate('Roles') }}</th>
                                @if (auth()->user()->can('Edit User'))
                                    <th>{{ translate('Status') }}</th>
                                @endif
                                @if (auth()->user()->can('Edit User') ||
                                        auth()->user()->can('Delete User'))
                                    <th>{{ translate('Actions') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $key = 1;
                            @endphp
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $key }}</td>
                                    <td>
                                        <div class="avatar avatar-sm me-2 avatar-rounded">
                                            <img src="{{ asset(getFilePath($user->image)) }}"
                                                    alt="{{ $user->alt }}" class="img-80">
                                        </div>
                                        
                                    </td>
                                    <td>{{ $user->uid }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ implode(',', $user->roles) }}</td>
                                    @if (auth()->user()->can('Edit User'))
                                        <td>
                                            @if (!in_array('Super Admin' , $user->roles))
                                            <div class="form-check form-switch">
                                                <input class="form-check-input user_status" type="checkbox" role="switch" id="user_status_{{ $user->id }}" name="status"
                                                        {{ $user->status == 1 ? 'checked' : '' }}
                                                        onchange="updateUserStatus('{{ $user->id }}')">
                                            </div>
                                               
                                            @endif
                                        </td>
                                    @endif
                                    @if (auth()->user()->can('Edit User') ||
                                            auth()->user()->can('Delete User'))
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                        @if (auth()->user()->can('Edit User'))
                                                            <a href="{{ route('core.edit.user', $user->id) }}" class="btn btn-warning btn-wave waves-effect waves-light"><i class="bi bi-pencil-square"></i></a>
                                                        @endif
                                                        @if (auth()->user()->can('Delete User'))
                                                            <a href="#"
                                                                onclick="deleteConfirmation('{{ $user->id }}')" class="btn btn-danger btn-wave waves-effect waves-light"><i class="bi bi-trash"></i></a>
                                                        @endif
                                            </div>
                                            
                                        </td>
                                    @endif
                                </tr>
                                @php
                                    $key++;
                                @endphp
                            @endforeach
                        </tbody>
                        </table>
                    </div>
                </div>

        </div>
    </div>
</div>
        <!-- User List-->

        <!--Delete Modal-->
        <div id="delete-modal" class="delete-modal modal fade show" aria-modal="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title h6">{{ translate('Delete Confirmation') }}</h4>
                </div>
                <form method="POST" action="{{ route('core.user.delete') }}">
                @csrf
                <input type="hidden" id="user_id" name="id">
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
        <!--Delete Modal-->
    </div>
@endsection
@section('custom_scripts')
        <!-- ======= Data-Tables Scripts ======= -->
        @include('core::base.includes.data_table.script')
    <!-- ======= Data-Tables Scripts Ends ======= -->

    <script type="application/javascript">
        (function($) {
            "use strict";
            $("#user_table").DataTable();
        })(jQuery);

        /**
         * Will request to update user status
         */
        function updateUserStatus(user_id) {
            "use strict";
            let status = 2
            if ($('#user_status_' + user_id).is(":checked")) {
                status = 1
            }
            $.post("{{ route('core.update.user.status') }}", {
                    _token: '{{ csrf_token() }}',
                    id: user_id,
                    status: status
                },
                function(data, status) {
                    toastr.success("User status updated successfully", "Success!");
                }).fail(function(xhr, status, error) {
                toastr.error("Unable to update user status", "!");
            });
        }

        /**
         * show delete confirmation modal
         */
        function deleteConfirmation(user_id) {
            "use strict";
            $("#user_id").val(user_id);
            $('#delete-modal').modal('show');
        }
</script>
@endsection
