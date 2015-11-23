 
                <!-- ************** - Categories - ************** -->   
                <div class="categories widget clearfix">
                    
                    <div class="title-caption">
                        <h3>League Details</h3>
                    </div><!--/ .title-caption-->
                    
                    <div class="entry-holder">

                        <!-- First check -->
                        @if($league->auction_stage == 2) 
                        
                        <!-- is this for rounds? -->
                        @if((is_null($league->rule->auction_movie_release) || $league->rule->auction_movie_release == 0))
                        
                        <h3>Remaining Auction Time: </h3>
                        <ul class="dropspot-list"><li><span class="dropspot" style="width: 170px !important"><?php auctionTimer($league->id, $league->auction_close_date, 'league'); ?></span></li></ul>
                        
                        @else
                        <!-- show rounds detail -->
                        <h3>Remaining Round Time: </h3>
                        <ul class="dropspot-list"><li><span class="dropspot" style="width: 170px !important"><?php auctionTimer($league->id, $league->round_start_date, 'league'); ?></span></li></ul>
                        
                        <style>
                        .round {
                            float:left;
                            display:block;
                            clear:both;
                            width: 250px !important;
                            font-weight:bold;
                            font-size: 2em;
                        }
                        </style>
                        <div class="round">
                        @if($league->current_round < $league->round_amount)
                        <span>Round No: {{$league->current_round}} of {{$league->round_amount}}</span>
                        @else
                        <span>Final Round!</span>
                        @endif
                        </div>

                        @endif 
                        <!-- end rounds check -->
                        
                        @elseif($league->auction_stage < 2)

                        <h3>Auction is due to start</h3>
                        <p>At: <strong>{{date("jS M Y g:iA", strtotime($league->auction_start_date))}}</strong></p>
                        
                        <!-- end first check -->

                        <div class="clear"></div>

                        @elseif($league->auction_stage == 3)
                        <h3>League Closes: </h3>
                        <strong>{{date("j M Y h:iA", strtotime($league->auction_close_date))}}</strong>
                        @endif 

                    </div>
                </div>

                @if($league->auction_stage < 3)
                <div class="categories widget clearfix">
                    
                    <div class="title-caption">
                        <h3>Your details</h3>
                    </div><!--/ .title-caption-->
                    
                    <div class="entry-holder">
                        <p>In this league you have a balance of <strong>{{number_format($currentLeagueUser->balance, 0)}} USD</strong>.</p>

                        <dl>
                        @foreach($authUser->auctions()->where('leagues_id', $currentLeagueUser->league_id)->get() as $movie)
                            <dt><strong>{{$movie->name}}</strong></dt>
                            <dd>Bid <strong>{{$movie->pivot->bid_amount}} USD</strong></dd>
                            
                        @endforeach
                        </dl>
                    </div>
                </div>
                @endif
                <div class="categories widget clearfix">
                    
                    <div class="title-caption">
                        <h3>Competitor details</h3>
                    </div><!--/ .title-caption-->
                    
                    <div class="entry-holder">
                    <dl>
                    @foreach($league->players as $player)
                        @if($player->id != $authUser->id)
                        <dt><strong>{{$player->name}}</strong></dt>
                        <dd>Has the balance: <strong>{{number_format($player->pivot->balance, 0)}} USD</strong>.</dd>
                        @endif
                    @endforeach
                    </dl>
                    </div>
                </div>
                <!-- ************** - END League Details - ************** -->
