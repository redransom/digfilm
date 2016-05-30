@extends('layouts.site')

@section('content')

<h2><span>{{$league->name}}</span></h2>
<div class="content-padding">
    @if($league->description != "")
    <h4><em>{{$league->description}}</em></h4>
    @endif 

    <h3>Auction Status</h3>
    <p>@if($league->auctions()->count() > 0)
        Auction is under way!
        @else
        Auction hasn't started.
        @endif
    </p>

    <div class="sep"></div>

    <div class="one-quarter">
        <h4>Players</h4>
        <ul>
        @foreach ($league->players as $player)
            <li>{{$player->fullName()}}</li>
        @endforeach
        </ul>

        @if($league->players->count() < $league->rule->max_players && $league->auction_stage == 0)
        <div class="form-footer">
            <div class="divider--img"></div>
            <a href="{{URL('select-participants', array('id'=>$league->id))}}" class="submit-btn btn-small">Add more players</a></li>
        </div>
        @endif
    </div>

    <div class="two-thirds last">
        @if($league->auction_stage == 0)
        {!! Form::open(array('route' => array('player-rules', $league->id), 'class'=>'form-horizontal row-fluid', 'method'=>'POST')) !!}
        <fieldset>
            <input type="hidden" name="location" value="C"/>
            <style>
                .manage_selects select {
                    width: 20% !important;
                    height: 2.5em !important;
                }
            </style>

            <script>
            $(function() {
                $('#datepicker').datetimepicker( "option", "dateFormat", "yy-mm-dd HH:mm");
                $('#datepicker').val('{!! $league->auction_start_date !!}');
            });
            </script>            
            <div class="manage_selects">
                <label>Number of players:</label><br/>
                {!! Form::select('min_players', $player_array, $league->rule->min_players, ['class'=>'span2']) !!} to 
                {!! Form::select('max_players', $player_array, $league->rule->max_players, ['class'=>'span2']) !!}<br/>
            </div>
            
            <div class="manage_selects">
                <label>Number of movies:</label><br/>
                {!! Form::select('min_movies', $movie_array, $league->rule->min_movies, ['class'=>'span2']) !!} to 
                {!! Form::select('max_movies', $movie_array, $league->rule->max_movies, ['class'=>'span2']) !!}<br/>
            </div>

            <div class="manage_selects">
                <label>Auction Start Date:</label><br/>
                {!! Form::text('auction_start_date', $league->auction_start_date, ['class'=>'span2', 'id'=>'datepicker']) !!}
            </div>
            
            <div class="form-footer">
             <div class="divider--img"></div>
                <input type="submit" class="submit-btn btn-small" id="submit" value="Update" />
            </div>
        </fieldset>
        {!! Form::close() !!}
        <br/>
        <h3>Rules of the league</h3>
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
</div>
<div class="sep"></div>

<h2><span>Available Movies</span></h2>

<div class="content-padding">
@if($league->movies->count() > 0)

@include('partials.site-movies', ['movies'=>$league->movies])

@else
<p>There are no movies associated with this league presently.</p>
@endif
</div>
@endsection