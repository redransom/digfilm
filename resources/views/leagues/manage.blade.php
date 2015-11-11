@extends('layouts.users')

@section('content')
<section class="entry sbr clearfix">
    <div class="title-caption-large">
        <h3>{{$league->name}}</h3>
    </div>


    <dl class="dl-horizontal">
        <dt>Auction Status</dt>
        @if(!is_null($league->auction))
        <dd></dd>
        @else
        <dd>Auction hasn't started.</dd>
        @endif
    </dl>

    <div class="sep"></div>

    <div class="one-quarter">
        <h4>Players</h4>
        <ul class="unstyled">
        @foreach ($league->players as $player)
            <li><a href="{{URL('users', array('id'=>$player->id))}}">{{$player->fullName()}}</li>
        @endforeach
        </ul>

        <ul>
            <li><a href="{{URL('league-add-player', array('id'=>$league->id))}}">Add Player</a></li>
        </ul>

    </div>

    <div class="one-quarter last">
        <h4>Rules</h4>
        @if($league->auction_stage == 0)
        {!! Form::open(array('route' => array('league-rules', $league->rule->id), 'class'=>'form-horizontal row-fluid', 'method'=>'POST')) !!}
        <fieldset>
            <label>Number of players:</label><br/>
            {!! Form::select('min_players', [1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6, 7=>7, 8=>8, 9=>9, 10=>10], $league->rule->min_players, ['class'=>'span2']) !!} to 
            {!! Form::select('max_players', [1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6, 7=>7, 8=>8, 9=>9, 10=>10, 11=>11, 12=>12, 13=>13, 14=>14, 15=>15], $league->rule->max_players, ['class'=>'span2']) !!}<br/>
            <label>Number of movies:</label><br/>
            {!! Form::select('min_movies', [10=>10, 20=>20, 30=>30, 40=>40, 50=>50, 60=>60, 70=>70], $league->rule->min_movies, ['class'=>'span2']) !!} to 
            {!! Form::select('max_movies', [10=>10, 20=>20, 30=>30, 40=>40, 50=>50, 60=>60, 70=>70, 80=>80, 90=>90, 100=>100], $league->rule->max_movies, ['class'=>'span2']) !!}<br/>
            <label>Auction Start Date:</label><br/>
            {!! Form::text('auction_start_date', $league->auction_start_date, ['class'=>'span2']) !!}<br/>
            <input type="submit" class="button green small" id="submit" value="Update" />
        </fieldset>
        {!! Form::close() !!}

        <dl>
            <dt>Durations</dt>
            <dd>Auction: {{$league->rule->auction_duration}} hours <br/>Round: {{$league->rule->round_duration}} hours <br/>Movies: {{$league->rule->ind_film_countdown}} mins</dd>
            <dt>Bids</dt>
            <dd>Min: {{$league->rule->min_bid}} Max: {{$league->rule->max_bid}}</dd>
            <dt>Selection</dt>
            <dd>Random: {{($league->rule->randomizer == "Y") ? "Yes" : "No"}} <br/>Auto-Select: {{($league->rule->auto_select == 'Y') ? "Yes" : "No"}} <br/>Grouped: {{$league->rule->auction_movie_release}}</dd>
            <dt>Blind</dt>
            <dd>{{$league->rule->blind_bid == "Y" ? "Yes" : "No"}}</dd>
            <dt>Misc</dt>
            <dd>Timeout: {{$league->rule->auction_timeout}} mins <br/>Denomination: {{$league->rule->denomination}} <br/>Movie Takings: {{$league->rule->movie_takings_duration}} weeks</dd>
        </dl>
        @else
        <dl>
            <dt>Players</dt>
            <dd>Min: {{$league->rule->min_players}} Max: {{$league->rule->max_players}}</dd>
            <dt>Movies</dt>
            <dd>Min: {{$league->rule->min_movies}} Max: {{$league->rule->max_movies}}</dd>
            <dt>Durations</dt>
            <dd>Auction: {{$league->rule->auction_duration}} hours <br/>Round: {{$league->rule->round_duration}} hours <br/>Movies: {{$league->rule->ind_film_countdown}} mins</dd>
            <dt>Bids</dt>
            <dd>Min: {{$league->rule->min_bid}} Max: {{$league->rule->max_bid}}</dd>
            <dt>Start/End</dt>
            <dd>Start Time: {{$league->rule->start_time}} End Time: {{$league->rule->end_time}}</dd>
            <dt>Selection</dt>
            <dd>Random: {{($league->rule->randomizer == "Y") ? "Yes" : "No"}} <br/>Auto-Select: {{($league->rule->auto_select == 'Y') ? "Yes" : "No"}} <br/>Grouped: {{$league->rule->auction_movie_release}}</dd>
            <dt>Blind</dt>
            <dd>{{$league->rule->blind_bid == "Y" ? "Yes" : "No"}}</dd>
            <dt>Misc</dt>
            <dd>Timeout: {{$league->rule->auction_timeout}} mins <br/>Denomination: {{$league->rule->denomination}} <br/>Movie Takings: {{$league->rule->movie_takings_duration}} weeks</dd>
        </dl>
    @endif

    </div>

    <div class="sep"></div>
    <h4>Available Movies</h4>
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
</section>
@endsection