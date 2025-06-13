<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Elight-Equine')</title>
  <link rel="icon" href="{{ asset('front/home/assets/images/logo/favicon.svg') }}" type="image/x-icon" id="favicon">

 @include('admin.sections.header-link')
</head>
<body class="hold-transition layout-navbar-fixed layout-fixed layout-footer-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <!-- <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div> -->

 @include('admin.sections.navbar')

  <!-- Main Sidebar Container -->
 @include('admin.sections.sidebar')

  <!-- Content Wrapper. Contains page content -->
  @yield('content')
  <!-- /.content-wrapper -->
  @include('admin.sections.footer')

  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

@include('admin.sections.footer-script')
</body>
</html>
