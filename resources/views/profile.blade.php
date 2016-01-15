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

        {!! Form::open(array('route' => array('users.update', $user->id), 'class'=>'form-horizontal row-fluid', 'method'=>'PUT', 'files'=>true, 'id'=>'contactform')) !!}
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="update_from" value="P">

            <div class="control-group">
                <label class="control-label" for="UserUsername">Username</label>
                <div class="controls">
                    {!! Form::text('name', $user->name, ['class'=>'span8', 'readonly'=>true]) !!}<br/>
                    <span class="help-inline">This username is now un-changeable - if you have a problem with this - please get in touch via the contact page.</span>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="UserForenames">Firstname(s)</label>
                <div class="controls">
                    {!! Form::text('forenames', $user->forenames, ['class'=>'span8', 'placeholder'=>'First name(s) here...']) !!}<br/>
                    <span class="help-inline">Minimum 3 Characters.</span>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="UserSurname">Surname</label>
                <div class="controls">
                    {!! Form::text('surname', $user->surname, ['class'=>'span8', 'placeholder'=>'Surname here...']) !!}<br/>
                    <span class="help-inline">Minimum 3 Characters.</span>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="UserSurname">Interests/Summary</label>
                <div class="controls">
                    {!! Form::textarea('description', $user->description, ['class'=>'span8', 'placeholder'=>'Description here...']) !!}<br/>
                    <span class="help-inline">Please give a basic synopysis.</span>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="UserEmail">Email</label>
                <div class="controls">
                    {!! Form::text('email', $user->email, ['class'=>'span8', 'placeholder'=>'Email here...']) !!}<br/>
                    <span class="help-inline">Provide a correct email account.</span>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="UserPassword">Password</label>
                <div class="controls">
                    {!! Form::password('password', null, ['class'=>'span8']) !!}
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="UserThumbnail">Photo</label>
                <div class="controls">
                    {!! Form::file('thumbnail', null, ['class'=>'span8']) !!}
                </div>
            </div>

            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="button medium dark">Save Profile</button>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>
@endsection