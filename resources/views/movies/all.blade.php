@extends('layouts.admin')

@section('content')
                    <div class="content">
                        <div class="module">
                            <div class="module-head">
                                <h3>Movies Database</h3>
                            </div>
                            <div class="module-body table">
                                <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped  display" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Summary</th>
                                            <th>Genre</th>
                                            <th>Rating</th>
                                            <th>Budget</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $movieCnt = 1; ?>
                                        @foreach($movies as $movie)
                                        <tr class="<?php echo (($movieCnt++ % 2) == 0) ? "odd" : "even"; ?> rating{{$movie->rating}}">
                                            <td>{{$movie->name}}</td>
                                            <td>{{$movie->summary}}</td>
                                            <td>{{$movie->genre}}</td>
                                            <td class="center">{{$movie->rating}}</td>
                                            <td class="center">{{$movie->budget}}</td>
                                            <td><a class="btn btn-mini btn-primary" href="{{URL('movies', array($movie->id))}}">Edit</a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
<!--/.content-->
@endsection