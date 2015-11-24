@if($auctions->count() > 0)
<h2>{{$tableTitle}}</h2>

<table class="feature-table dark-gray">
    <thead>
        <tr><th>&nbsp;</th><th>Movie</th><th>Release Date</th><th>Opening<br/>Bid</th><th>Final Price/<br/>$ USD</th><th>Owner</th></tr>
    </thead>
    <tbody>
    
    <?php $movieCnt = 1; ?>
    @foreach($auctions as $auction)
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