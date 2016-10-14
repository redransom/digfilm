@extends('layouts.site')

@section('content')

<div class="signup-panel">
    <div class="left">
        <h2><span>Your Profile</span></h2>
        <div class="content-padding">     
            <p>Please use the below form to change your contact details and password.</p>
                @if (count($errors) > 0)
            @foreach ($errors->all() as $error)
            <div class="alert">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>Warning!</strong>{{ $error }}
            </div>
            @endforeach
            @endif

            <div class="the-form">
            {!! Form::open(array('route' => array('update-profile', $user->id), 'class'=>'form-horizontal row-fluid', 'method'=>'PUT', 'files'=>true, 'id'=>'contactform')) !!}
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="update_from" value="P">

                <p>
                    <label for="UserUsername">Username</label>
                    {!! Form::text('name', $user->name, ['readonly'=>true]) !!}
                    <p>This username is now un-changeable - if you have a problem with this - please get in touch via the contact page.</p>
                </p>
                <p>
                    <label for="UserForenames">Firstname(s)</label>
                    {!! Form::text('forenames', $user->forenames, ['placeholder'=>'First name(s) here...']) !!}
                </p>
                <p>
                    <label for="UserSurname">Surname</label>
                    {!! Form::text('surname', $user->surname, ['placeholder'=>'Surname here...']) !!}
                </p>

                <p>
                    <label for="UserSurname">Interests/Summary</label>
                    {!! Form::textarea('description', $user->description, ['placeholder'=>'Description here...']) !!}
                    <p>Please give a basic synopysis.</p>
                </p>

                <p>
                    <label for="UserEmail">Email</label>
                    {!! Form::text('email', $user->email, ['placeholder'=>'Email here...']) !!}
                    <p>Provide a correct email account.</p>
                </p>

                <p>
                    <label for="UserPassword">Password</label>
                    {!! Form::password('password', null) !!}
                </p>

                <p>
                    <label for="UserThumbnail">Photo</label>
                    {!! Form::file('thumbnail', null) !!}
                    <p>Best image size 115px (width) by 166px (height)</p>
                </p>
                <p>
                    <button type="submit" id="submit1" class="button medium dark">Save Profile</button>
                </p>
            </form>
            </div>
        </div>
    </div>
    <div class="right">
        @if(!is_null($content))
        <h2><span>{{$content->title}}</span></h2>
        <div class="content-padding">
        {!! $content->body !!}
        </div>
        @endif
        @if(!is_null($user->thumbnail))
            <img src="{{asset($user->thumbnail)}}" width="115px" height="166px"/>
        @endif
        <p>&nbsp;</p>
    </div>

@endsection