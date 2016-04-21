@extends('layouts.admin')

@section('content')
                    <div class="content">
                        <div class="module">
                            <div class="module-head">
                                <h3>Movies Database</h3>
                            </div>
                            
                            <div class="module-option clearfix">
                                <div class="input-append pull-left">
                                     <a class="btn" href="{{route('movie.create')}}">Add Movie</a>
                                </div>
                                <div class="btn-group pull-right" data-toggle="buttons-radio">
                                    <a class="btn" href="{{URL('movies/all')}}">All</a>
                                    <a class="btn" href="{{URL('movies/1')}}">Enabled</a>
                                    <a class="btn" href="{{URL('movies/0')}}">Disabled</a>
                                </div>
                            </div>
                            
                            <div class="module-body table">
                                

                                <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped  display" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="25%"><a href="{{URL('movies/'.$status.'/name/'.(($order == 'asc') ? 'desc' : 'asc'))}}">Name</a></th>
                                            <th width="10%"><a href="{{URL('movies/'.$status.'/opening_bid/'.(($order == 'asc') ? 'desc' : 'asc'))}}">Opening<br/>Bid</a></th>
                                            <th width="13%"><a href="{{URL('movies/'.$status.'/release_at/'.(($order == 'asc') ? 'desc' : 'asc'))}}">Release Dt</a></th>
                                            <th width="13%"><a href="{{URL('movies/'.$status.'/takings_close_date/'.(($order == 'asc') ? 'desc' : 'asc'))}}">Close Dt</a></th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $movieCnt = 1; ?>
                                        @foreach($movies as $movie)
                                        <tr class="<?php echo (($movieCnt++ % 2) == 0) ? "odd" : "even"; ?> rating{{$movie->rating}}">
                                            <td><a href="{{URL('movie-show', array('id'=>$movie->id))}}">{{$movie->name}}</a></td>
                                            @if(!is_null($movie->opening_bid))
                                            <td>{{$movie->opening_bid}}</td>
                                            @else
                                            <td>0.00</td>
                                            @endif
                                            @if(is_null($movie->release_at))
                                            <td></td><td></td>
                                            @else
                                            <td>{{date("j M Y", strtotime($movie->release_at))}}</td>
                                            @if(is_null($movie->takings_close_date))
                                            <td>{{date("j M Y", strtotime($movie->release_at."+2 month"))}}</td>
                                            @else
                                            <td>{{date("j M Y", strtotime($movie->takings_close_date))}}</td>
                                            @endif
                                            @endif
                                            <td><a class="btn btn-mini btn-primary" href="{{URL('movie/'.$movie->id.'/edit')}}">Edit</a>
                                            <a class="btn btn-mini btn-inverse" href="{{URL('movie/'.$movie->id.'/takings')}}">Add Takings</a>
                                            <a class="btn btn-mini btn-success" href="{{URL('movie/'.$movie->id.'/media')}}">Add Media</a>
                                            @if($movie->enabled)
                                            <a class="btn btn-mini btn-danger" href="{{URL('movie-disable/'.$movie->id)}}">Disable</a>
                                            @else
                                            <a class="btn btn-mini btn-info" href="{{URL('movie-enable/'.$movie->id)}}">Enable</a>
                                            @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="pagination pagination-centered">
                                    <!-- <ul>
                                        <li><a href="#"><i class="icon-double-angle-left"></i></a></li>
                                        <li><a href="#">1</a></li>
                                        <li><a href="#">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li><a href="#"><i class="icon-double-angle-right"></i></a></li>
                                    </ul> -->
                                    <?php echo $movies->render(); ?>
                                </div>
                        </div>
                    </div>
<!--/.content-->
@endsection