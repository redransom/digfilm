@if($movies->count() > 0)
<div class="event-list">
@foreach ($movies as $movie)
    <!-- BEGIN .item -->
    <div class="item">
        <div class="item-head" style="padding-right: 10px">
            @if($movie->firstImage())
            <img src="{{asset($movie->firstImage()->file_name)}}" />
            @else
            <img src="{{asset('images/temp/img_1.jpg')}}" width="159" height="100" alt="" />
            @endif
            <!--a href="events-single.html" class="event-icon"><strong>{{date("j", strtotime($movie->release_at))}}</strong><span>{{date("M", strtotime($movie->release_at))}}</span></a-->
        </div>
        <div class="item-top">
            <h3>@if(!is_null($movie->slug) && $movie->slug != "")
            <a href="{{URL('movie-knowledge', $movie->slug)}}">{{$movie->name}}</a>
            @else
            <a href="{{URL('movie-knowledge', $movie->id)}}">{{$movie->name}}</a>
            @endif</h3>
            <strong class="post-a"><i class="fa fa-clock-o"></i><strong>{{date("j M Y", strtotime($movie->release_at))}}</strong></strong>
            <strong class="post-a"><i class="fa fa-map-marker"></i><strong>Genre: {{$movie->genre->name}}</strong></strong>
            <span id="rating_{{$movie->id}}"></span><!--/ .star-->
        </div>
        <div class="item-bottom">
            <p>{{$movie->summary}}</p>
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
        </script>

    <!-- END .item -->
    </div>
@endforeach

</div>
@else
<p>There are no movies in this category currently.</p>
@endif

