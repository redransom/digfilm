@extends('layouts.site')

@section('content')
<h2><span>Reset Password</span></h2>

<div class="content-padding">
	@if (count($errors) > 0)
		<div class="alert alert-danger">
			<strong>Whoops!</strong> There were some problems with your input.<br><br>
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

    {!! Form::open(array('class'=>'form-vertical', 'id'=>'contactform', 'files'=>true)) !!}
    <div class="the-form league--form">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="form--item">
            <label for="LeagueName">E-Mail Address:</label>
            {!! Form::text('email', old('email'), ['class'=>'span8', 'placeholder'=>'Your email address...']) !!}
        </div>

        <div class="form--item">
            <label for="LeagueName">Password:</label>
            {!! Form::text('password', old('password'), ['class'=>'span8', 'placeholder'=>'Your password...']) !!}
        </div>

        <div class="form--item">
            <label for="LeagueName">Confirm Password:</label>
            {!! Form::text('password_confirmation', old('password_confirmation'), ['class'=>'span8', 'placeholder'=>'Confirm your password...']) !!}
        </div>
	</div>

	<div class="form-footer">
         <div class="divider--img"></div>
        <input type="submit" name="submit" class="submit-btn btn-small" id="submit" value="Reset Password" />
    </div>
		
	</form>
</div>
@endsection
