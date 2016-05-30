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
            <a href="{{URL('leagues/2')}}" class="btn-box big span4"><i class="icon-user"></i><b>{{$totals['liveLeaguesTotal']}}</b>
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
                            <b>Expenses</b></a>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <a href="#" class="btn-box small span4"><i class="icon-save"></i>
                            <b>{{$totals['LiveMovies']}}</b>Live Movies</a>
                        <a href="#" class="btn-box small span4"><i class="icon-bullhorn"></i>
                            <b>{{$totals['MoviesOnRelease']}}</b>On Release</a>
                        <a href="#" class="btn-box small span4"><i class="icon-sort-down"></i>
                            <b>Bounce Rate</b></a>
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
    <!--/#btn-controls-->
    <!--div class="module">
        <div class="module-head">
            <h3>
                Profit Chart</h3>
        </div>
        <div class="module-body">
            <div class="chart inline-legend grid">
                <div id="placeholder2" class="graph" style="height: 500px">
                </div>
            </div>
        </div>
    </div-->
    <!--/.module-->
    <div class="module hide">
        <div class="module-head">
            <h3>
                Adjust Budget Range</h3>
        </div>
        <div class="module-body">
            <div class="form-inline clearfix">
                <a href="#" class="btn pull-right">Update</a>
                <label for="amount">
                    Price range:</label>
                &nbsp;
                <input type="text" id="amount" class="input-" />
            </div>
            <hr />
            <div class="slider-range">
            </div>
        </div>
    </div>
    <div class="module">
        <div class="module-head">
            <h3>
                DataTables</h3>
        </div>
        <div class="module-body table">
            <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped  display"
                width="100%">
                <thead>
                    <tr>
                        <th>
                            Rendering engine
                        </th>
                        <th>
                            Browser
                        </th>
                        <th>
                            Platform(s)
                        </th>
                        <th>
                            Engine version
                        </th>
                        <th>
                            CSS grade
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="odd gradeX">
                        <td>
                            Trident
                        </td>
                        <td>
                            Internet Explorer 4.0
                        </td>
                        <td>
                            Win 95+
                        </td>
                        <td class="center">
                            4
                        </td>
                        <td class="center">
                            X
                        </td>
                    </tr>
                    <tr class="even gradeC">
                        <td>
                            Trident
                        </td>
                        <td>
                            Internet Explorer 5.0
                        </td>
                        <td>
                            Win 95+
                        </td>
                        <td class="center">
                            5
                        </td>
                        <td class="center">
                            C
                        </td>
                    </tr>
                    <tr class="odd gradeA">
                        <td>
                            Trident
                        </td>
                        <td>
                            Internet Explorer 5.5
                        </td>
                        <td>
                            Win 95+
                        </td>
                        <td class="center">
                            5.5
                        </td>
                        <td class="center">
                            A
                        </td>
                    </tr>
                    <tr class="even gradeA">
                        <td>
                            Trident
                        </td>
                        <td>
                            Internet Explorer 6
                        </td>
                        <td>
                            Win 98+
                        </td>
                        <td class="center">
                            6
                        </td>
                        <td class="center">
                            A
                        </td>
                    </tr>
                    <tr class="odd gradeA">
                        <td>
                            Trident
                        </td>
                        <td>
                            Internet Explorer 7
                        </td>
                        <td>
                            Win XP SP2+
                        </td>
                        <td class="center">
                            7
                        </td>
                        <td class="center">
                            A
                        </td>
                    </tr>
                    <tr class="even gradeA">
                        <td>
                            Trident
                        </td>
                        <td>
                            AOL browser (AOL desktop)
                        </td>
                        <td>
                            Win XP
                        </td>
                        <td class="center">
                            6
                        </td>
                        <td class="center">
                            A
                        </td>
                    </tr>
                    <tr class="gradeA">
                        <td>
                            Gecko
                        </td>
                        <td>
                            Firefox 1.0
                        </td>
                        <td>
                            Win 98+ / OSX.2+
                        </td>
                        <td class="center">
                            1.7
                        </td>
                        <td class="center">
                            A
                        </td>
                    </tr>
                    <tr class="gradeA">
                        <td>
                            Gecko
                        </td>
                        <td>
                            Firefox 1.5
                        </td>
                        <td>
                            Win 98+ / OSX.2+
                        </td>
                        <td class="center">
                            1.8
                        </td>
                        <td class="center">
                            A
                        </td>
                    </tr>
                    <tr class="gradeA">
                        <td>
                            Gecko
                        </td>
                        <td>
                            Firefox 2.0
                        </td>
                        <td>
                            Win 98+ / OSX.2+
                        </td>
                        <td class="center">
                            1.8
                        </td>
                        <td class="center">
                            A
                        </td>
                    </tr>
                    <tr class="gradeA">
                        <td>
                            Gecko
                        </td>
                        <td>
                            Firefox 3.0
                        </td>
                        <td>
                            Win 2k+ / OSX.3+
                        </td>
                        <td class="center">
                            1.9
                        </td>
                        <td class="center">
                            A
                        </td>
                    </tr>
                    <tr class="gradeA">
                        <td>
                            Gecko
                        </td>
                        <td>
                            Camino 1.0
                        </td>
                        <td>
                            OSX.2+
                        </td>
                        <td class="center">
                            1.8
                        </td>
                        <td class="center">
                            A
                        </td>
                    </tr>
                    <tr class="gradeA">
                        <td>
                            Gecko
                        </td>
                        <td>
                            Camino 1.5
                        </td>
                        <td>
                            OSX.3+
                        </td>
                        <td class="center">
                            1.8
                        </td>
                        <td class="center">
                            A
                        </td>
                    </tr>
                    <tr class="gradeA">
                        <td>
                            Gecko
                        </td>
                        <td>
                            Netscape 7.2
                        </td>
                        <td>
                            Win 95+ / Mac OS 8.6-9.2
                        </td>
                        <td class="center">
                            1.7
                        </td>
                        <td class="center">
                            A
                        </td>
                    </tr>
                    <tr class="gradeA">
                        <td>
                            Gecko
                        </td>
                        <td>
                            Netscape Browser 8
                        </td>
                        <td>
                            Win 98SE+
                        </td>
                        <td class="center">
                            1.7
                        </td>
                        <td class="center">
                            A
                        </td>
                    </tr>
                    <tr class="gradeA">
                        <td>
                            Gecko
                        </td>
                        <td>
                            Netscape Navigator 9
                        </td>
                        <td>
                            Win 98+ / OSX.2+
                        </td>
                        <td class="center">
                            1.8
                        </td>
                        <td class="center">
                            A
                        </td>
                    </tr>
                    <tr class="gradeA">
                        <td>
                            Gecko
                        </td>
                        <td>
                            Mozilla 1.0
                        </td>
                        <td>
                            Win 95+ / OSX.1+
                        </td>
                        <td class="center">
                            1
                        </td>
                        <td class="center">
                            A
                        </td>
                    </tr>
                    <tr class="gradeA">
                        <td>
                            Gecko
                        </td>
                        <td>
                            Mozilla 1.1
                        </td>
                        <td>
                            Win 95+ / OSX.1+
                        </td>
                        <td class="center">
                            1.1
                        </td>
                        <td class="center">
                            A
                        </td>
                    </tr>
                    <tr class="gradeA">
                        <td>
                            Gecko
                        </td>
                        <td>
                            Mozilla 1.2
                        </td>
                        <td>
                            Win 95+ / OSX.1+
                        </td>
                        <td class="center">
                            1.2
                        </td>
                        <td class="center">
                            A
                        </td>
                    </tr>
                    <tr class="gradeA">
                        <td>
                            Gecko
                        </td>
                        <td>
                            Mozilla 1.3
                        </td>
                        <td>
                            Win 95+ / OSX.1+
                        </td>
                        <td class="center">
                            1.3
                        </td>
                        <td class="center">
                            A
                        </td>
                    </tr>
                    <tr class="gradeA">
                        <td>
                            Gecko
                        </td>
                        <td>
                            Mozilla 1.4
                        </td>
                        <td>
                            Win 95+ / OSX.1+
                        </td>
                        <td class="center">
                            1.4
                        </td>
                        <td class="center">
                            A
                        </td>
                    </tr>
                    <tr class="gradeA">
                        <td>
                            Gecko
                        </td>
                        <td>
                            Mozilla 1.5
                        </td>
                        <td>
                            Win 95+ / OSX.1+
                        </td>
                        <td class="center">
                            1.5
                        </td>
                        <td class="center">
                            A
                        </td>
                    </tr>
                    <tr class="gradeA">
                        <td>
                            Gecko
                        </td>
                        <td>
                            Mozilla 1.6
                        </td>
                        <td>
                            Win 95+ / OSX.1+
                        </td>
                        <td class="center">
                            1.6
                        </td>
                        <td class="center">
                            A
                        </td>
                    </tr>
                    <tr class="gradeA">
                        <td>
                            Gecko
                        </td>
                        <td>
                            Mozilla 1.7
                        </td>
                        <td>
                            Win 98+ / OSX.1+
                        </td>
                        <td class="center">
                            1.7
                        </td>
                        <td class="center">
                            A
                        </td>
                    </tr>
                    <tr class="gradeA">
                        <td>
                            Gecko
                        </td>
                        <td>
                            Mozilla 1.8
                        </td>
                        <td>
                            Win 98+ / OSX.1+
                        </td>
                        <td class="center">
                            1.8
                        </td>
                        <td class="center">
                            A
                        </td>
                    </tr>
                    <tr class="gradeA">
                        <td>
                            Gecko
                        </td>
                        <td>
                            Seamonkey 1.1
                        </td>
                        <td>
                            Win 98+ / OSX.2+
                        </td>
                        <td class="center">
                            1.8
                        </td>
                        <td class="center">
                            A
                        </td>
                    </tr>
                    <tr class="gradeA">
                        <td>
                            Gecko
                        </td>
                        <td>
                            Epiphany 2.20
                        </td>
                        <td>
                            Gnome
                        </td>
                        <td class="center">
                            1.8
                        </td>
                        <td class="center">
                            A
                        </td>
                    </tr>
                    <tr class="gradeA">
                        <td>
                            Webkit
                        </td>
                        <td>
                            Safari 1.2
                        </td>
                        <td>
                            OSX.3
                        </td>
                        <td class="center">
                            125.5
                        </td>
                        <td class="center">
                            A
                        </td>
                    </tr>
                    <tr class="gradeA">
                        <td>
                            Webkit
                        </td>
                        <td>
                            Safari 1.3
                        </td>
                        <td>
                            OSX.3
                        </td>
                        <td class="center">
                            312.8
                        </td>
                        <td class="center">
                            A
                        </td>
                    </tr>
                    <tr class="gradeA">
                        <td>
                            Webkit
                        </td>
                        <td>
                            Safari 2.0
                        </td>
                        <td>
                            OSX.4+
                        </td>
                        <td class="center">
                            419.3
                        </td>
                        <td class="center">
                            A
                        </td>
                    </tr>
                    <tr class="gradeA">
                        <td>
                            Webkit
                        </td>
                        <td>
                            Safari 3.0
                        </td>
                        <td>
                            OSX.4+
                        </td>
                        <td class="center">
                            522.1
                        </td>
                        <td class="center">
                            A
                        </td>
                    </tr>
                    <tr class="gradeA">
                        <td>
                            Webkit
                        </td>
                        <td>
                            OmniWeb 5.5
                        </td>
                        <td>
                            OSX.4+
                        </td>
                        <td class="center">
                            420
                        </td>
                        <td class="center">
                            A
                        </td>
                    </tr>
                    <tr class="gradeA">
                        <td>
                            Webkit
                        </td>
                        <td>
                            iPod Touch / iPhone
                        </td>
                        <td>
                            iPod
                        </td>
                        <td class="center">
                            420.1
                        </td>
                        <td class="center">
                            A
                        </td>
                    </tr>
                    <tr class="gradeA">
                        <td>
                            Webkit
                        </td>
                        <td>
                            S60
                        </td>
                        <td>
                            S60
                        </td>
                        <td class="center">
                            413
                        </td>
                        <td class="center">
                            A
                        </td>
                    </tr>
                    <tr class="gradeA">
                        <td>
                            Presto
                        </td>
                        <td>
                            Opera 7.0
                        </td>
                        <td>
                            Win 95+ / OSX.1+
                        </td>
                        <td class="center">
                            -
                        </td>
                        <td class="center">
                            A
                        </td>
                    </tr>
                    <tr class="gradeA">
                        <td>
                            Presto
                        </td>
                        <td>
                            Opera 7.5
                        </td>
                        <td>
                            Win 95+ / OSX.2+
                        </td>
                        <td class="center">
                            -
                        </td>
                        <td class="center">
                            A
                        </td>
                    </tr>
                    <tr class="gradeA">
                        <td>
                            Presto
                        </td>
                        <td>
                            Opera 8.0
                        </td>
                        <td>
                            Win 95+ / OSX.2+
                        </td>
                        <td class="center">
                            -
                        </td>
                        <td class="center">
                            A
                        </td>
                    </tr>
                    <tr class="gradeA">
                        <td>
                            Presto
                        </td>
                        <td>
                            Opera 8.5
                        </td>
                        <td>
                            Win 95+ / OSX.2+
                        </td>
                        <td class="center">
                            -
                        </td>
                        <td class="center">
                            A
                        </td>
                    </tr>
                    <tr class="gradeA">
                        <td>
                            Presto
                        </td>
                        <td>
                            Opera 9.0
                        </td>
                        <td>
                            Win 95+ / OSX.3+
                        </td>
                        <td class="center">
                            -
                        </td>
                        <td class="center">
                            A
                        </td>
                    </tr>
                    <tr class="gradeA">
                        <td>
                            Presto
                        </td>
                        <td>
                            Opera 9.2
                        </td>
                        <td>
                            Win 88+ / OSX.3+
                        </td>
                        <td class="center">
                            -
                        </td>
                        <td class="center">
                            A
                        </td>
                    </tr>
                    <tr class="gradeA">
                        <td>
                            Presto
                        </td>
                        <td>
                            Opera 9.5
                        </td>
                        <td>
                            Win 88+ / OSX.3+
                        </td>
                        <td class="center">
                            -
                        </td>
                        <td class="center">
                            A
                        </td>
                    </tr>
                    <tr class="gradeA">
                        <td>
                            Presto
                        </td>
                        <td>
                            Opera for Wii
                        </td>
                        <td>
                            Wii
                        </td>
                        <td class="center">
                            -
                        </td>
                        <td class="center">
                            A
                        </td>
                    </tr>
                    <tr class="gradeA">
                        <td>
                            Presto
                        </td>
                        <td>
                            Nokia N800
                        </td>
                        <td>
                            N800
                        </td>
                        <td class="center">
                            -
                        </td>
                        <td class="center">
                            A
                        </td>
                    </tr>
                    <tr class="gradeA">
                        <td>
                            Presto
                        </td>
                        <td>
                            Nintendo DS browser
                        </td>
                        <td>
                            Nintendo DS
                        </td>
                        <td class="center">
                            8.5
                        </td>
                        <td class="center">
                            C/A<sup>1</sup>
                        </td>
                    </tr>
                    <tr class="gradeC">
                        <td>
                            KHTML
                        </td>
                        <td>
                            Konqureror 3.1
                        </td>
                        <td>
                            KDE 3.1
                        </td>
                        <td class="center">
                            3.1
                        </td>
                        <td class="center">
                            C
                        </td>
                    </tr>
                    <tr class="gradeA">
                        <td>
                            KHTML
                        </td>
                        <td>
                            Konqureror 3.3
                        </td>
                        <td>
                            KDE 3.3
                        </td>
                        <td class="center">
                            3.3
                        </td>
                        <td class="center">
                            A
                        </td>
                    </tr>
                    <tr class="gradeA">
                        <td>
                            KHTML
                        </td>
                        <td>
                            Konqureror 3.5
                        </td>
                        <td>
                            KDE 3.5
                        </td>
                        <td class="center">
                            3.5
                        </td>
                        <td class="center">
                            A
                        </td>
                    </tr>
                    <tr class="gradeX">
                        <td>
                            Tasman
                        </td>
                        <td>
                            Internet Explorer 4.5
                        </td>
                        <td>
                            Mac OS 8-9
                        </td>
                        <td class="center">
                            -
                        </td>
                        <td class="center">
                            X
                        </td>
                    </tr>
                    <tr class="gradeC">
                        <td>
                            Tasman
                        </td>
                        <td>
                            Internet Explorer 5.1
                        </td>
                        <td>
                            Mac OS 7.6-9
                        </td>
                        <td class="center">
                            1
                        </td>
                        <td class="center">
                            C
                        </td>
                    </tr>
                    <tr class="gradeC">
                        <td>
                            Tasman
                        </td>
                        <td>
                            Internet Explorer 5.2
                        </td>
                        <td>
                            Mac OS 8-X
                        </td>
                        <td class="center">
                            1
                        </td>
                        <td class="center">
                            C
                        </td>
                    </tr>
                    <tr class="gradeA">
                        <td>
                            Misc
                        </td>
                        <td>
                            NetFront 3.1
                        </td>
                        <td>
                            Embedded devices
                        </td>
                        <td class="center">
                            -
                        </td>
                        <td class="center">
                            C
                        </td>
                    </tr>
                    <tr class="gradeA">
                        <td>
                            Misc
                        </td>
                        <td>
                            NetFront 3.4
                        </td>
                        <td>
                            Embedded devices
                        </td>
                        <td class="center">
                            -
                        </td>
                        <td class="center">
                            A
                        </td>
                    </tr>
                    <tr class="gradeX">
                        <td>
                            Misc
                        </td>
                        <td>
                            Dillo 0.8
                        </td>
                        <td>
                            Embedded devices
                        </td>
                        <td class="center">
                            -
                        </td>
                        <td class="center">
                            X
                        </td>
                    </tr>
                    <tr class="gradeX">
                        <td>
                            Misc
                        </td>
                        <td>
                            Links
                        </td>
                        <td>
                            Text only
                        </td>
                        <td class="center">
                            -
                        </td>
                        <td class="center">
                            X
                        </td>
                    </tr>
                    <tr class="gradeX">
                        <td>
                            Misc
                        </td>
                        <td>
                            Lynx
                        </td>
                        <td>
                            Text only
                        </td>
                        <td class="center">
                            -
                        </td>
                        <td class="center">
                            X
                        </td>
                    </tr>
                    <tr class="gradeC">
                        <td>
                            Misc
                        </td>
                        <td>
                            IE Mobile
                        </td>
                        <td>
                            Windows Mobile 6
                        </td>
                        <td class="center">
                            -
                        </td>
                        <td class="center">
                            C
                        </td>
                    </tr>
                    <tr class="gradeC">
                        <td>
                            Misc
                        </td>
                        <td>
                            PSP browser
                        </td>
                        <td>
                            PSP
                        </td>
                        <td class="center">
                            -
                        </td>
                        <td class="center">
                            C
                        </td>
                    </tr>
                    <tr class="gradeU">
                        <td>
                            Other browsers
                        </td>
                        <td>
                            All others
                        </td>
                        <td>
                            -
                        </td>
                        <td class="center">
                            -
                        </td>
                        <td class="center">
                            U
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th>
                            Rendering engine
                        </th>
                        <th>
                            Browser
                        </th>
                        <th>
                            Platform(s)
                        </th>
                        <th>
                            Engine version
                        </th>
                        <th>
                            CSS grade
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <!--/.module-->
</div>
@endsection