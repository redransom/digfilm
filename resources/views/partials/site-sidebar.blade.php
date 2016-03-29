<!-- BEGIN #sidebar -->
                    <div id="sidebar">
                        
                        <!-- BEGIN .panel -->
                        <div class="panel">
                            <h2><span>We are social</span></h2>
                            <div class="panel-content socialize">
                                <div class="social-icon-item">
                                <a href="#" target="_blank" class="strike-tooltip s-fb" title="Visit Facebook"><i class="fa fa-facebook"></i></a>
                                </div>
                                <div class="social-icon-item">
                                <a href="#" target="_blank" class="strike-tooltip s-tw" title="Visit Twitter"><i class="fa fa-twitter"></i></a>
                                </div>
                                <div class="social-icon-item">
                                <a href="#" target="_blank" class="strike-tooltip s-yt" title="Visit YouTube"><i class="fa fa-youtube-play"></i></a>
                                </div>
                                <div class="social-icon-item">
                                    <a href="#" target="_blank" class="strike-tooltip s-sh" title="Share"><i class="fa fa-share-alt"></i></a>
                                </div>
                            </div>
                        <!-- END .panel -->
                        </div>
                        
                        @if(isset($authUser) && !is_null($authUser))
                        @include('partials.site-user-details')
                        @endif

                        @if(isset($currentLeague))
                        @include('partials.site-league-details', ['currentLeagueUser'=>$currentLeagueUser, 'league'=>$currentLeague, 'blind'=>($currentLeague->rule->blind_bid == 'Y')])
                        @elseif(isset($genres_list))
                        @include('partials.user-sidebar-genres')
                        @endif
                                      
                        @if(isset($contact_rhs))
                        @include('partials.site-sidebar-contact', ['content'=>$contact_rhs])
                        @endif
                    <!-- END #sidebar -->
                    </div>