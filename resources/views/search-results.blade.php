@extends('layouts.site')

@section('content')
<h2><span>{{$title}}</span></h2>
<div class="content-padding">
	<p>The order of any search is by the following:</p>
	<ol>
		<li>Movies</li>
		<li>Leagues</li>
		<li>News</li>
	</ol>

	@if(!empty($results))
	<p>Your search brought up the following matches:</p>

	@if(isset($results['movies']) && !empty($results['movies']))
	<h3>Movies Found</h3>

	@foreach($results['movies'] as $movie_result)
	<h4>{{$movie_result->name}}</h4>
	<p>{!! $movie_result->summary !!}</p>
	<a href="{{URL('movie-knowledge', ['id'=>$movie_result->link()])}}">More...</a>
	<br/>

	@endforeach
	@endif

	@else
	<p>We are sorry but there are no results from your search.</p>

	@endif
</div>
@endsection