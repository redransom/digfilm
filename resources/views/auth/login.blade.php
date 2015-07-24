@extends('layouts.login')

@section('content')
    <div class="wrapper">
        <div class="container">
            <div class="row">
                <div class="module module-login span4 offset4">
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

					<form class="form-vertical" role="form" method="POST" action="/auth/login">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
	                    <div class="module-head">
	                        <h3>Sign In</h3>
	                    </div>

	                    <div class="module-body">
	                        <div class="control-group">
	                            <div class="controls row-fluid">
									<input type="email" class="form-control" name="email" value="{{ old('email') }}">
		                        </div>
		                    </div>

	                        <div class="control-group">
	                            <div class="controls row-fluid">
									<input type="password" class="form-control" name="password">
								</div>
							</div>
						</div>

	                    <div class="module-foot">
	                        <div class="control-group">
	                            <div class="controls clearfix">
									<button type="submit" class="btn btn-primary pull-right">
										Login
									</button>
	                                <label class="checkbox">
	                                    <input type="checkbox" name="remember"> Remember me
	                                </label>
	                            </div>
	                        </div>
	                    </div>

					</form>
                </div>
            </div>
        </div>
    </div><!--/.wrapper-->
@endsection