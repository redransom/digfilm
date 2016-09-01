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
                @if(!is_null($item) && $item->type =='T' && str_contains($item->url, "youtu.be"))
                <div class="item">
                    <a href="{{URL('movie-knowledge', $movie->link())}}">
                    <?php                      
                    $base_url = "";  
                    $url = $item->url;

                    //only use youtube currently
                    $path = parse_url($url, PHP_URL_PATH);
                    $base_url = "http://www.youtube.com/embed".$path;
                    ?>
                    <iframe width="100%" height="400" src="{{$base_url}}" frameborder="0" allowfullscreen></iframe>
                    </a>
                    <div class="caption">
                        <h5 class="title"><a href="{{URL('movie-knowledge', $movie->link())}}">{{$movie->name}}</a></h5>
                        <div class="caption-info">
                            <span class="date">{{date("l, jS F Y", strtotime($movie->release_at))}}</span>
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
<h2><span>{{$title}}</span></h2>
<div class="content-padding">
@include('partials.site-movies', ['movies'=>$movies, 'description'=>$description])
</div>
@include('pagination.default', ['paginator' => $movies])
@endsection