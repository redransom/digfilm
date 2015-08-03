@extends('layouts.admin')

@section('content')
<div class="content">

    <div class="module">
        <div class="module-head">
            <h3>Add User</h3>
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
                {!! Form::open(array('route' => 'users.store', 'class'=>'form-horizontal row-fluid')) !!}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="control-group">
                        <label class="control-label" for="MovieName">Role(s)</label>
                        <div class="controls">
                            {!! Form::select('role_id[]', $roles, null, ['class'=>'span8', 'multiple'=>'multiple']) !!}
                            <span class="help-inline">You must choose at least one role.</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="MovieName">Firstname(s)</label>
                        <div class="controls">
                            {!! Form::text('forenames', null, ['class'=>'span8', 'placeholder'=>'First name(s) here...']) !!}
                            <span class="help-inline">Minimum 3 Characters.</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="MovieSummary">Surname</label>
                        <div class="controls">
                            {!! Form::text('surname', null, ['class'=>'span8', 'placeholder'=>'Surname here...']) !!}
                            <span class="help-inline">Minimum 3 Characters.</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="MovieSummary">Username</label>
                        <div class="controls">
                            {!! Form::text('name', null, ['class'=>'span8', 'placeholder'=>'Username here...']) !!}
                            <span class="help-inline">This will need to be unique and will be checked against the system.</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="MovieSummary">Email</label>
                        <div class="controls">
                            {!! Form::text('email', null, ['class'=>'span8', 'placeholder'=>'Email here...']) !!}
                            <span class="help-inline">Provide a correct email account.</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="MovieSummary">Password</label>
                        <div class="controls">
                            {!! Form::password('password', null, ['class'=>'span8']) !!}
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="MovieSummary">Confirm Password</label>
                        <div class="controls">
                            {!! Form::password('confirm_password', null, ['class'=>'span8']) !!}
                        </div>
                    </div>

                    <div class="control-group">
                        <div class="controls">
                            <button type="submit" class="btn btn-primary pull-right">Add User</button>
                        </div>
                    </div>
                </form>
        </div>
    </div>

    
    
</div>
@endsection