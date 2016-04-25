                    <!-- BEGIN .panel -->
                    <div class="panel">
                        <h2>Recent News</h2>
                        <!--div class="top-right"><a href="#">View all</a></div-->
                        <div class="panel-content">
                            @if(isset($news_articles))

                            <div class="d-articles">
                                @foreach($news_articles as $article)
                                <div class="item">
                                    <div class="item-header">
                                        <a href="{{URL('news-detail', $article->link())}}">
                                        @if(!is_null($article->thumbnail))
                                        <img src="{{asset($article->thumbnail) }}" alt="" />
                                        @else
                                        <img src="{{asset('/images/TNBF.jpg') }}" alt="" />
                                        @endif
                                        </a>
                                    </div>
                                    <div class="item-content">
                                        <h4><a href="{{URL('news-detail', $article->link())}}">{!! $article->title !!}</a></h4>
                                       {!! $article->summary !!}...
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