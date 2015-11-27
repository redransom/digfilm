@extends('layouts.admin')

@section('content')
<div class="content">

    <div class="module">
        <div class="module-head">
            <h3>Edit League</h3>
        </div>
        <div class="module-body">

                @if (count($errors) > 0)
                @foreach ($errors->all() as $error)
                <div class="alert">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>Warning!</strong>{{ $error }}
                </div>
                @endforeach
                @endif

                <br />
                {!! Form::open(array('route' => array('leagues.update', $league->id), 'class'=>'form-horizontal row-fluid', 'method'=>'PUT')) !!}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="control-group">
                        <label class="control-label" for="LeagueName">Name</label>
                        <div class="controls">
                            {!! Form::text('name', $league->name, ['class'=>'span8', 'placeholder'=>'Enter league name here...']) !!}
                            <span class="help-inline">Minimum 4 Characters.</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="LeagueUsersId">League Owner</label>
                        <div class="controls">
                            {!! Form::select('users_id', $users, $league->users_id, ['class'=>'span8']) !!}
                            <span class="help-inline">Who owns this league?</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="LeagueName">Public/Private</label>
                        <div class="controls">
                            {!! Form::select('type', ["U"=>"Public", "R" => "Private"], $league->type, ['class'=>'span4']) !!}
                            <span class="help-inline">Is it available for anyone to join (PUBLIC) or just those invited (PRIVATE).</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="LeagueRuleSet">Rule Set</label>
                        <div class="controls">
                            {!! Form::select('rule_set', [null=>'Please Select'] + $sets, null, ['class'=>'span8']) !!}
                            <span class="help-inline">Which default options to use?</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="LeagueStartDate">Start Date</label>
                        <div class="controls">
                            {!! Form::text('auction_start_date', $league->auction_start_date, ['class'=>'span8', 'placeholder'=>'YYYY-MM-DD HH:mm:SS']) !!}
                            <span class="help-inline">When does the auction start?</span>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label" for="LeagueCloseDate">Close Date</label>
                        <div class="controls">
                            {!! Form::text('auction_close_date', $league->auction_close_date, ['class'=>'span8', 'placeholder'=>'YYYY-MM-DD HH:mm:SS']) !!}
                            <span class="help-inline">When does the auction finish?</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="LeagueAuctionStage">Status</label>
                        <div class="controls">
                            {!! Form::select('auction_stage', [-1=>'Not Ready', '0'=>'League Ready for Auction', '1'=>'Movies Chosen', '2'=>'Auctions Live', '3'=>'Roster', '4'=>'League Ended'], $league->auction_stage, ['class'=>'span8']) !!}
                            <span class="help-inline">Change status of league auctions using this option</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <div class="controls">
                            <button type="submit" class="btn btn-primary pull-right">Save League</button>
                        </div>
                    </div>
                </form>
        </div>
    </div>

    
    
</div>
@endsection