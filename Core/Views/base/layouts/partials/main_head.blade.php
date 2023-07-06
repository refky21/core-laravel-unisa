<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="dark" data-toggled="close">

<head>
<!-- Page Title -->
<title>@yield('title') | {{ $logo_details['system_name'] }}</title>
    <meta name="_token" content="{{ csrf_token() }}">
    <!-- Meta Data -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">
    
    <!-- Favicon -->
    <link rel="icon" href="{{ isset($logo_details['favicon']) ? project_asset($logo_details['favicon']) : '' }}" type="image/x-icon">
    
    <!-- Choices JS -->
    <script src="{{ asset('/public/backend/assets/libs/choices.js/public/assets/scripts/choices.min.js')}}"></script>

    <!-- Main Theme Js -->
    <script src="{{ asset('/public/backend/assets/js/main.js')}}"></script>
    
    <!-- Bootstrap Css -->
    <link id="style" href="{{ asset('/public/backend/assets/libs/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" >

    <!-- Style Css -->
    <link href="{{ asset('/public/backend/assets/css/styles.min.css')}}" rel="stylesheet" >
    <link href="{{ asset('/public/backend/assets/css/custom.css')}}" rel="stylesheet" >

    <!-- Icons Css -->
    <link href="{{ asset('/public/backend/assets/css/icons.css')}}" rel="stylesheet" >

    <!-- Node Waves Css -->
    <link href="{{ asset('/public/backend/assets/libs/node-waves/waves.min.css')}}" rel="stylesheet" > 

    <!-- Simplebar Css -->
    <link href="{{ asset('/public/backend/assets/libs/simplebar/simplebar.min.css')}}" rel="stylesheet" >
    
    <!-- Color Picker Css -->
    <link rel="stylesheet" href="{{ asset('/public/backend/assets/libs/flatpickr/flatpickr.min.css')}}">
    <link rel="stylesheet" href="{{ asset('/public/backend/assets/libs/@simonwep/pickr/themes/nano.min.css')}}">

    <!-- Choices Css -->
    <link rel="stylesheet" href="{{ asset('/public/backend/assets/libs/choices.js/public/assets/styles/choices.min.css')}}">
