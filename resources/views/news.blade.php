@extends('layouts.site')

@section('content')
<h2><span>{{$page_title}}</span></h2>
<div class="content-padding">
@foreach($articles as $article)
@include('partials.site-article', ['content'=>$article])
@endforeach
</div>
@endsection