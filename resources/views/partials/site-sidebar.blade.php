<!-- BEGIN #sidebar -->
                    <div id="sidebar">
                        
                        @if(!isset($currentLeague))
                        @include('partials.site-social-sidebar')
                        @endif

                        @if(isset($authUser) && !is_null($authUser) && !isset($currentLeague))
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

                        @include('partials.site-sidebar-adverts')
                    <!-- END #sidebar -->
                    </div>