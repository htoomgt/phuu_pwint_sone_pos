<!DOCTYPE html>
<html lang="en">
@php
    $pageTitle = session('page_title') ?? '';
@endphp
{{-- Header  --}}
@include('layouts.header')
{{-- /Header  --}}

<body class="hold-transition sidebar-mini">

    <!--wrapper -->
    <div class="wrapper">

        <!-- Head Nav bar -->
        @include('layouts.head_nav_bar')
        <!-- /Head Nav bar -->

        <!-- Main Sidebar Container -->
        @include('layouts.left_side_nav_panel')
        <!-- /Main Sidebar Container -->



        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
        <!-- /.content-wrapper -->





        <!-- Main Footer -->
        @include('layouts.footer')
        <!-- /Main Footer -->




    </div>
    <!-- ./wrapper -->
</body>

</html>
