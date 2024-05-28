<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="images/favicon.ico" type="image/ico" />
        <title>@yield('title')</title>
        <!-- Bootstrap -->
        <link href="{{ url('assets/admin/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="{{ url('assets/admin/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
        <!-- NProgress -->
        <link href="{{ url('assets/admin/vendors/nprogress/nprogress.css') }}" rel="stylesheet">
        <!-- bootstrap-progressbar -->
        <link href="{{ url('assets/admin/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet">

        <!-- Custom Theme Style -->
        <link href="{{ url('assets/admin/build/css/custom.min.css') }}" rel="stylesheet">
    </head>
    <body class="nav-md footer_fixed">
        <div class="container body">
            <div class="main_container">
                @include('admin.includes.sidebar')
                <!-- top navigation -->
                @include('admin.includes.navbar')
                <!-- /top navigation -->
                <!-- page content -->
                @include('admin.includes.content')
                <!-- /page content -->
                <!-- footer content -->
                @include('admin.includes.footer')
                <!-- /footer content -->
            </div>
        </div>
        <!-- jQuery -->
        <script src="{{ url('assets/admin/vendors/jquery/dist/jquery.min.js') }}"></script>
        <!-- Bootstrap -->
        <script src="{{ url('assets/admin/vendors/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
        <!-- NProgress -->
        <script src="{{ url('assets/admin/vendors/nprogress/nprogress.js') }}"></script>
        <!-- bootstrap-progressbar -->
        <script src="{{ url('assets/admin/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
        
        <!-- Custom Theme Scripts -->
        <script src="{{ url('assets/admin/build/js/custom.min.js') }}"></script>
        @yield('scripts')
    </body>
</html>