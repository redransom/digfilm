@extends('layouts.admin')

@section('content')
<div class="content">
<script>
   /* $(document).ready(function(){
        $('#startdate').datetimepicker({
            formatTime:'H:i',
            formatDate:'Y-m-d'
        });
    });*/
</script>
    <div class="module">
        <div class="module-head">
            <h3>Add League</h3>
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
                {!! Form::open(array('route' => 'leagues.store', 'class'=>'form-horizontal row-fluid')) !!}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="control-group">
                        <label class="control-label" for="LeagueName">Name</label>
                        <div class="controls">
                            {!! Form::text('name', null, ['class'=>'span8', 'placeholder'=>'Enter league name here...']) !!}
                            <span class="help-inline">Minimum 4 Characters.</span>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label" for="LeagueName">League Owner</label>
                        <div class="controls">
                            {!! Form::select('users_id', $users, null, ['class'=>'span8']) !!}
                            <span class="help-inline">Who owns this league?</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="LeagueName">Rule Set</label>
                        <div class="controls">
                            {!! Form::select('rule_set', $sets, null, ['class'=>'span8']) !!}
                            <span class="help-inline">Which default options to use?</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="LeagueName">Public/Private</label>
                        <div class="controls">
                            {!! Form::select('type', ["U"=>"Public", "R" => "Private"], null, ['class'=>'span2']) !!}
                            <span class="help-inline">Is it available for anyone to join (PUBLIC) or just those invited (PRIVATE).</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="LeagueStartDate">Start Date</label>
                        <div class="controls">
                            {!! Form::text('auction_start_date', null, ['class'=>'span8', 'placeholder'=>'YYYY-MM-DD HH:mm:SS', 'id'=>'startdate']) !!}
                            <span class="help-inline">When does the auction start?</span>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label" for="LeagueCloseDate">Close Date</label>
                        <div class="controls">
                            {!! Form::text('auction_close_date', null, ['class'=>'span8', 'placeholder'=>'YYYY-MM-DD HH:mm:SS']) !!}
                            <span class="help-inline">When does the auction finish?</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="LeagueName">Auto-select</label>
                        <div class="controls">
                            {!! Form::select('auto_select', ["Y"=>"Yes", "N" => "No"], null, ['class'=>'span2']) !!}
                            <span class="help-inline">Auto select the movies for population.</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <div class="controls">
                            <button type="submit" class="btn btn-primary pull-right">Add League</button>
                        </div>
                    </div>
                </form>
        </div>
    </div>

    
    
</div>
@endsection