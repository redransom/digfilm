@extends('layouts.site')

@section('content')
<h2><span>All Movies in The Next Big Film database</span></h2>
<div class="content-padding">
    
    @foreach($movies as $movie)
    <article class="post-item clearfix">
        
        <section class="post-thumb">
            <a href="{{URL('movie-knowledge', $movie->link())}}">
            @if($movie->firstImage())
            <img src="{{$movie->firstImage()->file_name}}" width="159" height="100" alt="" />
            @else
            <img src="images/temp/img_1.jpg" width="159" height="100" alt="" />
            @endif
            </a>
        </section><!--/ .post-thumb-->
        <section class="post-entry">
            <div class="post-date">{{date("l, jS F Y", strtotime($movie->release_at))}}</div><!--/ .post-date-->
            <div class="post-title">
                <h5><a href="{{URL('movie-knowledge', $movie->link())}}">{{$movie->name}}</a></h5>
            </div><!--/ .post-title-->
            <div class="description">
                {{$movie->summary}}
            </div><!--/ .description-->
            <!--/ .platform-teaser-->
            <div id="rating_{{$movie->id}}"></div><!--/ .star-->
            <script>
            $(function() {
                $('#rating_{{$movie->id}}').raty({ score: {{$movie->rating}}});
            });
            </script>
            <!--a class="comments-icon" href="#">23 comments</a--><!--/ comments-icon-->
        </section><!--/ .post-entry-->
        
    </article><!--/ .post-item-->
    @endforeach    
    
</div>
@endsection