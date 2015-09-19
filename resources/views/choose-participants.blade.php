@extends('layouts.users')

@section('content')
<section class="entry sbr clearfix">
    <div class="title-caption-large">
        <h3>Create Your League</h3>
    </div>

    @if(isset($authUser))
    <p>Use the below form to enter the name of the league you wish to create and select the movies to be auctioned for.</p>
    <div id="contact">
        <div id="message"></div>
        {!! Form::open(array('route' => 'leagues.store', 'class'=>'form-horizontal row-fluid', 'id'=>'contactform')) !!}
            <fieldset>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="source" value="P">
                <input type="hidden" name="users_id" value="{{$authUser->id}}">
                <div class="alignleft">
                    <div class="row">
                        <label for="name"><span class="required">*</span>League Name:</label>
                        {!! Form::text('name', null, ['class'=>'span8', 'placeholder'=>'Enter league name here...']) !!}
                    </div><!--/ row-->
                    
                    <input type="submit" class="button green small" id="submit" value="Submit" />
                </div><!--/ textfield-->
            </fieldset>
        </form>
    </div><!--/ contact-->
    
    @else
    <p>You need to be logged in if you want create a league here for your friends to play in.</p>
    @endif

</section>

@endsection