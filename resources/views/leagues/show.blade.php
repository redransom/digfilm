@extends('layouts.admin')

@section('content')
                    <div class="module">
                        <div class="module-head">
                            <h3>{{$league->name}}</h3>
                        </div>
                        <div class="module-body">
                            <dl class="dl-horizontal">
                                <dt>Owned By</dt>
                                <dd>{{$league->Owner->name}}</dd>
                                @if(is_null($league->auction_start_date))
                                <dt>Created</dt>
                                <dd>{{date("j M y", strtotime($league->created_at))}}</dd>
                                @elseif(!is_null($league->auction_start_date) && $league->auction_stage < 2)
                                <dt>Due to Start</dt>
                                <dd>{{date("j M y h:iA", strtotime($league->auction_start_date))}}</dd>
                                @else
                                <dt>Started</dt>
                                <dd>{{date("j M y h:iA", strtotime($league->auction_start_date))}}</dd>
                                @endif
                            </dl>
                            <a class="btn" href="{{route('leagues.edit', [$league->id])}}">Edit League</a>
                        </div>
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
                            <dl>
                                <dt>Public/Private: </dt>
                                <dd>{{$league->rule->league_type}}</dd>   
                            </dl>
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