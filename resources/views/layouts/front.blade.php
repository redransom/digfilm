<!DOCTYPE HTML>
<html lang = "en">
    <head>
        <meta charset="utf-8" />
        <title>TheNextBigFilm | Homepage</title>
        <meta content="IE=edge" http-equiv="X-UA-Compatible" />
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <meta property="og:type" content="TheNextBigFilm" />
        <meta property="og:title" content="TheNextBigFilm Movies | Homepage" />
        <meta property="og:image" content="" />
        <meta property="og:description" content="" />
        <meta property="og:url" content="http://www.thenextbigfilm.com" />
        <meta property="og:site_name" content="TheNextBigFilm | Homepage" />
        <link rel="shortcut icon" type="image/png" href="images/favicon.png" />
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/reset.css') }}" media="screen" />
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/font-awesome.min.css') }}" media="screen" />
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/dat-menu.css') }}" media="screen" />
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/main-stylesheet.css') }}" media="screen" />
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/responsive.css') }}" media="screen" />
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans:400,600,700|Oswald:300,400,700|Source+Sans+Pro:300,400,600,700&amp;subset=latin,latin-ext" />
        <!--[if lt IE 9 ]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style>
            #featured-img-1 {
                background-image: url({{ asset('/images/photos/image-1.jpg') }});
            }
            #featured-img-2 {
                background-image: url({{ asset('/images/photos/image-2.jpg') }});
            }
            #featured-img-3 {
                background-image: url({{ asset('/images/photos/image-3.jpg') }});
            }
            #featured-img-4 {
                background-image: url({{ asset('/images/photos/image-4.jpg') }});
            }

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

            /* Button color, default #256193 */
            .panel-duel-voting .panel-duel-vote a {
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
    </head>
    <body class="has-top-menu">

        @include('partials.site-slider-images')
        <!-- BEGIN #top-layer -->
        <div id="top-layer">
            <div id="header-top">
            
            <div class="wrapper">

                    <ul class="right">
                        <li><a href="#" target="_blank"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#" target="_blank"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#" target="_blank"><i class="fa fa-youtube-play"></i></a></li>
                        <li><a href="#" target="_blank"><i class="fa fa-twitch"></i></a></li>
                        <li><a href="#" target="_blank"><i class="fa fa-steam"></i></a></li>
                    </ul>
                    @include('partials.site-top-menu')
                </div>
            </div>

            <section id="content">
                @include('partials.site-header')
    
                <div id="main-box">
                    
                    <div id="main">
        
                        @if (Session::has('flash_notification.message'))
                        <div class="{{Session::get('flash_notification.level')}} custom-box-wrap">
                            <p>{{ Session::get('flash_notification.message') }}</p>
                        </div><!--/ info-->
                        @endif
                        <!-- <div class="content-padding">
                            <a href="podcasts-single.html" class="top-alert-message">
                                <span><span class="pod-live">Custom message</span>An event is happening tonight 20:00! Be Prepared!</span>
                            </a>
                        </div> -->

                        @yield('content')

                        <h2><span>Latest Articles from Developers</span></h2>
                        <div class="content-padding">
                            <div class="home-article left">
                                <span class="article-image-out">
                                    <span class="image-comments"><span>21</span></span>
                                    <span class="article-image">
                                        <span class="nth1 strike-tooltip" title="Read Article">
                                            <a href="post.html"><i class="fa fa-eye"></i></a>
                                        </span>
                                        <span class="nth2 strike-tooltip" title="Save to read later">
                                            <a href="#"><i class="fa fa-plus"></i></a>
                                        </span>
                                        <a href="post.html"><img src="images/photos/image-9.jpg" alt="" title="" /></a>
                                    </span>
                                </span>
                                <h3><a href="post.html">Lorem ipsum dolor sit amet usu sit amet usu at quot case</a></h3>
                                <p>Eos deleniti moderatius ea. Dolorem definiebas usu cu, quot case detracto mei in. Eum tollit eripuit voluptatibus ea, hinc choro omnesque eam cu mel te timeam...</p>
                                <div>
                                    <a href="post.html" class="defbutton"><i class="fa fa-reply"></i>Read full article</a>
                                </div>
                            </div>
                            <div class="home-article right">
                                <ul>
                                    <li>
                                        <a href="post.html">
                                            <span class="image-comments"><span>21</span></span>
                                            <img src="images/photos/image-10.jpg" alt="" title="" />
                                            <strong>Lorem ipsum dolor sit amet usu at</strong>
                                            <span class="a-txt">Eos deleniti moderatius ea. Dolorem</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="post.html">
                                            <span class="image-comments inactive"><span>200</span></span>
                                            <img src="images/photos/image-11.jpg" alt="" title="" />
                                            <strong>Vitae qualisque ex pri, cu eos case tempor delenit.</strong>
                                            <span class="a-txt">Eos deleniti moderatius ea. Dolorem</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="post.html">
                                            <span class="image-comments"><span>10</span></span>
                                            <img src="images/photos/image-12.jpg" alt="" title="" />
                                            <strong>Ut qui ignota discere vivendo, cu eam causae appetere</strong>
                                            <span class="a-txt">Eos deleniti moderatius ea. Dolorem</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="post.html">
                                            <span class="image-comments"><span>9</span></span>
                                            <img src="images/photos/image-13.jpg" alt="" title="" />
                                            <strong>Alii porro vituperatoribus mea te</strong>
                                            <span class="a-txt">Eos deleniti moderatius ea. Dolorem</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="post.html">
                                            <span class="image-comments"><span>3</span></span>
                                            <img src="images/photos/image-14.jpg" alt="" title="" />
                                            <strong>Probatus inimicus eloquentiam ea vel</strong>
                                            <span class="a-txt">Eos deleniti moderatius ea. Dolorem</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="post.html">
                                            <span class="image-comments"><span>0</span></span>
                                            <img src="images/photos/image-15.jpg" alt="" title="" />
                                            <strong>Ne pri illum deterruisset lorem ornatus facilis ut mel</strong>
                                            <span class="a-txt">Eos deleniti moderatius ea. Dolorem</span>
                                        </a>
                                    </li>
                                </ul>

                                <div>
                                    <a href="#" class="defbutton"><i class="fa fa-reply"></i>View more articles</a>
                                </div>
                                
                            </div>
                            <div class="clear-float"></div>
                        </div>
       
                        <h2><span>Latest Articles</span></h2>
                        <div class="content-padding">
                            <div class="grid-articles">

                                <!-- BEGIN .item -->
                                <div class="item">
                                    
                                    <span class="article-image-out">
                                        <span class="image-comments"><span>21</span></span>
                                        <span class="article-image">
                                            <span class="nth1 strike-tooltip" title="Read Article">
                                                <a href="post.html"><i class="fa fa-eye"></i></a>
                                            </span>
                                            <span class="nth2 strike-tooltip" title="Save to read later">
                                                <a href="#"><i class="fa fa-plus"></i></a>
                                            </span>
                                            <a href="post.html"><img src="images/photos/image-25.jpg" alt="" title="" /></a>
                                        </span>
                                    </span>
                                    <h3><a href="post.html">Lorem ipsum dolor sit amet usu sit amet usu at quot case</a></h3>
                                    <p>Eos deleniti moderatius ea. Dolorem definiebas usu cu, quot case detracto mei in. Eum tollit eripuit voluptatibus ea, hinc choro omnesque eam cu mel te timeam...</p>
                                    <div>
                                        <a href="post.html" class="defbutton"><i class="fa fa-reply"></i>Read full article</a>
                                    </div>

                                <!-- END .item -->
                                </div>

                                <!-- BEGIN .item -->
                                <div class="item">
                                    
                                    <span class="article-image-out">
                                        <span class="image-comments"><span>21</span></span>
                                        <span class="article-image">
                                            <span class="nth1 strike-tooltip" title="Read Article">
                                                <a href="post.html"><i class="fa fa-eye"></i></a>
                                            </span>
                                            <span class="nth2 strike-tooltip" title="Save to read later">
                                                <a href="#"><i class="fa fa-plus"></i></a>
                                            </span>
                                            <a href="post.html"><img src="images/photos/image-26.jpg" alt="" title="" /></a>
                                        </span>
                                    </span>
                                    <h3><a href="post.html">Lorem ipsum dolor sit amet usu sit amet usu at quot case</a></h3>
                                    <p>Eos deleniti moderatius ea. Dolorem definiebas usu cu, quot case detracto mei in. Eum tollit eripuit voluptatibus ea, hinc choro omnesque eam cu mel te timeam...</p>
                                    <div>
                                        <a href="post.html" class="defbutton"><i class="fa fa-reply"></i>Read full article</a>
                                    </div>

                                <!-- END .item -->
                                </div>

                                <!-- BEGIN .item -->
                                <div class="item">
                                    
                                    <span class="article-image-out">
                                        <span class="image-comments"><span>21</span></span>
                                        <span class="article-image">
                                            <span class="nth1 strike-tooltip" title="Read Article">
                                                <a href="post.html"><i class="fa fa-eye"></i></a>
                                            </span>
                                            <span class="nth2 strike-tooltip" title="Save to read later">
                                                <a href="#"><i class="fa fa-plus"></i></a>
                                            </span>
                                            <a href="post.html"><img src="images/photos/image-27.jpg" alt="" title="" /></a>
                                        </span>
                                    </span>
                                    <h3><a href="post.html">Lorem ipsum dolor sit amet usu sit amet usu at quot case</a></h3>
                                    <p>Eos deleniti moderatius ea. Dolorem definiebas usu cu, quot case detracto mei in. Eum tollit eripuit voluptatibus ea, hinc choro omnesque eam cu mel te timeam...</p>
                                    <div>
                                        <a href="post.html" class="defbutton"><i class="fa fa-reply"></i>Read full article</a>
                                    </div>

                                <!-- END .item -->
                                </div>

                                <!-- BEGIN .item -->
                                <div class="item">
                                    
                                    <span class="article-image-out">
                                        <span class="image-comments"><span>21</span></span>
                                        <span class="article-image">
                                            <span class="nth1 strike-tooltip" title="Read Article">
                                                <a href="post.html"><i class="fa fa-eye"></i></a>
                                            </span>
                                            <span class="nth2 strike-tooltip" title="Save to read later">
                                                <a href="#"><i class="fa fa-plus"></i></a>
                                            </span>
                                            <a href="post.html"><img src="images/photos/image-28.jpg" alt="" title="" /></a>
                                        </span>
                                    </span>
                                    <h3><a href="post.html">Lorem ipsum dolor sit amet usu sit amet usu at quot case</a></h3>
                                    <p>Eos deleniti moderatius ea. Dolorem definiebas usu cu, quot case detracto mei in. Eum tollit eripuit voluptatibus ea, hinc choro omnesque eam cu mel te timeam...</p>
                                    <div>
                                        <a href="post.html" class="defbutton"><i class="fa fa-reply"></i>Read full article</a>
                                    </div>

                                <!-- END .item -->
                                </div>

                                <!-- BEGIN .item -->
                                <div class="item">
                                    
                                    <span class="article-image-out">
                                        <span class="image-comments"><span>21</span></span>
                                        <span class="article-image">
                                            <span class="nth1 strike-tooltip" title="Read Article">
                                                <a href="post.html"><i class="fa fa-eye"></i></a>
                                            </span>
                                            <span class="nth2 strike-tooltip" title="Save to read later">
                                                <a href="#"><i class="fa fa-plus"></i></a>
                                            </span>
                                            <a href="post.html"><img src="images/photos/image-29.jpg" alt="" title="" /></a>
                                        </span>
                                    </span>
                                    <h3><a href="post.html">Lorem ipsum dolor sit amet usu sit amet usu at quot case</a></h3>
                                    <p>Eos deleniti moderatius ea. Dolorem definiebas usu cu, quot case detracto mei in. Eum tollit eripuit voluptatibus ea, hinc choro omnesque eam cu mel te timeam...</p>
                                    <div>
                                        <a href="post.html" class="defbutton"><i class="fa fa-reply"></i>Read full article</a>
                                    </div>

                                <!-- END .item -->
                                </div>

                                <!-- BEGIN .item -->
                                <div class="item">
                                    
                                    <span class="article-image-out">
                                        <span class="image-comments"><span>21</span></span>
                                        <span class="article-image">
                                            <span class="nth1 strike-tooltip" title="Read Article">
                                                <a href="post.html"><i class="fa fa-eye"></i></a>
                                            </span>
                                            <span class="nth2 strike-tooltip" title="Save to read later">
                                                <a href="#"><i class="fa fa-plus"></i></a>
                                            </span>
                                            <a href="post.html"><img src="images/photos/image-9.jpg" alt="" title="" /></a>
                                        </span>
                                    </span>
                                    <h3><a href="post.html">Lorem ipsum dolor sit amet usu sit amet usu at quot case</a></h3>
                                    <p>Eos deleniti moderatius ea. Dolorem definiebas usu cu, quot case detracto mei in. Eum tollit eripuit voluptatibus ea, hinc choro omnesque eam cu mel te timeam...</p>
                                    <div>
                                        <a href="post.html" class="defbutton"><i class="fa fa-reply"></i>Read full article</a>
                                    </div>

                                <!-- END .item -->
                                </div>

                            </div>
                        </div>
                    </div>

                    @include('partials.site-sidebar')

                    <div class="clear-float"></div>
                    
                </div>
            </section>
        <!-- END #top-layer -->
        </div>

        <div class="clear-float"></div>
        
        @include('partials.site-footer')

        <script type='text/javascript' src='{{ asset('/jscript/jquery-1.11.2.min.js') }}'></script>
        <script type='text/javascript' src='{{ asset('/jscript/modernizr.custom.50878.js') }}'></script>
        <script type='text/javascript' src='{{ asset('/jscript/iscroll.js') }}'></script>
        <script type='text/javascript' src='{{ asset('/jscript/dat-menu.js') }}'></script>
        <script type='text/javascript'>
            var strike_featCount = 4;
            var strike_autostart = true;
            var strike_autoTime = 7000;
        </script>
        <script type='text/javascript' src='jscript/theme-script.js'></script>
    </body>
</html>

