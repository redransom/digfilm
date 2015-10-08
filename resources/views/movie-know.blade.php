@extends('layouts.users')

@section('content')
<div class="title-caption-large">
    <h3>{{$movie->name}}</h3>
</div><!--/ .title-caption-large-->


<!-- ************** - Posts - ************** -->
<section id="content-posts" class="detailed">
    
    
    <article class="post-item clearfix">
        
        <section class="post-thumb">
            @if($movie->media)
            <a href="#"><img src="images/temp/img_1.jpg" width="313" height="220" alt="" /></a>
            @endif
        </section><!--/ .post-thumb-->

        
        <section class="post-entry">
            <div class="post-date">Released: {{date("l, jS F Y", strtotime($movie->release_at))}}</div><!--/ .post-date-->
            <div class="post-title">
                <h5><a href="#">{{$movie->summary}}</a></h5>
            </div><!--/ .post-title-->
            <div class="star"></div><!--/ .star-->
            <p>
            </p>
            
            <blockquote>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod <br /> tempor incididunt ut labore 
                et dolore magna aliqua.
            </blockquote>
            
            <p>
                Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo 
                consequat. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor 
                incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis consectetur adipisicing elit
                 ipsum dolor sit amet.
            </p>
            
        </section><!--/ .post-entry-->
    </article><!--/ .post-item-->
</section>
@endsection