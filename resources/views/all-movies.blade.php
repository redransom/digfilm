@extends('layouts.site')

@section('content')
@if(isset($highlights))
<h2><span>Highlights</span></h2>
<div class="content-padding">
    <div class="release">
        <div class="gamelist">
            <div class="clearfix owl-carousel owl-theme" id="owl-movies">
                @foreach($highlights as $movie)
               
                <div class="item">
                    <a href="{{URL('movie-knowledge', $movie->link())}}">
                    @if($movie->firstImage())
                    <img src="{{asset($movie->firstImage()->path())}}" width="159" height="100" alt="" />
                    @else
                    <img src="{{asset('images/TNBF.jpg')}}" width="159" height="100" alt="" />
                    @endif
                    </a>
                    <div class="caption">
                        <h5 class="title"><a href="{{URL('movie-knowledge', $movie->link())}}">{{$movie->name}}</a></h5>
                        <div class="caption-info">
                            <span class="date">{{date("l, jS F Y", strtotime($movie->release_at))}} | </span>
                            <span class="description">{{$movie->summary}}</span>
                        </div>
                    </div><!--/ .caption-->                            
                    <div class="clear"></div>
                </div><!-- End Owl Item-->
                @endforeach
            </div><!-- End Owl Carousel, Owl Movies -->
        </div>
    </div>
</div>
@endif

<h2><span>All Movies</span></h2>
<div class="content-padding">
@include('partials.site-movies', ['movies'=>$movies, 'description'=>'All the movies in TheNextBigFilm database'])
</div>
@include('pagination.default', ['paginator' => $movies])

@endsection