@extends('layouts.admin')

@section('content')
                    <div class="content">
                        <div class="module">
                            <div class="module-head">
                                <h3>{{$movie->name}}</h3>
                            </div>
                            <div class="module-body">
                                <dl class="dl-horizontal">
                                    <dt>Summary</dt>
                                    <dd>{{$movie->summary}}</dd>
                                    <dt>Genre</dt>
                                    <dd>{{$movie->genre}}</dd>
                                    <dt>Rating</dt>
                                    <dd>{{$movie->rating}}</dd>
                                    <dt>Budget</dt>
                                    <dd>${{$movie->budget}} million</dd>
                                    <dt>Release Date</dt>
                                    <dd>{{$movie->release_at}}</dd>
                                </dl>
                                <ul class="inline">
                                    <li><a href="{{URL('movies/'.$movie->id.'/edit')}}">Edit Movie</a></li>
                                </ul>
                            </div>
                            <div class="module-head">
                                <h3>Contributors</h3>
                            </div>

                            <div class="module-body">
                                <dl class="dl-horizontal">
                                    @foreach($movie->contributors as $contributor)
                                    <dt>{{$contributor->first_name}} {{$contributor->surname}}</dt>
                                    <dd>{{$types[$contributor->pivot->contributor_types_id]}}</dd>
                                    @endforeach
                                </dl>
                                <p>NOTE: I'd like to be able to have this as a free text field that adds a line with the contributor type.
                                <br/> I'll have a look into it but for getting this out quickly I'll make it a standard entry page for now.</p>
                                <ul class="inline">
                                    <li><a href="{{URL('movie-add-contributor', array('id'=>$movie->id))}}">Add Contributor</a></li>
                                </ul>
                            </div>

                            <div class="module-head">
                                <h3>Media</h3>
                            </div>
                            <div class="module-body">

                                @if($movie->media->count() > 0)


                                @else
                                <p>There are no media files/links for this movie currently.</p>
                                @endif
                            </div>

                            <div class="module-head">
                                <h3>Takings History</h3>
                            </div>
                            <div class="module-body">

                                @if($movie->takings->count() > 0)


                                @else
                                <p>No takings have been recorded for this movie currently.</p>
                                @endif
                                <ul class="inline">
                                    <li><a href="{{URL('movie-add-takings', array('id'=>$movie->id))}}">Add Takings</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
<!--/.content-->
@endsection