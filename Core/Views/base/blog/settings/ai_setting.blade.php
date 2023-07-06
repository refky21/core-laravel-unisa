@extends('core::base.layouts.master')

@section('title')
    {{ translate('Open AI Settings') }}
@endsection

@section('custom_css')
@endsection
@push('plugin-breadcrumb')
    <li class="breadcrumb-item active"><a href="#">{{ translate('Setup Open AI Settings') }}</a></li>
@endpush
@section('main_content')
    <!-- Main Content -->
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card custom-card mb-30">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        {{ translate('Setup Open AI Settings') }}
                    </div>
                </div>
                <form class="form-horizontal" action="{{ route('core.blog.update.ai.setting') }}" method="post">
                <div class="card-body">
                    @csrf

                        <div class="row">
                            {{-- OpenAI Model --}}
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">{{ translate('Default OpenAI Model') }} <span class="text-danger">*</span></label>
                                    <select name="default_model" class="form-control" required>
                                        <option value="text-davinci-003" @selected($ai_settings->default_model == 'text-davinci-003')>Davinci GPT-3</option>
                                        <option value="text-babbage-001" @selected($ai_settings->default_model == 'text-babbage-001')>Babbage GPT-3</option>
                                        <option value="text-curie-001" @selected($ai_settings->default_model == 'text-curie-001')>Curie GPT-3</option>
                                        <option value="text-ada-001" @selected($ai_settings->default_model == 'text-ada-001')>Ada GPT-3</option>
                                    </select>

                                    @if ($errors->has('default_model'))
                                        <p class="text-danger">{{ $errors->first('default_model') }}</p>
                                    @endif
                            </div>
                            {{-- OpenAI Model --}}

                            <!---Secret Key---->
                            <div class="col-md-6 mb-3">
                                <label for="api_key" class="form-label">{{ translate('OpenAI Secret Key') }} <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="api_key" id="api_key"
                                    placeholder="{{ translate('Enter Secret Key') }}" required value="{{ $ai_settings->api_key }}">
                                @if ($errors->has('api_key'))
                                    <p class="text-danger">{{ $errors->first('api_key') }}</p>
                                @endif
                            </div>
                       <!---Secret Key---->
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success label-btn">
                            <i class="bi bi-save label-btn-icon me-2"></i>
                            {{ translate('Save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
