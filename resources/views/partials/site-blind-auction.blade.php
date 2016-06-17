<div class="content-padding">
@if($currentLeague->auctions()->where('ready_for_auction', 1)->count() > 0)
<p>See a list of movies you can bid on:</p>
<table class="feature-table dark-gray">
    <thead>
        <tr>
        <th>&nbsp;</th><th>Movie</th><th>Release Date</th>
        <th>Your Bid</th>
        <th>Place Bid</th>
        </tr>
    </thead>
    <tbody>
    <?php $movieCnt = 1; ?>
    @foreach($currentLeague->auctions()->where('ready_for_auction', 1)->orderBy('name', 'asc')->get() as $auction)
        <tr><td>{{($movieCnt++)}}</td><td>
        <a href="{{URL('movie-knowledge', [$auction->link()])}}">{{$auction->name}}</a></td>
        <td>{{date("j-M-y", strtotime($auction->release_at))}}</td>

        @if(isset($previousBids) && isset($previousBids[$auction->pivot->id]))
        <td>{{$previousBids[$auction->pivot->id]}}</td>
        @else
        <td>&nbsp;</td>
        @endif

        @if($auction->pivot->ready_for_auction == 1)

            <!-- Need to determine if logged in user can bid -->
            @if($auction->bids()->where('users_id', $authUser->id)->where('auctions_id', $auction->pivot->id)->count() > 0)
            <td>PLACED</td>
            @else
            <td id="bid_link_{{$auction->pivot->id}}"><a href="{{URL('place-bid', [$auction->pivot->id])}}" class="popup">PLACE BID</a></td>
            @endif
        @else
        <td>ENDED</td>
        @endif

        </tr>
    @endforeach
    </tbody>
</table>
@else
<h3>There are no auctions left in this league.</h3>
@endif
</div>