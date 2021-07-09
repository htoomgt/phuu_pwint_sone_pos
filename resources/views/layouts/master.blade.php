<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> PWS POS | @yield('title')</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">


  {{-- App CSS --}}
  <link rel="stylesheet" href="{{asset('css/app.css')}}" />
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Head Nav bar -->
    @include('layouts.head_nav_bar')

    <!-- Main Sidebar Container -->
    @include('layouts.left_side_nav_panel')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('content')

  </div>
  <!-- /.content-wrapper -->



  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      {{-- Anything you want --}}
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; {{ date('Y') }} <a href="#">Phuu Pwint Sone POS</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->




</body>
</html>


<!-- REQUIRED SCRIPTS -->
<script src="{{asset('js/app.js')}}"></script>
<script >
    $("#logout").on('click', function(){
        $("#frmLogout").submit();
    })
</script>
