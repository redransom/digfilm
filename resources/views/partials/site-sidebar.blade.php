<!-- BEGIN #sidebar -->
                    <div id="sidebar">
                        
                        <!-- BEGIN .panel -->
                        <div class="panel">
                            <h2>We are social</h2>
                            <div class="panel-content socialize">
                                
                                <a href="#" target="_blank" class="strike-tooltip s-fb" title="Visit Facebook"><i class="fa fa-facebook"></i></a>
                                <a href="#" target="_blank" class="strike-tooltip s-tw" title="Visit Twitter"><i class="fa fa-twitter"></i></a>
                                <a href="#" target="_blank" class="strike-tooltip s-yt" title="Visit YouTube"><i class="fa fa-youtube-play"></i></a>
                                <a href="#" target="_blank" class="strike-tooltip s-tc" title="Visit Twitch"><i class="fa fa-twitch"></i></a>
                                <a href="#" target="_blank" class="strike-tooltip s-st" title="Visit Steam"><i class="fa fa-steam"></i></a>
                                
                            </div>
                        <!-- END .panel -->
                        </div>
                        
                        @if(isset($currentLeague))
                        @include('partials.user-league-details', ['currentLeagueUser'=>$currentLeagueUser, 'league'=>$currentLeague, 'blind'=>($currentLeague->rule->blind_bid == 'Y')])
                        @elseif(isset($genres_list))
                        @include('partials.user-sidebar-genres')
                        @endif
                        
                        <!-- BEGIN .panel -->
                        <div class="panel">
                            
                            

                            <h2>Upcoming Events</h2>
                            <div class="top-right"><a href="#">View all</a></div>
                            <div class="panel-content">
                                
                                <div class="panel-games-lobby">
                                    <ol>
                                        <li>
                                            <div class="lobby-block" style="background:url({{asset('/images/photos/image-38.jpg') }}) no-repeat center;">
                                                <span class="caption">Rualisque ex pri delenit</span>
                                                <div class="join-button">
                                                    <a href="#">View event page</a>
                                                </div>
                                            </div>
                                            <div class="lobby-info">
                                                <span class="right">14.May 2013, 20:00</span>
                                                <span class="left"><b class="countdown-text" rel="1428482400">Loading..</span></b>
                                                <div class="clear-float"></div>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="lobby-block" style="background:url({{asset('/images/photos/image-37.jpg') }}) no-repeat center;">
                                                <span class="caption">Cu eam causae appetere inciderint</span>
                                                <div class="join-button">
                                                    <a href="#">View event page</a>
                                                </div>
                                            </div>
                                            <div class="lobby-info">
                                                <span class="right">25.Okt 2013, 20:00</span>
                                                <span class="left"><b class="countdown-text" rel="1428482400">Loading..</span></b>
                                                <div class="clear-float"></div>
                                            </div>
                                        </li>
                                    </ol>
                                </div>

                            </div>
                        <!-- END .panel -->
                        </div>

                        <!-- BEGIN .panel -->
                        <div class="panel">
                            <h2>Popular Articles</h2>
                            <div class="top-right"><a href="#">View all</a></div>
                            <div class="panel-content">
                                
                                <div class="d-articles">
                                    <div class="item">
                                        <div class="item-header">
                                            <a href="#"><img src="{{asset('/images/photos/image-95.jpg') }}" alt="" /></a>
                                        </div>
                                        <div class="item-content">
                                            <h4><a href="post.html">Fermentum hac consectetur</a></h4>
                                            <p>Sagittis ut eleifend taciti eleifend, mauris primis...</p>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="item-header">
                                            <a href="post.html"><img src="{{asset('/images/photos/image-96.jpg') }}" alt="" /></a>
                                        </div>
                                        <div class="item-content">
                                            <h4><a href="post.html">Fermentum hac consectetur</a></h4>
                                            <p>Sagittis ut eleifend taciti eleifend, mauris primis...</p>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="item-header">
                                            <a href="post.html"><img src="{{asset('/images/photos/image-97.jpg') }}" alt="" /></a>
                                        </div>              
                                        <div class="item-content">
                                            <h4><a href="post.html">Fermentum hac consectetur</a></h4>
                                            <p>Sagittis ut eleifend taciti eleifend, mauris primis...</p>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="item-header">
                                            <a href="post.html"><img src="{{asset('/images/photos/image-98.jpg') }}" alt="" /></a>
                                        </div>              
                                        <div class="item-content">
                                            <h4><a href="post.html">Fermentum hac consectetur</a></h4>
                                            <p>Sagittis ut eleifend taciti eleifend, mauris primis...</p>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="item-header">
                                            <a href="#"><img src="{{asset('/images/photos/image-99.jpg') }}" alt="" /></a>
                                        </div>              
                                        <div class="item-content">
                                            <h4><a href="post.html">Fermentum hac consectetur</a></h4>
                                            <p>Sagittis ut eleifend taciti eleifend, mauris primis...</p>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        <!-- END .panel -->
                        </div>

                        <!-- BEGIN .panel -->
                        <div class="panel">
                            <h2>Duel of the week</h2>
                            <div class="panel-content">

                                <div class="voting-line">
                                    <div class="voting-left" style="width:70%;"><span>70%</span></div>
                                    <div class="voting-right" style="width:30%;"><span>30%</span></div>
                                    <div class="clear-float"></div>
                                </div>
                                
                                <div class="panel-duel">
                                    <div class="panel-duel-block" style="background:url({{asset('/images/photos/image-30.jpg') }}) no-repeat center;">
                                        <span class="caption">Tempor delenit</span>
                                    </div>
                                    <div class="panel-duel-block" style="background:url({{asset('/images/photos/image-31.jpg') }}) no-repeat center;">
                                        <span class="caption">Pro ne harum postea</span>
                                    </div>
                                    <div class="duel-versus"></div>
                                    <div class="clear-float"></div>
                                </div>
                                
                                <div class="panel-duel-voting">
                                    <div class="panel-duel-vote">
                                        <a href="#">Vote</a>
                                    </div>
                                    <div class="panel-duel-vote">
                                        <a href="#">Vote</a>
                                    </div>
                                    <div class="clear-float"></div>
                                </div>
                                
                            </div>
                        <!-- END .panel -->
                        </div>

                        <!-- BEGIN .panel -->
                        <div class="panel">
                            <h2>Contact Information</h2>
                            <div class="panel-content">
                                
                                <div>
                                    <h4>What do we stand for ?</h4>
                                    <p>Soleat aperiam ex pri, at pericula constituam efficiantu per, voluptaria intellegam eu nec. Duo modus homero vivendum an, facete timeam ne eum.</p>

                                    <a href="mailto:revelio@oursite.com" class="icon-line">
                                        <i class="fa fa-comment"></i><span>revelio@oursite.com</span>
                                    </a>
                
                                    <span class="icon-line">
                                        <i class="fa fa-map-marker"></i><span>949 West Grassland Drive, UT 84003</span>
                                    </span>
                
                                </div>
                                
                            </div>
                        <!-- END .panel -->
                        </div>

                    <!-- END #sidebar -->
                    </div>