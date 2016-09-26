@extends('layouts.site')

@section('content')
@if(isset($highlights) && !empty($highlights) && $highlights->count() > 0)
<h2><span>Highlights</span></h2>
<div class="content-padding">
    <div class="release">
        <div class="gamelist">
            <div class="clearfix owl-carousel owl-theme" id="owl-movies">
                @foreach($highlights as $movie)
                <?php $item = $movie->topTrailer(); ?>
                @if(!is_null($movie) && $movie->type =='T' && str_contains($movie->url, "youtu.be"))
                <div class="item">
                    <a href="{{URL('movie-knowledge', $movie->link())}}">
                    @if($movie->topTrailer())
                    <?php                      
                    $base_url = "";  
                    $item = $movie->topTrailer();            
                    if ($item->type =='T' && str_contains($item->url, "youtu.be")) {
                        $url = $item->url;

                        //only use youtube currently
                        $path = parse_url($url, PHP_URL_PATH);
                        $base_url = "http://www.youtube.com/embed".$path;
                    }
                    ?>
                    <iframe width="100%" height="400" src="{{$base_url}}" frameborder="0" allowfullscreen></iframe>

                    @else
                    @if($movie->firstImage())
                    <img src="{{asset($movie->firstImage()->path())}}" width="159" height="100" alt="" />
                    @else
                    <img src="{{asset('images/TNBF.jpg')}}" width="159" height="100" alt="" />
                    @endif
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
                @endif
                @endforeach
            </div><!-- End Owl Carousel, Owl Movies -->
        </div>
    </div>
</div>
@endif

<h2><span>Our movie database</span></h2>
<div class="content-padding">
@include('partials.site-movies', ['movies'=>$movies, 'description'=>'All the movies in TheNextBigFilm database'])
</div>
@include('pagination.default', ['paginator' => $movies])

@endsection