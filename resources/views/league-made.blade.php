@extends('layouts.site')

@section('content')
<h2><span>League created successfully!</span></h2>
<div class="content-padding">
    <p>The league <strong>{{$league->name}}</strong> is ready for playing. If you need to make changes to it you need to use the <a href="{{URL('manage', [$league->id])}}">manage page</a> or you can go back to your <a href="{{URL('dashboard')}}">dashboard</a>. </p>
</div>

@endsection