@extends('layouts.site')

@section('content')
<h2><span>Public Leagues</span></h2>
<div class="content-padding">

    <!--h4>All leagues available to play for anyone!</h4>
    @if(isset($leagues) && $leagues->count() > 0)
        <?php $league_counter = 0; ?>
        <table class="feature-table dark-gray">
            <thead>
                <tr><th>Name</th><th>Players</th><th>Owner</th><th>Stage</th><th>Closes?</th><th>&nbsp;</th></tr>
            </thead>
            <tbody>
                @foreach($leagues as $league)
                <tr<?php echo (($league_counter % 2) == 1) ? " class='odd'" : ""; ?>>
                <td><a href="{{URL('league-show', ['id'=>$league->id])}}">{{$league->name}}</a></td>
                @if($league->rule)
                <td>{{count($league->players)}} / {{$league->rule->min_players}} / {{$league->rule->max_players}}</td>
                @else
                <td>{{count($league->players)}}</td>
                @endif
                <td>{{$league->owner->name}}</td>
                <td>{{$league->stage()}}</td>
                <td>{{date("jS M Y", strtotime($league->auction_start_date))}}<br/>
                at {{date("g:iA", strtotime($league->auction_start_date))}}</td>
                <td>
                @if(!is_null($authUser) && time() < strtotime($league->auction_start_date))
                <a class="button small dark" href="{{URL('join-league/'.$league->id)}}">Join</a>
                @elseif(!is_null($authUser) && time() >= strtotime($league->auction_start_date))
                <a class="button small" style="background-color: #519623;" title="This league has started!">Started</a>
                @else
                <a class="button small" style="background-color: #B1221C;" title="You need to be logged in to join a league">Join</a>
                @endif
                </td>
                </tr>
                <?php $league_counter++; ?>
                @endforeach
            </tbody>
        </table>
        <h3>Players Legend: Current / Minimum / Maximum</h3>
        <dl>
            <dt></dt>
            <dd>Current: Number of players currently signed up to play.</dd>
            <dd>Minimum: Minimum number of players needed to play.</dd>
            <dd>Maximum: Maximum number of players who can play in the league.</dd>
        </dl>
    @else
    <p>There are no leagues available presently.</p>
    @endif
    -->

<div class="one-half small--one-whole">
    <div class="league-container league-item">
        <img src="{{asset('/images/league-1.jpg')}}" alt="Test Admin League">
        <div class="league-info">
            <div class="row">
                <span class="title">Name:</span><p>Test Admin League</p>
            </div>
            <div class="row">
                <span class="title">Players:</span><p>1</p>
            </div>
            <div class="row">
                <span class="title">Min:</span><p>4</p>
            </div>
            <div class="row">
                <span class="title">Max:</span><p>6</p>
            </div>
            <div class="row">
                <span class="title">Closes:</span><p>8th Nov 2012 - 12pm</p>
            </div>
            <a href="#" class="btn">Join Now</a>
        </div>
    </div>
</div>


<div class="one-half small--one-whole">
    <div class="league-container league-item">
        <img src="{{asset('/images/league-1.jpg')}}" alt="Test Admin League">
        <div class="league-info">
            <div class="row">
                <span class="title">Name:</span><p>Test Admin League</p>
            </div>
            <div class="row">
                <span class="title">Players:</span><p>1</p>
            </div>
            <div class="row">
                <span class="title">Min:</span><p>4</p>
            </div>
            <div class="row">
                <span class="title">Max:</span><p>6</p>
            </div>
            <div class="row">
                <span class="title">Closes:</span><p>8th Nov 2012 - 12pm</p>
            </div>
            <a href="#" class="btn">Join Now</a>
        </div>
    </div>
</div>

<div class="one-half small--one-whole">
    <div class="league-container league-item">
        <img src="{{asset('/images/league-1.jpg')}}" alt="Test Admin League">
        <div class="league-info">
            <div class="row">
                <span class="title">Name:</span><p>Test Admin League</p>
            </div>
            <div class="row">
                <span class="title">Players:</span><p>1</p>
            </div>
            <div class="row">
                <span class="title">Min:</span><p>4</p>
            </div>
            <div class="row">
                <span class="title">Max:</span><p>6</p>
            </div>
            <div class="row">
                <span class="title">Closes:</span><p>8th Nov 2012 - 12pm</p>
            </div>
            <a href="#" class="btn">Join Now</a>
        </div>
    </div>
</div>
</div>
@endsection
