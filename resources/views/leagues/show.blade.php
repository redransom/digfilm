@extends('layouts.admin')

@section('content')
                    <div class="module">
                        <div class="module-head">
                            <h3>{{$league->name}}</h3>
                        </div>
                        <dl class="dl-horizontal">
                            <dt>Owned By</dt>
                            <dd>{{$league->Owner->name}}</dd>
                            <dt>Started</dt>
                            <dd>{{date("j M y", strtotime($league->created_at))}}</dd>
                        </dl>
                    </div>

                    <div class="module">
                        <div class="module-head">
                            <h3>Players</h3>
                        </div>

                        <div class="module-body">
                        @if(!empty($players))
                        <ul class="unstyled">
                        @foreach ($players as $player)
                            @if(!is_null($player->forenames))
                            <li><a href="{{URL('users', array('id'=>$player->id))}}">{{$player->forenames}} {{$player->surname}}</li>
                            @else
                            <li><a href="{{URL('users', array('id'=>$player->id))}}">{{$player->name}}</li>
                            @endif
                        @endforeach
                        </ul>
                        @else
                        <p>The league has no players currently. </p>
                        @endif
                        <ul class="inline">
                            <li><a href="{{URL('league-add-player', array('id'=>$league->id))}}">Add Player</a></li>
                        </ul>
                        </div>
                    </div>

                    <div class="module">
                        <div class="module-head">
                            <h3>Rules</h3>
                        </div>

                        <div class="module-body">
                        @if(!is_null($league->rule))

                        @else
                        <p>No rules have been selected so far - go to the <a href="{{URL('leagues/'.$league->id.'/edit')}}">Edit League</a> page</p>
                        @endif
                        </div>
                    </div>

                    <div class="module">
                        <div class="module-head">
                            <h3>Available Movies</h3>
                        </div>

                        <div class="module-body">
                            @if($league->Movies->count() > 0)
                            <ul class="inline">
                            @foreach($league->Movies as $movie)
                                <li>{{$movie->pivot->id}}: {{$movie->name}} <a href="{{URL('league-remove-movie', array($movie->pivot->id))}}">x</a></li>
                            @endforeach
                            </ul>
                            @else
                            <p>There are no movies associated with this league presently.</p>
                            @endif
                            <p>TODO: I'd like to make this free entry population much like tags.</p>
                            <ul class="inline">
                                <li><a href="{{URL('league-add-movie', array('id'=>$league->id))}}">Add Movie</a></li>
                            </ul>
                        </div>
                    </div>
@endsection