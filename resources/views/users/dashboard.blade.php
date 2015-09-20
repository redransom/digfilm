@extends('layouts.users')

@section('content')
<section class="entry sbr clearfix">
    <div class="title-caption-large">
        <h3>Dashboard</h3>
    </div>

    <h1>Hi {{$authUser->forenames}}, Welcome to DigFilm today.</h1>
    
    <h2>Leagues Owned</h2>

    @if($authUser->leagues->count() > 0)
    <p>Here are the leagues you own:</p>
    <table class="feature-table dark-gray">
        <thead>
            <tr> 
                <th>Name</th> 
                <th>Players</th>
                <th>Started?</th>
                <th>Ends?</th>
            </tr>
        </thead>
        <tbody>
            @foreach($authUser->leagues as $league)
            <tr>
                <td>{{$league->name}}</td>
                <td>{{count($league->players)}}</td>
                <td>{{$league->created_at}}</td>
                <td>--</td>
            </tr>
            @endforeach
        </tbody>
    </table><!--/ feature-table-->
    @else
    <p>You currently own no leagues.</p>
    @endif

    <h2>Leagues Participating in</h2>
    <p>Here are the leageus you are in:</p>
    @if($authUser->inLeagues->count() > 0)
    <table class="feature-table dark-gray">
        <thead>
            <tr> 
                <th>Name</th> 
                <th>Players</th>
                <th>Started?</th>
                <th>Ends?</th>
            </tr>
        </thead>
        <tbody>
            @foreach($authUser->inLeagues as $league)
            <tr>
                <td><a class="btn btn-mini btn-danger" href="{{URL('league/'.$league->id)}}">{{$league->name}}</a></td>
                <td>{{count($league->players)}}</td>
                <td>{{$league->created_at}}</td>
                <td>--</td>
            </tr>
            @endforeach
        </tbody>
    </table><!--/ feature-table-->
    @else
    <p>You are not part of any leagues currently.</p>
    @endif

</section>    
@endsection