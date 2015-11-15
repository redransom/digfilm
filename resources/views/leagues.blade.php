@extends('layouts.users')

@section('content')
<section class="entry sbr clearfix">
    <div class="title-caption-large">
        <h3>Leagues</h3>
    </div>
    @if(isset($leagues) && $leagues->count() > 0)
        <?php $league_counter = 0; ?>
        <table class="feature-table dark-gray">
            <thead>
                <tr><th>Name</th><th>Players</th><th>Owner</th><th>Type</th><th>Closes?</th><th>&nbsp;</th></tr>
            </thead>
            <tbody>
                @foreach($leagues as $league)
                <tr<?php echo (($league_counter % 2) == 1) ? " class='odd'" : ""; ?>><td>{{$league->name}}</td>
                @if($league->rule)
                <td>{{count($league->players)}} / {{$league->rule->min_players}} / {{$league->rule->max_players}}</td>
                @else
                <td>{{count($league->players)}}</td>
                @endif
                <td>{{$league->owner->name}}</td>
                <td>{{((!empty($league->rule) && $league->rule->league_type == 'R') ? "Private" : "Public")}}</td>
                <td>{{date("jS M Y")}}</td>
                <td>
                @if(isset($authUser) && isset($league->rule) && $league->type =='U')
                <a class="button small dark" href="{{URL('leagues/'.$league->id.'/join')}}">Join</a>
                @elseif(isset($authUser) && isset($league->rule) && $league->rule->league_type =='R')
                <a class="button small dark" title="This league is invite only">Invite Only</a>
                @else
                <a class="button small red" title="You need to be logged in to join a league">Join</a>
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

</section>
@endsection
