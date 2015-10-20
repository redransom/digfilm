@extends('layouts.admin')

@section('content')
                    <div class="content">
                        <div class="module">
                            <div class="module-head">
                                <h3>Auctions</h3>
                            </div>
                            <div class="module-body table">
                                <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped  display" width="100%">
                                    <thead>
                                        <tr>
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
                                        ?>
                                        @foreach($leagues as $league)
                                            <?php $players = $league->players->lists('name', 'id'); ?>
                                        <tr>
                                            <td colspan="8">{{$league->name}}</td>
                                        </tr>
                                            @foreach($league->auctions as $auction)

                                        <tr class="<?php echo (($auctionCnt++ % 2) == 0) ? "odd" : "even"; ?> user{{$auction->users_id}}">
                                            <td><a href="{{URL('auctions', array('id'=>$auction->id))}}">{{$auction->name}}</a></td>
                                            @if($auction->pivot->users_id != 0)
                                            <td>{{$players[$auction->pivot->users_id]}}</td>
                                            @else
                                            <td></td>
                                            @endif
                                            <td>{{$auction->pivot->opening_bid}}</td>
                                            <td>{{$auction->pivot->bid_amount}}</td>
                                            <td>{{date("j M Y H:i", strtotime($auction->pivot->auction_start_time))}}</td>
                                            <td>{{date("j M Y H:i", strtotime($auction->pivot->auction_end_time))}}</td>
                                            @if(strtotime($auction->pivot->updated_at) == strtotime($auction->pivot->created_at)) 
                                            <td>--</td>
                                            @else
                                            <td>{{date("H:i:s", strtotime($auction->updated_at))}}</td>
                                            @endif
                                            <td>
                                            @if($auction->pivot->ready_for_auction == 1)
                                            <a class="btn btn-mini btn-inverse" href="{{URL('auction-close/'.$auction->pivot->id)}}">End</a>
                                            @else
                                            Ended
                                            @endif
                                            </td>
                                        </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
<!--/.content-->
@endsection