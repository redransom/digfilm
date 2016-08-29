@extends('layouts.site')

@section('content')
@include('partials.site-auction-timer')
<div id="main" itemscope="" itemtype="http://data-vocabulary.org/Review">
    <div class="game-info-left">
        <img itemprop="image" src="{{asset($currentLeague->leagueImage())}}" class="game-poster" alt="" />
        <div class="game-info-details">
            @if($currentLeague->canJoin($authUser) == 1)
            <div class="game-info-buttons">
                <a href="{{Route('join-league', [$currentLeague->id, '1'])}}" class="defbutton green"><i class="fa fa-bell"></i>Join League</a>
            </div>
            @endif
            <div class="game-info-rating">
                <h3>League Information</h3>
                <hr />
            </div>

            <div class="game-info-graph">
                <div>
                    <span>Starts</span>
                    <strong>{{date("l, jS F Y g:iA", strtotime($currentLeague->auction_start_date))}}</strong>
                    <span>Countdown:</span>
                    <strong><?php auctionTimer($league->id, $league->auction_start_date); ?></strong>
                
                    @if(!is_null($currentLeague->end_date))
                    <span>Ends</span>
                    <strong>{{date("l, jS F Y g:iA", strtotime($currentLeague->end_date))}}</strong>
                    @endif
                    <span>League Pot Size</span>
                    @if($currentLeague->players()->count() > 0)
                    <strong>{{$currentLeague->value()}} USD</strong>
                    @else
                    <strong>0 USD</strong>
                    @endif
                    @if(isset($currentLeague->rule_set->name))
                    <br/>
                    <h3>Rules</h3>
                    <span>Type</span>
                    <strong>{{$currentLeague->rule_set->name}}</strong>

                    <span>Durations</span>
                    <strong>Auction: {{$currentLeague->rule->auction_duration}} hours 
                    @if($currentLeague->rule->round_duration != 0)
                    <br/>Round: {{$currentLeague->rule->round_duration}} hours 
                    @endif
                    @if($currentLeague->rule->blind_bid != 'Y')
                    <br/>Movies countdown: {{$currentLeague->rule->ind_film_countdown}} mins
                    <br/>Timeout: {{$currentLeague->rule->auction_timeout}} mins
                    </strong>
                    <span>Bids</span>
                    <strong>Min: {{$currentLeague->rule->min_bid}}USD Max: {{$currentLeague->rule->max_bid}}USD</strong>
                    <span>Increment</span>
                    <strong>Min: {{number_format($currentLeague->rule->min_increment, 2)}}USD Max: {{number_format($currentLeague->rule->max_increment, 2)}}USD</strong>
                    @endif
                    <span>Selection</span>
                    <strong>Random: {{($currentLeague->rule->randomizer == "Y") ? "Yes" : "No"}} <br/>Auto-Select: {{($currentLeague->rule->auto_select == 'Y') ? "Yes" : "No"}} 
                    @if(!is_null($currentLeague->rule->auction_movie_release))
                    <br/>Grouped: {{$currentLeague->rule->auction_movie_release}}
                    @endif</strong>
                    <span>Misc</span>
                    <strong>Movie Takings: {{intval($currentLeague->rule->movie_takings_duration)}} weeks</strong>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="game-info-right">

        <!-- BEGIN .game-menu -->
        <script>
        $(function() {
            $("#stats_link").click(function() {
                $('#info_box').removeClass('active').css('background-color', '#000000');
                $('#stats_box').addClass('active').css('background-color', '#921913');
                $('#movies_box').removeClass('active').css('background-color', '#000000');
                $('#info').toggle(false);
                $('#movies').toggle(false);
                $('#stats').toggle(true);
            });

            $("#info_link").click(function() {
                $('#stats_box').removeClass('active').css('background-color', '#000000');
                $('#info_box').addClass('active').css('background-color', '#921913');
                $('#movies_box').removeClass('active').css('background-color', '#000000');
                $('#stats').toggle(false);
                $('#info').toggle(true);
                $('#movies').toggle(false);
            });

            $("#movies_link").click(function() {
                $('#info_box').removeClass('active').css('background-color', '#000000');
                $('#movies_box').addClass('active').css('background-color', '#921913');
                $('#stats_box').removeClass('active').css('background-color', '#000000');
                $('#stats').toggle(false);
                $('#info').toggle(false);
                $('#movies').toggle(true);
            });
        });
        </script>

        <div class="game-menu" style="border-bottom: 5px solid #921913;">
            <div class="game-overlay-info">
                <h1 itemprop="itemreviewed">{{$currentLeague->name}}</h1>
            </div>
            <ul>
                <li class="active" style="background-color: #921913;" id="info_box"><a href="#" id="info_link"><i class="fa fa-comments"></i>&nbsp;&nbsp;Information</a></li>
                <li id="movies_box"><a href="#" id="movies_link"><i class="fa fa-comments"></i>&nbsp;&nbsp;Movies</a></li>
                @if($currentLeague->auction_stage == 3)
                <li id="stats_box"><a href="#" id="stats_link"><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;League Stats</a></li>
                @endif
            </ul>
        <!-- END .game-menu -->
        </div>

        <div id="info">
            <h2><span name='info'>Description</span></h2>        
            <div class="content-padding">
            {!! $currentLeague->description !!}
            </div>

            <h2><span>Players</span></h2>
            <p>
            The following <strong>{{$currentLeague->players()->count()}}</strong> players are in the league:
            </p>

            @if($currentLeague->players()->count() > 0)

            <div class="content-padding">
                <!-- BEGIN .photo-blocks -->
                <div class="photo-blocks">
                    <ul>
                        @foreach($currentLeague->players as $player)
                        <li>
                            <!--a href="#" class="article-image-out"-->
                            @if(!is_null($player->thumbnail) || $player->thumbnail != '')
                            <span class="article-image"><img src="{{asset($player->thumbnail) }}" width="128" height="128" alt="" title="" /></span><!--/a-->
                            @else
                            <span class="article-image"><img src="{{asset('/images/TNBF.jpg') }}" width="128" height="128" alt="" title="" /></span><!--/a-->
                            @endif
                            <span>{{$player->fullName()}}</span>

                        </li>
                        @endforeach
                    </ul>
                    <div class="clear-float"></div>
                <!-- END .photo-blocks -->
                </div>
            </div>
            @endif
            <div class="clear-float"></div>
        </div> <!-- close off info section -->
        
        @if($currentLeague->movies()->count() > 0)
        <div id="movies" style="display:none">
            @include('partials.site-movies', ['movies'=>$currentLeague->movies, 'sectionTitle'=>'Movies in this league', 'showTakings'=>true])
            <div class="clear-float"></div>
        </div> <!-- close off movies section -->
        @endif

        
        @if($currentLeague->auction_stage == 3)
        <div id="stats" style="display:none">
            <h2><span>Stats</span></h2>
            <h3>League Revenue</h3>
            <ul>
                <li>Total League Revenue: <strong>{{number_format($currentLeague->rosters()->sum('total_gross')/1000000, 2)}}m USD</strong></li>
                <li>Top two films on revenue: 
                    <ol>
                        @foreach($currentLeague->rosters()->orderBy('total_gross', 'DESC')->limit(2)->get() as $rev)
                        <li>{{$rev->movie->name}} <strong>{{number_format($rev->total_gross/1000000, 2)}}m USD</strong></li>
                        @endforeach
                    </ol>
                </li>
                @if(isset($highest_bid))
                <li>Highest Bid <strong>{{number_format($highest_bid->bid_amount, 2)}} USD </strong> for <strong><a href="{{URL('movie-knowledge', $highest_bid->movie->link())}}">{{$highest_bid->movie->name}}</a></strong></li>
                @endif
            </ul>
            <br/>

            <h3>Current Rankings</h3>
            @if($rankings->count()> 0)
            <table class="feature-table dark-gray">
                <tr><th>Pos</th><th>Player</th><th>Gross</th><th>VFM</th></tr>
                <?php $pos = 0; ?>
            @foreach($rankings->orderBy('total_gross', 'DESC')->get() as $rank)
                <tr><td>{{$pos+1}}</td><td>{{get_user_by_id($currentLeague->players, $rank->users_id)->fullName()}}</td>
                <td>{{number_format($rank->total_gross/1000000, 2)}}m USD</td><td>{{$rank->vfm}}</td></tr>
            @endforeach
            </table>
            @endif
            <div class="clear-float"></div>
        </div>
         <!-- close off stats section -->
        @endif
    </div>

</div>

<div class="clear-float"></div>
@endsection

<?php

function get_user_by_id($players, $player_id) {
    foreach ($players as $player) {
        if ($player->id == $player_id)
            return $player;
    }
}

?>