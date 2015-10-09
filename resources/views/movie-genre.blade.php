@extends('layouts.users')

@section('content')
<div class="title-caption-large">
    <h3>Movies in the {{$genre->name}} Genre</h3>
</div><!--/ .title-caption-large-->
                
                
<!-- ************** - Posts - ************** -->
<section id="page">
    
    @foreach($genre->movies as $movie)
    <article class="post-item clearfix">
        
        <section class="post-thumb">
            @if($movie->media)
            <a href="#"><img src="images/temp/img_1.jpg" width="159" height="100" alt="" /></a>
            @endif
        </section><!--/ .post-thumb-->
        
        <section class="post-entry">
            <div class="post-date">{{date("l, jS F Y", strtotime($movie->release_at))}}</div><!--/ .post-date-->
            <div class="post-title">
                <h5><a href="{{URL('movie-knowledge', $movie->slug)}}">{{$movie->name}}</a></h5>
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
    
</section>
@endsection