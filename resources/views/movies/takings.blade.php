@extends('layouts.admin')

@section('content')
<div class="content">
    <div class="module">
    <script>
    $(function() {
        $('#takings_at').datetimepicker({
            format: 'Y-m-d'
        });
    });    
    </script>

        <div class="module-head">
            <h3>Add Takings to Movie {{$movie->name}}</h3>
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

            @if($takings->count() > 0)
            <h4>Takings</h4>
            <ul class="unstyled">
            @foreach($takings as $taking)
                <li>{{intval($taking->amount) / 1000000}}M {{$taking->country}} {{$taking->takings_at}}</li>
            @endforeach
            </ul>
            @endif
            <br />
            {!! Form::open(array('route' => array('add-takings', $movie->id), 'class'=>'form-horizontal row-fluid')) !!}
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="movies_id" value="{{ $movie->id }}">
                <div class="control-group">
                    <label class="control-label" for="TakingAmount">Amount</label>
                    <div class="controls">
                        {!! Form::text('amount', null, ['class'=>'span8', 'placeholder'=>'Enter takings here...']) !!}
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="TakingCountry">Currency</label>
                    <div class="controls">
                        {!! Form::select('country', $countries, null, ['class'=>'span8']) !!}
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="TakingTakingsAt">At Which Date?</label>
                    <div class="controls">
                        {!! Form::text('takings_at', null, ['class'=>'span8', 'placeholder'=>'YYYY-MM-DD', 'id'=>'takings_at']) !!}
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn btn-primary pull-right">Add Takings</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection