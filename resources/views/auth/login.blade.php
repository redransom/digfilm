@extends('layouts.site')

@section('content')
		<div class="signup-panel">

			<div class="left">
				<h2><span>Log in</span></h2>
				<div class="content-padding">
					<p class="p-padding">An euripidis assentior accommodare usu, ut eam fabellas facilisi perpetua. Accumsan scripserit cu mel, ut dolorem adolescens per.</p>

					<div class="login-passes">
						<b>Or you can use passports:</b>
						<a href="#" class="strike-tooltip" title="Use Facebook.com passport"><img src="images/social-icon-facebook.png" alt="" /></a>
						<a href="#" class="strike-tooltip" title="Use Twitter.com passport"><img src="images/social-icon-twitter.png" alt="" /></a>
						<a href="#" class="strike-tooltip" title="Use Steampowered.com passport"><img src="images/social-icon-steam.png" alt="" /></a>
						<a href="#" class="strike-tooltip" title="Use Google.com passport"><img src="images/social-icon-google.png" alt="" /></a>
					</div>

					<div class="the-form" style="margin-top:40px;">
						<form action="" method="post">

							<p>
								<span class="the-error-msg"><i class="fa fa-warning"></i>You got an error</span>
								<!-- <span class="the-success-msg"><i class="fa fa-check"></i>This is success</span> -->
								<!-- <span class="the-alert-msg"><i class="fa fa-warning"></i>This is alert message</span> -->
							</p>

							<p>
								<label for="login_username">Username:</label>
								<input type="text" name="login_username" id="login_username" value="" />
							</p>

							<p>
								<label for="login_password">Password:</label>
								<input type="password" name="login_password" id="login_password" value="" />
							</p>

							<p>
								<label for="">&nbsp;</label>
								<input type="checkbox" name="login_remember" id="login_remember" value="" />

								<label class="iiiii" for="login_remember">Remember me</label>
							</p>

							<p class="form-footer">
								<input type="submit" name="login_submit" id="login_submit" value="Log in" />
							</p>

							<p style="margin-top:40px;">
								<span class="info-msg">If you don't have an account, <a href="signup.html">sign up</a> !<br /><br />If lost password <a href="signup-password.html">click here</a> and we will help you to reset !</span>
							</p>

						</form>
					</div>

				</div>
			</div>

			<div class="right">
				<h2><span>What is Revelio ?</span></h2>
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
		<form class="form-vertical" id="contactform" role="form" method="POST" action="/auth/login">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">

			<fieldset>
				<div class="alignleft">	
					<div class="row">
						<label for="name"><span class="required">*</span>Email Address:</label>
						<input type="text" class="form-control" name="email" value="{{ old('email') }}">
					</div><!--/ row-->

					<div class="row">
						<label for="name"><span class="required">*</span>Password:</label>
						<input type="password" class="form-control" name="password">
					</div><!--/ row-->
				</div>
			</fieldset>

			<button type="submit" class="button medium dark">
				Login
			</button>
            <label class="checkbox">
                <input type="checkbox" name="remember"> Remember me
            </label>
		</form>
    </div>
</div><!--/.wrapper-->
@endsection