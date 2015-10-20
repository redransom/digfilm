@extends('layouts.admin')

@section('content')
                    <div class="content">
                        <div class="module">
                            <div class="module-head">
                                <h3>Movies Database</h3>
                            </div>
                            
                            <div class="module-body">
                                <a class="btn" href="{{route('movies.create')}}">Add Movie</a>
                            </div>
                            
                            <div class="module-body table">
                                

                                <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped  display" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="25%">Name</th>
                                            <th width="10%">Genre</th>
                                            <th width="12%">Release Dt</th>
                                            <th width="12%">Close Dt</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $movieCnt = 1; ?>
                                        @foreach($movies as $movie)
                                        <tr class="<?php echo (($movieCnt++ % 2) == 0) ? "odd" : "even"; ?> rating{{$movie->rating}}">
                                            <td><a href="{{URL('movies', array('id'=>$movie->id))}}">{{$movie->name}}</a></td>
                                            <td>{{$movie->genre->name}}</td>
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
                                            <td><a class="btn btn-mini btn-primary" href="{{URL('movies/'.$movie->id.'/edit')}}">Edit</a>
                                            <a class="btn btn-mini btn-inverse" href="{{URL('movie-add-takings/'.$movie->id)}}">Add Takings</a>
                                            <a class="btn btn-mini btn-success" href="{{URL('movie-add-media/'.$movie->id)}}">Add Media</a>
                                            @if($movie->enabled)
                                            <a class="btn btn-mini btn-danger" href="{{URL('movies/'.$movie->id.'/disable')}}">Disable</a>
                                            @else
                                            <a class="btn btn-mini btn-info" href="{{URL('movies/'.$movie->id.'/enable')}}">Enable</a>
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