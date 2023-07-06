@extends('core::base.layouts.master')
@section('title')
    {{ translate('Themes') }}
@endsection
@section('custom_css')
@endsection
@push('plugin-breadcrumb')
    <!-- <li class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Homepage</a></li> -->
    <li class="breadcrumb-item" aria-current="page">@yield('title')</li>
@endpush

@section('main_content')
<div class="row">
@foreach ($themes as $theme)
    <div class="col-xl-4">
        <div class="card custom-card">
            <img src="{{ asset('/themes' . '/' . $theme->location . '/banner.png') }}" class="card-img-top" alt="{{ $theme->name }}">
            <div class="card-body">
                <h6 class="card-title fw-semibold">{{ $theme->name }}</h6>
                <p class="card-text mb-3 text-muted">
                    {{ translate('By:') }} <a href="{{ $theme->url }}" target="_blank">{{ $theme->author }}</a>
                    <br><small>{{ translate('Version:') }} {{ $theme->version }}</small></p>
                <p class="card-text mb-0"><br>
                    {{ $theme->description }}
                    </p>
            </div>
            <div class="card-footer">
            @if ($theme->is_activated === 1)
                <button  class="btn btn-success label-btn  btn-trigger-change-status" data-theme="{{ $theme->id }}">
                    <i class="bi bi-check label-btn-icon me-2"></i>
                    {{ translate('Activated') }}
                </button>
            @else
                <button  class="btn btn-info label-btn  btn-trigger-change-status activate-theme" data-theme="{{ $theme->id }}">
                    <i class="bi bi-save label-btn-icon me-2"></i>
                    {{ translate('Activated') }}
                </button>
            @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
    <!--Active Modal-->
    <div id="active-modal" class="delete-modal modal fade show" aria-modal="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title h6">{{ translate('activate Confirmation') }}</h4>
                </div>
                <div class="modal-body text-center">
                    <p class="mt-1">{{ translate('Are you sure to active this theme') }}?</p>
                    <form method="POST" action="{{ route('core.themes.activate') }}">
                        @csrf
                        <input type="hidden" id="active-theme-id" name="id">
                        <button type="button" class="btn long mt-2 btn-danger"
                            data-dismiss="modal">{{ translate('cancel') }}</button>
                        <button type="submit" class="btn long mt-2">{{ translate('Activate') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--End Active  Modal-->
@endsection
@section('custom_scripts')
    <script>
        /**
         * Activate theme
         * */
        $('.activate-theme').on('click', function(e) {
            "use strict";
            e.preventDefault();
            let $this = $(this);
            let id = $this.data('theme');
            $("#active-theme-id").val(id);
            $('#active-modal').modal('show');
        });
    </script>
@endsection
