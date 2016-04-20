
@if($currentLeague->auctions()->where('ready_for_auction', 1)->count() > 0)
<p>See a list of movies you can bid on:</p>
<table class="feature-table dark-gray">
    <thead>
        <tr><th>&nbsp;</th>
        <th><a href="{{Route('league-play', ['id' => $currentLeague->id, 'col'=>'name', 'order'=> (($order == 'asc') ? 'desc' : 'asc')])}}">Movie</a></th>
        <th><a href="{{Route('league-play', ['id' => $currentLeague->id, 'col'=>'release_at', 'order'=> (($order == 'asc') ? 'desc' : 'asc')])}}">Release Date</a></th>
        <th>Opening<br/>Bid</th>
        <th>Current Price /<br/>$ USD</th>
        <th>Place Bid</th>
        <th>Owner</th>
        <th><a href="{{Route('league-play', ['id' => $currentLeague->id, 'col'=>'auction_end_time', 'order'=> (($order == 'asc') ? 'desc' : 'asc')])}}">Time</a></th>
    </thead>
    <tbody>
    <?php $movieCnt = 1; ?>
    @foreach($currentLeague->auctions()->where('ready_for_auction', 1)->orderBy($col, $order)->get() as $auction)
        <tr>
        @if(!is_null($auction->firstImage()))
        <td><img src='{{asset($auction->firstImage()->file_name)}}' width="100px"/></td>
        @else
        <td>&nbsp;</td>
        @endif
        <td><a href="{{URL('movie-knowledge', [$auction->link()])}}">{{$auction->name}}</a></td>
        <td>{{date("j-M-y", strtotime($auction->release_at))}}</td>

        @if(is_null($auction->pivot->initial_bid))
        <td></td>
        @else
        <td>{{$auction->pivot->initial_bid}}</td>
        @endif

        <td>{{$auction->pivot->bid_amount}}</td>

        @if($auction->pivot->ready_for_auction == 1 && strtotime($auction->pivot->auction_end_time) > time())
            @if($auction->pivot->users_id == $authUser->id)
            <td class="bid--placed">PLACED</td>
            @elseif ($leagueUser->balance > 0 && (is_null($auction->pivot->bid_amount) || $auction->pivot->bid_amount < $currentLeague->rule->max_bid) && ($leagueUser->balance > $auction->pivot->bid_amount))
            <td id="bid_link{{$auction->pivot->id}}" class="public place--bid"><!--a href="{{URL('place-bid', [$auction->pivot->id])}}" class="popup1"--><a href="#poppup-open-bid_link{{$auction->pivot->id}}" class="popup league-btn">PLACE BID</a>
            <div id="poppup-open-bid_link{{$auction->pivot->id}}" class="mfp-hide white-popup">   
                 @include('partials.user-auction-bid', ['rule'=>$currentLeague->rule, 'movie'=>$auction])
            </div>
            </td>
            @elseif($leagueUser->balance > 0 && (!is_null($auction->pivot->bid_amount) || $auction->pivot->bid_amount >= $currentLeague->rule->max_bid))
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
            
        @endif
        </tr>
    @endforeach
    </tbody>
</table>
@else
<h3>There are no auctions left in this league.</h3>
@endif