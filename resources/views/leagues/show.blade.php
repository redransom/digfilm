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
@endsection