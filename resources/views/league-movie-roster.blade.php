@extends('layouts.users')

@section('content')
<section class="entry sbr clearfix">
    <div class="title-caption-large">
        <h3>{{$currentLeague->name}} League</h3>
    </div>
    <h2>Your Movie Roster</h2>

    @include('partials.user-roster', ['currentLeague'=>$currentLeague, 'leagueUser'=>$currentLeagueUser])
   
    <br/>
    @include('partials.user-league-rules', ['currentLeague'=>$currentLeague, 'leagueUser'=>$currentLeagueUser])
 
</section>

@endsection
