                <header id="header">
                    <div id="menu-bottom">
                        <!-- <nav id="menu" class="main-menu width-fluid"> -->
                        <nav id="menu" class="main-menu">
                            <div class="blur-before"></div>
                            <a href="index.html" class="header-logo left"><img src="{{asset('images/BFlogo.png')}}" class="logo" /></a>
                            <a href="#dat-menu" class="datmenu-prompt"><i class="fa fa-bars"></i>Show menu</a>
                            <ul class="load-responsive" rel="Main menu">
                                <li><a href="/all-leagues"><span><i class="fa fa-calendar-o"></i><strong>Leagues</strong></span></a>
                                    <ul class="sub-menu">
                                        <li><a href="{{URL('/all-leagues')}}">All Leagues</a></li>
                                        <li><a href="{{URL('/create')}}">Create League</a></li>
                                    </ul>
                                </li>
                                <!--li><a href="blog.html"><span><i class="fa fa-comment"></i><strong>Blog Page</strong></span></a>
                                    <ul class="sub-menu">
                                        <li><a href="post.html">Single Post</a></li>
                                        <li><a href="post-left.html">Sidebar on Left side</a></li>
                                        <li><a href="full-width.html">Full Width Page</a></li>
                                    </ul>
                                </li-->
                                <li><a href="calendar.html"><span><i class="fa fa-calendar-o"></i><strong>Schedule</strong></span></a>
                                    <ul class="sub-menu">
                                        <li><a href="calendar.html">Calendar</a></li>
                                        <li><a href="events.html">Events List</a></li>
                                        <li><a href="events-single.html">Event Single</a></li>
                                    </ul>
                                </li>
                                <!--li><a href="shortcodes.html"><span><i class="fa fa-puzzle-piece"></i><strong>Features</strong></span></a>
                                    <ul class="sub-menu">
                                        <li><a href="shortcodes.html">Shortcodes</a></li>
                                        <li><a href="login.html">Login page</a></li>
                                        <li><a href="signup.html">Sign up page</a></li>
                                        <li><a href="messages.html">Private messages</a></li>
                                        <li><a href="games-single.html">Games detail page</a></li>
                                        <li><a href="podcasts.html">Podcast list</a></li>
                                        <li><a href="podcasts-single.html">Podcast single</a></li>
                                        <li><a href="404-page.html">404 Page</a></li>
                                    </ul>
                                </li-->
                                <li><a href="photo-gallery.html"><i class="fa fa-camera-retro"></i><strong>Gallery</strong></a></li>
                                <li><a href="forum.html"><span><i class="fa fa-comments-o"></i><strong>Forum layout</strong></span></a>
                                    <ul class="sub-menu">
                                        <li><a href="forum.html">Forums layout</a></li>
                                        <li><a href="forum-threads.html">Forum threads list</a></li>
                                        <li><a href="forum-single.html">Single forum topic</a></li>
                                        <li><a href="forum-create.html">Create new topic</a></li>
                                    </ul>
                                </li>
                                <li><a href="team.html"><span><i class="fa fa-users"></i><strong>Our Team</strong></span></a>
                                    <ul class="sub-menu">
                                        <li><a href="team.html">Team Members</a></li>
                                        <li><a href="user-single.html">Member profile</a></li>
                                        <li><a href="user-single-blog.html">Members personal blog</a></li>
                                        <li><a href="user-single-guestbook.html">Member guest book</a></li>
                                        <li><a href="user-single-friends.html">Member friends list</a></li>
                                        <li><a href="user-single-instagram.html">Member Instagram photos</a></li>
                                    </ul>
                                </li>
                                <!--li><a href="contact-us.html"><i class="fa fa-map-marker"></i><strong>Contact us</strong></a></li-->
                                <!-- <li class="no-icon"><a href="#"><strong>Without icon</strong></a></li> -->
                            </ul>
                        </nav>
                    </div>

                    @if(isset($frontpage))
                    <div id="slider">
                        <div id="slider-info">
                            <div class="padding-box">
                                <ul>
                                    <li>
                                        <h2><a href="post.html">Lorem ipsum dolor sit amet, ne nec suas graece</a></h2>
                                        <p>Liber alterum mentitum ea vel, cu debet harum altera vim. Te velit voluptaria qui. Cu has ipsum vitae torquatos, at modus congue delicata duo adversarium...</p>
                                        <a href="post.html" class="read-more-r">Read this article</a>
                                    </li>
                                    <li class="dis">
                                        <h2><a href="post.html">Lorem ipsum dolor sit amet, ne nec suas graece</a></h2>
                                        <p>Liber alterum mentitum ea vel, cu debet harum altera vim. Te velit voluptaria qui. Cu has ipsum vitae torquatos, at modus congue delicata duo adversarium...</p>
                                        <a href="post.html" class="read-more-r">Read this article</a>
                                    </li>
                                    <li class="dis">
                                        <h2><a href="post.html">Lorem ipsum dolor sit amet, ne nec suas graece</a></h2>
                                        <p>Liber alterum mentitum ea vel, cu debet harum altera vim. Te velit voluptaria qui. Cu has ipsum vitae torquatos, at modus congue delicata duo adversarium...</p>
                                        <a href="post.html" class="read-more-r">Read this article</a>
                                    </li>
                                    <li class="dis">
                                        <h2><a href="post.html">Lorem ipsum dolor sit amet, ne nec suas graece</a></h2>
                                        <p>Liber alterum mentitum ea vel, cu debet harum altera vim. Te velit voluptaria qui. Cu has ipsum vitae torquatos, at modus congue delicata duo adversarium...</p>
                                        <a href="post.html" class="read-more-r">Read this article</a>
                                    </li>
                                </ul>
                            </div>
                            <a href="javascript: featSelect(1);" id="featSelect-1" class="featured-select this-active">
                                <span class="w-bar" id="feat-countdown-bar-1">.</span>
                                <span class="w-coin" id="feat-countdown-1">0</span>
                                <img src="images/photos/image-5.jpg" alt="" title="" />
                            </a>
                            <a href="javascript: featSelect(2);" id="featSelect-2" class="featured-select">
                                <span class="w-bar" id="feat-countdown-bar-2">.</span>
                                <span class="w-coin" id="feat-countdown-2">0</span>
                                <img src="images/photos/image-6.jpg" alt="" title="" />
                            </a>
                            <a href="javascript: featSelect(3);" id="featSelect-3" class="featured-select">
                                <span class="w-bar" id="feat-countdown-bar-3">.</span>
                                <span class="w-coin" id="feat-countdown-3">0</span>
                                <img src="images/photos/image-7.jpg" alt="" title="" />
                            </a>
                            <a href="javascript: featSelect(4);" id="featSelect-4" class="featured-select">
                                <span class="w-bar" id="feat-countdown-bar-4">.</span>
                                <span class="w-coin" id="feat-countdown-4">0</span>
                                <img src="images/photos/image-8.jpg" alt="" title="" />
                            </a>
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