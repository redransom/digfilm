@if($currentLeague->auctions->where('ready_for_auction', 2)->count() > 0)
<h2>Expired Auctions</h2>

<table class="feature-table dark-gray">
    <thead>
        <tr><th>Movie</th><th>Release Date</th><th>Opening<br/>Bid</th><th>Final Price/<br/>$ USD</th><th>Owner</th></tr>
    </thead>
    <tbody>
    
    @foreach($currentLeague->auctions()->where('ready_for_auction', 2)->orderBy('name', 'asc')->get() as $auction)
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
        @if($auction->pivot->users_id != 0)
        <td>{{$players[$auction->pivot->users_id]}}</td>
        @else
        <td>&nbsp;</td>
        @endif
        </tr>
    @endforeach
    </tbody>
</table>
@endif