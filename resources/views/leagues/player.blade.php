@extends('layouts.admin')

@section('content')
    <div class="module">
        <div class="module-head">
            <h3>Add Player to League {{$league->name}}</h3>
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

                <p>NOTE: Need to make sure the below players list is only of players who have not already joined the league.</p>
                <br />
                {!! Form::open(array('route' => array('add-player', $league->id), 'class'=>'form-horizontal row-fluid')) !!}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="league_id" value="{{ $league->id }}">
                    <div class="control-group">
                        <label class="control-label" for="MovieName">Player</label>
                        <div class="controls">
                            {!! Form::select('user_id', $players, null, ['class'=>'span8']) !!}
                        </div>
                    </div>

                    <div class="control-group">
                        <div class="controls">
                            <button type="submit" class="btn btn-primary pull-right">Add Player</button>
                        </div>
                    </div>
                </form>
        </div>
    </div>
@endsection