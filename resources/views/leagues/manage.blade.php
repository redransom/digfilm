@extends('layouts.users')

@section('content')
                    <div class="module">
                        <div class="module-head">
                            <h3>{{$league->name}}</h3>
                        </div>
                        <dl class="dl-horizontal">
                            <dt>Days left till start of auction</dt>
                            <dd></dd>
                        </dl>
                    </div>

                    <div class="module">
                        <div class="module-head">
                            <h3>Players</h3>
                        </div>

                        <div class="module-body">
                        @if(!empty($league->players))
                        <ul class="unstyled">
                        @foreach ($league->players as $player)
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
                            {{var_dump($league->rule)}}
                        </div>
                    </div>

                    <div class="module">
                        <div class="module-head">
                            <h3>Available Movies</h3>
                        </div>

                        <div class="module-body">
                            @if($league->movies->count() > 0)
                            <ul class="inline">
                            @foreach($league->movies as $movie)
                                <li>{{$movie->pivot->id}}: {{$movie->name}} <a href="{{URL('league-remove-movie', array($movie->pivot->id))}}">x</a></li>
                            @endforeach
                            </ul>
                            @else
                            <p>There are no movies associated with this league presently.</p>
                            @endif
                            <ul class="inline">
                                <li><a href="{{URL('league-add-movie', array('id'=>$league->id))}}">Add Movie</a></li>
                            </ul>
                        </div>
                    </div>
@endsection