@extends('layouts.admin')

@section('content')
<div class="content">

    <div class="module">
        <div class="module-head">
            <h3>Add Rule Set</h3>
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

                {!! Form::open(array('route' => 'rulesets.store', 'class'=>'form-horizontal row-fluid')) !!}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <h3>Basic Details</h3>
                    <div class="control-group">
                        <label class="control-label" for="LeagueName">Rule Set Name</label>
                        <div class="controls">
                            {!! Form::text('name', null, ['class'=>'span8', 'placeholder'=>'Enter rule set name here...']) !!}
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="LeagueName">Rule Set Description</label>
                        <div class="controls">
                            {!! Form::textarea('description', null, ['class'=>'span8']) !!}
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="LeagueName">Admin Only?</label>
                        <div class="controls">
                            {!! Form::select('admin_only', ["N"=>"No", "Y" => "Yes"], null, ['class'=>'span2']) !!}
                            <span class="help-inline">Set this to be yes if you only want it to be available on admin. Can also be used to hide rule sets.</span>
                        </div>
                    </div>

                    <h3>Game Specification</h3>

                    <div class="control-group">
                        <label class="control-label" for="LeagueName">Blind?</label>
                        <div class="controls">
                            {!! Form::select('blind_bid', ["N"=>"No", "Y" => "Yes"], null, ['class'=>'span2']) !!}
                            <span class="help-inline">Use this option if you wish for players to have only one bid per auction.</span>
                        </div>
                    </div>

                    <h3>League Details &amp; Roster Details</h3>
                    <div class="control-group">
                        <label class="control-label" for="LeagueName">No Of Players</label>
                        <div class="controls">
                            {!! Form::select('min_players', [1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6, 7=>7, 8=>8, 9=>9, 10=>10], null, ['class'=>'span2']) !!} to 
                            {!! Form::select('max_players', [1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6, 7=>7, 8=>8, 9=>9, 10=>10, 11=>11, 12=>12, 13=>13, 14=>14, 15=>15], null, ['class'=>'span2']) !!}
                            <span class="help-inline">Between 4 and 15 players.</span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="LeagueName">No Of Movies</label>
                        <div class="controls">
                            {!! Form::select('min_movies', [10=>10, 20=>20, 30=>30, 40=>40, 50=>50, 60=>60, 70=>70], null, ['class'=>'span2']) !!} to 
                            {!! Form::select('max_movies', [10=>10, 20=>20, 30=>30, 40=>40, 50=>50, 60=>60, 70=>70, 80=>80, 90=>90, 100=>100], null, ['class'=>'span2']) !!}
                            <span class="help-inline">Between 10 and 100 movies.</span>

                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="LeagueName">Movie Takings Duration</label>
                        <div class="controls">
                            <div class="input-append">
                                {!! Form::text('movie_takings_duration', null, ['class'=>'span2', 'placeholder'=>'8']) !!}
                                <span class="add-on">weeks</span>
                            </div><br/>
                            <span class="help-inline">This can be used to override the standard 2 months that are expected.</span>
                        </div>
                    </div>

                    <h3>Auction Details</h3>
                    <div class="control-group">
                        <label class="control-label" for="LeagueName">Auction Duration</label>
                        <div class="controls">
                            <div class="input-append">
                                {!! Form::text('auction_duration', null, ['class'=>'span2', 'placeholder'=>'8']) !!}
                                <span class="add-on">hours</span>
                            </div><br/>
                            <span class="help-inline">Total duration of the auction including any rounds.</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="LeagueName">Round Duration</label>
                        <div class="controls">
                            <div class="input-append">
                                {!! Form::text('round_duration', null, ['class'=>'span2', 'placeholder'=>'0']) !!}
                                <span class="add-on">hours</span>
                            </div><br/>
                            <span class="help-inline">This is only beneficial if the quantity of movies is split up.</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="LeagueName">Film Countdown</label>
                        <div class="controls">
                            <div class="input-append">
                                {!! Form::text('ind_film_countdown', null, ['class'=>'span2', 'placeholder'=>'10']) !!}
                                <span class="add-on">mins</span>
                            </div><br/>
                            <span class="help-inline">Each film once it appears on the list counts down at the start.</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="LeagueName">Min/Max Bid</label>
                        <div class="controls">
                            {!! Form::text('min_bid', null, ['class'=>'span2']) !!} to 
                            {!! Form::text('max_bid', null, ['class'=>'span2']) !!}
                            <span class="help-inline">Leave bid amount empty if there is no limit.</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="LeagueName">Start / Finish Times</label>
                        <div class="controls">
                            {!! Form::text('start_time', null, ['class'=>'span2']) !!} to {!! Form::text('close_time', null, ['class'=>'span2']) !!}
                            <span class="help-inline">Start and finish time (NOTE This will need to depend on the auction duration).</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="LeagueName">Minimum Denominations</label>
                        <div class="controls">
                            {!! Form::text('denomination', null, ['class'=>'span2']) !!}
                            <span class="help-inline">Whats the lowest denomination that can be used? Use 0.1 for 10cents, and 3 for 3 dollars.</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="LeagueName">Auction Time-out</label>
                        <div class="controls">
                            <div class="input-append">
                                {!! Form::text('auction_timeout', null, ['class'=>'span2', 'placeholder'=>'0']) !!}
                                <span class="add-on">mins</span>
                            </div><br/>
                        <span class="help-inline">Put in the number of minutes till this auction is closed off after previous bid. If this is zero then it just waits till end of auction.</span>
                        </div>
                    </div>

                    <h3>Movie Selection</h3>
                    <div class="control-group">
                        <label class="control-label" for="LeagueName">Randomizer</label>
                        <div class="controls">
                            {!! Form::select('randomizer', ["Y"=>"Yes", "N" => "No"], null, ['class'=>'span2']) !!}
                            <span class="help-inline">This is used with the auction movie release - if not All then it will randomly choose films for each group.</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="LeagueName">Auto-select</label>
                        <div class="controls">
                            {!! Form::select('auto_select', ["Y"=>"Yes", "N" => "No"], null, ['class'=>'span2']) !!}
                            <span class="help-inline">Auto select the movies for using.</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="LeagueName">Auction Movie Release</label>
                        <div class="controls">
                            <div class="input-append">
                                {!! Form::text('auction_movie_release', null, ['class'=>'span2', 'placeholder'=>'0']) !!}
                                <span class="add-on">number of movies</span>
                            </div><br/>
                            <span class="help-inline">Leave zero for all movies or use a group of movies e.g. 10.</span>
                        </div>
                    </div>

                    <h3>Miscellaneous</h3>
                    <div class="control-group">
                        <label class="control-label" for="LeagueName">Joint Ownership</label>
                        <div class="controls">
                            {!! Form::select('joint_ownership', ["Y"=>"Yes", "N" => "No"], null, ['class'=>'span2']) !!}
                            <span class="help-inline">(NOT USED).</span>
                        </div>
                    </div>


                    <div class="control-group">
                        <div class="controls">
                            <button type="submit" class="btn btn-primary pull-right">Save New Rule Set</button>
                        </div>
                    </div>
                </form>
        </div>
    </div>

    
    
</div>
@endsection