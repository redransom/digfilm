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
                    <p>Note you can no longer change your username, please get in touch with us via the contact page if this is an issue.</p>
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
                    <label for="UserEmail">Email</label>
                    {!! Form::text('email', $user->email, ['placeholder'=>'Email here...']) !!}
                    <p>This is how we will contact you so please make sure this is correct and up to date. </p>
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
    

@endsection