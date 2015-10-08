 
                <!-- ************** - Categories - ************** -->   
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

                <div class="categories widget clearfix">
                    
                    <div class="title-caption">
                        <h3>Competitor details</h3>
                    </div><!--/ .title-caption-->
                    
                    <div class="entry-holder">
                    <dl>
                    @foreach($league->players as $player)
                        <dt><strong>{{$player->name}}</strong></dt>
                        <dd>Has the balance: <strong>{{number_format($player->pivot->balance, 0)}} USD</strong>.</dd>
                    @endforeach
                    </dl>
                    </div>
                </div>
                <!-- ************** - END League Details - ************** -->
