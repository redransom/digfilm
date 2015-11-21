@extends('layouts.users')

@section('content')
<section class="entry sbr clearfix">
    <div class="title-caption-large">
        <h3>Dashboard</h3>
    </div>

    <h1>Hi {{$authUser->forenames}}, Welcome to TheNextBigFilm today.</h1>

    <h2>Leagues Participating in</h2>
    <p>Here are the leagues you are in:</p>
    @if($authUser->inLeagues()->where('auction_stage', '2')->count() > 0)

    <h3>Live Auctions</h3>
    <table class="feature-table dark-gray">
        <thead>
            <tr> 
                <th width="40%">Name</th> 
                <th width="18%">Rules</th> 
                <th width="12%">Players</th>
                <th width="21%">Auction Ends?</th>
            </tr>
        </thead>
        <tbody>
            @foreach($authUser->inLeagues()->where('auction_stage', '2')->orderBy('auction_close_date', 'asc')->get() as $league)
            <tr>
                <td><a class="btn btn-mini btn-danger" href="{{URL('league-show/'.$league->id)}}">{{$league->name}}</a></td>
                <td>{{$league->rule_set->name}}</td>
                <td>{{count($league->players)}}</td>
                <td>{{date("jS M Y H:i", strtotime($league->auction_close_date))}}</td>
            </tr>
            @endforeach
        </tbody>
    </table><!--/ feature-table-->

    @endif

    @if($authUser->inLeagues()->where('auction_stage', '3')->count() > 0)
    <h3>Live Leagues</h3>
    <table class="feature-table dark-gray">
        <thead>
            <tr> 
                <th width="40%">Name</th> 
                <th width="18%">Rules</th>
                <th width="12%">Players</th>
                <th width="21%">League Ends?</th>
            </tr>
        </thead>
        <tbody>
            @foreach($authUser->inLeagues()->where('auction_stage', '3')->orderBy('name', 'asc')->get() as $league)
            <tr>
                <td><a class="btn btn-mini btn-danger" href="{{URL('roster/'.$league->id)}}">{{$league->name}}</a></td>
                <td>{{$league->rule_set->name}}</td>
                <td>{{count($league->players)}}</td>
                <td>{{date("jS M Y H:i", strtotime($league->end_date))}}</td>
            </tr>
            @endforeach
        </tbody>
    </table><!--/ feature-table-->
    @endif

    @if($authUser->inLeagues()->where('auction_stage', '<', '2')->orWhereNull('auction_stage')->count() > 0)
    <h3>Leagues due to start</h3>
    <table class="feature-table dark-gray">
        <thead>
            <tr> 
                <th width="49%">Name</th> 
                <th width="15%">Players</th>
                <th width="18%">Started?</th>
                <th width="18%">Ends?</th>
            </tr>
        </thead>
        <tbody>
            @foreach($authUser->inLeagues()->where('auction_stage', '<', '2')->orderBy('name', 'asc')->get() as $league)
            <tr>
                @if($league->auction_stage < 3)
                <td><a class="btn btn-mini btn-danger" href="{{URL('league-show/'.$league->id)}}">{{$league->name}}</a></td>
                @else
                <td><a class="btn btn-mini btn-danger" href="{{URL('roster/'.$league->id)}}">{{$league->name}}</a></td>
                @endif
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
            </tr>
            @endforeach
        </tbody>
    </table><!--/ feature-table-->
    @endif

    @if($authUser->inLeagues()->where('auction_stage', '<', '4')->count() == 0)
    <p>You are not part of any leagues currently.</p>
    @endif

    <h2>Leagues Owned</h2>

    @if($authUser->leagues->count() > 0)
    <p>Here are the leagues you own:</p>

    <table class="feature-table dark-gray">
        <thead>
            <tr> 
                <th width="49%">Name</th> 
                <th width="15%">Players</th>
                <th width="18%">Started?</th>
                <th width="18%">Ends?</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($authUser->leagues as $league)
            <tr>
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
                <td><a class="button small dark" href="{{URL('league/'.$league->id.'/manage')}}">Manage</a></td>
            </tr>
            @endforeach
        </tbody>
    </table><!--/ feature-table-->
    @else
    <p>You don't currently own any leagues.</p>
    @endif

</section>    
@endsection