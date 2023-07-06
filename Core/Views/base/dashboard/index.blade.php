
@extends('core::base.layouts.master')
@section('title')
    {{ translate('Dashboard') }}
@endsection
@section('custom_css')
   
@endsection

@section('main_content')
        @includeIf('theme/default::backend.dashboard')
@endsection

@section('custom_scripts')
   
@endsection
