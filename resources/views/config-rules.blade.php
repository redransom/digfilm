@extends('layouts.site')

@section('content')

<h2><span>Configure League Rules</span></h2>
<div class="content-padding">
    {!! Form::open(array('route' => array('player-rules', $league->id), 'class'=>'form-horizontal row-fluid', 'method'=>'POST')) !!}
    <fieldset>
        <input type="hidden" name="location" value="R"/>
        <style>
            .manage select {
                width: 20% !important;
                height: 2.5em !important;
            }
            .manage input {
                width: 20% !important;
            }
        </style>

        <h3>Configuration</h3>
        <p>Use this form to change how many players / movies can be involved in the league and when the league should start.</p>
        <p><strong>NOTE:</strong> These options are removed once the league is under way.</p>          
        <div class="manage">
            <label>Number of players:</label><br/>
            {!! Form::select('min_players', $player_array, $league->rule->min_players, ['class'=>'span2']) !!} to 
            {!! Form::select('max_players', $player_array, $league->rule->max_players, ['class'=>'span2']) !!}<br/>
        </div>
        
        <div class="manage">
            <label>Number of movies:</label><br/>
            {!! Form::select('min_movies', $movie_array, $league->rule->min_movies, ['class'=>'span2']) !!} to 
            {!! Form::select('max_movies', $movie_array, $league->rule->max_movies, ['class'=>'span2']) !!}<br/>
        </div>
        
        <div class="form-footer">
            <div class="divider--img"></div>
            <input type="submit" class="submit-btn btn-small" id="submit" value="Continue" />
        </div>
    </fieldset>
    {!! Form::close() !!}
</div>
<div class="sep"></div>


@endsection