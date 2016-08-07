@extends('layouts.site')

@section('content')
<h2><span>{{$currentLeague->name}} League</span></h2>
<div class="content-padding">

    <h3>Your Movie Roster</h3>
    <br/>
    @include('partials.user-roster', ['currentLeague'=>$currentLeague, 'leagueUser'=>$currentLeagueUser])
</div>
@include('partials.user-league-rules', ['rule'=>$currentLeague->rule, 'leagueUser'=>$currentLeagueUser])

@endsection

