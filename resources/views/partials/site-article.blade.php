@if(isset($content))
    <div class="article-full">
        <div class="article-main-photo">
            @if(!is_null($content->main_image))
            <img src="{{ asset($content->main_image) }}" alt="" title=""  width="644" height="300"/>
            @else
            <img src="{{ asset('images/photos/image-59.jpg') }}" alt="" title=""/>
            @endif
        </div>
        <div class="article-icons">
            <a href="user-single.html" class="user-tooltip"><i class="fa fa-fire"></i>{{$content->owner->forenames}}</a>
            <a href="#"><i class="fa fa-calendar"></i>{{date("F d, Y", strtotime($content->created_at))}}</a>
            <!--a href="#" class="show-likes"><i class="fa fa-heart"></i>20 likes</a-->
        </div>
    
        <div class="clear-float do-the-split"></div>

        <div class="article-content">
            @if(!is_null($content->summary))
            {!! $content->summary !!}
            <div class="breaking-line"></div>
            @endif
            {!! $content->body !!}

        </div>
    </div>
@endif
