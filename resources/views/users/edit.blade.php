@extends('layouts.admin')

@section('content')
<div class="content">
    <div style="padding: 20px 10px;">
        @if(isset($page_name) && !isset($object))
            {!! Breadcrumbs::render($page_name) !!}
        @elseif(isset($page_name) && isset($object))
            {!! Breadcrumbs::render($page_name, $object) !!}
        @endif
    </div>

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
                {!! Form::open(array('route' => array('users.update', $user->id), 'class'=>'form-horizontal row-fluid', 'method'=>'PUT')) !!}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="control-group">
                        <label class="control-label" for="UserRole">Role(s)</label>
                        <div class="controls">
                            {!! Form::select('role_id[]', $roles, $user->roles[0]->id, ['class'=>'span8', 'multiple'=>'multiple']) !!}
                            <span class="help-inline">You must choose at least one role.</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="UserForenames">Firstname(s)</label>
                        <div class="controls">
                            {!! Form::text('forenames', $user->forenames, ['class'=>'span8', 'placeholder'=>'First name(s) here...']) !!}
                            <span class="help-inline">Minimum 3 Characters.</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="UserSurname">Surname</label>
                        <div class="controls">
                            {!! Form::text('surname', $user->surname, ['class'=>'span8', 'placeholder'=>'Surname here...']) !!}
                            <span class="help-inline">Minimum 3 Characters.</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="UserUsername">Username</label>
                        <div class="controls">
                            {!! Form::text('name', $user->name, ['class'=>'span8', 'placeholder'=>'Username here...']) !!}
                            <span class="help-inline">This will need to be unique and will be checked against the system.</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="UserEmail">Email</label>
                        <div class="controls">
                            {!! Form::text('email', $user->email, ['class'=>'span8', 'placeholder'=>'Email here...']) !!}
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
                        <div class="controls">
                            <button type="submit" class="btn btn-primary pull-right">Save User</button>
                        </div>
                    </div>
                </form>
        </div>
    </div>

    
    
</div>
@endsection