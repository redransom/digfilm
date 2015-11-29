@extends('layouts.users')

@section('content')
<section class="entry sbr clearfix">
    <div class="title-caption-large">
        <h3>Welcome to the "{{$currentLeague->name}}" League</h3>
    </div>
    <h2>Available Auctions</h2>
    @if(is_null($currentLeague->auction_start_date))
    <p>The auction will start soon!</p>

    @elseif(strtotime($currentLeague->auction_start_date) > time())
    <p>The auction will start on the <strong>{{date("jS F Y g:iA", strtotime($currentLeague->auction_start_date))}}</strong>.</p>
    @elseif($currentLeague->auctions()->count() > 0)
    <?php $players = $currentLeague->players->lists('name', 'id'); ?>

    @include('partials.user-auctions', ['currentLeague'=>$currentLeague, 'players'=>$players, 'leagueUser'=>$currentLeagueUser])

    @include('partials.user-expired-auctions', ['tableTitle'=>'Films Purchased', 'players'=>$players, 'leagueUser'=>$currentLeagueUser, 'auctions'=>$wonAuctions])

    @include('partials.user-expired-auctions', ['tableTitle'=>'Expired Movies', 'players'=>$players, 'leagueUser'=>$currentLeagueUser, 'auctions'=>$expiredAuctions])

    @else
    <p>The auction is almost ready!</p>
    @endif

    @if(is_null($currentLeague->auction_start_date) || (strtotime($currentLeague->auction_start_date) > time())) 
    <h2>Players</h2>
    <p>Who you are competing against.</p>
    @if($currentLeague->players->count())
    <ul>
        @foreach($currentLeague->players as $player)
        <li>{{$player->name}}</li>
        @endforeach
    </ul>
    @endif
    <br/>
    <h2>Rules</h2>
        <table class="feature-table dark-gray">
            <tr>
                <td>Players</td>
                <td>Min: {{$currentLeague->rule->min_players}} Max: {{$currentLeague->rule->max_players}}</td>
            </tr>
            <tr>
                <td>Movies</td>
                <td>Min: {{$currentLeague->rule->min_movies}} Max: {{$currentLeague->rule->max_movies}}</td>
            </tr>
            <tr>
                <td>Start/End</td>
                <td>Start Time: {{$currentLeague->rule->start_time}} End Time: {{$currentLeague->rule->end_time}}</td>
            </tr>
            <tr>
                <td>Durations</td>
                <td>Auction: {{$currentLeague->rule->auction_duration}} hours <br/>Round: {{$currentLeague->rule->round_duration}} hours <br/>Movies: {{$currentLeague->rule->ind_film_countdown}} mins</td>
            </tr>
            <tr>
                <td>Bids</td>
                <td>Min: {{$currentLeague->rule->min_bid}} Max: {{$currentLeague->rule->max_bid}}</td>
            </tr>
            <tr>
                <td>Selection</td>
                <td>Random: {{($currentLeague->rule->randomizer == "Y") ? "Yes" : "No"}} <br/>Auto-Select: {{($currentLeague->rule->auto_select == 'Y') ? "Yes" : "No"}} 
                @if(!is_null($currentLeague->rule->auction_movie_release))
                <br/>Grouped: {{$currentLeague->rule->auction_movie_release}}
                @endif</td>
            </tr>
            <tr>
                <td>Blind</td>
                <td>{{$currentLeague->rule->blind_bid == "Y" ? "Yes" : "No"}}</td>
            </tr>
            <tr>
                <td>Misc</td>
                <td>Timeout: {{$currentLeague->rule->auction_timeout}} mins <br/>Denomination: {{$currentLeague->rule->denomination}} <br/>Movie Takings: {{$currentLeague->rule->movie_takings_duration}} weeks</td>
            </tr>
        </table>
    <br/>
    <h2>Movies</h2>
    <p>This is a list of all movies that are to be played for in this league.</p>
    @if($currentLeague->movies->count() > 0)

    <?php $movieCnt = 0; ?>
    <ul id="movie-badge" class="clearfix">
    @foreach($movies as $movie)
        @if(($movieCnt % 4) == 0 && $movieCnt != 0)
        <li class="last">
        @else
        <li>
        @endif
        
        @if($movie->Media->count() > 0)
            @foreach($movie->Media as $media)
                @if($media->type == 'I')
                <img src="{{$media->file_name}}" alt="{{$media->description}}" width="100px"/>
                <br/>
                @endif
            @endforeach
        @endif
        <a href="{{URL('movie-knowledge', [$movie->id])}}">{{$movie->name}}</a>
        @if($movie->opening_bid != 0)
        <br/>Opening Bid: <strong>${{$movie->opening_bid}}</strong>
        @endif
        </li>
        <?php $movieCnt++;?>
    @endforeach
        </ul>
    @endif
    @endif
</section>

<?php function auctionTimer ($auctionid, $auctionTime, $name='bid_link') { ?>
    <div id="{{$name}}<?php echo $auctionid; ?>"></div>
    <script type="text/javascript">
      $('#{{$name}}<?php echo $auctionid; ?>').countdown('<?php echo $auctionTime; ?>', function(event) {
        <?php 
        //if auction finish time - current time is over an hour then show the hour not just the minute
        if (strtotime($auctionTime) - time() > 3600) { ?>
        $(this).html(event.strftime('%-H:%-M:%S'));
        <?php } else { ?>
        $(this).html(event.strftime('%-M:%S'));
        <?php } ?>
        if(event.elapsed) {
            $('#{{$name}}_{{$auctionid}}').val = "ENDED";
        }
      });
    </script>
<?php } ?>

@endsection
