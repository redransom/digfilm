<!DOCTYPE html>
<!--[if IE 7]>                  <html class="ie7 no-js" lang="en">     <![endif]-->
<!--[if lte IE 8]>              <html class="ie8 no-js" lang="en">     <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="not-ie no-js" lang="en">  <!--<![endif]-->
<head>
<title>Games Throne | Home Page</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="shortcut" href="/images/favicon.ico" />
<link type="text/css" href="{{ asset('/css/style.css') }}" rel="stylesheet">

<!-- initialize jQuery Library -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

<!--[if lt IE 9]>
    <script src="js/modernizr.custom.js"></script>
    <script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE8.js"></script>
    <script type="text/javascript" src="js/ie.js"></script>
<![endif]-->

</head>
<body class="background-1 h-style-1 text-1 skin-1">
    
    
<!-- ***************** - Wrapper - ******************* -->
<div id="wrapper">
    
    
    <!-- ***************** - Header - ***************** -->     
    <header class="clearfix">
        
        
        @include('partials.user-nav')        
        
        <!-- ***************** - Logo - ******************* --> 
        <div id="logo">
            <a href="index.html"><h1>Games</h1><span>Theme</span></a>
            <div class="slogan">The Latest News of Games</div>
        </div><!--/ #logo-->
        <!-- ***************** - END Logo - ******************* --> 
        
        
    </header>
    <!-- ***************** - END Header - ***************** --> 
    
    
    <!-- *************** - Container - *************** -->
    <div class="container">
        
        
        @include('partials.user-search')
        
        
        @include('partials.user-genre')
        
        
        
        <!-- ************** - END Content Container - ************** -->
        
        
        <!-- ************** - Entry - ************** -->
        <div class="entry sbr clearfix">


            <!-- ************** - Content - ************** -->
            <div id="content">
                
                @yield('content')
                
                
            </div><!--/ #content-->
            <!-- ************** - END Content - ************** -->


            <!-- ************** - Sidebar - ************** -->              
            <aside id="sidebar">
                
                
                <!-- ************** - Categories - ************** -->   
                <div class="categories widget clearfix">
                    
                    <div class="title-caption">
                        <h3>Categories</h3>
                    </div><!--/ .title-caption-->
                    
                    <ul>
                        <li class="active"><div><a href="#">Action</a><span>(293)</span></div></li>
                        <li><div><a href="#">Racing</a><span>(76)</span></div></li>
                        <li><div><a href="#">Adventure</a><span>(108)</span></div></li>
                        <li><div><a href="#">Role-Playing</a><span>(72)</span></div></li>
                        <li><div><a href="#">Fighting</a><span>(52)</span></div></li>
                        <li><div><a href="#">Shooter</a><span>(174)</span></div></li>
                        <li><div><a href="#">Kids & Family</a><span>(25)</span></div></li>
                        <li><div><a href="#">Simulation</a><span>(98)</span></div></li>
                        <li><div><a href="#">LucasArts</a><span>(0)</span></div></li>
                        <li><div><a href="#">Sports</a><span>(180)</span></div></li>
                        <li><div><a href="#">Music</a><span>(67)</span></div></li>
                        <li><div><a href="#">Strategy</a><span>(57)</span></div></li>
                        <li><div><a href="#">Puzzle</a><span>(23)</span></div></li>
                    </ul>
                    
                </div><!--/ .categories-->
                <!-- ************** - END Categories - ************** -->
                
                
                <!-- ************** - Top Games - ************** -->    
                <div class="topgames widget">
                    
                    <div class="title-caption">
                        <h3>Top Games</h3>
                    </div><!--/ .title-captin -->
                    
                    <div class="entry-holder">
                        
                        <div class="tabs-2">
                            <ul class="tabs-nav tabs-2 clearfix">
                                <li><a href="#tab4">All</a></li>
                                <li><a href="#tab5">Xbox369</a></li>
                                <li><a href="#tab6">PC</a></li>
                                <li><a href="#tab7">PS3</a></li>
                            </ul><!--/ .tabs-nav -->

                            <div class="tabs-container">
                                
                                <div class="tab-content" id="tab4">
                                    <ul class="rate">
                                        <li>
                                            <a href="top-games.html"><img src="/images/temp/temp_thumbs_4.jpg" width="94" height="60" alt="" class="alignleft" /></a>
                                            <div class="teaser-content">
                                                <h6><a class="title" href="top-games.html">Lorem ipsum dolor sit amet consec</a></h6>
                                                <div class="star"></div>
                                            </div><!--/ .teaser-conent-->
                                            <div class="clear"></div>
                                        </li>
                                        <li>
                                            <a href="top-games.html"><img src="/images/temp/temp_thumbs_5.jpg" width="94" height="60" alt="" class="alignleft" /></a>
                                            <div class="teaser-content">
                                                <h6><a class="title" href="top-games.html">Qui officia deserunt mollit anim id est laborum</a></h6>
                                                <div class="star"></div>
                                            </div><!--/ .teaser-conent-->
                                            <div class="clear"></div>
                                        </li>
                                        <li>
                                            <a href="top-games.html"><img src="/images/temp/temp_thumbs_6.jpg" width="94" height="60" alt="" class="alignleft" /></a>
                                            <div class="teaser-content">
                                                <h6><a class="title" href="top-games.html">Deserunt mollit anim id est laborum</a></h6>
                                                <div class="star"></div>
                                            </div><!--/ .teaser-conent-->
                                            <div class="clear"></div>
                                        </li>
                                    </ul><!--/ .rate-->
                                </div><!--/ #tab4-->
                                
                                <div class="tab-content" id="tab5">
                                    <ul class="rate">
                                        <li>
                                            <a href="top-games.html"><img src="/images/temp/temp_thumbs_5.jpg" width="94" height="60" alt="" class="alignleft" /></a>
                                            <div class="teaser-content">
                                                <h6><a class="title" href="top-games.html">Qui officia deserunt mollit anim id est laborum</a></h6>
                                                <div class="star"></div>
                                            </div><!--/ .teaser-conent-->
                                            <div class="clear"></div>
                                        </li>
                                        <li>
                                            <a href="top-games.html"><img src="/images/temp/temp_thumbs_4.jpg" width="94" height="60" alt="" class="alignleft" /></a>
                                            <div class="teaser-content">
                                                <h6><a class="title" href="top-games.html">Lorem ipsum dolor sit amet consec</a></h6>
                                                <div class="star"></div>
                                            </div><!--/ .teaser-conent-->
                                            <div class="clear"></div>
                                        </li>
                                        <li>
                                            <a href="top-games.html"><img src="/images/temp/temp_thumbs_6.jpg" width="94" height="60" alt="" class="alignleft" /></a>
                                            <div class="teaser-content">
                                                <h6><a class="title" href="top-games.html">Deserunt mollit anim id est laborum</a></h6>
                                                <div class="star"></div>
                                            </div><!--/ .teaser-conent-->
                                            <div class="clear"></div>
                                        </li>
                                    </ul><!--/ .rate-->
                                </div><!--/ #tab5-->
                                
                                <div class="tab-content" id="tab6">
                                    <ul class="rate">
                                        <li>
                                            <a href="top-games.html"><img src="/images/temp/temp_thumbs_5.jpg" width="94" height="60" alt="" class="alignleft" /></a>
                                            <div class="teaser-content">
                                                <h6><a class="title" href="top-games.html">Qui officia deserunt mollit anim id est laborum</a></h6>
                                                <div class="star"></div>
                                            </div><!--/ .teaser-conent-->
                                            <div class="clear"></div>
                                        </li>
                                        <li>
                                            <a href="top-games.html"><img src="/images/temp/temp_thumbs_6.jpg" width="94" height="60" alt="" class="alignleft" /></a>
                                            <div class="teaser-content">
                                                <h6><a class="title" href="top-games.html">Deserunt mollit anim id est laborum</a></h6>
                                                <div class="star"></div>
                                            </div><!--/ .teaser-conent-->
                                            <div class="clear"></div>
                                        </li>
                                        <li>
                                            <a href="top-games.html"><img src="/images/temp/temp_thumbs_4.jpg" width="94" height="60" alt="" class="alignleft" /></a>
                                            <div class="teaser-content">
                                                <h6><a class="title" href="top-games.html">Lorem ipsum dolor sit amet consec</a></h6>
                                                <div class="star"></div>
                                            </div><!--/ .teaser-conent-->
                                            <div class="clear"></div>
                                        </li>
                                    </ul><!--/ .rate-->
                                </div><!--/ #tab6-->
                                
                                <div class="tab-content" id="tab7">
                                    <ul class="rate">
                                        <li>
                                            <a href="top-games.html"><img src="/images/temp/temp_thumbs_6.jpg" width="94" height="60" alt="" class="alignleft" /></a>
                                            <div class="teaser-content">
                                                <h6><a class="title" href="top-games.html">Deserunt mollit anim id est laborum</a></h6>
                                                <div class="star"></div>
                                            </div><!--/ .teaser-conent-->
                                            <div class="clear"></div>
                                        </li>
                                        <li>
                                            <a href="top-games.html"><img src="/images/temp/temp_thumbs_4.jpg" width="94" height="60" alt="" class="alignleft" /></a>
                                            <div class="teaser-content">
                                                <h6><a class="title" href="top-games.html">Lorem ipsum dolor sit amet consec</a></h6>
                                                <div class="star"></div>
                                            </div><!--/ .teaser-conent-->
                                            <div class="clear"></div>
                                        </li>
                                        <li>
                                            <a href="top-games.html"><img src="/images/temp/temp_thumbs_5.jpg" width="94" height="60" alt="" class="alignleft" /></a>
                                            <div class="teaser-content">
                                                <h6><a class="title" href="top-games.html">Qui officia deserunt mollit anim id est laborum</a></h6>
                                                <div class="star"></div>
                                            </div><!--/ .teaser-conent-->
                                            <div class="clear"></div>
                                        </li>
                                    </ul><!--/ .rate-->
                                </div><!--/ #tab7-->
                                
                                <a href="#" class="see-all">See all &raquo;</a>
                                
                            </div><!--/ .tabs container-->                  
                        </div><!--/ .tabs-2-->
                    </div><!--/ .entry-holder-->
                </div><!--/ .topgames-->
                <!-- ************** - END Holder - ************** -->   
                
                
                <!-- ************** - Latest Videos - ************** -->
                <div class="latest-video widget">
                    
                    <div class="title-caption-dark">
                        <h3>Latest Videos</h3>
                        <a href="#" class="more-all">See all</a>
                    </div><!--/ .title-caption-dark-->
                    
                    <div id="jp_container_1" class="jp-video jp-video-270p">
                        <div class="jp-type-single">
                            <div id="jplayer" class="jp-jplayer"></div>
                            <div class="jp-gui">
                                <div class="jp-video-play">
                                    <a href="javascript:;" class="jp-video-play-icon" tabindex="1">play</a>
                                </div>
                                <div class="jp-interface">
                                    <div class="jp-progress">
                                        <div class="jp-seek-bar">
                                            <div class="jp-play-bar"></div>
                                        </div>
                                    </div>
                                    <div class="jp-current-time"></div>
                                    <div class="jp-duration"></div>
                                    <div class="jp-controls-holder">
                                        <ul class="jp-controls">
                                            <li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
                                            <li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
                                            <li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
                                            <li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
                                            <li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
                                            <li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
                                        </ul>
                                        <div class="jp-volume-bar">
                                            <div class="jp-volume-bar-value"></div>
                                        </div>
                                        <ul class="jp-toggles">
                                            <li><a href="javascript:;" class="jp-full-screen" tabindex="1" title="full screen">full screen</a></li>
                                            <li><a href="javascript:;" class="jp-restore-screen" tabindex="1" title="restore screen">restore screen</a></li>
                                            <li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>
                                            <li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    <ul class="video-list">
                        <li>
                            <a class="zoom" href="top-games.html">
                                <img src="/images/temp/video_img_1.jpg" width="94" height="60" alt="" />
                            </a>
                            <div class="teaser-content">
                                <h6><a class="title" href="top-games.html">Qui officia deserunt mollit anim id est laborum</a></h6>
                                <div class="star"></div>
                            </div><!--/ .teaser-conent-->
                            <div class="clear"></div>
                        </li>
                        <li>
                            <a class="zoom" href="top-games.html"><img src="/images/temp/video_img_2.jpg" width="94" height="60" alt="" /></a>
                            <div class="teaser-content">
                                <h6><a class="title" href="top-games.html">Qui officia deserunt mollit anim id est laborum</a></h6>
                                <div class="star"></div>
                            </div><!--/ .teaser-conent-->
                            <div class="clear"></div>
                        </li>
                        <li>
                            <a class="zoom" href="top-games.html"><img src="/images/temp/video_img_3.jpg" width="94" height="60" alt="" /></a>
                            <div class="teaser-content">
                                <h6><a class="title" href="top-games.html">Qui officia deserunt mollit anim id est laborum</a></h6>
                                <div class="star"></div>
                            </div><!--/ .teaser-conent-->
                            <div class="clear"></div>
                        </li>
                    </ul><!--/ .video-list-->
                    
                </div><!--/ .latest-video-->
                <!-- ************ - END Latest Videos - ************ -->
                
                
            </aside><!--/ #sidebar-->
            <!-- ************** - END Sidebar - ************** -->  

        
        </div><!--/ .entry-->
        <!-- ************** - END Entry - ************** -->
        
        
       @include('partials.user-footer')
    
        
    </div><!--/ .container-->
    <!-- *************** - END Container - *************** -->


</div><!--/ #wrapper--> 
    
<!-- ***************** - END Wrapper - ***************** -->
<script type="text/javascript" src="/js/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="/js/jquery.mousewheel.min.js"></script>
<script type="text/javascript" src="/js/general.js"></script>
</body>
</html>

