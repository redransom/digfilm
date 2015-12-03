
@if($currentLeague->auctions()->where('ready_for_auction', 1)->count() > 0)
<p>See a list of movies you can bid on:</p>
<table class="feature-table dark-gray">
    <thead>
        <tr><th>No</th><th>Movie</th><th>Release Date</th><th>Opening<br/>Bid</th><th>Current Price /<br/>$ USD</th><th>Place Bid</th><th>Owner</th><th>Time</th><th>Active</th></tr>
    </thead>
    <tbody>
    <?php $movieCnt = 1; ?>
    @foreach($currentLeague->auctions()->where('ready_for_auction', 1)->orderBy('name', 'asc')->get() as $auction)
        <tr><td>{{($movieCnt++)}}</td><td>
        @if(is_null($auction->slug) || $auction->slug == '')
        <a href="{{URL('movie-knowledge', [$auction->id])}}">
        @else
        <a href="{{URL('movie-knowledge', [$auction->slug])}}">
        @endif{{$auction->name}}</a></td>

        <td>{{date("j-M-y", strtotime($auction->release_at))}}</td>

        @if(is_null($auction->pivot->initial_bid))
        <td></td>
        @else
        <td>{{$auction->pivot->initial_bid}}</td>
        @endif

        <td>{{$auction->pivot->bid_amount}}</td>

        @if($auction->pivot->ready_for_auction == 1 && strtotime($auction->pivot->auction_end_time) > time())
            @if($auction->pivot->users_id == $authUser->id)
        <td>PLACED</td>
            @elseif ($leagueUser->balance > 0 && $auction->pivot->bid_amount < $currentLeague->rule->max_bid)
        <td id="bid_link_{{$auction->pivot->id}}"><a href="{{URL('place-bid', [$auction->pivot->id])}}" class="popup">PLACE BID</a></td>
            @elseif($leagueUser->balance > 0 && $auction->pivot->bid_amount >= $currentLeague->rule->max_bid)
        <td>MAX BID</td>
            @else
        <td>NO MONEY</td>
            @endif
        @else
        <td>ENDED</td>
        @endif

        @if($auction->pivot->users_id != 0)
        <td>{{$players[$auction->pivot->users_id]}}</td>
        @else
        <td>&nbsp;</td>
        @endif
        @if($auction->pivot->ready_for_auction == 1)

        @if(strtotime($auction->pivot->updated_at) > strtotime('-10 seconds') && $auction->pivot->users_id != $authUser->id)
        <td style="background-color: #f00">CHANGE<?php auctionTimer($auction->pivot->id, $auction->pivot->auction_end_time); ?></td>
        @else
        <td><?php auctionTimer($auction->pivot->id, $auction->pivot->auction_end_time); ?></td>
        @endif
        
        @else
        <td>&nbsp;</td>
        @endif
        @if($auction->pivot->ready_for_auction == 1)
        <td>Yes</td>
        @else
        <td>No</td>
        @endif
        </tr>
    @endforeach
    </tbody>
</table>
@else
<h3>There are no auctions left in this league.</h3>
@endif