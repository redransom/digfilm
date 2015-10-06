@extends('layouts.users')

@section('content')
<section class="entry sbr clearfix">
    <div class="title-caption-large">
        <h3>{{$league->name}} League</h3>
    </div>

    <h2>Auction</h2>
    @if(is_null($league->auction_start_date))
    <p>The auction will start soon!</p>
    @elseif(strtotime($league->auction_start_date) > time())
    <p>The auction will start on the <strong>{{date("d M y h:iA", strtotime($league->auction_start_date))}}</strong>.</p>
    @else
    <?php $players = $league->players->lists('name', 'id'); ?>
    <p>See a list of movies you can bid on:</p>
    <table class="feature-table dark-gray">
        <thead>
            <tr><th>Movie</th><th>Synopsis</th><th>Release Date</th><th>Current Price /<br/>$ USD</th><th>Place Bid</th><th>Owner</th><th>Active</th></tr>
        </thead>
        <tbody>
        @foreach($league->auctions as $auction)
            <tr><td><a href="{{URL('movie-knowledge', [$auction->id])}}">{{$auction->name}}</a></td><td>{{substr($auction->summary, 0, 50)}}</td>
            <td>{{date("j-M-y", strtotime($auction->release_at))}}</td><td>{{$auction->pivot->bid_amount}}</td>
            @if($auction->pivot->users_id == $authUser->id)
            <td>PLACED</td>
            @else
            <td><a href="{{URL('place-bid', [$auction->pivot->id])}}" class="popup">PLACE BID</a></td>
            @endif
            @if($auction->pivot->users_id != 0)
            <td>{{$players[$auction->pivot->users_id]}}</td>
            @else
            <td>&nbsp;</td>
            @endif
            @if($auction->pivot->ready_for_auction == 1)
            <td>Yes</td>
            @else
            <td>No</td>
            @endif
            </tr>
        @endforeach
        </tbody>
    </table>
    @endif

    @if(is_null($league->auction_start_date) || (strtotime($league->auction_start_date) > time())) 
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
    @endif
</section>
@endsection
