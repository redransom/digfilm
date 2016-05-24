@extends('layouts.site')

@section('content')
@if(isset($content))
<h2><span>{{$content->title}}</span></h2>
<div class="content-padding">
@include('partials.site-article', ['content'=>$content])
</div>
@else
<h2><span>Rules of the game</span></h2>
@endif
@endsection