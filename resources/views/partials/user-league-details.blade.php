 
                <!-- ************** - Categories - ************** -->   
                <div class="panel">
                    <h2><span>League Details</span></h2>
                    
                    <div class="panel-content">

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
                        <strong>{{date("j M Y g:iA", strtotime($league->end_date))}}</strong>
                        @endif 

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
                    <h2>Competitor details</h2>
                    
                    <div class="panel-content">
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
                @endif
                
                @elseif($league->auction_stage == 3)
                <!-- roster stage -->
                <div class="panel">
                    <h2>League Rankings</h2>
                    
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

                <div class="panel">
                    <h2>League Chat</h2>
                    
                    <div class="panel-content">
                        @if($league->messages->count() > 0)
                        <div class="d-articles">
                            @foreach($league->messages()->orderBy('created_at', 'ASC')->limit(3)->get() as $message)
                            <div class="item">
                                <div class="item-header">
                                    <a href="{{URL('profile', ['id'=>$message->owner->id])}}">
                                    @if($message->owner->thumbnail != "")
                                    <img src="{{asset($message->owner->thumbnail)}}" alt="" />
                                    @else
                                    <img src="{{asset('images/photos/image-95.jpg')}}" alt="" />
                                    @endif
                                    </a>
                                </div>
                                <div class="item-content">
                                    <p>{{$message->message}}</p>
                                    <h5>{{$message->owner->fullName()}} said {{date("d M Y h:iA", strtotime($message->created_at))}}</h5>
                                </div>
                            </div>
                            @endforeach

                        </div>
                        @endif
                        <div class="reply-textarea">
                            <form action="{{Route('add-message', ['id'=>$league->id])}}" method="post">
                                <input type="hidden" name="leagues_id" value="{{$league->id}}" />
                                <input type="hidden" name="owners_id" value="{{$authUser->id}}" />
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="respond-textarea">
                                    <div class="textarea-wrapper strike-wysiwyg-enable" rel="wys-current">
                                        <textarea name="message"></textarea>
                                    </div>
                                </div>
                                <div class="respond-submit">
                                    <input type="submit" name="send" value="Send">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- ************** - END League Details - ************** -->

<?php

function get_user_by_id($players, $player_id) {
    foreach ($players as $player) {
        if ($player->id == $player_id)
            return $player;
    }
}

?>