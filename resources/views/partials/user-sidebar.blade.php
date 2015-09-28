            <!-- ************** - Sidebar - ************** -->              
            <aside id="sidebar">
                
                
                <!-- ************** - Categories - ************** -->   
                <div class="categories widget clearfix">
                    
                    <div class="title-caption">
                        <h3>Movie Genres</h3>
                    </div><!--/ .title-caption-->
                    
                    @if(isset($genres_list))
                    <ul>
                        @foreach($genres_list as $genre)
                        <li><div><a href="{{URL('movies-genre', [$genre->id])}}">{{$genre->name}}</a><span>({{$genre->movie_count()}})</span></div></li>
                        @endforeach
                    </ul>
                    @endif
                </div><!--/ .categories-->
                <!-- ************** - END Categories - ************** -->
                
                
                <!-- ************** - Top Games - ************** -->    
                <div class="topgames widget">
                    
                    <div class="title-caption">
                        <h3>Movies</h3>
                    </div><!--/ .title-captin -->
                    
                    <div class="entry-holder">
                        
                        <div class="tabs-2">
                            <ul class="tabs-nav tabs-2 clearfix">
                                <li><a href="#tab4">All</a></li>
                                <li><a href="#tab5">New</a></li>
                                <li><a href="#tab6">Release</a></li>
                                <li><a href="#tab7">Auction</a></li>
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
