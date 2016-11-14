<div class="content-padding">
@if($currentLeague->auctions()->where('ready_for_auction', 1)->count() > 0)
<p>See a list of movies you can bid on:</p>
<style>
    td.bid--placed span {
        background-color: #BF1C29 !important;
        color: #fff;
        font-weight: bold;
        padding: 5% 12%  !important;
        border-radius: 0.3em !important;
    }

    .feature-table img {
        max-width: 58px !important;
        max-height: 80px !important;
        min-width: 58px !important;
        min-height: 80px !important;
    }

    .feature-table td {
        font-size: 0.9em;
    }
</style>
<table class="feature-table dark-gray">
    <thead>
        <tr>
        <th width="12%">&nbsp;</th><th width="40%">Movie</th><th width="10%">Release Date</th>
        <th width="12%">Your Bid</th>
        <th width="31%">Place Bid</th>
        </tr>
    </thead>
    <tbody>
    <?php $movieCnt = 1; ?>
    @foreach($currentLeague->auctions()->where('ready_for_auction', 1)->orderBy('name', 'asc')->get() as $auction)
        <tr>
        @if(!is_null($auction->firstImage()))
        <td align="center"><img src='{{asset($auction->firstImage()->file_name)}}'/></td>
        @else
        <td align="center"><img src="{{asset('images/TNBF_league_image.jpg')}}"/></td>
        @endif
        <td>
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
            <td class="bid--placed">PLACED</td>
            @elseif( $leagueUser->balance > 0)
            <td id="bid_link_{{$auction->pivot->id}}" class="public place--bid">
                <a href="#poppup-open-bid_link{{$auction->pivot->id}}" class="popup league-btn">BID</a>
            <div id="poppup-open-bid_link{{$auction->pivot->id}}" class="mfp-hide white-popup">   
                @include('partials.user-auction-bid', ['rule'=>$currentLeague->rule, 'auction'=>$auction, 'leagueUser'=>$leagueUser])
            </div></td>
            @else
            <td>NO MONEY</td>
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