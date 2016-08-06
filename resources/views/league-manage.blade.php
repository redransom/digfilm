@extends('layouts.site')

@section('content')

<h2><span>{{$league->name}}</span></h2>
<div class="content-padding">
    {!! Form::open(array('route' => array('player-rules', $league->id), 'class'=>'form-horizontal row-fluid', 'method'=>'POST')) !!}
    <fieldset>
        <input type="hidden" name="location" value="C"/>
        <style>
            .manage select {
                width: 20% !important;
                height: 2.5em !important;
            }
            .manage input {
                width: 20% !important;
            }
        </style>

        <script>
        $(function() {
            $('#datepicker').datetimepicker( "option", "dateFormat", "yy-mm-dd HH:mm");
            $('#datepicker').val('{!! $league->auction_start_date !!}');
        });
        </script>  
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

        <div class="manage">
            <label>Auction Start Date:</label><br/>
            {!! Form::text('auction_start_date', $league->auction_start_date, ['class'=>'span2', 'id'=>'datepicker']) !!}
        </div>
        
        <div class="form-footer">
            <div class="divider--img"></div>
            <input type="submit" class="submit-btn btn-small" id="submit" value="Update" />
        </div>
    </fieldset>
    {!! Form::close() !!}
</div>
<div class="sep"></div>

<h2><span>Players taking part</span></h2>
<div class="content-padding">
    <div class="photo-blocks">
        <ul>
            @foreach($league->players as $player)
            <li>
                <!--a href="#" class="article-image-out"-->
                @if(!is_null($player->thumbnail) || $player->thumbnail != '')
                <span class="article-image"><img src="{{asset($player->thumbnail) }}" width="128" height="128" alt="" title="" /></span><!--/a-->
                @else
                <span class="article-image"><img src="{{asset('/images/TNBF.jpg') }}" width="128" height="128" alt="" title="" /></span><!--/a-->
                @endif
                <span>{{$player->fullName()}}</span>

            </li>
            @endforeach
        </ul>
        <div class="clear-float"></div>
    <!-- END .photo-blocks -->
    </div>

    @if($league->players->count() < $league->rule->max_players && $league->auction_stage == 0)
    <div class="form-footer">
        <div class="divider--img"></div>
        <br/>
        <a href="{{URL('select-participants', array('id'=>$league->id))}}" class="submit-btn btn-small">Add more players</a></li>
    </div>
    @endif
</div>

<h2><span>Available Movies</span></h2>

<div class="content-padding">
@if($league->movies->count() > 0)

@include('partials.site-movies', ['movies'=>$league->movies])

@else
<p>There are no movies associated with this league presently.</p>
@endif
</div>

<h2><span>Rules of the league</span></h2>
<div class="content-padding">
@include('partials.user-league-rules', ['rule'=>$league->rule, 'leagueUser'=>$authUser])
</div> 
@endsection