<!DOCTYPE html>
<html lang="en">
<head>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>DigFilm - {{$title}}</title>
        <link type="text/css" href="{{ asset('/admin/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('/admin/bootstrap/css/bootstrap-responsive.min.css') }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('/admin/css/theme.css') }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('/admin/images/icons/css/font-awesome.css') }}" rel="stylesheet">
        <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600'
            rel='stylesheet'>
    </head>
    <body>
    <!-- NAVBAR GOES HERE -->
    @include('partials.navbar')
        <div class="wrapper">
            <div class="container">
                <div class="row">
                    <div class="span3">
                        <!-- SIDE BAR GOES HERE -->
                        @include('partials.sidebar')
                    </div>
                    <!--/.span3-->
                    <div class="span9">
                    @yield('content')
                    </div>
                    <!--/.span9-->
                </div>
            </div>
            <!--/.container-->
        </div>
        <!--/.wrapper-->
        <div class="footer">
            <div class="container">
                <b class="copyright">&copy; 2015 RedRansom Software </b>All rights reserved.
            </div>
        </div>
        <script src="{{ asset('/admin/scripts/jquery-1.9.1.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('/admin/scripts/jquery-ui-1.10.1.custom.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('/admin/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('/admin/scripts/flot/jquery.flot.js') }}" type="text/javascript"></script>
        <script src="{{ asset('/admin/scripts/flot/jquery.flot.resize.js') }}" type="text/javascript"></script>
        <script src="{{ asset('/admin/scripts/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
        <script src="{{ asset('/admin/scripts/common.js') }}" type="text/javascript"></script>
      
    </body>
</html> 