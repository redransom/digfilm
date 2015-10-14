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

    <table class="feature-table dark-gray">
        <thead>
            <tr><th>Movie</th><th>Release Date</th><th>Opening<br/>Bid</th><th>Current Price /<br/>$ USD</th><th>Place Bid</th><th>Owner</th><th>Time</th><th>Active</th></tr>
        </thead>
        <tbody>
        
        @foreach($currentLeague->auctions()->orderBy('name', 'asc')->get() as $auction)
            <tr><td>
            @if(is_null($auction->slug) || $auction->slug == '')
            <a href="{{URL('movie-knowledge', [$auction->id])}}">
            @else
            <a href="{{URL('movie-knowledge', [$auction->slug])}}">
            @endif{{$auction->name}}</a></td>
            <td>{{date("j-M-y", strtotime($auction->release_at))}}</td>
            @if(is_null($auction->pivot->opening_bid))
            <td></td>
            @else
            <td>{{$auction->pivot->opening_bid}}</td>
            @endif
            <td>{{$auction->pivot->bid_amount}}</td>
            @if($auction->pivot->users_id == $authUser->id)
            <td>PLACED</td>
            @else
            <td id="bid_link_{{$auction->pivot->id}}"><a href="{{URL('place-bid', [$auction->pivot->id])}}" class="popup">PLACE BID</a></td>
            @endif
            @if($auction->pivot->users_id != 0)
            <td>{{$players[$auction->pivot->users_id]}}</td>
            @else
            <td>&nbsp;</td>
            @endif
            <td><?php auctionTimer($auction->pivot->id, $currentLeague->auction_close_date,  $auction->pivot->auction_end_time); ?></td>
            @if($auction->pivot->ready_for_auction == 1)
            <td>Yes</td>
            @else
            <td>No</td>
            @endif
            </tr>
        @endforeach
        </tbody>
    </table>
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

<?php function auctionTimer ($auctionid, $auctionDate, $auctionTime) { ?>
    <div id="timer<?php echo $auctionid; ?>"></div>
    <script type="text/javascript">
      $('#timer<?php echo $auctionid; ?>').countdown('<?php echo date("Y-m-d", strtotime($auctionDate))." ".$auctionTime; ?>', function(event) {
        $(this).html(event.strftime('%-H:%M:%S'));
        if(event.elapsed) {
            $('#bid_link_{{$auctionid}}').val = "ENDED";
        }
      });
    </script>
<?php } ?>

@endsection
