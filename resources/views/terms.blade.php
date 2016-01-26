@extends('layouts.site')

@section('content')
@if(isset($content))
<h2><span>{{$content->title}}</span></h2>
@else
<h2><span>Terms &amp; Conditions</span></h2>
@endif
<div class="content-padding">
@include('partials.site-article', ['content'=>$content])
</div>
@endsection