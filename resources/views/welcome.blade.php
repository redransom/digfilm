@extends('layouts.site')

@section('content')
<div class="content-padding">
@if (!is_null($content))
{!! $content->summary !!}
@endif
</div>

<h2><span>Whats Going On?</span></h2>
<div class="content-padding">
              <div class="league-container clearfix">
        <div class="league-left-inner league-js small--one-whole">
            <h3>There are...</h3>
            <div class="league-table">
                 <!-- <div class="table-row"></div>-->
                    <div class="league-left">
                        <p>Public League</P>
                    </div>
                    <div class="league-right">
                        <p>200 </p>
                    </div>
                    <div class="table-row"></div>
                    <div class="league-left">
                        <p>Private Leagues</P>
                    </div>
                    <div class="league-right">
                        <p>2569 </p>
                    </div>
                    <div class="table-row"></div>
                    <div class="league-left">
                        <p>New Releases This Month</P>
                    </div>
                    <div class="league-right">
                        <p>34 </p>
                    </div>
                    <div class="table-row"></div>
                    <div class="league-left">
                        <p>Films Coming Soon</P>
                    </div>
                    <div class="league-right">
                        <p>56 </p>
                    </div>
                    <div class="table-row"></div>
                    <div class="league-left">
                        <p>Players</P>
                    </div>
                    <div class="league-right">
                        <p>7000 </p>
                    </div>
                    <div class="table-row"></div>
</div>
<div class="league-btn-container">
    <div class="league-left">
           <a href="#" class="league-btn">Create a new league</a> 
    </div>
    <div class="league-right">
        <a href="#" class="league-btn">Join a league</a>
    </div>
</div><!-- end league-btn-container -->

    <div class="league-btn-container">
        <div class="one-third">
           <a href="#" class="info-btn">Login</a>
        </div>
        <div class="one-third">
            <a href="#" class="info-btn">Rules</a>
        </div>
        <div class="one-third">
            <a href="#" class="info-btn">Movies</a>
        </div>
    </div><!-- end league-btn-container -->

</div><!-- end league-left-inner -->

<div class="league-right-inner league-js small--one-whole">
   <div class="table-row public">
        <div class="league-left">
            Test Admin League
        </div>
        <div class="league-right">
           <a href="#" class="league-btn">Public</a>
        </div>
   </div>
   <div class="table-row private">
        <div class="league-left">
            Create League Player
        </div>
        <div class="league-right">
            <a href="#" class="league-btn">Private</a>
        </div>
   </div>
   <div class="table-row public">
        <div class="league-left">
            Test Admin League
        </div>
        <div class="league-right">
           <a href="#" class="league-btn">Public</a>
        </div>
   </div>
   <div class="table-row public">
        <div class="league-left">
            Test Admin League
        </div>
        <div class="league-right">
           <a href="#" class="league-btn">Public</a>
        </div>
   </div>
   <div class="table-row public">
        <div class="league-left">
            Test Admin League
        </div>
        <div class="league-right">
           <a href="#" class="league-btn">Public</a>
        </div>
   </div>
   <div class="table-row public">
        <div class="league-left">
            Test Admin League
        </div>
        <div class="league-right">
           <a href="#" class="league-btn">Public</a>
        </div>
   </div>
   <div class="table-row private">
        <div class="league-left">
            Create League Player
        </div>
        <div class="league-right">
            <a href="#" class="league-btn">Private</a>
        </div>
   </div>
   <div class="table-row private">
        <div class="league-left">
            Create League Player
        </div>
        <div class="league-right">
            <a href="#" class="league-btn">Private</a>
        </div>
   </div>
    <div class="table-row public">
        <div class="league-left">
            Test Admin League
        </div>
        <div class="league-right">
           <a href="#" class="league-btn">Public</a>
        </div>
   </div>
</div>
</div>




</div>

<h2><span>Opening Bids</span></h2>
<div class="content-padding">

<div class="promo-hero">
    <img src="images/hero-image.jpg" alt="Still Alice" />
    <div class="promo-content">
        <div class="promo-image">
            <img src="images/promo-img.jpg" alt="Still Alice" />
        </div>
        <div class="promo-left">
            <h3>Still Alice</h3>
            <p>Opening Bid</p>
        </div>
        <div class="promo-right">
            <p class="price">Â£30</p>
        </div>
    </div>
</div>

<div class="one-quarter small--one-half">
    <img src="images/opening-bid-1.jpg" alt="Captain America" />
    <h3>Captain America</h3>
    <p>Include at: <span class="highlight">&pound;30.00</span></p>
    <p>Release Date: <span class="highlight">Feb 2018</span></p>
</div>

<div class="one-quarter small--one-half">
    <img src="images/opening-bid-1.jpg" alt="Captain America" />
    <h3>Captain America</h3>
    <p>Include at: <span class="highlight">&pound;30.00</span></p>
    <p>Release Date: <span class="highlight">Feb 2018</span></p>
</div>
<div class="one-quarter small--one-half">
    <img src="images/opening-bid-1.jpg" alt="Captain America" />
    <h3>Captain America</h3>
    <p>Include at: <span class="highlight">&pound;30.00</span></p>
    <p>Release Date: <span class="highlight">Feb 2018</span></p>
</div>
<div class="one-quarter small--one-half">
    <img src="images/opening-bid-1.jpg" alt="Captain America" />
    <h3>Captain America</h3>
    <p>Include at: <span class="highlight">&pound;30.00</span></p>
    <p>Release Date: <span class="highlight">Feb 2018</span></p>
</div>          
    
    
</div><!--/ .content-container-->

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
                        <div class="caption-info">
                            <span class="date">{{date("d-M-Y h:i A", strtotime($item->created_at))}}Thursday </span>
                            <span class="description">{{$item->description}}</span>
                        </div>
                    </div><!--/ .caption-->                            
                    <div class="clear"></div>
                </div><!-- end of owl item -->
                @endforeach
            </div><!-- end of owl carousel -->
        </div>
    </div>
</div>
           
@endsection