@extends('layouts.users')

@section('content')
<div class="title-caption-large">
    <h3>{{$title}}</h3>
</div><!--/ .title-caption-large-->
                
                
<!-- ************** - Posts - ************** -->
<section id="page">
    <h4>{{$description}}</h4>
    @include('partials.user-movies', ['movies'=>$movies])  
        
</section>
@endsection