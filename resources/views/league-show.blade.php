@extends('layouts.site')

@section('content')

<div id="main" itemscope="" itemtype="http://data-vocabulary.org/Review">
    <div class="game-info-left">
        @if(!is_null($currentLeague->file_name))
        <img itemprop="image" src="{{asset($currentLeague->file_name)}}" class="game-poster" alt="" />
        @else
        <img itemprop="image" src="{{asset('/images/TNBF.jpg')}}" class="game-poster" alt="" />
        @endif
        <div class="game-info-details">
            <!--div class="game-info-buttons">
                <a href="#" class="defbutton green"><i class="fa fa-bell"></i>Follow Film</a>
                <a href="games-single-video-single.html" class="defbutton"><i class="fa fa-film"></i>View Trailer</a>
            </div-->
            <div class="game-info-rating">
                <h3>League Information</h3>
                <hr />
                <!--a href="post.html" class="defbutton"><i class="fa fa-file-text-o"></i>Read Review</a-->
            </div>
            <!--div class="game-info-buttons">
                <a href="games-single-shop.html" class="defbutton"><i class="fa fa-shopping-cart"></i>Buy game starting from <span class="pricetag">55 &euro;</span></a>
                <a href="#" class="defbutton"><i class="fa fa-gamepad"></i>I have played</a>
            </div-->
            <div class="game-info-graph">
                <div>
                    <span>Started</span>
                    <strong itemprop="datePublished" content="{{$currentLeague->auction_start_date}}">{{date("l, jS F Y", strtotime($currentLeague->auction_start_date))}}</strong>
                    <span>Ends</span>
                    <strong itemprop="datePublished" content="{{$currentLeague->end_date}}">{{date("l, jS F Y", strtotime($currentLeague->end_date))}}</strong>
                </div>
                @if(isset($currentLeague->rule_set->name))
                <div>
                    <span>Rules</span>
                    <strong itemprop="applicationCategory"><a href="#">{{$currentLeague->rule_set->name}}</a></strong>
                </div>
                @endif
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
                <li class="active" style="background-color: #921913;"><a href="#info"><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;Information</a></li>
                <!--li><a href="games-single-news.html"><i class="fa fa-comments"></i>&nbsp;&nbsp;News</a></li-->
                <!--li><a href="games-single-video.html"><i class="fa fa-film"></i>&nbsp;&nbsp;Video (3)</a></li>
                <li><a href="photo-gallery-single.html"><i class="fa fa-camera-retro"></i>&nbsp;&nbsp;Photos (18)</a></li-->
            </ul>
        <!-- END .game-menu -->
        </div>

        <h2><span name='info'>Description</span></h2>        
        <div class="content-padding">
        {{$currentLeague->description}}
        </div>

        <div class="clear-float"></div>
        <h2><span>Stats</span></h2>

        <h3><span>League Pot Size</span></h3>
        @if($currentLeague->players()->count() > 0)
        <p><strong>{{$currentLeague->players()->count() * 100}} USD</strong></p>
        @endif


        <h3><span>Players</span></h3>
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

        @if($currentLeague->movies()->count() > 0)
        <div class="content-padding">
            @include('partials.site-movies', ['movies'=>$currentLeague->movies])
        </div>
        @endif

        @if($currentLeague->auction_stage == 3)

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
            <li>Highest Bid <strong>{{number_format($highest_bid->bid_amount, 2)}} USD </strong> for <strong><a href="{{URL('movie-knowledge', $highest_bid->movie->link())}}">{{$highest_bid->movie->name}}</a></strong></li>
        </ul>
        <br/>

        <h3>Current Rankings</h3>
        <div class="content-padding">
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
        </div>


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