@extends('layouts.site')

@section('content')

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
                    <span>Ended</span>
                    <strong>{{date("l, jS F Y g:iA", strtotime($currentLeague->end_date))}}</strong>
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
        <div class="game-menu" style="border-bottom: 5px solid #921913;">
            <div class="game-overlay-info">
                <h1 itemprop="itemreviewed">{{$currentLeague->name}}</h1>
            </div>
            <ul>
                <li class="active" style="background-color: #921913;" id="info_box"><a href="#" id="info_link"><i class="fa fa-comments"></i>&nbsp;&nbsp;Result Details</a></li>
            </ul>
        <!-- END .game-menu -->
        </div>

        <h2><span name='info'>News</span></h2>        
        <div class="content-padding">
            @if($authUser->id == $currentLeague->winners_id) 
            <h3>Congratulations <strong>{{$authUser->name}}</strong>!</h3>
            <p>You are the winner of the league!</p>
            <p>You have won <strong>{{$currentLeague->value()}} USD</strong> and this has been credited to your balance.</p>
            @else
            <h3>Disappointing!</h3>
            <p>We are sorry but <strong>{{$currentLeague->winner->name}}</strong> is the winner of the league.</p>
            @endif
        </div>

        <h2><span name='info'>Final Table</span></h2>
        @if($rankings->count()> 0)
        
        <table class="feature-table dark-gray">
            <tr><th>Pos</th><th>Player</th><th>Gross</th><th>VFM</th></tr>
            <?php $pos = 0; ?>
        @foreach($rankings->orderBy('total_gross', 'DESC')->get() as $rank)
            <tr><td>{{$pos+1}}</td><td>{{get_user_by_id($currentLeague->players, $rank->users_id)->fullName()}}</td>
            <td>{{number_format($rank->total_gross/1000000, 2)}}m USD</td><td>{{$rank->vfm}}</td></tr>
        @endforeach
        </table>
        @else
        <div class="content-padding">
        <p>No one else took part in the game so you won!</p>
        </div>
        @endif


        <div class="clear-float"></div>
        
        
    </div>

</div>

<div class="clear-float"></div>
@endsection