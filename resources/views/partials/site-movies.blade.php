@if($movies->count() > 0)
<div class="content-padding">
    @if(isset($description))
    <h4>{{$description}}</h4>
    @endif

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


@else
<p>There are no movies in this category currently.</p>
@endif