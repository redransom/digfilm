@extends('layouts.site')

@section('content')
<h2><span>Movies in the {{$genre->name}} Genre</span></h2>
<div class="content-padding">
@include('partials.site-movies', ['movies'=>$genre->movies])
</div>


@endsection