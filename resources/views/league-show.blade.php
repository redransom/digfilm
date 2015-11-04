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
    
    @include('partials.user-expired-auctions', ['currentLeague'=>$currentLeague, 'players'=>$players, 'leagueUser'=>$currentLeagueUser])

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
        $(this).html(event.strftime('%-M:%S'));
        if(event.elapsed) {
            $('#{{$name}}_{{$auctionid}}').val = "ENDED";
        }
      });
    </script>
<?php } ?>

@endsection
