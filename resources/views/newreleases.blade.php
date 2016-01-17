@extends('layouts.site')

@section('content')
<h2><span>{{$title}}</span></h2>
<div class="content-padding">

    <h4>{{$description}}</h4>

    @include('partials.site-movies', ['movies'=>$movies])      
</div>      
@endsection