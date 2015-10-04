@extends('layouts.admin')

@section('content')
                    <div class="content">
                        <div class="module">
                            <div class="module-head">
                                <h3>Auctions</h3>
                                <p></p>
                            </div>
                            <div class="module-body table">
                                <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped  display" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Movies</th>
                                            <th>Start?</th>
                                            <th>Owned By</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $auctionCnt = 1; 
                                        $leagueName = "";

                                        ?>
                                        @foreach($auctions as $auction)
                                        <tr class="<?php echo (($auctionCnt++ % 2) == 0) ? "odd" : "even"; ?> user{{$auction->users_id}}">
                                            <td><a href="{{URL('auctions', array('id'=>$auction->id))}}">{{$auction->name}}</a></td>
                                            <td>{{count($auction->players)}}</td>
                                            <td>{{$start}}</td>
                                            <td class="center"><a href="{{URL('users/'.$auction->owner->id)}}">{{$auction->owner->name}}</a></td>
                                            <td>
                                            <a class="btn btn-mini btn-primary" href="{{URL('auctions/'.$auction->id.'/edit')}}">Edit</a>
                                            @if($auction->enabled)
                                            <a class="btn btn-mini btn-danger" href="{{URL('auctions/'.$auction->id.'/disable')}}">Disable</a>
                                            @else
                                            <a class="btn btn-mini btn-info" href="{{URL('auctions/'.$auction->id.'/enable')}}">Enable</a>
                                            @endif
                                            @if(!is_null($auction->rule))
                                            <a class="btn btn-mini btn-inverse" href="{{URL('auctions/'.$auction->id.'/rules')}}">Rules</a>
                                            @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="pagination pagination-centered">
                                    <?php echo $auctions->render(); ?>
                                </div>
                        </div>
                    </div>
<!--/.content-->
@endsection