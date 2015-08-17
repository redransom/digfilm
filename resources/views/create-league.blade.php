@extends('layouts.users')

@section('content')
<h1>Create Your League</h1>
@if(isset($authUser))
<p></p>
@else
<p>You can create a league here for your friends to play in.</p>
@endif
@endsection