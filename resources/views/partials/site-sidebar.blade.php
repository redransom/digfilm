<!-- BEGIN #sidebar -->
                    <div id="sidebar">
                        
                        <!-- BEGIN .panel -->
                        <div class="panel">
                            <h2>We are social</h2>
                            <div class="panel-content socialize">
                                
                                <a href="#" target="_blank" class="strike-tooltip s-fb" title="Visit Facebook"><i class="fa fa-facebook"></i></a>
                                <a href="#" target="_blank" class="strike-tooltip s-tw" title="Visit Twitter"><i class="fa fa-twitter"></i></a>
                                <a href="#" target="_blank" class="strike-tooltip s-yt" title="Visit YouTube"><i class="fa fa-youtube-play"></i></a>
                                <!--a href="#" target="_blank" class="strike-tooltip s-tc" title="Visit Twitch"><i class="fa fa-twitch"></i></a>
                                <a href="#" target="_blank" class="strike-tooltip s-st" title="Visit Steam"><i class="fa fa-steam"></i></a-->
                                
                            </div>
                        <!-- END .panel -->
                        </div>
                        
                        @if(isset($currentLeague))
                        @include('partials.site-league-details', ['currentLeagueUser'=>$currentLeagueUser, 'league'=>$currentLeague, 'blind'=>($currentLeague->rule->blind_bid == 'Y')])
                        @elseif(isset($genres_list))
                        @include('partials.user-sidebar-genres')
                        @endif
                        


                        

                    <!-- END #sidebar -->
                    </div>