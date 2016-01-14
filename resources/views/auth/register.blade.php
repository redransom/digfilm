@extends('layouts.site')

@section('content')
		<div class="signup-panel">

			<div class="left">
				<h2><span>Register Here</span></h2>
				<div class="content-padding">
					<p class="p-padding">Use the below form to get into the site.</p>

					<div class="login-passes">
						<b>Or you can use passports:</b>
						<a href="#" class="strike-tooltip" title="Use Facebook.com passport"><img src="{{ asset('images/social-icon-facebook.png') }}" alt="" /></a>
						<a href="#" class="strike-tooltip" title="Use Twitter.com passport"><img src="{{ asset('images/social-icon-twitter.png') }}" alt="" /></a>
						<a href="#" class="strike-tooltip" title="Use Google.com passport"><img src="{{ asset('images/social-icon-google.png') }}" alt="" /></a>
					</div>
					<div class="the-form" style="margin-top:40px;">
						<form class="form-vertical" id="contactform" role="form" method="POST" action="/auth/register">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">

							@if (count($errors) > 0)
							<p>
								@foreach ($errors->all() as $error)
									<span class="the-error-msg">{{ $error }}</span>
								@endforeach
							</p>
							@endif

							<p class="p-padding">We need the following fields to be populated before you can register to the site.</p>
							<p>
								<label for="name">Username:<span class="required">*</span></label>
								<input type="text" name="name" id="name" value="{{ old('name') }}" />
							</p>

							<p>
								<label for="forenames">Forenames:<span class="required">*</span></label>
								<input type="text" name="forenames" id="forenames" value="{{ old('forenames') }}" />
							</p>

							<p>
								<label for="surname">Surname:<span class="required">*</span></label>
								<input type="text" name="surname" id="surname" value="{{ old('surname') }}" />
							</p>

							<p>
								<label for="email">E-Mail Address:<span class="required">*</span></label>
								<input type="text" name="email" id="email" value="{{ old('email') }}" />
							</p>

							<p>
								<label for="password">Password:<span class="required">*</span></label>
								<input type="password" name="password" id="password" value="" />
							</p>

							<p>
								<label for="password_confirmation">Confirm Password:<span class="required">*</span></label>
								<input type="password" name="password_confirmation" id="password_confirmation" value="" />
							</p>

							<p class="form-footer">
								<input type="submit" name="signup_submit" id="signup_submit" value="Sign up" />
							</p>

							<p>
								<span class="info-msg">If you already have an account please <a href="/auth/login">log in</a> !</span>
							</p>


						</form>
					</div>

				</div>
			</div>

			<div class="right">
				<h2><span>What is TheNextBigFilm ?</span></h2>
				<div class="content-padding">
					
					<div class="form-split-about">
						<p class="p-padding">Lorem ipsum dolor sit amet, natum referrentur sea no. Sensibus definitionem necessitatibus id vim, eu ornatus intellegat argumentum nam. Ius modo interpretaris at, alia erat pri te. An euripidis assentior accommodare usu, ut eam fabellas facilisi perpetua. Accumsan scripserit cu mel, ut dolorem adolescens per.</p>

						<ul>
							<li>
								<i class="fa fa-picture-o"></i>
								<b>Id ius facete urbanitas concludaturque mea</b>
								<p class="p-padding">Ius modo interpretaris at, alia erat pri te. An euripidis assentior accommodare usu, ut eam fabellas facilisi perpetua.</p>
							</li>
							
							<li>
								<i class="fa fa-trophy"></i>
								<b>Id ius facete urbanitas concludaturque mea</b>
								<p class="p-padding">Ius modo interpretaris at, alia erat pri te. An euripidis assentior accommodare usu, ut eam fabellas facilisi perpetua. Accumsan scripserit cu mel, ut dolorem adolescens per.</p>
							</li>

							<li>
								<i class="fa fa-microphone"></i>
								<b>Id ius facete urbanitas concludaturque mea</b>
								<p class="p-padding">Ius modo interpretaris at, alia erat pri te. An euripidis assentior accommodare usu, ut eam fabellas facilisi perpetua. Accumsan scripserit cu mel, ut dolorem adolescens per.</p>
							</li>
							
							<li>
								<i class="fa fa-comments"></i>
								<b>Id ius facete urbanitas concludaturque mea</b>
								<p class="p-padding">Ius modo interpretaris at, alia erat pri te. An euripidis assentior accommodare usu, ut eam fabellas facilisi perpetua.</p>
							</li>
						</ul>
						
					</div>
					
				</div>
			</div>

			<div class="clear-float"></div>
		</div>
		
	</div>
</section>
@endsection
