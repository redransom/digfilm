                @if(isset($extrapadding))
                <header id="header" class="needpadding">
                @else
                <header id="header">
                @endif
                    <div id="menu-bottom">
                        <!-- <nav id="menu" class="main-menu width-fluid"> -->
                        <nav id="menu" class="main-menu">
                            <div class="blur-before"></div>
                            <a href="/" class="header-logo left"><img src="{{asset('images/BFlogo.png')}}" class="logo" /></a>
                            <a href="#dat-menu" class="datmenu-prompt"><i class="fa fa-bars"></i>Show menu</a>
                            <ul class="load-responsive right" rel="Main menu">
                                <li><a href="/"><span><i class="fa fa-home"></i><strong>Home</strong></span></a></li>
                                <li><a href="/rules"><span><i class="fa fa-calendar-o"></i><strong>Rules</strong></span></a></li>
                                <li><a href="/all-leagues"><span><i class="fa fa-th-list"></i><strong>Leagues</strong></span></a>
                                    <ul class="sub-menu">
                                        <li><a href="{{URL('/all-leagues')}}">All Leagues</a></li>
                                        <!--li><a href="{{URL('/create')}}">Create League</a></li-->
                                    </ul>
                                </li>
                                <li><a href="/all-movies"><span><i class="fa fa-film"></i><strong>Movies</strong></span></a>
                                    <ul class="sub-menu">
                                        <li><a href="/newreleases">New Releases</a></li>
                                        <li><a href="/comingsoon">Coming Soon</a></li>
                                    </ul>
                                </li>
                                @if(!isset($authUser)))
                                <!--li><a href="/auth/register"><span><i class="fa fa-user-plus"></i><strong>Sign Up</strong></span></a></li-->
                                @endif
                            </ul>
                        </nav>
                    </div>

                    @if(isset($slider))
                    <div id="slider">
                        <div id="slider-info">
                            <div class="padding-box">
                                <ul>
                                    <?php $sliderNo = 1; ?>
                                    @foreach ($slider as $slide)
                                    @if($sliderNo == 1)
                                    <li>
                                    @else
                                    <li class="dis">
                                    @endif
                                        <h2>{{$slide->title}}</h2>
                                        {!! $slide->summary !!}
                                        @if(!is_null($slide->link_url))
                                        <a href="{{URL($slide->link_url)}}" class="read-more-r">Read this article</a>
                                        @endif
                                    </li>
                                    <?php $sliderNo++; ?>
                                    @endforeach
                                </ul>
                            </div>

                            <?php $slideNo = 1; ?>
                            @foreach ($slider as $slide)
                            <a href="javascript: featSelect({{$slideNo}});" id="featSelect-{{$slideNo}}" class="featured-select<?php echo (($slideNo == 1) ? " this-active" : ""); ?>">
                                <span class="w-bar" id="feat-countdown-bar-{{$slideNo}}">.</span>
                                <span class="w-coin" id="feat-countdown-{{$slideNo++}}">0</span>
                                <img src="{{asset($slide->thumbnail) }}" alt="{{$slide->thumbnail}}" title="{{$slide->title}}" />
                            </a>
                            @endforeach
                        </div>
                    </div>

                    @else
                    <div class="wrapper">
                        <div class="header-breadcrumbs">
                            @if(isset($page_title))
                            <h2 class="right">{{$page_title}}</h2>
                            @endif
                            @if(isset($page_name) && !isset($object))
                                {!! Breadcrumbs::render($page_name) !!}
                            @elseif(isset($page_name) && isset($object))
                                {!! Breadcrumbs::render($page_name, $object) !!}
                            @endif
                        </div>
                    </div>
                    @endif
                </header>