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
            <tr><th>Name</th><th>Players</th><th>Owner</th><th>Open?</th><th>Closes?</th><th>&nbsp;</th></tr>
        </thead>
        <tbody>
            @foreach($leagues as $league)
            <tr<?php echo (($league_counter % 2) == 1) ? " class='odd'" : ""; ?>><td>{{$league->name}}</td><td>{{count($league->players)}}</td><td>{{$league->owner->name}}</td>
            <td>Yes</td><td>{{date("jS M")}}</td>
            <td>
            @if(isset($authUser) && isset($league->rule) && $league->rule->league_type =='U')
            <a class="button small dark" href="{{URL('leagues/'.$league->id.'/join')}}">Join</a>
            @elseif(isset($authUser) && isset($league->rule) && $league->rule->league_type =='R')
            <a title="This league is invite only">Invite Only</a>
            @else
            <a title="You need to be logged in to join a league">Join</a>
            @endif
            </td>
            </tr>
            <?php $league_counter++; ?>
            @endforeach
        </tbody>

        </table>
    @else
    <p>There are no leagues available presently.</p>
    @endif
</section>
@endsection
