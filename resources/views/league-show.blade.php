@extends('layouts.users')

@section('content')
<section class="entry sbr clearfix">
    <div class="title-caption-large">
        <h3>{{$league->name}} League</h3>
    </div>

    <h2>Auction</h2>
    @if(is_null($league->auction_start_date))
    <p>The auction will start soon!</p>
    @else
    <p>The auction will start on the <strong>{{date("d M y h:iA", strtotime($league->auction_start_date))}}</strong>.</p>
    @endif

    <h2>Players</h2>
    <p>Who you are competing against.</p>
    @if($league->players->count())
    <ul>
        @foreach($league->players as $player)
        <li>{{$player->name}}</li>
        @endforeach
    </ul>
    @endif

    <br/>
    <h2>Movies</h2>
    <p>This is a list of all movies that are to be played for in this league.</p>
    @if($league->movies->count() > 0)
    <ul>
    @foreach($league->movies as $movie)
        <li>{{$movie->name}}</li>
    @endforeach
    </ul>
    @endif
</section>
@endsection
