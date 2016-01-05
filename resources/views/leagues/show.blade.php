@extends('layouts.admin')

@section('content')
                    <div class="module">
                        <div class="module-head">
                            <h3>{{$league->name}}</h3>
                        </div>
                        <div class="module-body">
                            @if(!is_null($league->file_name))
                            <div style="float:right; width:150px;">
                            <img src="{{asset($league->file_name)}}" width="140px">
                            </div>
                            @endif

                            <dl class="dl-horizontal">
                                <dt>Owned By</dt>
                                <dd>{{$league->Owner->name}}</dd>
                                @if(is_null($league->auction_start_date))
                                <dt>Created</dt>
                                <dd>{{date("j M y", strtotime($league->created_at))}}</dd>
                                @elseif(!is_null($league->auction_start_date) && $league->auction_stage < 2)
                                <dt>Due to Start</dt>
                                @else
                                <dt>Started</dt>
                                @endif
                                <dd>{{date("j M Y g:iA", strtotime($league->auction_start_date))}}</dd>
                                @if(!is_null($league->auction_close_date))
                                <dt>Close</dt>
                                <dd>{{date("j M Y g:iA", strtotime($league->auction_close_date))}}</dd>
                                @endif
                                <dt>Base Rules</dt>
                                <dd>{{$league->rule_set->name}}</dd>
                                <dt>Public/Private: </dt>
                                <dd>{{(($league->type == 'U') ? 'Public' : 'Private')}}</dd>   
                                @if(!is_null($league->round_amount))
                                <dt>No of Rounds</dt>
                                <dd>{{$league->round_amount}}</dd>
                                <dt>Current Round</dt>
                                <dd>{{$league->current_round}}  @if($league->current_round == $league->round_amount)
                                <strong>Finished!</strong>
                                @endif</dd>
                                <dt>Round End Date/Time</dt>
                                <dd>{{date("j M Y g:iA", strtotime($league->round_start_date))}}</dd>
                                @endif
                            </dl>
                            <a class="btn" href="{{route('leagues.edit', [$league->id])}}">Edit League</a>
                            &nbsp;
                            <a class="btn" href="{{URL('leagues/'.$league->id.'/rules')}}">Edit Rules</a>
                            
                        </div>
                    </div>

                    <div class="module">
                        <div class="module-head">
                            <h3>Players</h3>
                        </div>

                        <div class="module-body">
                        @if(!empty($players))
                        <ul class="unstyled">
                        @foreach ($players as $player)
                            <li><a href="{{URL('users', array('id'=>$player->id))}}">{{$player->fullName()}}</a>&nbsp;<a href="{{Route('league-remove-player', array($player->pivot->id))}}">x</a></li>
                        @endforeach
                        </ul>
                        @else
                        <p>The league has no players currently. </p>
                        @endif
                        @if($players->count() < $league->rule->min_players)
                        <p><strong>More players are needed for this league before it can go live.</strong></p>
                        @endif
                        @if($players->count() < $league->rule->max_players)
                        <ul class="inline">
                            <li><a href="{{Route('league-add-player', array('id'=>$league->id))}}">Add Player</a></li>
                        </ul>
                        @endif
                        </div>
                    </div>

                    <div class="module">
                        <div class="module-head">
                            <h3>Rules</h3>
                        </div>

                        <div class="module-body">
                        @if(!is_null($league->rule))
                            <dl>
                                <dt>Players</dt>
                                <dd>Min: {{$league->rule->min_players}} Max: {{$league->rule->max_players}}</dd>
                                <dt>Movies</dt>
                                <dd>Min: {{$league->rule->min_movies}} Max: {{$league->rule->max_movies}}</dd>
                                <dt>Durations</dt>
                                <dd>Auction: {{$league->rule->auction_duration}} hours <br/>Round: {{$league->rule->round_duration}} hours <br/>Movies: {{$league->rule->ind_film_countdown}} mins</dd>
                                <dt>Bids</dt>
                                <dd>Min: {{$league->rule->min_bid}} Max: {{$league->rule->max_bid}}</dd>
                                <dt>Start/End</dt>
                                <dd>Start Time: {{$league->rule->start_time}} End Time: {{$league->rule->end_time}}</dd>
                                <dt>Selection</dt>
                                <dd>Random: {{($league->rule->randomizer == "Y") ? "Yes" : "No"}} <br/>Auto-Select: {{($league->rule->auto_select == 'Y') ? "Yes" : "No"}} <br/>Grouped: {{$league->rule->auction_movie_release}}</dd>
                                <dt>Blind</dt>
                                <dd>{{$league->rule->blind_bid == "Y" ? "Yes" : "No"}}</dd>
                                <dt>Misc</dt>
                                <dd>Timeout: {{$league->rule->auction_timeout}} mins <br/>Denomination: {{$league->rule->denomination}} <br/>Movie Takings: {{$league->rule->movie_takings_duration}} weeks</dd>
                            </dl>
                        @else
                        <p>No rules have been selected so far - go to the <a href="{{URL('leagues/'.$league->id.'/edit')}}">Edit League</a> page</p>
                        @endif
                        </div>
                    </div>

                    <div class="module">
                        <div class="module-head">
                            <h3>Available Movies</h3>
                        </div>

                        <div class="module-body">
                            @if($league->Movies->count() > 0)
                            <ul class="inline">
                            @foreach($league->Movies as $movie)
                                <li>{{$movie->pivot->id}}: {{$movie->name}} <a href="{{URL('league-remove-movie', array($movie->pivot->id))}}">x</a></li>
                            @endforeach
                            </ul>
                            @else
                            <p>There are no movies associated with this league presently.</p>
                            @endif
                            <ul class="inline">
                                <li><a href="{{Route('league-add-movie', array('id'=>$league->id))}}">Add Movie</a></li>
                            </ul>
                        </div>
                    </div>
@endsection