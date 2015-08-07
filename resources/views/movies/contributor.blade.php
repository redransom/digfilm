@extends('layouts.admin')

@section('content')
<div class="content">

    <div class="module">
        <div class="module-head">
            <h3>Add Contributor to Movie {{$movie->name}}</h3>
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
                {!! Form::open(array('route' => array('add-contributor', $movie->id), 'class'=>'form-horizontal row-fluid')) !!}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="movies_id" value="{{ $movie->id }}">
                    <div class="control-group">
                        <label class="control-label" for="MovieName">Contributor</label>
                        <div class="controls">
                            {!! Form::select('contributors_id', $contributors, null, ['class'=>'span8']) !!}
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="MovieSummary">as?</label>
                        <div class="controls">
                            {!! Form::select('contributor_types_id', $types, null, ['class'=>'span8']) !!}
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="MovieSummary">Star?</label>
                        <div class="controls">
                            {!! Form::checkbox('star', 'Y', ['class'=>'span8']) !!} Yes
                        </div>
                    </div>

                    <div class="control-group">
                        <div class="controls">
                            <button type="submit" class="btn btn-primary pull-right">Assign Contributor</button>
                        </div>
                    </div>
                </form>
        </div>
    </div>

    
    
</div>
@endsection