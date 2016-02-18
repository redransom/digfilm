@extends('layouts.site')

@section('content')

<h2><span>{{$league->name}}</span></h2>
<div class="content-padding">

    <dl class="dl-horizontal">
        <dt>Auction Status</dt>
        @if(!is_null($league->auction))
        <dd></dd>
        @else
        <dd>Auction hasn't started.</dd>
        @endif
    </dl>

    @if($league->description != "")
    <h4><em>{{$league->description}}</em></h4>
    @endif 

    <div class="sep"></div>

    <div class="one-quarter">
        <h4>Players</h4>
        <ul>
        @foreach ($league->players as $player)
            <li>{{$player->fullName()}}</li>
        @endforeach
        </ul>

        @if($league->players->count() < $league->rule->max_players)
        <br/>
        <a href="{{URL('select-participants', array('id'=>$league->id))}}" class="button green small">Add more players</a></li>
        
        @endif
    </div>

    <div class="one-quarter last">
        @if($league->auction_stage == 0)
        {!! Form::open(array('route' => array('player-rules', $league->id), 'class'=>'form-horizontal row-fluid', 'method'=>'POST')) !!}
        <fieldset>
            <input type="hidden" name="location" value="C"/>
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

        <table class="feature-table dark-gray">
            <tr>
                <td>Durations</td>
                <td>Auction: {{$league->rule->auction_duration}} hours <br/>Round: {{$league->rule->round_duration}} hours <br/>Movies: {{$league->rule->ind_film_countdown}} mins</td>
            </tr>
            <tr>
                <td>Bids</td>
                <td>Min: {{$league->rule->min_bid}} Max: {{$league->rule->max_bid}}</td>
            </tr>
            <tr>
                <td>Selection</td>
                <td>Random: {{($league->rule->randomizer == "Y") ? "Yes" : "No"}} <br/>Auto-Select: {{($league->rule->auto_select == 'Y') ? "Yes" : "No"}} <br/>Grouped: {{$league->rule->auction_movie_release}}</td>
            </tr>
            <tr>
                <td>Blind</td>
                <td>{{$league->rule->blind_bid == "Y" ? "Yes" : "No"}}</td>
            </tr>
            <tr>
                <td>Misc</td>
                <td>Timeout: {{$league->rule->auction_timeout}} mins <br/>Denomination: {{$league->rule->denomination}} <br/>Movie Takings: {{$league->rule->movie_takings_duration}} weeks</td>
            </tr>
        </table>
        @else

        @include('partials.user-league-rules', ['rule'=>$league->rule, 'leagueUser'=>$authUser]) 

        
    @endif

    </div>

    <div class="sep"></div>
    <h4>Available Movies</h4>
    @if($league->movies->count() > 0)
    <ul>

    @foreach($league->movies as $movie)
        <li>{{$movie->pivot->id}}: {{$movie->name}}</li>
    @endforeach
    </ul>
    @else
    <p>There are no movies associated with this league presently.</p>
    @endif
</div>
@endsection