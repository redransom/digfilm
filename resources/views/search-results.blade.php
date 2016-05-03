@extends('layouts.site')

@section('content')

<h2><span>{{$title}}</span></h2>
@if(!empty($results))

@if(isset($results['movies']) && !empty($results['movies']))
<div class="content-padding">
@include('partials.site-movies', ['movies'=>$results['movies'], 'description'=>'Movies Found'])
</div>	
@endif

@if(isset($results['leagues']) && !empty($results['leagues']))
<div class="content-padding">
@include('partials.site-leagues', ['leagues'=>$results['leagues'], 'description'=>'Leagues Found'])
</div>
@endif

@else
<div class="content-padding">
<p>We are sorry but there are no results from your search.</p>
</div>
@endif
@endsection