@if(isset($content))
    <div class="article-full">
        @if(!is_null($content->main_image))
        <div class="article-main-photo">
            <img src="{{ asset($content->main_image) }}" alt="" title=""  width="644" height="300"/>
        </div>
        @endif
        <div class="article-icons">
            <a><i class="fa fa-fire"></i>{{$content->owner->forenames}}</a>
            <a><i class="fa fa-calendar"></i>{{date("F d, Y", strtotime($content->created_at))}}</a>
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
