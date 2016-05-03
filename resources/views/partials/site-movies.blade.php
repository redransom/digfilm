@if($movies->count() > 0)

    @if(isset($sectionTitle))
    <h2><span>{{$sectionTitle}}</span></h2>
    @endif
    @if(isset($description))
    <h3>{{$description}}</h3>
    @endif
    <br/>
    <?php $movieCnt = 0; ?>
    @foreach($movies as $movie)
    @if((($movieCnt % 4) == 0) || $movieCnt == 0)
    <div class="row">
    @endif
        <div class="one-quarter small--one-half">
            <a href="{{URL('movie-knowledge', ['id'=>$movie->link()])}}">
            @if($movie->topImage('L'))
            <img src="{{asset($movie->topImage('L')->path())}}" alt="{{$movie->name}}" />
            @else
            <img src="{{asset('images/TNBF_missing_poster.jpg')}}" alt="{{$movie->name}}" />
            @endif
            </a>
            <h3><a href="{{URL('movie-knowledge', ['id'=>$movie->link()])}}">{{$movie->name}}</a></h3>
            @if(!is_null($movie->opening_bid))
            <p>Open Bid: <span class="highlight">&pound;{{$movie->opening_bid}}</span></p>
            @endif
            <p>Release Date: <span class="highlight">{{date("M Y", strtotime($movie->release_at))}}</span></p>
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