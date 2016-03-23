@extends('layouts.site')

@section('content')
<h2><span>Highlights</span></h2>
<div class="content-padding">
    <div class="release">
        <div class="gamelist">
            <div class="clearfix owl-carousel owl-theme" id="owl-movies">
                @foreach($movies as $movie)
               
                <div class="item">
                    <a href="{{URL('movie-knowledge', $movie->link())}}">
                    @if($movie->firstImage())
                    <img src="{{$movie->firstImage()->file_name}}" width="159" height="100" alt="" />
                    @else
                    <img src="images/temp/img_1.jpg" width="159" height="100" alt="" />
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

<h2><span>All Movies</span></h2>
<div class="content-padding">
    <div class="row">
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
    </div>
     <div class="row">
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
    </div>

     <div class="row">
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
    </div>
     <div class="row">
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
    </div>
     <div class="row">
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
    </div>

</div>


        <h2 class="pagination"><span>
            <span class="pagination-item current">1</span>
            <span class="pagination-item">2</span>
            <span class="pagination-item">3</span>
            <span class="pagination-item">4</span>
            <span class="pagination-item">5</span>
        </span></h2>
@endsection