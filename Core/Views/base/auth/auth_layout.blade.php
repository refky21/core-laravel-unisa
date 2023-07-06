@php
$settings_details = getGeneralSettingsDetails(); 
@endphp
<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-vertical-style="overlay" data-theme-mode="light" data-header-styles="light" data-menu-styles="light" data-toggled="close">


<head>
  <!-- Page Title -->
  
  <title>
    @yield('title')
   </title>

  <!-- Meta Data -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicon -->
  <link rel="icon" href="{{asset('/public/backend/assets/images/brand-logos/favicon.ico')}}" type="image/x-icon">

  <!-- Main Theme Js -->
  <script src="{{asset('/public/backend/assets/js/authentication-main.js')}}"></script>

  <!-- Bootstrap Css -->
  <link id="style" href="{{asset('/public/backend/assets/libs/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" >

  <!-- Style Css -->
  <link href="{{asset('/public/backend/assets/css/styles.min.css')}}" rel="stylesheet" >

  <!-- Icons Css -->
  <link href="{{asset('/public/backend/assets/css/icons.min.css')}}" rel="stylesheet" >

  <!-- Web Fonts -->
  <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&display=swap" rel="stylesheet">

  <!-- ======= TOASTER CSS======= -->
  <link rel="stylesheet" href="{{asset('/public/backend/assets/css/toaster.min.css')}}">
  <!-- ======= TOASTER CSS======= -->
</head>

<body>

  @yield('main_content')

  <!-- Footer -->
  <footer class="footer style--two">
      {!! xss_clean($settings_details['copyright_text']) !!}
  </footer>
  <!-- End Footer -->

  <!-- ======= BEGIN GLOBAL MANDATORY SCRIPTS ======= -->
  <script src="{{asset('/public/backend/assets/js/jquery.min.js')}}"></script>
  <!-- ======= BEGIN GLOBAL MANDATORY SCRIPTS ======= -->

  <!-- Bootstrap JS -->
  <script src="{{asset('/public/backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

  <!-- Show Password JS -->
  <script src="{{asset('/public/backend/assets/js/show-password.js')}}"></script>
  
  <!-- ======= TOASTER ======= -->
  <script src="{{asset('/public/backend/assets/js/toaster.min.js')}}"></script>
  {!! Toastr::message() !!}
  <!-- ======= TOASTER ======= -->
</body>

</html>