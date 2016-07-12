@extends('layouts.admin')

@section('content')
                    <div class="content">
                        <div class="module">
                            <div class="module-head">
                                <h3>{{$title}}</h3>
                            </div>
                            <div class="module-body table">
                                <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped  display" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Movie</th>
                                            <th>Bidder</th>
                                            <th>Opening<br/>Bid</th>
                                            <th>Amt</th>
                                            <th>St</th>
                                            <th>Ed</th>
                                            <th>Last<br/>Bid</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $auctionCnt = 1; 
                                        $leagueName = "";
                                        $start = "";
                                        $players = $league->players->lists('name', 'id');?>
                                        @foreach($league->auctions as $auction)
                                        <tr class="<?php echo (($auctionCnt++ % 2) == 0) ? "odd" : "even"; ?> user{{$auction->users_id}}">
                                            <td>
                                            <a href="{{URL('auctions', array('id'=>$auction->pivot->id))}}">{{$auction->pivot->id}}</a></td>
                                            <td><a href="{{URL('auctions', array('id'=>$auction->pivot->id))}}">{{$auction->name}}</a></td>
                                            @if($auction->pivot->users_id != 0)
                                            <td>{{$players[$auction->pivot->users_id]}}</td>
                                            @else
                                            <td></td>
                                            @endif
                                            <td>{{$auction->pivot->initial_bid}}</td>
                                            <td>{{$auction->pivot->bid_amount}}</td>
                                            <td>{{date("j M Y g:iA", strtotime($auction->pivot->auction_start_time))}}</td>
                                            <td>{{date("j M Y g:iA", strtotime($auction->pivot->auction_end_time))}}</td>
                                            @if(strtotime($auction->pivot->updated_at) == strtotime($auction->pivot->created_at)) 
                                            <td>--</td>
                                            @else
                                            <td>
                                            {{!is_null($auction->bids($auction->pivot->id)->max('created_at')) ? date("j M Y g:i:sA", strtotime($auction->bids($auction->pivot->id)->max('created_at'))) : "No Bid"}}</td>
                                            @endif
                                            <td>
                                            @if($auction->pivot->ready_for_auction == 1)
                                            <a class="btn btn-mini btn-inverse" href="{{URL('auction-close/'.$auction->pivot->id)}}">End</a>
                                            @else
                                            Ended
                                            @endif
                                            </td>
                                        </tr>
                                        @if($auction->bids($auction->pivot->id)->count() > 0)
                                        <tr><td colspan="9">
                                            <ul>
                                            @foreach($auction->bids($auction->pivot->id)->orderby('created_at', 'DESC')->get() as $bid)
                                                
                                                <li>{{$bid->bid_amount}} @ {{date("j M Y g:i:sA", strtotime($bid->created_at))}} by {{get_player($players, $bid->users_id)}}</li>
                                                
                                            @endforeach

                                            </ul>
                                        </td></tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
<!--/.content-->
<?php 
function get_player($players, $id) {
    foreach ($players as $player_id => $player_label) {
        if ($player_id == $id)
            return $player_label;
    }
    return $id;
}
?>


@endsection