@php
    $roles = getAllRoleForAssign();
    
    $placeholder_info = getPlaceHolderImage();
    $placeholder_image = '';
    $placeholder_image_alt = '';
    
    if ($placeholder_info != null) {
        $placeholder_image = $placeholder_info->placeholder_image;
        $placeholder_image_alt = $placeholder_info->placeholder_image_alt;
    }
@endphp
@extends('core::base.layouts.master')
@section('title')
    {{ translate('Update User') }}
@endsection
@push('plugin-breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('core.users')}}">{{ translate('Users') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
@endpush

@section('custom_css')
<link rel="stylesheet" href="{{ asset('/public/backend/assets/libs/select2/select2.min.css') }}">
    
    <!-- Color Picker Css -->
    <link rel="stylesheet" href="{{ asset('/public/backend/assets/libs/flatpickr/flatpickr.min.css') }}">
    <!-- Choices Css -->
    <link rel="stylesheet" href="{{ asset('/public/backend/assets/libs/choices.js/public/assets/styles/choices.min.css') }}">
    
@endsection
@section('main_content')
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-body add-products p-0">
                <form action="{{ route('core.update.user') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $user->id }}">
                <div class="p-4">
                    <div class="row gx-5">
                        <div class="col-xxl-6 col-xl-12 col-lg-12 col-md-6">
                            <div class="card custom-card shadow-none mb-0 border-0">
                                <div class="card-body p-0">
                                    <div class="row gy-3">
                                        <div class="col-xl-12">
                                            <label for="name" class="form-label">{{ translate('Name') }}</label>
                                            <input type="text" name="name" class="form-control"
                                                value="{{ $user->name }}" id="name" placeholder="{{ translate('Give your name') }}">
                                            @if ($errors->has('name'))
                                                <div class="invalid-input">{{ $errors->first('name') }}</div>
                                            @endif
                                       </div>
                                        <div class="col-xl-6">
                                            <label for="email" class="form-label">{{ translate('Email') }}</label>
                                            <input type="email" name="email" class="form-control" id="email"
                                                value="{{ $user->email }}"
                                                placeholder="{{ translate('Give your email address') }}">
                                            @if ($errors->has('email'))
                                                <div class="invalid-input">{{ $errors->first('email') }}</div>
                                            @endif
                                        </div>
                                        <div class="col-xl-6 color-selection">
                                            <label for="role" class="form-label">{{ translate('Assign Role') }}</label>
                                            <select id='seectRole' name="role[]" id="role" class="form-control" multiple>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}" class="text-uppercase"  {{ userHasRole($user->id, $role->id) ? 'selected' : '' }}>{{ $role->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('role'))
                                                <div class="invalid-input">{{ $errors->first('role') }}</div>
                                            @endif
                                            
                                        </div>
                                        @if (!$user->hasRole('Super Admin'))
                                        <div class="col-xl-6">
                                            <label for="product-cost-add" class="form-label">{{ translate('Status') }}</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input user_status" type="checkbox" {{ $user->status == 1 ? 'checked' : '' }} role="switch" name="status">
                                            </div>
                                        </div>
                                        @endif
                                        <div class="col-xl-6">
                                            <label for="product-description-add" class="form-label">{{ translate('Profile Picture') }}</label>
                                            <input type="hidden" name="pro_pic" id="pro_pic_id" value="{{ $user->pro_pic_id }}">
                                            <div class="image-box">
                                                <div class="d-flex flex-wrap gap-10 mb-3">
                                                    @if (isset($user->pro_pic))
                                                        <div class="preview-image-wrapper">
                                                            <img src="{{ project_asset($user->pro_pic) }}"
                                                                alt="{{ $user->pro_pic_alt }}" width="150" class="preview_image"
                                                                id="pro_pic_preview" />
                                                            <button type="button" title="Remove image"
                                                                class="remove-btn btn btn-icon btn-outline-dark btn-sm rounded-pill btn-wave waves-effect waves-light" id="pro_pic_remove"
                                                                onclick="removeSelection('#pro_pic_preview,#pro_pic_id,#pro_pic_remove')"><i
                                                                    class="icofont-close"></i></button>
                                                        </div>
                                                    @else
                                                        <div class="preview-image-wrapper">
                                                            <img src="{{ project_asset($placeholder_image) }}" width="150"
                                                                class="preview_image" id="pro_pic_preview" />
                                                            <button type="button" title="Remove image"
                                                                class="remove-btn btn btn-icon btn-outline-dark btn-sm rounded-pill btn-wave waves-effect waves-light d-none" id="pro_pic_remove"
                                                                onclick="removeSelection('#pro_pic_preview,#pro_pic_id,#pro_pic_remove')"><i
                                                                    class="icofont-close"></i></button>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="image-box-actions">
                                                    <button type="button" class="btn btn-link btn-wave waves-effect waves-light" data-bs-toggle="modal"
                                                            data-bs-target="#mediaUploadModal"  id="pro_pic_choose"
                                                        onclick="setDataInsertableIds('#pro_pic_preview,#pro_pic_id,#pro_pic_remove')">
                                                        {{ translate('Choose image') }}
                                                    </button>
                                                </div>
                                            </div>
                                            @if ($errors->has('pro_pic'))
                                                <div class="invalid-input">{{ $errors->first('pro_pic') }}</div>
                                            @endif
                                            
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>
                <div class="px-4 py-3 border-top border-block-start-dashed d-sm-flex justify-content-end">
                    <button class="btn btn-success-light m-1" type="submit">{{ translate('Update') }}<i class="bi bi-download ms-2"></i></button>
                </div>
                </form>
                <!-- form -->
            </div>
        </div>
    </div>
</div>

@include('core::base.media.partial.media_modal')

@endsection

@section('partial_scripts')

<!-- Date & Time Picker JS -->
<script src="{{ asset('/public/backend/assets/libs/flatpickr/flatpickr.min.js') }}"></script>


@endsection

@section('custom_scripts')
    <script src="{{ asset('/public/backend/assets/plugins/select2/select2.min.js') }}"></script>
    <script>
        (function($) {
            "use strict";
            initDropzone()
            $(document).ready(function() {
                is_for_browse_file = true
                filtermedia()


                const multipleCancelButton = new Choices(
                    '#seectRole',
                    {
                        allowHTML: true,
                        removeItemButton: true,
                    }
                );
            });
        })(jQuery);
    </script>
@endsection
