@extends('layouts.site')

@section('content')
<h2><span>Email Verified!</span></h2>
<div class="content-padding">
    <p>Your email address has now been verified!</p>
    <p>Please go to the login page by clicking the link above or by following <a href="{{URL('auth/login')}}">this link</a>.</p>
        
</div>
@endsection