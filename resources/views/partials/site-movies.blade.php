@if($movies->count() > 0)

    @if(isset($sectionTitle))
    <h2><span>{{$sectionTitle}}</span></h2>
    @endif
    @if(isset($description))
    <h3>{{$description}}</h3>
    @endif
    <br/>
    <?php $movieCnt = 0; ?>

    <style>
        img.movie_image {
            height: 217px;
            width: 150px;
        }
    </style>
    @foreach($movies as $movie)
    @if((($movieCnt % 4) == 0) || $movieCnt == 0)
    <div class="row">
    @endif
        <div class="one-quarter small--one-half">
            <a href="{{URL('movie-knowledge', ['id'=>$movie->link()])}}">
            @if($movie->topImage('L'))
            <img src="{{asset($movie->topImage('L')->path())}}" alt="{{$movie->name}}" class="movie_image"/>
            @else
            <img src="{{asset('images/TNBF_missing_poster.jpg')}}" alt="{{$movie->name}}" class="movie_image" />
            @endif
            </a>
            <h3><a href="{{URL('movie-knowledge', ['id'=>$movie->link()])}}">{{$movie->name}}</a></h3>
            @if(!is_null($movie->opening_bid))
            <p>Open Bid: <span class="highlight">&pound;{{$movie->opening_bid}}</span></p>
            @endif
            <p>Released: <span class="highlight">{{date("j M Y", strtotime($movie->release_at))}}</span></p>
            @if(isset($showTakings) && $movie->takings()->count()>0)
            <p>Revenue: <span class="highlight">{{$movie->takings()->max('amount')/1000000}}M USD</span></p>
            @endif
        </div>

    <?php $movieCnt++; ?>

    @if(($movieCnt % 4) == 0)
    </div>
    @endif

    @endforeach

    @if(($movieCnt % 4) != 0)
    <!-- always close off the row in case it doesnt end on a 4 -->
    </div>
    @endif

@else
<p>There are no movies in this category currently.</p>
@endif