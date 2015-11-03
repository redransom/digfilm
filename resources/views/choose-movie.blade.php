@extends('layouts.users')

@section('content')
<section class="entry sbr clearfix">
    <div class="title-caption-large">
        <h3>Choose the movies for your league</h3>
    </div>

    <p>Select {{$league->rule->min_movies}} movies from the movie selection below.</p>
    <p>We only provide movies that are yet to be released.</p>
    <div id="contact">
        <div id="message"></div>
        {!! Form::open(array('route' => 'select-movies', 'class'=>'form-horizontal row-fluid', 'id'=>'contactform')) !!}
            <fieldset>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="leagues_id" value="{{$league->id}}">
                <div class="alignleft">
                    <ul>
                    @foreach($movies as $movie)
                        <li>{!! Form::checkbox('movies_id[]', $movie->id, false) !!}&nbsp;&nbsp;{{$movie->name}} (Released on {{date("d M Y", strtotime($movie->release_at))}})</li>
                    @endforeach
                    </ul>
                    <br/>
                    <input type="submit" class="button green small" id="submit" value="Add Movies" />
                </div><!--/ textfield-->
            </fieldset>
        </form>
    </div><!--/ contact-->

</section>

@endsection