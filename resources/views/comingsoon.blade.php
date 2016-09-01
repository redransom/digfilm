@extends('layouts.site')

@section('content')
<h2><span>{{$title}}</span></h2>
<div class="content-padding">
@include('partials.site-movies', ['movies'=>$movies, 'description'=>$description])
</div>
@include('pagination.default', ['paginator' => $movies])
@endsection