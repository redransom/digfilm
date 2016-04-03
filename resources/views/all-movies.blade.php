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
                    <img src="{{asset($movie->firstImage()->file_name)}}" width="159" height="100" alt="" />
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
    <?php $movieCnt = 0; ?>
    @foreach($movies as $movie)
    @if((($movieCnt % 4) == 0) || $movieCnt == 0)
    <div class="row">
    @endif
        <div class="one-quarter small--one-half">
            <a href="{{URL('movie-knowledge', ['id'=>$movie->link()])}}">
            @if($movie->images()->count() > 0)
                <img src="{{asset($movie->firstImage()->file_name)}}" alt="{{$movie->name}}" />
            @else
                <img src="{{asset('images/TNBF.jpg')}}" alt="{{$movie->name}}" />
            @endif
            </a>
            <h3><a href="{{URL('movie-knowledge', ['id'=>$movie->link()])}}">{{$movie->name}}</a></h3>
            @if(!is_null($movie->opening_bid))
            <p><a href="{{URL('movie-knowledge', ['id'=>$movie->link()])}}">Include at: <span class="highlight">&pound;{{$movie->opening_bid}}</span></a></p>
            @endif
            <p>Release Date: <span class="highlight">{{date("M Y", strtotime($movie->release_at))}}</span></p>
        </div>

    <?php $movieCnt++; ?>

    @if(($movieCnt % 4) == 0)
    </div>
    @endif

    @endforeach
</div>
    
    @include('pagination.default', ['paginator' => $movies])

@endsection