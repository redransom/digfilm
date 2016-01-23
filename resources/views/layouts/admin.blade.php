<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TheNextBigFilm - {{$title}}</title>
    <link type="text/css" href="{{ asset('/admin/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('/admin/bootstrap/css/bootstrap-responsive.min.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('/admin/css/theme.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('/admin/images/icons/css/font-awesome.css') }}" rel="stylesheet">
    <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600'
        rel='stylesheet'>

    <link type="text/css" href="{{ asset('/admin/css/jquery.datetimepicker.css') }}" rel="stylesheet">

    @if(isset($show_stars))
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('/admin/css/star-rating.min.css') }}" media="all" rel="stylesheet" type="text/css" />
    @endif

    <script src="{{ asset('/admin/scripts/jquery-1.9.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/admin/scripts/jquery-ui-1.10.1.custom.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/admin/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>

    @if(isset($use_graph))
    <script src="{{ asset('/admin/scripts/flot/jquery.flot.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/admin/scripts/flot/jquery.flot.resize.js') }}" type="text/javascript"></script>

    <script src="{{ asset('/admin/scripts/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/admin/scripts/common.js') }}" type="text/javascript"></script>
    @endif
    @if(isset($show_stars))
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="{{ asset('/admin/scripts/star-rating.min.js') }}" type="text/javascript"></script>
    @endif

    <script type="text/javascript" src="{{ asset('/admin/scripts/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/admin/scripts/jquery.datetimepicker.min.js') }}"></script>

    @if(isset($use_graph))
    <script>
        $(document).ready(function() {
            $('.datatable-1').dataTable();
            /*$('.dataTables_paginate').addClass("btn-group datatable-pagination");
            $('.dataTables_paginate > a').wrapInner('<span />');
            $('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
            $('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');*/
        } );
    </script>
    @endif
</head>
<body>
    <!-- NAVBAR GOES HERE -->
    @include('partials.admin-navbar')
        <div class="wrapper">
            <div class="container">
                <div class="row">
                    <div class="span3">
                        <!-- SIDE BAR GOES HERE -->
                        @include('partials.admin-sidebar')
                    </div>
                    <!--/.span3-->
                    <div class="span9">
                        <div class="content">
                            @if (Session::has('flash_notification.message'))
                                <div class="alert alert-{{ Session::get('flash_notification.level') }}">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    {{ Session::get('flash_notification.message') }}
                                </div>
                            @endif
                        
                            <div>
                                @if(isset($page_name) && !isset($object))
                                    {!! Breadcrumbs::render($page_name) !!}
                                @elseif(isset($page_name) && isset($object))
                                    {!! Breadcrumbs::render($page_name, $object) !!}
                                @endif
                            </div>

                            @yield('content')
                        </div>
                    </div>
                    <!--/.span9-->
                </div>
            </div>
            <!--/.container-->
        </div>
        <!--/.wrapper-->
        <div class="footer">
            <div class="container">
                <b class="copyright">&copy; <?php echo date("Y"); ?> RedRansom Software </b>All rights reserved.
            </div>
        </div>

    </body>
</html> 