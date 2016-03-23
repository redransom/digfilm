@if($movies->count() > 0)
<div class="event-list">
@foreach ($movies as $movie)
    <!-- BEGIN .item -->
    <div class="one-quarter small--one-half">

            @if($movie->firstImage())
            <img src="{{asset($movie->firstImage()->file_name)}}" />
            @else
            <img src="{{asset('images/temp/img_1.jpg')}}" />
            @endif

            <h3>@if(!is_null($movie->slug) && $movie->slug != "")
            <a href="{{URL('movie-knowledge', $movie->slug)}}">{{$movie->name}}</a>
            @else
            <a href="{{URL('movie-knowledge', $movie->id)}}">{{$movie->name}}</a>
            @endif</h3>
            <!--strong class="post-a"><i class="fa fa-clock-o"></i><strong>{{date("j M Y", strtotime($movie->release_at))}}</strong></strong>
            @if(isset($movie->genre))
            <strong class="post-a"><i class="fa fa-map-marker"></i><strong>Genre: {{$movie->genre->name}}</strong></strong>
            @endif
            <span id="rating_{{$movie->id}}"></span><!--/ .star-->

            <!--p>{{$movie->summary}}</p>
            @if(!is_null($movie->slug) && $movie->slug != "")
            <a href="{{URL('movie-knowledge', $movie->slug)}}" class="button invert">View Movie</a>
            @else
            <a href="{{URL('movie-knowledge', $movie->id)}}" class="button invert">View Movie</a>
            @endif
        </div>
        <script>
        $(function() {
            $('#rating_{{$movie->id}}').raty({ score: {{$movie->rating}}});
        });
        </script-->

    <!-- END .item -->
        <p>Include at: <span class="highlight">&pound;30.00</span></p>
     <p>Release Date: <span class="highlight">{{date("j M Y", strtotime($movie->release_at))}}</span></p>
    </div>
@endforeach

</div>
@else
<p>There are no movies in this category currently.</p>
@endif

