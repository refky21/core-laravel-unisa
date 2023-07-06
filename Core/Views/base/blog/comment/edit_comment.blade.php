@extends('core::base.layouts.master')

@section('title')
    {{ translate('Edit Comment') }}
@endsection

@section('custom_css')
@endsection

@push('plugin-breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('core.blog.comment')}}">{{ translate('Comments') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
@endpush

@section('main_content')
    <form class="form-horizontal my-4 mb-4" action="{{ route('core.blog.comment.update') }}" method="post"
        enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-md-8">
                <div class="card custom-card mb-30">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                        {{ translate('Edit Comment') }}
                        </div>
                    </div>
                   <div class="card-body">
                        <div class="row">
                        <input type="hidden" name="id" value="{{ $comment->id }}">
                        @if ($errors->has('id'))
                            <p class="text-danger my-1">{{ $errors->first('id') }}</p>
                        @endif
                        {{-- Author --}}
                            <h3 class="font-20 black my-3">{{ translate('Author') }}</h3>
                            <div class="col-md-12 mb-3">
                                <label for="name" class="form-label">{{ translate('Name') }}</label>
                                <input type="text" name="user_name" class="form-control" value="{{ $comment->user_name }}">
                                    @if ($errors->has('user_name'))
                                        <p class="text-danger my-1">{{ $errors->first('user_name') }}</p>
                                    @endif
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">{{ translate('Email') }}</label>
                                <input type="text" name="user_email" class="form-control"  value="{{ $comment->user_email }}">
                                    @if ($errors->has('user_email'))
                                        <p class="text-danger my-1">{{ $errors->first('user_email') }}</p>
                                    @endif
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">{{ translate('Url') }}</label>
                                <input type="text" name="user_website"  class="form-control"  value="{{ $comment->user_website }}">
                                    @if ($errors->has('user_website'))
                                        <p class="text-danger my-1">{{ $errors->first('user_website') }}</p>
                                    @endif
                            </div>
                            <div class="col-md-12 mb-3">
                                <textarea name="comment" class="form-control" rows="5">{{ $comment->comment }}</textarea>
                                @if ($errors->has('comment'))
                                    <p class="text-danger my-1">{{ $errors->first('comment') }}</p>
                                @endif
                            </div>
                    </div>
                    </div>
                </div>
            </div>

            {{-- Add Blog Side Field --}}
            <div class="col-md-4">
                {{-- Publish Section --}}
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                        {{ translate('Save') }}
                        </div>
                    </div>
                    <div class="card-body">
                    {{-- Comment Status part --}}
                    <div class="row mb-2">
                        <div class="form-group">
                            <label><i class="bi bi-eye"></i> {{ translate('Status') }} : @switch($comment->status)
                            @case(1)
                                {{ translate('Approve') }}
                            @break
                            @case(2)
                                {{ translate('Pending') }}
                            @break
                            @case(3)
                                {{ translate('Spam') }}
                            @break
                            @default
                        @endswitch
                        
                        </label>
                        </div>
                        
                    </div>
                    <div class="mx-1" id="visibility_form">
                        <input type="radio" class="form-check-input" checked name="status" id="status-radio-approve" value="approve" {{ $comment->status == '1' ? 'checked':'' }}/>
                        <label for="status-radio-approve" class="form-check-label">{{ translate('Approve') }}</label>
                        <br />

                        <input type="radio" class="form-check-input" name="status" id="status-radio-pending" value="pending"  {{ $comment->status == '2' ? 'checked':'' }}/>
                        <label for="status-radio-pending" class="form-check-label">{{ translate('Pending') }}</label>
                        <br />

                        <input type="radio" class="form-check-input" name="status" id="status-radio-spam" value="spam"  {{ $comment->status == '3' ? 'checked':'' }}/> <label
                            for="status-radio-spam" class="form-check-label">{{ translate('Spam') }}</label><br />
                    </div>
                    @if ($errors->has('status'))
                        <p class="text-danger my-1">{{ $errors->first('status') }}</p>
                    @endif
                    {{-- Comment Status part end --}}

                    {{-- Submitted part --}}
                    <div class="form-group">
                        <label for="publish_at" class="font-14 black ml-1 mt-2">{{ translate('Submitted on') }} :</label>
                        <div class="input-group">
                            <div class="input-group-text text-muted"> <i class="bi bi-calendar"></i> </div>
                            <input type="datetime-local" name="comment_date" id="comment_date" class="form-control"
                            value="{{ $comment->comment_date }}">
                        </div>
                        @if ($errors->has('comment_date'))
                            <p class="text-danger my-1">{{ $errors->first('comment_date') }}</p>
                        @endif
                    </div>
                    
                    {{-- Submitted part end --}}

                    {{-- In Response to part --}}
                    <div class="row my-2 mx-1">
                        <span class="fs-14 text-dark mx-1"><i class="bi bi-chat-dots-fill"></i> {{ translate('In Response to') }} :</span>
                        <a href="{{ route('core.edit.blog', ['id' => $comment->blog_id, 'lang' => getDefaultLang()]) }}"
                            target="_blank" class="text-info d-block mb-1">{{ $comment->blog->translation('name', getLocale())}}</a>
                    </div>
                    {{-- In Response to part end --}}

                    {{-- In Reply to part --}}
                    @if (isset($comment->parent))
                        <div class="row my-2 mx-1">
                            @php
                                $parent_comment = Core\Models\TlBlogComment::where('id', $comment->parent)->first()->user_name;
                            @endphp
                            <span class="d-block mb-3 mx-1">{{ translate('In reply to') }} :</span>
                            <a href="javascript:void(0)" class="text-primary" >{{ $parent_comment }}</a>
                        </div>
                    @endif
                    {{-- In Reply to part end --}}
                    
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success label-btn">
                        <i class="bi bi-save label-btn-icon me-2"></i>
                        {{ translate('Update') }}
                    </button>
                </div>
                </div>
                {{-- Publish Section End --}}
            </div>
            {{-- Add Blog Side Field End --}}

        </div>

    </form>
@endsection

@section('custom_scripts')
<script src="{{ asset('/public/backend/assets/libs/flatpickr/flatpickr.min.js') }}"></script>
<script>
(function($) {
            "use strict";
            $(document).ready(function() {

                flatpickr("#comment_date", {
                    enableTime: true,
                    dateFormat: "d/m/Y H:i",
                });
            });

        })(jQuery);
</script>
@endsection
