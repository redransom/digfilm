@extends('layouts.site')

@section('content')

@if (!is_null($content))
<div class="content-padding">{!! $content->body !!}</div>
@endif

<!-- Whats going on -->
<h2><span>Whats Going On?</span></h2>
<div class="content-padding">
    <div class="league-container clearfix">
        <div class="league-left-inner league-js small--one-whole">
            <h3>There are...</h3>
            <div class="league-table">
                 <!-- <div class="table-row"></div>-->
                <div class="league-left">
                    <p>Public League</p>
                </div>
                <div class="league-right">
                    <p>{{$count_array['public']}}</p>
                </div>
                <div class="table-row"></div>
                <div class="league-left">
                    <p>Private Leagues</p>
                </div>
                <div class="league-right">
                    <p>{{$count_array['private']}}</p>
                </div>
                <div class="table-row"></div>
                <div class="league-left">
                    <p>New Releases This Month</p>
                </div>
                <div class="league-right">
                    <p>{{$count_array['newreleases']}}</p>
                </div>
                <div class="table-row"></div>
                <div class="league-left">
                    <p>Films Coming Soon</p>
                </div>
                <div class="league-right">
                    <p>{{$count_array['comingsoon']}}</p>
                </div>
                <div class="table-row"></div>
                <div class="league-left">
                    <p>Players</p>
                </div>
                <div class="league-right">
                    <p>{{$count_array['player']}}</p>
                </div>
                <div class="table-row"></div>
            </div>
            <div class="league-btn-container">
                <div class="league-left">
                       <a href="{{URL('/create')}}" class="league-btn">Create a new league</a> 
                </div>
                <div class="league-right">
                    <a href="{{URL('/all-leagues')}}" class="league-btn">Join a league</a>
                </div>
            </div><!-- end league-btn-container -->

            <div class="league-btn-container">
                <div class="one-third">
                   <a href="{{URL('/auth/login')}}" class="info-btn">Login</a>
                </div>
                <div class="one-third">
                    <a href="{{URL('/rules')}}" class="info-btn">Rules</a>
                </div>
                <div class="one-third">
                    <a href="{{URL('/all-movies')}}" class="info-btn">Movies</a>
                </div>
            </div><!-- end league-btn-container -->

        </div><!-- end league-left-inner -->

        <div class="league-right-inner league-js small--one-whole">
            @if($recent_leagues->count() > 0)
            @foreach($recent_leagues as $recent)
           <div class="table-row {{(($recent->type == 'U') ? 'public' : 'private')}}">
                <div class="league-left">
                    {{$recent->name}}
                </div>
                <div class="league-right">
                   <a href="{{URL('league-show', ['id'=>$recent->id])}}" class="league-btn">{{(($recent->type == 'U') ? 'Public' : 'Private')}}</a>
                </div>
           </div>
           @endforeach
           @endif
        </div>
    </div>
</div>
<!-- End Whats going on -->

@if(isset($opening_bids))
<!-- Opening Bids -->
<?php $openingBid = $opening_bids[0]; ?>
<h2><span>Opening Bids</span></h2>
<div class="content-padding">

<div class="promo-hero">
    
    @if($openingBid->topMedia())
    <img src="{{asset($openingBid->topMedia()->file_name)}}" alt="{{$openingBid->topMedia()->name}}" />
    @endif
    <div class="promo-content">
        @if($openingBid->topImage('L'))
        <div class="promo-image">
            <img src="{{$openingBid->topImage('L')->path()}}" alt="{{$openingBid->topImage('L')->name}}" width="55%" />
        </div>
        @endif
        <div class="promo-left">
            <h3>{{$openingBid->name}}</h3>
            <p>Opening Bid</p>
        </div>
        <div class="promo-right">
            <p class="price">&pound;{{$openingBid->opening_bid}}</p>
        </div>
    </div>
</div>

@for($movie_no=1; $movie_no < $opening_bids->count(); $movie_no++)
<?php $movie_bid = $opening_bids[$movie_no]; ?>
<div class="one-quarter small--one-half">
    @if($movie_bid->topImage('L'))
    <img src="{{asset($movie_bid->topImage('L')->path())}}" alt="{{$movie_bid->name}}" />
    @else
    <img src="{{asset('images/TNBF_missing_poster.jpg')}}" alt="{{$movie_bid->name}}" />
    @endif
    <h3>{{$movie_bid->name}}</h3>
    <p>Include at: <span class="highlight">&pound;{{$movie_bid->opening_bid}}</span></p>
    <p>Release Date: <span class="highlight">{{date("M Y", strtotime($movie_bid->release_at))}}</span></p>
</div>
@endfor
</div><!--/ .content-container-->
@endif

@if(isset($trailers))
<h2><span>New Trailers</span></h2>
<div class="content-padding">
       
    <div class="release">
        <div class="gamelist">
            <div class="clearfix owl-carousel owl-theme" id="owl-movies">
                @foreach($trailers as $item)
                <?php                      
                    $base_url = "";              
                    if ($item->type =='T' && str_contains($item->url, "youtu.be")) {
                        $url = $item->url;

                        //only use youtube currently
                        $path = parse_url($url, PHP_URL_PATH);
                        $base_url = "http://www.youtube.com/embed".$path;
                    }
                ?>
                <div class="item">
                    <a href="{{URL('movie-knowledge', ['id'=>$item->movies_id])}}">
                        <iframe width="100%" height="400" src="{{$base_url}}" frameborder="0" allowfullscreen></iframe>
                    </a>
                    <div class="caption">
                        
                        <h5 class="title"><a href="{{URL('movie-knowledge', ['id'=>$item->movie->slug])}}">
                        {{$item->movie->name}}</a></h5>
                        <div class="caption-info" style="font-size: 0.9em">
                            <span class="description">Include at <span style="font-color: #F00">&pound;{{number_format($item->movie->opening_bid, 2)}}</span></span> | <span class="date">Release Date: <span style="font-color: #F00">{{date("M Y", strtotime($item->movie->release_at))}}</span></span>
                        </div>
                    </div><!--/ .caption-->                            
                    <div class="clear"></div>
                </div><!-- end of owl item -->
                @endforeach
            </div><!-- end of owl carousel -->
        </div>
    </div>
</div>
@endif    
@endsection