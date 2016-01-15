@extends('layouts.site')

@section('content')
<h2><span>{{$currentLeague->name}} League</span></h2>
<div class="content-padding">

    <h2>Your Movie Roster</h2>

    @include('partials.user-roster', ['currentLeague'=>$currentLeague, 'leagueUser'=>$currentLeagueUser])
   
    <br/>
    @include('partials.user-league-rules', ['rule'=>$currentLeague->rule, 'leagueUser'=>$currentLeagueUser])

</div>

@endsection

