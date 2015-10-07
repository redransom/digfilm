<!DOCTYPE html>
<!--[if IE 7]>                  <html class="ie7 no-js" lang="en">     <![endif]-->
<!--[if lte IE 8]>              <html class="ie8 no-js" lang="en">     <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="not-ie no-js" lang="en">  <!--<![endif]-->
<head>
<title>DigFim | </title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="shortcut" href="/images/favicon.ico" />
<link type="text/css" href="{{ asset('/css/style.css') }}" rel="stylesheet">
<link type="text/css" href="{{ asset('http//:code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css') }}" rel="stylesheet">

<!-- initialize jQuery Library -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="{{ asset('http://code.jquery.com/jquery-1.10.2.js') }}"></script>
<script src="{{ asset('http://code.jquery.com/ui/1.11.4/jquery-ui.js') }}"></script>
<script src="{{ asset('/js/jquery.countdown.js') }}"></script>

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
            <a href="index.html"><h1>Dig</h1><span>Film</span></a>
            <div class="slogan">Games and Films - what's not to like?</div>
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

            @include('partials.user-sidebar')

        
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

