@extends('layouts.site')

@section('content')
		<div class="signup-panel">

			<div class="left">
				<h2><span>Log in</span></h2>
				<div class="content-padding">
					<p class="p-padding">Use the below form to get into the site.</p>

					<!--div class="login-passes">
						<b>Or you can use passports:</b>
						<a href="#" class="strike-tooltip" title="Use Facebook.com passport"><img src="{{ asset('images/social-icon-facebook.png') }}" alt="" /></a>
						<a href="#" class="strike-tooltip" title="Use Twitter.com passport"><img src="{{ asset('images/social-icon-twitter.png') }}" alt="" /></a>
						<a href="#" class="strike-tooltip" title="Use Google.com passport"><img src="{{ asset('images/social-icon-google.png') }}" alt="" /></a>
					</div-->

					<div class="the-form" style="margin-top:40px;">
						<form class="form-vertical" id="contactform" role="form" method="POST" action="/auth/login">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">

							@if (count($errors) > 0)
							<p>
								@foreach ($errors->all() as $error)
									<span class="the-error-msg">{{ $error }}</span>
								@endforeach
							</p>
							@endif

							<p>
								<label for="email">Email Address:</label>
								<input type="text" name="email" id="email" value="{{ old('email') }}" />
							</p>

							<p>
								<label for="password">Password:</label>
								<input type="password" name="password" id="password" value="" />
							</p>

							<p>
								<label for="">&nbsp;</label>
								<input type="checkbox" name="remember" id="remember" value="" />

								<label class="iiiii" for="remember">Remember me</label>
							</p>

							<p class="form-footer">
								<input type="submit" name="login_submit" id="login_submit" value="Log in" />
							</p>

							<p style="margin-top:40px;">
								<span class="info-msg">If you don't have an account, <a href="{{URL('/auth/register')}}">sign up</a> !<br /><br />If lost password <a href="{{URL('auth/reset')}}">click here</a> and we will help you to reset !</span>
							</p>

						</form>
					</div>

				</div>
			</div>

			<div class="right">
				@if(isset($content))
				<h2><span>{{$content->title}}</span></h2>
				<div class="content-padding">
				{!! $content->body !!}
				</div>
				@endif
			</div>

			<div class="clear-float"></div>
		</div>
</div><!--/.wrapper-->
@endsection