@extends('layouts.users')

@section('content')
<section class="entry sbr clearfix">
    <div class="title-caption-large">
        <h3>Email Verified!</h3>
    </div>
    
    <p>Your email address has now been verified!</p>
    <p>Please go to the login page by clicking the link above or by following <a href="{{URL('auth/login')}}">this link</a>.</p>
</section>
@endsection