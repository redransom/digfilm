<!DOCTYPE HTML>
<html lang = "en">
    <head>
        <meta charset="utf-8" />
        <title>TheNextBigFilm | {{$title}}</title>
        <meta content="IE=edge" http-equiv="X-UA-Compatible" />
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        @if(isset($meta) && !empty($meta))
        <meta name="description" content="{{$meta['meta_description']}}" />
        <meta name="keywords" content="{{$meta['meta_keywords']}}" />
        <meta property="og:description" content="{{$meta['meta_description']}}" />
        @endif
        <meta property="og:type" content="TheNextBigFilm" />
        <meta property="og:title" content="TheNextBigFilm Movies | {{$title}}" />
        <meta property="og:image" content="" />
        <meta property="og:url" content="http://www.thenextbigfilm.com" />
        <meta property="og:site_name" content="TheNextBigFilm | Homepage" />
        <link rel="shortcut icon" type="image/png" href="{{ asset('images/favicon.png') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/reset.css') }}" media="screen" />
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/font-awesome.min.css') }}" media="screen" />
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/dat-menu.css') }}" media="screen" />
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/main-stylesheet.css') }}" media="screen" />
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/responsive.css') }}" media="screen" />
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/plugins.css')}}" media="screen" />
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/rr-style.css') }}" media="screen" />
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans:400,600,700|Oswald:300,400,700|Source+Sans+Pro:300,400,600,700&amp;subset=latin,latin-ext" />


        <script type='text/javascript' src='{{ asset('/jscript/jquery-1.11.2.min.js') }}'></script>
        <script type='text/javascript' src='{{ asset('/jscript/modernizr.custom.50878.js') }}'></script>
        <script type='text/javascript' src='{{ asset('/jscript/iscroll.js') }}'></script>
        <script type='text/javascript' src='{{ asset('/jscript/dat-menu.js') }}'></script>
        <script type='text/javascript' src='{{ asset('/jscript/plugins.js')}}'></script>
        <script type='text/javascript'>
            @if(isset($frontpage))
            var strike_featCount = 4;
            var strike_autostart = true;
            var strike_autoTime = 7000;
            @else
            var strike_autostart = false;
            @endif
        </script>
        <script type='text/javascript' src='{{ asset('/jscript/theme-script.js') }}'></script>
        <script type='text/javascript' src='{{ asset('/jscript/jquery.raty.min.js') }}'></script>
        <script type='text/javascript' src='{{ asset('/jscript/jquery.countdown.js') }}'></script>

        <!--[if lt IE 9 ]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style>
            @if(isset($slider))
            <?php $slideNo = 1; ?>
            @foreach($slider as $slide)
            #featured-img-{{$slideNo++}} {
                background-image: url({{ asset($slide->main_image) }});
            }
            @endforeach
            @endif
            /* Man content & sidebar top lne, default #256193 */
            #sidebar .panel,
            #main-box #main {
                border-top: 5px solid #256193;
            }

            /* Slider colors, default #256193 */
            a.featured-select,
            #slider-info .padding-box ul li:before,
            .home-article.right ul li a:hover {
                background-color: #256193;
            }

            

            /* Menu background color, default #000 */
            #menu-bottom.blurred #menu > .blur-before:after {
                background-color: #000;
            }

            /* Top menu background, default #0D0D0D */
            #header-top {
                background: #0D0D0D;
            }

            /* Sidebar panel titles color, default #333333 */
            #sidebar .panel > h2 {
                color: #333333;
            }

            /* Main titles color, default #353535 */
            #main h2 span {
                color: #353535;
            }

            /* Selection color, default #256193 */
            ::selection {
                background: #256193;
            }

            /* Links hover color, default #256193 */
            .article-icons a:hover,
            a:hover {
                color: #256193;
            }

            /* Image hover background, default #256193 */
            .article-image-out,
            .article-image {
                background: #256193;
            }

            /* Image hover icons color, default #256193 */
            span.article-image span .fa {
                color: #256193;
            }
        </style>
        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-76537495-1', 'auto');
          ga('send', 'pageview');

        </script>
    </head>
    @if(isset($frontpage))
    <body class="has-top-menu">
    @else
    <body class="no-slider">
    @endif

        @include('partials.site-slider-images')
        <!-- BEGIN #top-layer -->
        <div id="top-layer">
            <div id="header-top">
            
                <div class="wrapper">

                    <!-- @include('partials.site-social') -->
                    @include('partials.site-top-menu')
                    @include('partials.site-search')
                </div>
            </div>

            <section id="content">
                @if(isset($padding))
                @include('partials.site-header', ['extrapadding'=>$padding])
                @else
                @include('partials.site-header')
                @endif

                @if(isset($fullwidth))
                <div id="main-box" class="full-width">
                @else
                <div id="main-box">
                @endif

                    <div id="main">
        
                        @if (Session::has('flash_notification.message'))
                        <div class="info-message">
                            <a href="#" class="close-info"><i class="fa fa-times"></i></a>
                            <p><strong>Information: </strong>
                            {{ Session::get('flash_notification.message') }}</p>
                        </div><!--/ info-->
                        @endif
                        <!-- <div class="content-padding">
                            <a href="podcasts-single.html" class="top-alert-message">
                                <span><span class="pod-live">Custom message</span>An event is happening tonight 20:00! Be Prepared!</span>
                            </a>
                        </div> -->

                        @yield('content')

                    </div>

                    @if(!isset($fullwidth))
                    @include('partials.site-sidebar')
                    @endif
                    <div class="clear-float"></div>
                    
                </div>
            </section>
        <!-- END #top-layer -->
        </div>

        <div class="clear-float"></div>
        
        @include('partials.site-footer')

    </body>
</html>

