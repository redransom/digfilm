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
            <div class="game-info-rating">
                <h3>TheNextBigFilm Review</h3>
                <hr />
                @if($movie->rating > 0)
                <strong itemprop="rating">{{$movie->rating}}</strong>
                <div class="rating-stars">
                    <div class="rating-stars-inner" style="width: 90%;"></div>
                </div>
                @endif
            </div>
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
                $('#stats_link').addClass('filmStats');
                $('#articles_link').removeClass('filmStats');
                $('#stats').toggle();
                $('#articles').toggle();
            });

            $("#articles_link").click(function() {
                $('#stats_box').removeClass('active').css('background-color', '#000000');
                $('#articles_box').addClass('active').css('background-color', '#921913');
                $('#articles_link').addClass('filmStats');
                $('#stats_link').removeClass('filmStats');
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
                <li class="active" style="background-color: #921913;" id="stats_box"><a class="filmStats" href="#" id="stats_link"><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;Film Stats</a></li>
                <li style="background-color: #1c1c1c" class="removeBack" id="articles_box"><a href="#" id="articles_link"><i class="fa fa-comments"></i>&nbsp;&nbsp;Articles</a></li>
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
                    <p>Number of bids placed on this film in the last 30 days.</p>
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
                    <canvas id="lcNoOfBids" width="500px" height="339px" style="float: right; display: block;"></canvas>
                </div>
                <div class="sep"></div>
                <div style="width:679px; float: left; clear:both; padding-top: 10px">
                    <div style="float:left; width: 150px">
                    <h3>Average purchase value:</h3>
                    <p>Average purchase value of this film in the last 30 days.</p>
                    </div>
                    <canvas id="avg30" width="500" height="200" style="float:right; display:block"></canvas>
                </div>

                <script type="text/javascript">
                    @if(isset($no_of_bids))
                    <?php createGraph("lcNoOfBids", $days, "No Of Bids", $no_of_bids, "noOfBids", 2, "Last 30 Days", "Number of Bids"); ?>
                    @endif
        
                    @if(isset($avgs))
                    <?php createGraph("avg30", $days, "Last 30 days", $avgs, "avg30", 4, "Last 30 Days", "Average Value"); ?>
                    @endif
                </script>
                  
            </div>
            @endif
        </div>

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
<?php 
function createGraph($elementId, $labels, $title, $data, $varName, $uniqueId, $xAxesLabel, $yAxesLabel, $type="line") {
    $labels_string = join($labels, ",");
    $data_string = join($data, ",");
?>
    var ctx{{$uniqueId}} = $("#{{$elementId}}");
    var {{$varName}} = new Chart(ctx{{$uniqueId}}, {
        type: '{{$type}}',
        data: {
            labels: [{{$labels_string}}],
            datasets: [{
                label: '{{$title}}',
                data: [{{$data_string}}],
                borderWidth: 1,
                borderColor: 'rgba(255, 255, 255, 1)',
                backgroundColor: 'rgba(134, 23, 23, 1)'
            }]
        },
        options: {
            responsive: false,
            scales: {
                xAxes: [{
                    ticks: {
                        maxTicksLimit:7
                    },
                    position: "bottom",
                    scaleLabel: {
                        display: true,
                        labelString: "{{$xAxesLabel}}",
                    }, 
                }],
                yAxes: [{
                position: "left",
                    scaleLabel: {
                        display: true,
                        labelString: "{{$yAxesLabel}}",
                    },                    
                    ticks: {
                        beginAtZero:true,
                        userCallback: function(label, index, labels) {
                            // when the floored value is the same as the value we have a whole number
                            if (Math.floor(label) === label) {
                                return label;
                            }

                        },
                    }
                }]
            }
        }
    });

<?php 
}
?>

@endsection