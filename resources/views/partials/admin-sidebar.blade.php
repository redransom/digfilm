
                        <div class="sidebar">
                            <ul class="widget widget-menu unstyled">
                                <li class="active"><a href="{{URL('admin-dashboard')}}"><i class="menu-icon icon-dashboard"></i>Dashboard
                                </a></li>
                                <!--li><a href="activity.html"><i class="menu-icon icon-bullhorn"></i>News Feed </a>
                                </li>
                                <li><a href="message.html"><i class="menu-icon icon-inbox"></i>Inbox <b class="label green pull-right">
                                    11</b> </a></li>
                                <li><a href="task.html"><i class="menu-icon icon-tasks"></i>Tasks <b class="label orange pull-right">
                                    19</b> </a></li-->
                            </ul>
                            <!--/.widget-nav-->
                            
                            
                            <ul class="widget widget-menu unstyled">
                                <li><a class="collapsed" data-toggle="collapse" href="#toggleUsers"><i class="menu-icon icon-user">
                                </i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right"></i>Users </a>
                                    <ul id="toggleUsers" class="collapse unstyled">
                                        <li><a href="{{URL('users')}}"><i class="icon-user"></i>List</a></li>
                                        <li><a href="{{Route('user-create')}}"><i class="icon-user"></i>Add New</a></li>
                                    </ul>
                                </li>

                                <li><a class="collapsed" data-toggle="collapse" href="#toggleMovies"><i class="menu-icon icon-film">
                                </i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right"></i>Movies </a>
                                    <ul id="toggleMovies" class="collapse unstyled">
                                        <li><a href="{{URL('movies')}}"><i class="icon-film"></i>List</a></li>
                                        <li><a href="{{URL('movies/create')}}"><i class="icon-film"></i>Add New</a></li>
                                    </ul>
                                </li>

                                <li><a class="collapsed" data-toggle="collapse" href="#toggleContributors"><i class="menu-icon icon-star">
                                </i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right"></i>Contributors </a>
                                    <ul id="toggleContributors" class="collapse unstyled">
                                        <li><a href="{{URL('contributors')}}"><i class="icon-star"></i>List</a></li>
                                        <li><a href="{{URL('contributors/create')}}"><i class="icon-star"></i>Add New</a></li>
                                    </ul>
                                </li>

                                <li><a class="collapsed" data-toggle="collapse" href="#toggleLeagues"><i class="menu-icon icon-th">
                                </i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right"></i>Leagues </a>
                                    <ul id="toggleLeagues" class="collapse unstyled">
                                        <li><a href="{{URL('leagues')}}"><i class="icon-th"></i> All List</a></li>
                                        <li><a href="{{URL('leagues/0')}}"><i class="icon-th"></i> Not Ready</a></li>
                                        <li><a href="{{URL('leagues/1')}}"><i class="icon-th"></i> Start Set</a></li>
                                        <li><a href="{{URL('leagues/2')}}"><i class="icon-th"></i> Movies Chosen</a></li>
                                        <li><a href="{{URL('leagues/3')}}"><i class="icon-th"></i> Auctions Live</a></li>
                                        <li><a href="{{URL('leagues/4')}}"><i class="icon-th"></i> Roster</a></li>
                                        <li><a href="{{URL('create-league')}}"><i class="icon-th"></i> Add New</a></li>
                                    </ul>
                                </li>

                                <li><a class="collapsed" data-toggle="collapse" href="#toggleRulesets"><i class="menu-icon icon-save">
                                </i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right"></i>Rule Sets </a>
                                    <ul id="toggleRulesets" class="collapse unstyled">
                                        <li><a href="{{URL('rulesets')}}"><i class="icon-save"></i>List</a></li>
                                        <li><a href="{{URL('rulesets/create')}}"><i class="icon-save"></i>Add New</a></li>
                                    </ul>
                                </li>                                

                                <li><a class="collapsed" data-toggle="collapse" href="#toggleContent"><i class="menu-icon icon-save">
                                </i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right"></i>Content</a>
                                    <ul id="toggleContent" class="collapse unstyled">
                                        <li><a href="{{URL('sitecontent')}}"><i class="icon-save"></i>List</a></li>
                                        <li><a href="{{URL('sitecontent/create/C')}}"><i class="icon-save"></i>Add Page Content</a></li>
                                        <li><a href="{{URL('sitecontent/create/F')}}"><i class="icon-save"></i>Add Front Slider</a></li>
                                        <li><a href="{{URL('sitecontent/create/N')}}"><i class="icon-save"></i>Add News/Blog</a></li>
                                    </ul>
                                </li>                                
                                <!--li><a class="collapsed" data-toggle="collapse" href="#toggleAuctions"><i class="menu-icon icon-exchange">
                                </i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right"></i>Auctions</a>
                                    <ul id="toggleAuctions" class="collapse unstyled">
                                        <li><a href="{{URL('auctions')}}"><i class="icon-exchange"></i> All</a></li>
                                        <li><a href="{{URL('auctions/1')}}"><i class="icon-exchange"></i> About to Start</a></li>
                                        <li><a href="{{URL('auctions/2')}}"><i class="icon-exchange"></i> Live</a></li>
                                        <li><a href="{{URL('auctions/3')}}"><i class="icon-exchange"></i> Closed</a></li>
                                    </ul>
                                </li-->                                
                                <li><a class="collapsed" data-toggle="collapse" href="#toggleTasks"><i class="menu-icon icon-group">
                                </i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right"></i>Automated Tasks</a>
                                    <ul id="toggleTasks" class="collapse unstyled">
                                        <li><a href="{{route('league-auctions')}}" target="_blank"><i class="icon-group"></i> 1) Set Auction Start Dates</a></li>
                                        <li><a href="{{route('notify-auctions')}}" target="_blank"><i class="icon-group"></i> 2) Load Auction Movies</a></li>
                                        <li><a href="{{route('phase1-auctions')}}" target="_blank"><i class="icon-group"></i> 3) Run Auctions</a></li>
                                        <li><a href="{{route('load-movies')}}" target="_blank"><i class="icon-group"></i> 4) Load Next Movies</a></li>
                                        <li><a href="{{route('prepare-clear-auctions')}}" target="_blank"><i class="icon-group"></i> 5c) End Auctions</a></li>
                                        <li><a href="{{route('close-league-auctions')}}" target="_blank"><i class="icon-group"></i> 6) Close League Auctions</a></li>
                                        <li><a href="{{route('close-bad-leagues')}}" target="_blank"><i class="icon-group"></i> 7) Disable Old Leagues</a></li>
                                        <li><a href="{{route('end-leagues')}}" target="_blank"><i class="icon-group"></i> 7) End Leagues</a></li>
                                    </ul>
                                </li>                                
                            </ul>
                        </div>
                        <!--/.sidebar-->