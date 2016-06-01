@if($auctions->count() > 0)
<h2>{{$tableTitle}}</h2>
<style>
    td.bid--placed span {
        background-color: #BF1C29 !important;
        color: #fff;
        font-weight: bold;
        padding: 5% 12%  !important;
        border-radius: 0.3em !important;
    }

    table#expire img {
        min-width: 75% !important;
    }

    table#expire td {
        font-size: 0.8em;
    }
</style>
<table class="feature-table dark-gray" id="expire">
    <thead>
        <tr><th width="11%">&nbsp;</th><th width="30%">Movie</th><th width="12%">Release Date</th><th width="15%">Opening<br/>Bid</th><th width="15%">Final Price/<br/>$ USD</th><th width="15%">Owner</th></tr>
    </thead>
    <tbody>
    
    <?php $movieCnt = 1; ?>
    @foreach($auctions as $auction)
        <tr>
        @if(!is_null($auction->topImage('A')))
        <td><img src='{{asset($auction->topImage("A")->file_name)}}'/></td>
        @else
        <td><img src="{{asset('images/TNBF.jpg')}}"/></td>
        @endif
        <td>
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