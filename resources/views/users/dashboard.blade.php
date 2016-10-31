@extends('layouts.site')

@section('content')
<h2><span>My Leagues</span></h2>
<div class="content-padding">
    <p>Hi {{$authUser->forenames}}, on your dashboard below you can see how you are doing in active leagues, 
    how you have done in previous leagues, the leagues you own and the leagues waiting to go to auction.</p>
    <p>Here are the leagues you are in:</p>
</div>
<style>
table th {
    font-size: 0.8em !important;
}
.feature-table img {
    max-width: 58px !important;
    max-height: 80px !important;
    min-width: 58px !important;
    min-height: 80px !important;
}
</style>
@if($authUser->inLeagues()->where('auction_stage', '2')->count() > 0)
<h2><span>Live Auctions</span></h2>

<div class="content-padding">
<p>These are the leagues which have auctions running currently.</p>
<table class="feature-table dark-gray">
    <thead>
        <tr> 
            <th width="12%"></th>
            <th width="30%">League Name</th>
            <th width="10%">Pot Size</th> 
            <th width="10%">Players</th>
            <th width="18%">Auction Type</th> 
            <th width="23%">End Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($authUser->inLeagues()->where('auction_stage', '2')->orderBy('auction_close_date', 'asc')->get() as $league)
        <?php $link = ($league->auction_stage < 3) ? URL('league-play/'.$league->id) : URL('roster/'.$league->id); ?>
        <tr>
            <td align="center"><a href="{{$link}}"><img src="{{asset($league->leagueImage())}}" alt="{{$league->name}}"/></a></td>
            <td><a class="btn btn-mini btn-danger" href="{{URL('league-play/'.$league->id)}}">{{$league->name}}</a></td>
            <td>{{$league->value()}}USD</td>
            <td>{{count($league->players)}}</td>
            @if(!is_null($league->rule_set))
            <td>{{$league->rule_set->name}}</td>
            @else
            <td>&nbsp;</td>
            @endif
            <td>{{date("jS M Y g:iA", strtotime($league->auction_close_date))}}</td>
        </tr>
        @endforeach
    </tbody>
</table><!--/ feature-table-->
</div>
@endif

@if($authUser->inLeagues()->where('auction_stage', '3')->count() > 0)
<h2><span>Active Leagues</span></h2>
<div class="content-padding">
<p>Once the auction for a league has finished, your roster will appear here. You will be to check how you’re doing and how other players in your league are doing.</p>
<table class="feature-table dark-gray">
    <thead>
        <tr> 
            <th width="12%"></th>
            <th width="30%">League Name</th>
            <th width="10%">Pot Size</th> 
            <th width="10%">Players</th>
            <th width="18%">Auction Type</th>
            <th width="23%">End Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($authUser->inLeagues()->where('auction_stage', '3')->orderBy('name', 'asc')->get() as $league)
        <?php $link = ($league->auction_stage < 3) ? URL('league-show/'.$league->id) : URL('roster/'.$league->id); ?>
        <tr>
            <td align="center"><a href="{{$link}}"><img src="{{asset($league->leagueImage())}}" alt="{{$league->name}}"/></a></td>
            <td><a class="btn btn-mini btn-danger" href="{{URL('roster/'.$league->id)}}">{{$league->name}}</a></td>
            <td>{{$league->value()}}USD</td>
            <td>{{count($league->players)}}</td>
            @if(!is_null($league->rule_set))
            <td>{{$league->rule_set->name}}</td>
            @else
            <td>&nbsp;</td>
            @endif
            @if(!is_null($league->end_date))
            @if(date("H:i", strtotime($league->end_date)) != '00:00')
            <td>{{date("jS M Y g:iA", strtotime($league->end_date))}}</td>
            @else
            <td>{{date("jS M Y g:iA", strtotime($league->end_date))}}</td>
            @endif
            @else
            <td></td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table><!--/ feature-table-->
</div>
@endif

@if($authUser->startedLeagues()->count() > 0)
<h2><span>Leagues due to start</span></h2>
<div class="content-padding">
<p>These are the leagues which are due to start their auctions shortly.</p>
<table class="feature-table dark-gray">
    <thead>
        <tr> 
            <th width="12%"></th>
            <th width="30%">League Name</th> 
            <th width="10%">Pot Size</th> 
            <th width="10%">Players</th>
            <th width="18%">Start Date</th>
            <th width="18%">End Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($authUser->startedLeagues()->orderBy('name', 'asc')->get() as $league)
        <?php $link = ($league->auction_stage < 3) ? URL('league-show/'.$league->id) : URL('roster/'.$league->id); ?>
        <tr>
            <td align="center"><a href="{{$link}}"><img src="{{asset($league->leagueImage())}}" alt="{{$league->name}}"/></a></td>
            <td><a class="btn btn-mini btn-danger" href="{{$link}}">{{$league->name}}</a></td>
            <td>{{$league->value()}}USD</td>
            <td>{{count($league->players)}}</td>
            @if(!is_null($league->auction_start_date))
            <td>{{date("jS M Y g:iA", strtotime($league->auction_start_date))}}</td>
             @else
            <td>&nbsp;</td>
            @endif
            @if(!is_null($league->auction_close_date))
            <td>{{date("jS M Y g:iA", strtotime($league->auction_close_date))}}</td>
            @else
            <td>--</td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>
</div>
@endif

@if($authUser->inLeagues()->where('auction_stage', '<', '4')->count() == 0)
<div class="content-padding">
<p>You are not part of any leagues currently.</p>
</div>
@endif



@if($authUser->leagues->count() > 0)
<h2><span>Leagues Owned</span></h2>
<div class="content-padding">
<p>Here are the leagues you own:</p>

<table class="feature-table dark-gray">
    <thead>
        <tr> 
            <th width="12%"></th>
            <th width="30%">League Name</th> 
            <th width="10%">Pot Size</th> 
            <th width="10%">Players</th>
            <th width="17%">Start Date</th>
            <th width="17%">End Date</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($authUser->leagues as $league)
        <tr>
            <td align="center"><img src="{{asset($league->leagueImage())}}" alt="{{$league->name}}"/></td>
            <td>{{$league->name}}</td>
            <td>{{$league->value()}}USD</td>
            <td>{{count($league->players)}}</td>
            @if(!is_null($league->auction_start_date))
            <td>{{date("jS M Y g:iA", strtotime($league->auction_start_date))}}</td>
            @else
            <td>&nbsp;</td>
            @endif
            @if(!is_null($league->auction_close_date))
            <td>{{date("jS M Y g:iA", strtotime($league->auction_close_date))}}</td>
            @else
            <td>--</td>
            @endif
            <td><a class="league-btn" href="{{URL('manage/'.$league->id)}}">Manage</a></td>
        </tr>
        @endforeach
    </tbody>
</table><!--/ feature-table-->
</div>
@endif
 
@endsection