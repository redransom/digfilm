@extends('layouts.users')

@section('content')
<section class="entry sbr clearfix">
    <div class="title-caption-large">
        <h3>Dashboard</h3>
    </div>

    <h1>Hi {{$authUser->forenames}}, Welcome to TheNextBigFilm today.</h1>

    <h2>Leagues Participating in</h2>
    <p>Here are the leagues you are in:</p>
    @if($authUser->inLeagues->count() > 0)
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
            @foreach($authUser->inLeagues as $league)
            <tr>
                @if($league->auction_stage < 3)
                <td><a class="btn btn-mini btn-danger" href="{{URL('league/'.$league->id)}}">{{$league->name}}</a></td>
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
    @else
    <p>You are not part of any leagues currently.</p>
    @endif
    
    <h2>Leagues Owned</h2>

    @if($authUser->leagues->count() > 0)
    <p>Here are the leagues you own:</p>

    <!-- ************ - Tabs - ************** -->   
    <div class="tabs1 widget">
        
        <ul class="tabs-nav">
            @foreach($authUser->leagues as $league)
            <li><a href="#tab{{$league->id}}">{{$league->name}}</a></li>
            @endforeach
        </ul>

        <div class="tabs-container">
            
            @foreach($authUser->leagues as $league)
            <div id="tab{{$league->id}}" class="tab-content">
            Currently has the following players:<br/>
            <br/>
            @if(!is_null($league->auction_start_date))
            Starts at <strong>{{date("jS M Y", strtotime($league->auction_start_date))}}</strong>
            @else
            Needs more players!
            @endif
            &nbsp;&nbsp;

            <a class="button small dark" href="{{URL('league/'.$league->id.'/manage')}}">Manage</a>
            </div>
            @endforeach
        </div>
    </div>
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
            </tr>
            @endforeach
        </tbody>
    </table><!--/ feature-table-->
    @else
    <p>You currently own no leagues.</p>
    @endif

</section>    
@endsection