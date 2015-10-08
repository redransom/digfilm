@extends('layouts.users')

@section('content')
<div class="title-caption-large">
    <h3>Movies in the {{$genre->name}} Genre</h3>
</div><!--/ .title-caption-large-->
                
                
<!-- ************** - Posts - ************** -->
<section id="page">
    
    {{var_dump($genre->movies)}}
    <article class="post-item clearfix">
        
        <section class="post-thumb">
            <a href="blog-single.html"><img src="images/temp/temp_thumbs_1.jpg" width="159" height="100" alt="" /></a>
        </section><!--/ .post-thumb-->
        
        <section class="post-entry">
            <div class="post-date">Thursday 22-Mar-2012 12:37 PM</div><!--/ .post-date-->
            <div class="post-title">
                <h5><a href="blog-single.html">sed do eiusmod tempor incididunt </a></h5>
            </div><!--/ .post-title-->
            <div class="description">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod.
            </div><!--/ .description-->
            <div class="platform-teaser">
                <a href="#" class="xbox">Xbox360</a>
                <a href="#" class="ps3">PS3</a>
                <a href="#" class="ps-vista">Ps Vista</a>
                <a href="#" class="pc">PC</a>
            </div><!--/ .platform-teaser-->
            <div class="star"></div><!--/ .star-->
            <a class="comments-icon" href="#">23 comments</a><!--/ comments-icon-->
        </section><!--/ .post-entry-->
        
    </article><!--/ .post-item-->
    
    
    <article class="post-item clearfix">
        
        <section class="post-thumb">
            <a href="blog-single.html"><img src="images/temp/temp_thumbs_2.jpg" width="159" height="100" alt="" /></a>
        </section><!--/ .post-thumb-->
        
        <section class="post-entry">
            <div class="post-date">Thursday 22-Mar-2012 12:37 PM</div><!--/ .post-date-->
            <div class="post-title">
                <h5><a href="blog-single.html">Duis aute irure dolor in reprehenderit in  </a></h5>
            </div><!--/ .post-title-->
            <div class="description">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod.
            </div><!--/ .description-->
            <div class="platform-teaser">
                <a href="#" class="ps3">PS3</a>
                <a href="#" class="ps-vista">Ps Vista</a>
            </div><!--/ .platform-teaser-->
            <div class="star"></div><!--/ .star-->
            <a class="comments-icon" href="#">23 comments</a><!--/ comments-icon-->
        </section><!--/ .post-entry-->
        
    </article><!--/ .post-item-->
</section>
@endsection