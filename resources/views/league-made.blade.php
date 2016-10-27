@extends('layouts.site')

@section('content')
<h2><span>League created successfully!</span></h2>
<div class="content-padding">
    <p>Your league is now ready, good luck!</p> 
    <p>To make changes, head back to your  <a href="{{URL('dashboard')}}">dashboard</a>.</p>
</div>

@endsection