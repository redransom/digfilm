                    <!-- BEGIN .panel -->
                    <div class="panel">
                        <h2>News</h2>
                        <!--div class="top-right"><a href="#">View all</a></div-->
                        <div class="panel-content">
                            @if(isset($news_articles))

                            <div class="d-articles">
                                @foreach($news_articles as $article)
                                <?php $thumbnail = (!is_null($article->thumbnail) && $article->thumbnail != '') ? asset($article->thumbnail) : "\images\TNBF.jpg"; ?>
                                <div class="item">
                                    <div class="item-header">
                                        <a href="{{URL('news-detail', $article->link())}}"><img src="{{$thumbnail}}" alt="{{$article->title}}" /></a>
                                    </div>
                                    <div class="item-content">
                                        <h4><a href="{{URL('news-detail', $article->link())}}">{!! $article->title !!}</a></h4>
                                        @if(!is_null($article->summary) && $article->summary !='')
                                            {!! str_limit($article->summary, 100) !!}
                                        @endif
                                        <br/><span style="font-size: 0.8em"><em>{{date("j M Y", strtotime($article->created_at))}}</em></span>
                                    </div>
                                </div>
                                @endforeach

                            </div>
                            @else
                            <p>There are no news articles currently.</p>
                            @endif
                        </div>
                    <!-- END .panel -->
                    </div>