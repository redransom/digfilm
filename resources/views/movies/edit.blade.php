@extends('layouts.admin')

@section('content')
<div class="content">
<script>
$(function() {
    $('#release_at').datetimepicker({
        format: 'Y-m-d'
    });
    $('#takings_close_date').datetimepicker({
        format: 'Y-m-d'
    });
});    
</script>

    <div class="module">
        <div class="module-head">
            <h3>Edit Movie</h3>
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
                {!! Form::open(array('route' => array('movies.update', $movie->id), 'class'=>'form-horizontal row-fluid', 'method'=>'PUT')) !!}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="referer" value="{{URL::previous()}}">
                    <div class="control-group">
                        <label class="control-label" for="MovieName">Name</label>
                        <div class="controls">
                            {!! Form::text('name', $movie->name, ['class'=>'span4', 'placeholder'=>'Enter movie name here...']) !!}
                            <span class="help-inline">Minimum 4 Characters.</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="MovieSummary">Summary</label>
                        <div class="controls">
                            {!! Form::textarea('summary', $movie->summary, ['class'=>'span8', 'placeholder'=>'Enter summary here...', 'rows'=>5]) !!}
                            <span class="help-inline">Give as good a summary as you can of the film.</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="MovieOpeningBid">Opening Bid</label>
                        <div class="controls">
                            {!! Form::text('opening_bid', $movie->opening_bid, ['class'=>'span4', 'placeholder'=>'0.00']) !!}
                            <span class="help-inline">Default is 0.00 - only change if you need a minimum to be shown when purchasing the movie.</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="MovieGenre">Genre</label>
                        <div class="controls">
                            {!! Form::select('genres_id', $genres, $movie->genres_id, ['class'=>'span4']) !!}
                            <span class="help-inline">Select from drop down</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="MovieGenre">PEGI Rating</label>
                        <div class="controls">
                            {!! Form::select('ratings[]', $ratings, $movie->ratings()->lists('ratings_id'), ['class'=>'span4', 'multiple'=>'multiple']) !!}
                            <span class="help-inline"></span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="MovieRating">Score (out of 5)</label>
                        <div class="controls">
                            {!! Form::text('rating', $movie->rating, ['class'=>'span2 rating', 'min'=>'1', 'max'=>'5']) !!}
                            <span class="help-inline">From 1 to 5</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="MovieBudget">Budget</label>
                        <div class="controls">
                            <div class="input-prepend">
                                <span class="add-on">$</span>{!! Form::text('budget', $movie->budget, ['class'=>'span4', 'placeholder'=>'0']) !!}
                                <span class="help-inline">In millions of dollars</span>
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="MovieReleaseDate">Release Date</label>
                        <div class="controls">
                            {!! Form::date('release_at', $movie->release_at, ['class'=>'span4', 'id'=>'release_at']) !!}
                            <span class="help-inline">Date film is released</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="MovieTakingsCloseDate">Takings Close Date</label>
                        <div class="controls">
                            {!! Form::date('takings_close_date', $movie->takings_close_date, ['class'=>'span4', 'id'=>'takings_close_date']) !!}
                            <span class="help-inline">Date takings stop being compiled</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="MovieTakingsFrequency">Takings Frequency</label>
                        <div class="controls">
                            {!! Form::select('takings_frequency', ['W'=>'Weekly', 'D'=>'Daily'], $movie->takings_frequency, ['class'=>'span4']) !!}
                            <span class="help-inline">How frequent are takings taken?</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <div class="controls">
                            <button type="submit" class="btn btn-primary pull-right">Save Movie</button>
                        </div>
                    </div>
                </form>
        </div>
    </div>

    
    
</div>
@endsection