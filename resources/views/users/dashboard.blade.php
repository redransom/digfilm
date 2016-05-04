@extends('layouts.site')

@section('content')
<h2><span>Dashboard</span></h2>
<div class="content-padding">
    <p>Hi {{$authUser->forenames}}, Welcome to <strong>TheNextBigFilm</strong> today.</p1>
</div>

<h2><span>Leagues Participating in</span></h2>
<div class="content-padding">
    <p>Here are the leagues you are in:</p>
</div>

@if($authUser->inLeagues()->where('auction_stage', '2')->count() > 0)
<h2><span>Live Auctions</span></h2>
<style>
table {
    font-size: 0.9em;
}
</style>
<div class="content-padding">
<table class="feature-table dark-gray">
    <thead>
        <tr> 
            <th width="10%"></th>
            <th width="30%">Name</th> 
            <th width="10%">Players</th>
            <th width="18%">Rules</th> 
            <th width="23%">Ends</th>
        </tr>
    </thead>
    <tbody>
        @foreach($authUser->inLeagues()->where('auction_stage', '2')->orderBy('auction_close_date', 'asc')->get() as $league)
        <tr>
            <td>
            @if($league->file_name != "")
                <img src="{{asset($league->file_name)}}" alt="{{$league->name}}" width="100px"/>
            @else
                <img src="{{asset('images/TNBF.jpg')}}" alt="{{$league->name}}" width="100px"/>
            @endif
            </td>
            <td><a class="btn btn-mini btn-danger" href="{{URL('league-play/'.$league->id)}}">{{$league->name}}</a></td>
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
<h2><span>Live Leagues</span></h2>
<div class="content-padding">
<table class="feature-table dark-gray">
    <thead>
        <tr> 
            <th width="10%"></th>
            <th width="30%">Name</th> 
            <th width="10%">Players</th>
            <th width="18%">Rules</th>
            <th width="23%">League Ends</th>
        </tr>
    </thead>
    <tbody>
        @foreach($authUser->inLeagues()->where('auction_stage', '3')->orderBy('name', 'asc')->get() as $league)
        <tr>
            <td>
            @if($league->file_name != "")
                <img src="{{asset($league->file_name)}}" alt="{{$league->name}}" width="100px"/>
            @else
                <img src="{{asset('images/TNBF.jpg')}}" alt="{{$league->name}}" width="100px"/>
            @endif
            </td>
            <td><a class="btn btn-mini btn-danger" href="{{URL('roster/'.$league->id)}}">{{$league->name}}</a></td>
            <td>{{count($league->players)}}</td>
            @if(!is_null($league->rule_set))
            <td>{{$league->rule_set->name}}</td>
            @else
            <td>&nbsp;</td>
            @endif
            @if(!is_null($league->end_date))
            @if(date("H:i", strtotime($league->end_date)) != '00:00')
            <td>{{date("jS M Y H:i", strtotime($league->end_date))}}</td>
            @else
            <td>{{date("jS M Y", strtotime($league->end_date))}}</td>
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
<table class="feature-table dark-gray">
    <thead>
        <tr> 
            <th width="10%"></th>
            <th width="30%">Name</th> 
            <th width="10%">Players</th>
            <th width="18%">Starts</th>
            <th width="18%">Ends</th>
        </tr>
    </thead>
    <tbody>
        @foreach($authUser->startedLeagues()->orderBy('name', 'asc')->get() as $league)
        <tr>
            <td>
            @if($league->file_name != "")
                <img src="{{asset($league->file_name)}}" alt="{{$league->name}}" width="100px"/>
            @else
                <img src="{{asset('images/TNBF.jpg')}}" alt="{{$league->name}}" width="100px"/>
            @endif
            </td>
            @if($league->auction_stage < 3)
            <td><a class="btn btn-mini btn-danger" href="{{URL('league-show/'.$league->id)}}">{{$league->name}}</a></td>
            @else
            <td><a class="btn btn-mini btn-danger" href="{{URL('roster/'.$league->id)}}">{{$league->name}}</a></td>
            @endif
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
<p>You are not part of any leagues currently.</p>
@endif



@if($authUser->leagues->count() > 0)
<h2><span>Leagues Owned</span></h2>
<div class="content-padding">
<p>Here are the leagues you own:</p>

<table class="feature-table dark-gray">
    <thead>
        <tr> 
            <th width="10%"></th>
            <th width="30%">Name</th> 
            <th width="10%">Players</th>
            <th width="17%">Started</th>
            <th width="17%">Ends</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($authUser->leagues as $league)
        <tr>
            <td>
            @if($league->file_name != "")
                <img src="{{asset($league->file_name)}}" alt="{{$league->name}}" width="100px"/>
            @else
                <img src="{{asset('images/TNBF.jpg')}}" alt="{{$league->name}}" width="100px"/>
            @endif
            </td>
            <td>{{$league->name}}</td>
            <td>{{count($league->players)}}</td>
            @if(!is_null($league->auction_start_date))
            <td>{{date("jS M Y", strtotime($league->auction_start_date))}}</td>
            @else
            <td>&nbsp;</td>
            @endif
            @if(!is_null($league->auction_close_date))
            <td>{{date("jS M Y", strtotime($league->auction_close_date))}}</td>
            @else
            <td>--</td>
            @endif
            <td><a class="league-btn" href="{{URL('manage/'.$league->id)}}">Manage</a></td>
        </tr>
        @endforeach
    </tbody>
</table><!--/ feature-table-->
</div>
@else
<p>You don't currently own any leagues.</p>
@endif
 
@endsection