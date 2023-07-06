@extends('core::base.layouts.master')


@section('title')
    {{ translate('Edit Tag') }}
@endsection

@section('custom_css')
<link rel="stylesheet" href="{{ asset('/public/backend/assets/libs/dropzone/dropzone.css') }}" />
@endsection
@push('plugin-breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('core.tag')}}">{{ translate('Tags') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
@endpush

@section('main_content')
    <!-- Main Content -->
    <div class="row">
        <div class="col-lg-12 mx-auto">
            <div class="row">
                <div class="col-12 mb-3">
                    <p class="alert alert-info">You are editing <strong>"{{ getLanguageNameByCode($lang) }}"</strong> version</p>
                </div>
                <div class="col-12">
                    <ul class="nav nav-tabs nav-fill border-light border-0">
                        @foreach ($languages as $key => $language)
                            <li class="nav-item">
                                <a class="nav-link @if ($language->code == $lang) active border-0 @else bg-light @endif py-3"
                                    href="{{ route('core.edit.tag', ['id' => $tag->id, 'lang' => $language->code]) }}">
                                    <img src="{{ asset('/public/flags/') . '/' . $language->code . '.png' }}" width="20px">
                                    <span>{{ $language->name }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="card custom-card mb-30">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        {{ translate('Edit Tag') }}
                    </div>
                </div>
                <form class="form-horizontal mt-4" action="{{ route('core.update.tag') }}" method="post">
                    <div class="card-body">
                        <div class="row">
                            
                        @csrf

                        {{-- Tag - Name Field --}}
                        <input type="hidden" name="id" value="{{ $tag->id }}">
                        <input type="hidden" name="lang" value="{{ $lang }}">

                        <div class="col-md-12 mb-3">
                            <label for="name" class="form-label">{{ translate('Name') }} <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name"
                                    class="form-control @if (!empty($lang) && $lang == getdefaultlang()) tag_name @endif"
                                    value="{{ $tag->translation('name', $lang) }}" placeholder="{{ translate('Name') }}" required>
                                <input type="hidden" name="permalink" id="permalink_input_field"
                                    value="{{ $tag->permalink }}">

                                @if ($errors->has('name'))
                                    <p class="text-danger">{{ $errors->first('name') }}</p>
                                @endif
                        </div>
                        {{-- Tag - Name Field --}}

                        {{-- Permalink --}}
                        <div class="col-md-12 mb-20 permalink-input-group @if (!empty($lang) && $lang != getDefaultLang()) area-disabled @endif">
                            <label for="permalink" class="form-label">{{ translate('Permalink') }}</label><br>
                                <a href="#">{{ url('') }}/blog/tag/<span
                                        id="permalink">{{ $tag->permalink }}</span><span
                                        class="btn btn-link btn-wave waves-effect waves-light ml-1 permalink-edit-btn">{{ translate('Edit') }}</span></a>
                                @if ($errors->has('permalink'))
                                    <p class="text-danger">{{ $errors->first('permalink') }}</p>
                                @endif
                                <div class="permalink-editor d-none">
                                    <input type="text" class="form-control" id="permalink-updated-input"
                                        placeholder="{{ translate('Type here') }}">
                                    <button type="button" class="btn btn-danger btn-sm btn-wave waves-effect waves-light mt-2 btn-danger permalink-cancel-btn"
                                        data-dismiss="modal">{{ translate('Cancel') }}</button>
                                    <button type="button"
                                        class="btn btn-primary btn-sm btn-wave waves-effect waves-light mt-2 permalink-save-btn">{{ translate('Save') }}</button>
                                </div>
                        </div>
                        {{-- Permalink End --}}


                        {{-- Seo --}}
                        <div class="col-md-6 mb-3 @if (!empty($lang) && $lang != getDefaultLang()) area-disabled @endif">
                            <label class="form-label">{{ translate('Meta Title') }} </label>
                            <input type="text" name="meta_title" class="form-control"
                            value="{{ $tag->meta_title }}" placeholder="{{ translate('Type here') }}">
                        </div>
                        <div class="col-md-6 mb-3 @if (!empty($lang) && $lang != getDefaultLang()) area-disabled @endif">
                                <label class="form-label">{{ translate('Meta Description') }} </label>
                                <textarea name="meta_description" class="form-control">  {{ $tag->meta_description }}</textarea>
                        </div>
                        <div class="col-md-12 mb-3 @if (!empty($lang) && $lang != getDefaultLang()) area-disabled @endif">
                                <label class="form-label">{{ translate('Meta Image') }} </label>
                                @include('core::base.includes.media.media_input', [
                                    'input' => 'meta_image',
                                    'data' => $tag->meta_image,
                                ])
                        </div>
                        {{-- Seo End --}}
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success label-btn">
                            <i class="bi bi-save label-btn-icon me-2"></i>
                            {{ translate('Update') }}
                        </button>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('core::base.media.partial.media_modal')

    <!-- End Main Content -->
@endsection

@section('custom_scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('/public/backend/assets/libs/dropzone/dropzone-min.js') }}"></script>
    <script>
        (function($) {
            "use strict";
            initDropzone()
            $(document).ready(function() {
                is_for_browse_file = true
                filtermedia()
            });
            /*Generate permalink*/
            $('.tag_name').change(function(e) {
                e.preventDefault();
                let name = DOMPurify.sanitize($('.tag_name').val());
                let permalink = string_to_slug(name);
                $('#permalink').html(permalink);
                $('#permalink_input_field').val(permalink);
                $('.permalink-input-group').removeClass("d-none");
                $('.permalink-editor').addClass("d-none");
                $('.permalink-edit-btn').removeClass("d-none");

            });
            /*edit permalink*/
            $('.permalink-edit-btn').on('click', function(e) {
                e.preventDefault();
                let permalink = $('#permalink').html();
                $('#permalink-updated-input').val(permalink);
                $('.permalink-edit-btn').addClass("d-none");
                $('.permalink-editor').removeClass("d-none");


            });
            /*Cancel permalink edit*/
            $('.permalink-cancel-btn').on('click', function(e) {
                e.preventDefault();
                $('#permalink-updated-input').val();
                $('.permalink-editor').addClass("d-none");
                $('.permalink-edit-btn').removeClass("d-none");

            });
            /*Update permalink*/
            $('.permalink-save-btn').on('click', function(e) {
                e.preventDefault();
                let input = $('#permalink-updated-input').val();
                let updated_permalnk = string_to_slug(input);
                $('#permalink_input_field').val(updated_permalnk);
                $('#permalink').html(updated_permalnk);
                $('.permalink-editor').addClass("d-none");
                $('.permalink-edit-btn').removeClass("d-none");

            });
        })(jQuery);
        /**
         * Generate slug
         * 
         */
        function string_to_slug(str) {
            "use strict";
            str = str.replace(/^\s+|\s+$/g, ''); // trim
            str = str.toLowerCase();

            // remove accents, swap ñ for n, etc
            var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
            var to = "aaaaeeeeiiiioooouuuunc------";
            for (var i = 0, l = from.length; i < l; i++) {
                str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
            }

            str = str
                .replace(/\s+/g, '-') // collapse whitespace and replace by -
                .replace(/-+/g, '-') // collapse dashes
                .replace(/[^\w\s\d\u00C0-\u1FFF\u2C00-\uD7FF\-\_]/g, "-");

            return str;
        }
    </script>
@endsection
