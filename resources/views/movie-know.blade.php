@extends('layouts.site')

@section('content')
@include('partials.site-auction-timer')
<div id="main" itemscope="" itemtype="http://data-vocabulary.org/Review">
    <div class="game-info-left">
        @if($movie->topImage('K'))
        <img itemprop="image" src="{{ asset($movie->topImage('K')->path()) }}" class="game-poster" width="220px" alt="{{$movie->topImage('K')->name}}" />
        @else
        <img itemprop="image" src="{{ asset('images/TNBF_missing_poster.jpg') }}" class="game-poster" alt="{{$movie->name}}" />
        @endif
        <div class="game-info-details">
            <!--div class="game-info-buttons">
                <a href="#" class="defbutton green"><i class="fa fa-bell"></i>Follow Film</a>
                <a href="games-single-video-single.html" class="defbutton"><i class="fa fa-film"></i>View Trailer</a>
            </div-->
            <div class="game-info-rating">
                <h3>TheNextBigFilm Review</h3>
                <hr />
                @if($movie->rating > 0)
                <strong itemprop="rating">{{$movie->rating}}</strong>
                <div class="rating-stars">
                    <div class="rating-stars-inner" style="width: 90%;"></div>
                </div>
                @endif
                <!--a href="post.html" class="defbutton"><i class="fa fa-file-text-o"></i>Read Review</a-->
            </div>
            <!--div class="game-info-buttons">
                <a href="games-single-shop.html" class="defbutton"><i class="fa fa-shopping-cart"></i>Buy game starting from <span class="pricetag">55 &euro;</span></a>
                <a href="#" class="defbutton"><i class="fa fa-gamepad"></i>I have played</a>
            </div-->
            <div class="game-info-graph">
                <div>
                    <span>Release Date:</span>
                    <strong itemprop="datePublished" content="2013-03-05">{{date("l, jS F Y", strtotime($movie->release_at))}}</strong>
                </div>
                @if(!is_null($movie->opening_bid))
                <div>
                    <span>Opening Bid:</span>
                    <strong>£{{number_format($movie->opening_bid, 2)}}</strong>
                </div>
                @endif
                <div>
                    <span>Highest Purchase Value:</span>
                    <strong>£{{number_format($movie->topBid(), 2)}}</strong>
                </div>
                <div>
                    <span>Lowest Purchase Value:</span>
                    <strong>£{{number_format($movie->lowestBid(), 2)}}</strong>
                </div>
                <div>
                    <span>Average Purchase Value:</span>
                    <strong>£{{number_format($movie->averageBid(), 2)}}</strong>
                </div>
                @if($movie->daysInterval() !== FALSE)
                 <div>
                    <span>Days since release:</span>
                    <strong>{{$movie->daysInterval()}}</strong>
                </div>
                @else
                 <div>
                    <span>Days till release:</span>
                    <strong><?php auctionTimer($movie->id, $movie->release_at); ?></strong>
                </div>
                @endif
                @if($movie->daysInterval(true, 'TC') !== FALSE)
                 <div>
                    <span>Days left for auctions:</span>
                    <strong>{{$movie->daysInterval(true, 'TC')}}</strong>
                </div>
                @endif
                <div>
                    <span>No of Bids:</span>
                    <strong>{{$movie->bids()->count()}}</strong>
                </div>
                @if(isset($movie->genre))
                <div>
                    <span>Genre</span>
                    <strong itemprop="applicationCategory"><a href="{{URL('/genre/'.$movie->genre->slug)}}">{{$movie->genre->name}}</a></strong>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="game-info-right">

        <!-- BEGIN .game-menu -->
        <script>
        $(function() {
            $("#stats_link").click(function() {
                $('#articles_box').removeClass('active').css('background-color', '#000000');
                $('#stats_box').addClass('active').css('background-color', '#921913');
                $('#stats').toggle();
                $('#articles').toggle();
            });

            $("#articles_link").click(function() {
                $('#stats_box').removeClass('active').css('background-color', '#000000');
                $('#articles_box').addClass('active').css('background-color', '#921913');
                $('#stats').toggle();
                $('#articles').toggle();
            });
        });
        </script>

        <div class="game-menu">
            <div class="game-overlay-info">
                <h1 itemprop="itemreviewed">{{$movie->name}} ({{date("Y", strtotime($movie->release_at))}})</h1>
                <span>{{$movie->summary}}</span>
            </div>

            <ul>
                <li class="active" style="background-color: #921913;" id="stats_box"><a href="#" id="stats_link"><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;Film Stats</a></li>
                <li id="articles_box"><a href="#" id="articles_link"><i class="fa fa-comments"></i>&nbsp;&nbsp;Articles</a></li>
            </ul>

        <!-- END .game-menu -->
        </div>
        <div id="stats">
            @if(!is_null($movie->topTrailer()))
            <div class="vid-contain">
                <?php                      
                    $base_url = "";              
                    //if ($item->type =='T' && str_contains(, "youtu.be")) {
                        $url = $movie->topTrailer()->url;

                        //only use youtube currently
                        $path = parse_url($url, PHP_URL_PATH);
                        $base_url = "http://www.youtube.com/embed".$path;
                    //}
                ?>
                <iframe width="100%" height="400" src="{{$base_url}}" frameborder="0" allowfullscreen></iframe>
            </div>
            @endif

            @if($movie->bids()->count() > 0 && isset($authUser))
            <h2><span>Stats</span></h2>
            <div class="content-padding">
                <script src="{{ asset('jscript/Chart.min.js') }}"></script>

                <div width="100%" style="display: clear">
                    <div style="float:left; width: 150px">
                    <h3>Number of Bids in last month</h3>
                    <p>Use this graph to see how popular the movie is and has been in the last 30 days</p>
                    @if(isset($bid_history) && !empty($bid_history))
                    <h4>Bids History</h4>
                    <ul>
                        @foreach($bid_history as $bid)
                            <li>{{$bid->month_nm}} : {{$bid->no_of_bids}} 
                            @if($bid->no_of_bids > 1)
                            bids
                            @else
                            bid
                            @endif
                            </li>
                        @endforeach
                    </ul>
                    @endif
                    </div>
                    <canvas id="lcNoOfBids" width="400" height="200" style="float:left; padding-left: 50px; display:block"></canvas>
                </div>
                <div class="sep"></div>
                <div style="width:600px; float: left; clear:both; padding-top: 10px">
                    <div style="float:left; width: 150px">
                    <h3>Bid amounts in last month</h3>
                    <p>This graph shows what the values that were bid on the film over the last month.</p>
                    </div>
                    <canvas id="lcLast30" width="400" height="200" style="float:left; padding-left: 50px; display:block"></canvas>
                </div>

                <script type="text/javascript">
                    var options = {

                            ///Boolean - Whether grid lines are shown across the chart
                            scaleShowGridLines : true,

                            //String - Colour of the grid lines
                            scaleGridLineColor : "rgba(35,25,125,.05)",

                            //Number - Width of the grid lines
                            scaleGridLineWidth : 1,

                            //Boolean - Whether to show horizontal lines (except X axis)
                            scaleShowHorizontalLines: true,

                            //Boolean - Whether to show vertical lines (except Y axis)
                            scaleShowVerticalLines: true,

                            //Boolean - Whether the line is curved between points
                            bezierCurve : false,

                            //Number - Tension of the bezier curve between points
                            bezierCurveTension : 0.4,

                            //Boolean - Whether to show a dot for each point
                            pointDot : false,

                            //Number - Radius of each point dot in pixels
                            pointDotRadius : 4,

                            //Number - Pixel width of point dot stroke
                            pointDotStrokeWidth : 1,

                            //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
                            pointHitDetectionRadius : 20,

                            //Boolean - Whether to show a stroke for datasets
                            datasetStroke : true,

                            //Number - Pixel width of dataset stroke
                            datasetStrokeWidth : 2,

                            //Boolean - Whether to fill the dataset with a colour
                            datasetFill : true,

                            //String - A legend template
                            legendTemplate : "{!! $legend1 !!}"

                        };
                    @if(isset($no_of_bids))
                    var ctx2 = document.getElementById("lcNoOfBids").getContext("2d"),
                        data2 = {
                            labels: [{{join($days, ",")}}],
                            datasets: [
                                {
                                    label: "No Of Bids",
                                    fillColor: "rgba(93, 29, 30,0.2)",
                                    strokeColor: "rgba(220,220,220,1)",
                                    pointColor: "rgba(220,220,220,1)",
                                    pointStrokeColor: "#fff",
                                    pointHighlightFill: "#fff",
                                    pointHighlightStroke: "rgba(220,220,220,1)",

                                    data: [{{join($no_of_bids, ",")}}]
                                }
                            ]
                        };

                    var noOfBids = new Chart(ctx2).Line(data2, options);
                    @endif
                    @if(isset($bid_groups['totals']))
                    var ctx3 = document.getElementById("lcLast30").getContext("2d"),
                        data3 = {
                            labels: [{{join($bid_groups['amount'], ",")}}],
                            datasets: [
                                {
                                    label: "Last 30 bids",
                                    fillColor: "rgba(93, 29, 30,0.2)",
                                    strokeColor: "rgba(220,220,220,1)",
                                    pointColor: "rgba(220,220,220,1)",
                                    pointStrokeColor: "#fff",
                                    pointHighlightFill: "#fff",
                                    pointHighlightStroke: "rgba(220,220,220,1)",

                                    data: [{{join($bid_groups['totals'], ",")}}]
                                }
                            ]
                        };

                    var last30Bids = new Chart(ctx3).Bar(data3, options);
                    @endif
                </script>
                  
            </div>
            @endif
        </div>
        <!--h2><span>Media</span></h2>
        <div class="content-padding">
            <div class="row">
                @if($movie->images()->count() > 0)
                <?php $imageCnt = 1; ?>
                @foreach($movie->images() as $image)
                @if($image->image_type != 'F')
                <div class="one-fifth" style="padding-right: 10px">
                    <img src="{{asset($image->path())}}" alt="{{$image->name}}" />
                </div>
                @endif
                @if($imageCnt++ > 6)
                    <?php break; ?>
                @endif
                @endforeach

                @else
                <p>There is no media for this movie currently.</p>
                @endif
            </div>
        </div-->

        <div id="articles" style="display:none">
            @if($movie->reviews->count() > 0)
            @foreach($movie->reviews as $review)
            <h2><span>{{$review->title}}</span></h2>
            <div class="content-padding">
            @include('partials.site-article', ['content'=>$review])
            </div>

            @endforeach
            @endif
        </div>


        <!-- END .content-padding -->
        </div>

    </div>

    <div class="clear-float"></div>
    
</div>

@endsection