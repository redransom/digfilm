@extends('layouts.users')

@section('content')
<section class="entry sbr clearfix">
    <div class="title-caption-large">
        <h3>{{$currentLeague->name}} League</h3>
    </div>
    <h2>Auction</h2>
    @if(is_null($currentLeague->auction_start_date))
    <p>The auction will start soon!</p>

    @elseif(strtotime($currentLeague->auction_start_date) > time())
    <p>The auction will start on the <strong>{{date("d M y g:iA", strtotime($currentLeague->auction_start_date))}}</strong>.</p>
    @else
    <?php $players = $currentLeague->players->lists('name', 'id'); ?>
    <p>See a list of movies you can bid on:</p>

    @include('partials.user-auctions', ['currentLeague'=>$currentLeague, 'players'=>$players])
    
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
    <ul>
    @foreach($currentLeague->movies()->orderBy('name', 'asc')->get() as $movie)
        <li><a href="{{URL('movie-knowledge', [$movie->id])}}">{{$movie->name}}</a></li>
    @endforeach
    </ul>
    @endif
    @endif
</section>

<?php function auctionTimer ($auctionid, $auctionTime) { ?>
    <div id="timer<?php echo $auctionid; ?>"></div>
    <script type="text/javascript">
      $('#timer<?php echo $auctionid; ?>').countdown('<?php echo $auctionTime; ?>', function(event) {
        $(this).html(event.strftime('%-H:%M:%S'));
        if(event.elapsed) {
            $('#bid_link_{{$auctionid}}').val = "ENDED";
        }
      });
    </script>
<?php } ?>

@endsection
