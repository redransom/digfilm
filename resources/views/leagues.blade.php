@extends('layouts.site')

@section('content')
<h2><span>Public Leagues</span></h2>
<div class="content-padding">

@if(isset($leagues) && $leagues->count() > 0)

    @foreach($leagues as $league)
    <div class="one-half small--one-whole">
        <div class="league-container league-item">
            <a href="{{Route('league-show', ['id'=>$league->id])}}">
            @if(!is_null($league->file_name))
            <img src="{{asset($league->file_name)}}" alt="{{$league->name}}">
            @else
            <img src="{{asset('/images/TNBF_missing_poster.jpg')}}" alt="{{$league->name}}">
            @endif
            </a>
            <div class="league-info">
                <div class="row">
                    <span class="title">Name:</span><p>{{$league->name}}</p>
                </div>
                <div class="row">
                @if(count($league->players) == $league->rule->max_players)
                    <span class="title">Players:</span><p>Full</p>
                @elseif(count($league->players) < $league->rule->min_players)
                    <span class="title">Players:</span><p>Need more players!</p>
                @else
                    <span class="title">Players:</span><p>Can take more!</p>
                @endif
                </div>
                <div class="row">
                    <span class="title">Closes:</span><p>{{date("jS M Y", strtotime($league->auction_start_date))}} <br/>at {{date("g:iA", strtotime($league->auction_start_date))}}</p>
                </div>
                @if(!is_null($authUser) && time() < strtotime($league->auction_start_date))
                @if(count($league->players) == $league->rule->max_players)
                Full
                @else
                <a class="btn" href="{{URL('join-league/'.$league->id)}}">Join</a>
                @endif
                @elseif(!is_null($authUser) && time() >= strtotime($league->auction_start_date))
                <a class="btn" title="This league has started!">Started</a>
                @else
                <a class="btn" title="You need to be logged in to join a league">Login</a>
                @endif
            </div>
        </div>
    </div>
    @endforeach
@endif
</div>
@endsection
