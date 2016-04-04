@extends('layouts.site')

@section('content')
<h2><span>{{$title}}</span></h2>
@include('partials.site-movies', ['movies'=>$movies, 'description'=>$description])

</div>
@endsection