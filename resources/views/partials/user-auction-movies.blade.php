    
    @if($movies->count() > 0)
    <br/>
    <h2>{{$movieTitle}}</h2>
    <p>This is a list of all movies that are to be played for in this league.</p>
    <?php $movieCnt = 0; ?>
    <ul id="movie-badge" class="clearfix">
    @foreach($movies as $movie)
        @if(($movieCnt % 4) == 0 && $movieCnt != 0)
        <li class="last">
        @else
        <li>
        @endif
        
        @if($movie->firstImage())
            <img src="{{$movie->firstImage()->file_name}}" alt="{{$movie->firstImage()->description}}" width="100px"/>
        @endif
        <a href="{{URL('movie-knowledge', [$movie->id])}}">{{$movie->name}}</a>
        @if($movie->opening_bid != 0)
        <br/>Opening Bid: <strong>${{$movie->opening_bid}}</strong>
        @endif
        </li>
        <?php $movieCnt++;?>
    @endforeach
    </ul>
    @endif