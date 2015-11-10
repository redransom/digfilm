@extends('layouts.users')

@section('content')
<section class="entry sbr clearfix">
	<div class="title-caption-large">
		<h3>Register Here</h3>
	</div>

	<style>
		/* Form style */
		#contact label {display: block;}

		#contact input[type="submit"][disabled] { background:#888; cursor: default; }

		#message fieldset { padding:20px; border:1px solid #eee; border-radius:5px; -moz-border-radius:5px; -webkit-border-radius:5px; background:#F9FAF5; }

		.error_message { display: block; line-height: 22px; background: #FBE3E4 url('../assets/error.gif') no-repeat 10px 6px; padding: 3px 10px 3px 35px; color:#8a1f11;border: 1px solid #FBC2C4; -moz-border-radius:5px; -webkit-border-radius:5px; }

		ul.error_messages { margin: 0 0 0 15px; padding: 0; }
		ul.error_messages li { height: 22px; line-height: 22px; color:#333; }

		.loader { padding: 0 10px; }

		#contact #success_page h1 { background: url('../assets/success.gif') left no-repeat; padding-left:22px; }

		acronym { border-bottom:1px dotted #ccc; }

	</style>
	<div id="contact">

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
		<p>We need the following fields to be populated before you can register to the site.</p>

		<form class="form-horizontal" id="contactform" role="form" method="POST" action="/auth/register">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<fieldset>
				<div class="alignleft">
					<div class="row">
						<label for="name"><span class="required">*</span>Username:</label>
						<input type="text" class="form-control" name="name" value="{{ old('name') }}">
					</div><!--/ row-->

					<div class="row">
						<label for="name"><span class="required">*</span>Forenames:</label>
						<input type="text" class="form-control" name="forenames" value="{{ old('forenames') }}">
					</div><!--/ row-->

					<div class="row">
						<label for="name"><span class="required">*</span>Surname:</label>
						<input type="text" class="form-control" name="surname" value="{{ old('surname') }}">
					</div><!--/ row-->					

					<div class="row">
						<label for="name"><span class="required">*</span>E-Mail Address:</label>
						<input type="text" class="form-control" name="email" value="{{ old('surname') }}">
					</div><!--/ row-->	

					<div class="row">
						<label for="name"><span class="required">*</span>Password:</label>
						<input type="password" class="form-control" name="password" value="{{ old('surname') }}">
					</div><!--/ row-->	

					<div class="row">
						<label for="name"><span class="required">*</span>Confirm Password:</label>
						<input type="password" class="form-control" name="password_confirmation">
					</div><!--/ row-->

					<button type="submit" class="button green small">
						Register
					</button>
				</div>
			</fieldset>
		</form>
	</div>
</section>
@endsection
