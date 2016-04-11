 
                <!-- ************** - Categories - ************** -->   
                <div class="panel">
                    <h2><span>League Details</span></h2>
                    
                    <div class="panel-content">

                        <h3>League Type: </h3><p>{{$league->rule_set->name}}</p>

                        @if($league->auction_stage >= 2 && $league->auction_stage < 5)
                        <h3>Auction Started: </h3><p>{{date("jS M Y g:iA", strtotime($league->auction_start_date))}}</p>
                        <h3>Auction Close: </h3><p>{{date("jS M Y g:iA", strtotime($league->auction_close_date))}}</p>
                        @endif

                        <!-- First check -->
                        @if($league->auction_stage == 2) 

                        <!-- is this for rounds? -->
                        @if((is_null($league->rule->auction_movie_release) || $league->rule->auction_movie_release == 0))
                        <h3>Remaining Auction Time: </h3>
                        <div class="round"><?php auctionTimer($league->id, $league->auction_close_date, 'league'); ?></div>
                        
                        @else
                        <!-- show rounds detail -->
                        <h3>Remaining Round Time: </h3>
                        <div class="round"><?php auctionTimer($league->id, $league->round_start_date, 'league'); ?></div>
                        
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
                        <p>At: <strong>{{date("j M Y g:iA", strtotime($league->end_date))}}</strong></p>
                        @endif 
                        <p>&nbsp;</p>
                    </div>
                </div>

                @if($league->auction_stage < 3)
                <div class="panel">
                    <h2><span>Your details</span></h2>
                    
                    <div class="panel-content">
                        <p>In this league you have a balance of <strong>{{number_format($currentLeagueUser->balance, 2)}} USD</strong>.</p>

                        @if(!$blind)
                        <dl>
                        @foreach($authUser->auctions()->where('leagues_id', $currentLeagueUser->league_id)->get() as $movie)
                            <dt><strong>{{$movie->name}}</strong></dt>
                            <dd>Bid <strong>{{$movie->pivot->bid_amount}} USD</strong></dd>
                            
                        @endforeach
                        </dl>
                        @endif
                    </div>
                </div>
                
                @if(!$blind)
                <div class="panel">
                    <h2><span>Competitor details</span></h2>
                    
                    <div class="panel-content">
                        @foreach($league->players as $player)
                            @if($player->id != $authUser->id)
                            <h3>{{$player->name}}</h3>
                            <p>Has the balance: <strong>{{number_format($player->pivot->balance, 0)}} USD</strong>.</p>
                            @endif
                        @endforeach
                    </div>
                </div>
                @endif
                
                @elseif($league->auction_stage == 3)
                <!-- roster stage -->
                <div class="panel">
                    <h2><span>League Rankings</span></h2>
                    
                    <div class="panel-content">
                        @if($rankings->count()> 0)
                        <table class="feature-table dark-gray">
                            <tr><th>Pos</th><th>Player</th><th>Gross</th><th>VFM</th></tr>
                            <?php $pos = 0; ?>
                        @foreach($rankings->orderBy('total_gross', 'DESC')->get() as $rank)
                            <tr><td>{{$pos+1}}</td><td>{{get_user_by_id($currentLeague->players, $rank->users_id)->fullName()}}</td>
                            <td>{{$rank->total_gross}}</td><td>{{$rank->vfm}}</td></tr>
                        @endforeach
                        </table>
                        @endif

                    </div>
                </div>

                @endif

                @include('partials.site-league-chat', ['messages'=>$league->messages()->orderBy('created_at', 'ASC')->limit(3)->get()])
                <!-- ************** - END League Details - ************** -->

<?php

function get_user_by_id($players, $player_id) {
    foreach ($players as $player) {
        if ($player->id == $player_id)
            return $player;
    }
}

?>