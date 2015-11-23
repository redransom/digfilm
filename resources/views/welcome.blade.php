@extends('layouts.front')

@section('content')
<!-- ************** - Scroll Container - ************** -->
        <div class="scroll-container">
                        
            <!-- ************** - UI Scroller - ************** -->
            <h3>Whats Going On?</h3>
            
            <div class="scroller_wrap">
                <div class="scroller_block">
                    <ul style="width:1980px">
                        <li>
                            <a href="{{URL('all-leagues')}}"><img class="small-custom-frame" src="{{asset('/images/publicleagues.png')}}" width="222" height="137" alt="" /></a>
                            <div class="scroll-caption">
                                <span>Public Leagues</span>
                                <h6><a href="#">There are <strong>{{$public_count}}</strong> public leagues!</a></h6>
                            </div><!--/ .scroll-caption-->
                        </li>
                        @if(!is_null($opening_bid))
                        <li>
                            <a href="{{URL('movie-knowledge', ['id'=>$opening_bid->id])}}"><img class="small-custom-frame" src="images/temp/temp_img_2.jpg" width="222" height="137" alt="" /></a>
                            <div class="scroll-caption">
                                <span>Opening Bid</span>
                                <h6><a href="{{URL('movie-knowledge', ['id'=>$opening_bid->id])}}">Include this film at <strong>&dollar;{{$opening_bid->opening_bid}}</strong></a></h6>
                                <h6><em>{{$opening_bid->name}}</em></h6>
                                
                            </div><!--/ .scroll-caption-->
                        </li>
                        @endif
                        @if(!is_null($next_film))
                        <li>
                            <a href="{{URL('movie-knowledge', ['id'=>$opening_bid->id])}}"><img class="small-custom-frame" src="{{asset('/images/countdown.png')}}" width="222" height="137" alt="" />
                            </a>
                            <div class="scroll-caption">
                                <span>Next Film Released</span>
                                <h6><a href="{{URL('movie-knowledge', ['id'=>$opening_bid->id])}}">{{$next_film->name}}</a></h6>
                                <div style="display:inline !important; padding-bottom: 10px" id="rating_{{$next_film->id}}"></div><!--/ .star-->
                                <script>
                                $(function() {
                                    $('#rating_{{$next_film->id}}').raty({ score: {{$next_film->rating}}});
                                });
                                </script>
                            </div><!--/ .scroll-caption-->
                        </li>
                        @endif
                    </ul>
                </div><!--/ .sroller_block-->
                <!--div class="scroller_slider">
                    <a href="#" class="scroller_slider_prev"></a>
                    <a href="#" class="scroller_slider_next"></a>
                    <div class="scroller_slider_bar"></div>
                </div--><!--/ .scroller_slider-->
            </div><!--/ .scroller_wrap-->
            

            <!-- ************** - END UI Scroller - ************** -->
            
            
        </div><!--/ .content-container-->


        <!-- ************** - END Content Container - ************** -->

        <div class="entry sbr clearfix">


            <!-- ************** - Content - ************** -->
            
            <div id="content">
                
                <div class="title-caption-large">
                    <h3>New Trailers</h3>
                </div><!--/ .title-caption-large-->
                
                <div class="release">
                    <div class="gamelist">
                        <ul class="clearfix">
                            @foreach($trailers as $item)
                            <?php                      
                                $base_url = "";              
                                if ($item->type =='T' && str_contains($item->url, "youtu.be")) {
                                    $url = $item->url;

                                    //only use youtube currently
                                    $path = parse_url($url, PHP_URL_PATH);
                                    $base_url = "http://www.youtube.com/embed".$path;
                                }
                            ?>
                            <li>
                                <a href="{{URL('movie-knowledge', ['id'=>$item->movies_id])}}">
                                    <iframe width="313" height="220" src="{{$base_url}}" frameborder="0" allowfullscreen></iframe>
                                </a>
                                <div class="caption">
                                    <span class="date">{{date("d-M-Y h:i A", strtotime($item->created_at))}}Thursday </span>
                                    <h5 class="title"><a href="{{URL('movie-knowledge', ['id'=>$item->movie->slug])}}">{{$item->movie->name}}</a></h5>
                                    <div class="description">{{$item->description}}</div>
                                    
                                </div><!--/ .caption-->                            
                                <div class="clear"></div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
           @include('partials.user-sidebar')
        </div>
@endsection