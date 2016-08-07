@if($currentLeague->rosters()->count() > 0)
    <style>
        .feature-table img {
            max-width: 58px !important;
            max-height: 80px !important;
        }

        .feature-table td {
            font-size: 0.8em;
        }
    </style>
<table class="feature-table dark-gray">
    <thead>
        <tr><th width="15%">&nbsp;</th><th width="40%">Movie</th><th width="15%">Release<br/>Date</th><th width="15%">Amount Bid</th><th width="15%">Total Gross</th><th width="15%">Value For Money</th></tr>
    </thead>
    <tbody>
    <?php
        $total_gross = 0;
        $bid = 0;
    ?>
    @foreach($currentLeague->rosters()->where('users_id', $authUser->id)->get() as $roster_line)
        <?php
        $total_gross += $roster_line->total_gross;
        $bid += $roster_line->bid_amount;
        ?>
        <tr>
        @if(!is_null($roster_line->movie->firstImage()))
        <td><img src='{{asset($roster_line->movie->firstImage()->file_name)}}'/></td>
        @else
        <td><img src="{{asset('images/TNBF_league_image.jpg')}}"/></td>
        @endif
        <td>
        @if(is_null($roster_line->movie->slug) || $roster_line->movie->slug == '')
        <a href="{{URL('movie-knowledge', [$roster_line->movie->id])}}">
        @else
        <a href="{{URL('movie-knowledge', [$roster_line->movie->slug])}}">
        @endif{{$roster_line->movie->name}}</a></td>
        <td>{{date("j-M-y", strtotime($roster_line->movie->release_at))}}</td>
        <td align="right">${{$roster_line->bid_amount}}</td>
        <td align="right">${{number_format($roster_line->total_gross, 0, ".", ",")}}</td>
        <td align="right">{{number_format($roster_line->value_for_money, 2)}}</td>
        </tr>
    @endforeach
        <?php $vfm = ($bid != 0) ? (($total_gross / $bid) / 100000) : 0;?>
        <tr><td colspan="3">Totals</td><td align="right"><strong>${{number_format($bid, 2)}}</strong></td>
        <td align="right"><strong>${{number_format($total_gross, 0, ".", ",")}}</strong></td><td align="right"><strong>{{number_format($vfm, 2)}}</strong></td></tr>        
    </tbody>
</table>
@endif