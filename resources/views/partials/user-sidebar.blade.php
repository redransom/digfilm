            <!-- ************** - Sidebar - ************** -->              
            <aside id="sidebar">
                @if(isset($currentLeague))
                @include('partials.user-league-details', ['currentLeagueUser'=>$currentLeagueUser, 'league'=>$currentLeague, 'blind'=>($currentLeague->rule->blind_bid == 'Y')])
                @elseif(isset($genres_list))
                @include('partials.user-sidebar-genres')
                @endif
                
                <!-- ************** - Top Games - ************** -->    
                <div class="topgames widget">
                    
                    <div class="title-caption">
                        <h3>Movies</h3>
                    </div><!--/ .title-captin -->
                    
                    <div class="entry-holder">
                        
                        <div class="tabs-2">
                            <ul class="tabs-nav tabs-2 clearfix">
                                <li><a href="#newmovies">New</a></li>
                                <li><a href="#newrelease">Release</a></li>
                                <li><a href="#topauction">Auction</a></li>
                            </ul><!--/ .tabs-nav -->

                            <div class="tabs-container">
                                
                                <div class="tab-content" id="newmovies">
                                    <ul class="rate">

                                    @foreach($new_movies as $newmovie)
                                        <li>
                                            <a href="{{URL('movie-knowledge', ['id'=>$newmovie->slug])}}">

                                            <img src="/images/temp/temp_thumbs_5.jpg" width="94" height="60" alt="" class="alignleft" /></a>
                                            <div class="teaser-content">
                                                <h6><a class="title" href="top-games.html">{{$newmovie->name}}</a></h6>
                                                <div class="star"></div>
                                            </div><!--/ .teaser-conent-->
                                            <div class="clear"></div>
                                        </li>
                                    @endforeach
                                    </ul><!--/ .rate-->
                                </div><!--/ #tab5-->
                                <div class="tab-content" id="newrelease">
                                    <ul class="rate">
                                        @foreach($released_movies as $relmovie)
                                        <li>
                                            <a href="{{URL('movie-knowledge', ['id'=>$relmovie->slug])}}"><img src="/images/temp/temp_thumbs_5.jpg" width="94" height="60" alt="" class="alignleft" /></a>
                                            <div class="teaser-content">
                                                <h6><a class="title" href="{{URL('movie-knowledge', ['id'=>$relmovie->slug])}}">{{$relmovie->name}}}</a></h6>
                                                <div class="star"></div>
                                            </div><!--/ .teaser-conent-->
                                            <div class="clear"></div>
                                        </li>
                                        @endforeach
                                    </ul><!--/ .rate-->
                                </div><!--/ #tab6-->
                                
                                <div class="tab-content" id="topauction">
                                    <ul class="rate">
                                        @foreach($top_auctions as $topmovie)
                                        <li>
                                            <a href="{{URL('movie-knowledge', ['id'=>$topmovie->slug])}}"><img src="/images/temp/temp_thumbs_6.jpg" width="94" height="60" alt="" class="alignleft" /></a>
                                            <div class="teaser-content">
                                                <h6><a class="title" href="{{URL('movie-knowledge', ['id'=>$topmovie->slug])}}">{{$topmovie->name}}</a></h6>
                                                <strong>{{$topmovie->bids()->count()}} bids</strong>
                                            </div><!--/ .teaser-conent-->
                                            <div class="clear"></div>
                                        </li>
                                        @endforeach
                                    </ul><!--/ .rate-->
                                </div><!--/ #tab7-->
                                
                                <a href="{{URL('movies')}}" class="see-all">See all &raquo;</a>
                                
                            </div><!--/ .tabs container-->                  
                        </div><!--/ .tabs-2-->
                    </div><!--/ .entry-holder-->
                </div><!--/ .topgames-->
                <!-- ************** - END Holder - ************** -->   
                
                
                <!-- ************** - Latest Videos - ************** -->
                <div class="latest-video widget">
                    
                    <div class="title-caption-dark">
                        <h3>Latest Trailers</h3>
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
