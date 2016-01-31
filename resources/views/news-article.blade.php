@extends('layouts.site')

@section('content')
<h2><span>{{$content->title}}</span></h2>
<div class="content-padding">
@include('partials.site-article', ['content'=>$content])
</div>
@endsection