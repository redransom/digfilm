@if($currentLeague->auctions()->where('ready_for_auction', 3)->count() > 0)

<table class="feature-table dark-gray">
    <thead>
        <tr><th>Movie</th><th>Date</th><th>Amount Bid/</th><th>Opening Value</th><th>Total Gross</th><th>Value For Money</th></tr>
    </thead>
    <tbody>
    
    @foreach($currentLeague->auctions()->where('users_id', $authUser->id)->orderBy('name', 'asc')->get() as $auction)
        <?php
        //total gross can be retrieved by the movie with the end date of the movie
        //value is based on total gross / bid amount / 100,000

        $takings = 1;
        if ($auction->takings->count() > 0) {
            $takings = $auction->takings->sum('amount');
            $takings *= 1000000;
        }

        $value = ($takings * $auction->pivot->bid_amount) / 100000;
        ?>
        <tr><td>
        @if(is_null($auction->slug) || $auction->slug == '')
        <a href="{{URL('movie-knowledge', [$auction->id])}}">
        @else
        <a href="{{URL('movie-knowledge', [$auction->slug])}}">
        @endif{{$auction->name}}</a></td>
        <td>{{date("j-M-y", strtotime($auction->release_at))}}</td>
        @if(is_null($auction->pivot->initial_bid))
        <td></td>
        @else
        <td>${{$auction->pivot->initial_bid}}</td>
        @endif
        <td>${{$auction->pivot->bid_amount}}</td>
        @if($auction->pivot->users_id != 0)
        @else
        <td>&nbsp;</td>
        @endif
        <td>${{number_format($takings, 0, ".", ",")}}</td>
        <td>{{number_format($value, 2)}}</td>
        </tr>
    @endforeach
        
    </tbody>
    <tfoot>
        <tr style="border-top: 1px solid #000"><td colspan="2">Totals</td><td>${{$currentLeague->auctions()->where('users_id', $authUser->id)->sum('bid_amount')}}</td>
        <td colspan="2">$0.00</td><td>0.00</td></tr>
    </tfoot>
</table>
@endif