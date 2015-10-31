@extends('layouts.admin')

@section('content')
<div class="content">

    <div class="module">
        <div class="module-head">
            <h3>Add Movie</h3>
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
                {!! Form::open(array('route' => 'movies.store', 'class'=>'form-horizontal row-fluid')) !!}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="control-group">
                        <label class="control-label" for="MovieName">Name</label>
                        <div class="controls">
                            {!! Form::text('name', null, ['class'=>'span8', 'placeholder'=>'Enter movie name here...']) !!}
                            <span class="help-inline">Minimum 4 Characters.</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="MovieSummary">Summary</label>
                        <div class="controls">
                            {!! Form::textarea('summary', null, ['class'=>'span8', 'placeholder'=>'Enter summary here...', 'rows'=>5]) !!}
                            <span class="help-inline">Give as good a summary as you can of the film.</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="MovieOpeningBid">Opening Bid</label>
                        <div class="controls">
                            {!! Form::text('opening_bid', null, ['class'=>'span4', 'placeholder'=>'0.00']) !!}
                            <span class="help-inline">Default is 0.00 - only change if you need a minimum to be shown when purchasing the movie.</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="MovieGenre">Genre</label>
                        <div class="controls">
                            {!! Form::select('genres_id', $genres, null, ['class'=>'span8']) !!}
                            <span class="help-inline">Choose from genre list</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="MovieGenre">Rating</label>
                        <div class="controls">
                            {!! Form::select('ratings[]', $ratings, null, ['class'=>'span4', 'multiple'=>'multiple']) !!}
                            <span class="help-inline"></span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="MovieRating">Rating</label>
                        <div class="controls">
                            {!! Form::text('rating', null, ['class'=>'span8 rating', 'min'=>'1', 'max'=>'5']) !!}
                            <span class="help-inline">Enter 1 to 5</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="MovieBudget">Budget</label>
                        <div class="controls">
                            <span class="add-on">$</span>{!! Form::text('budget', null, ['class'=>'span8', 'placeholder'=>'0']) !!}
                            <span class="help-inline">This is in millions</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="MovieReleaseDate">Release Date</label>
                        <div class="controls">
                            {!! Form::date('release_at', null, ['class'=>'span8']) !!}
                            <span class="help-inline">Date film is released</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <div class="controls">
                            <button type="submit" class="btn btn-primary pull-right">Add Movie</button>
                        </div>
                    </div>
                </form>
        </div>
    </div>

    
    
</div>
@endsection