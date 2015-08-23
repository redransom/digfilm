@extends('layouts.admin')

@section('content')
                    <div class="content">
                        <div class="module">
                            <div class="module-head">
                                <h3>{{$movie->name}}</h3>
                            </div>
                            <dl class="dl-horizontal">
                                <dt>Summary</dt>
                                <dd>{{$movie->summary}}</dd>
                                <dt>Genre</dt>
                                <dd>{{$movie->genre}}</dd>
                                <dt>Rating</dt>
                                <dd>{{$movie->rating}}</dd>
                                <dt>Budget</dt>
                                <dd>${{$movie->budget}} million</dd>
                            </dl>

                            <div class="module-head">
                                <h3>Contributors</h3>
                            </div>

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
                    </div>
<!--/.content-->
@endsection