@extends('layouts.admin')

@section('content')

<div class="content">
    <div class="btn-controls">
        <div class="btn-box-row row-fluid">
            @if(isset($totals['liveAuctionTotal']))
            <a href="{{URL('auctions')}}" class="btn-box big span4"><i class=" icon-random"></i><b>{{$totals['liveAuctionTotal']}}</b>
                <p class="text-muted">
                    Movies being auctioned</p>
            </a>
            @endif
            @if(isset($totals['liveRostersTotal']))
            <a href="{{URL('leagues/2')}}" class="btn-box big span4"><i class="icon-user"></i><b>{{$totals['liveRostersTotal']}}</b>
                <p class="text-muted">
                    Live Rosters</p>
            </a>
            @endif
            @if(isset($totals['liveLeaguesTotal']))
            <a href="{{URL('leagues/2')}}" class="btn-box big span4"><i class="icon-th"></i><b>{{$totals['liveLeaguesTotal']}}</b>
                <p class="text-muted">
                    Live Leagues</p>
            </a>
            @endif
        </div>
        <div class="btn-box-row row-fluid">
            <div class="span8">
                <div class="row-fluid">
                    <div class="span12">
                        <a href="#" class="btn-box small span4"><i class="icon-envelope"></i>
                            <b>{{$totals['TotalMovies']}}</b>
                            Movies </a>
                        <a href="#" class="btn-box small span4"><i class="icon-group"></i>
                            <b>{{$totals['LivePlayers']}}</b>
                            Players</a>
                        <a href="#" class="btn-box small span4"><i class="icon-exchange"></i>
                            <b>{{$totals['liveAuctionsTotal']}}</b>
                            Live Auctions</a>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <a href="#" class="btn-box small span4"><i class="icon-save"></i>
                            <b>{{$totals['LiveMovies']}}</b>Live Movies</a>
                        <a href="#" class="btn-box small span4"><i class="icon-bullhorn"></i>
                            <b>{{$totals['MoviesOnRelease']}}</b>On Release</a>
                        <a href="#" class="btn-box small span4"><i class="icon-sort-down"></i>
                            <b>{{$totals['bidsTodayTotal']}}</b>Bids last 24 hours</a>
                    </div>
                </div>
            </div>

            <ul class="widget widget-usage unstyled span4">
            @if($totals['LeagueTotal'] > 0)
            @foreach($totals['RuleSetTotal'] as $rule_name => $rule_count)
                <li>
                    <p>
                        <strong>{{$rule_name}}</strong> <span class="pull-right small muted">{{number_format((($rule_count/$totals['LeagueTotal']) * 100), 0)}}%</span>
                    </p>
                    <div class="progress tight">
                        <div class="bar" style="width: {{number_format((($rule_count/$totals['LeagueTotal']) * 100), 0)}}%;">
                        </div>
                    </div>
                </li>
            @endforeach
            @endif
                <!--li>
                    <p>
                        <strong>Mac</strong> <span class="pull-right small muted">56%</span>
                    </p>
                    <div class="progress tight">
                        <div class="bar bar-success" style="width: 56%;">
                        </div>
                    </div>
                </li>
                <li>
                    <p>
                        <strong>Linux</strong> <span class="pull-right small muted">44%</span>
                    </p>
                    <div class="progress tight">
                        <div class="bar bar-warning" style="width: 44%;">
                        </div>
                    </div>
                </li>
                <li>
                    <p>
                        <strong>iPhone</strong> <span class="pull-right small muted">67%</span>
                    </p>
                    <div class="progress tight">
                        <div class="bar bar-danger" style="width: 67%;">
                        </div>
                    </div>
                </li-->
            </ul>
        </div>
    </div>
    <div class="module">
        <div class="module-head">
            <h3>Movie Takings Needed</h3>
        </div>
        <div class="module-body">
            @if(isset($totals['takings']))
                @foreach($totals['takings'] as $takings_key=>$takings_dates)
                <div style="width:90px; float: left; padding: 5px; margin: 5px;">
                <table class="table-bordered">
                    <tbody>
                    
                        <tr><td><strong>{{$movies[$takings_key]}}</strong></td></tr>
                        @foreach($takings_dates as $date)
                        <tr><td>&nbsp;&nbsp;<a href="{{Route('movie-add-takings', [$takings_key, $date])}}">{{date("d M Y", $date)}}</a></td></tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
                @endforeach
            @endif
            <div class="clear"></div>
        </div>
    </div>    
    
</div>
@endsection