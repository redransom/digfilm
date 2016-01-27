@extends('layouts.site')

@section('content')
<style>
/* Man content & sidebar top lne, default #256193 */
            #sidebar .panel,
            #main-box #main {
                border-top: 5px solid #256193;
            }

            /* Slider colors, default #256193 */
            a.featured-select,
            #slider-info .padding-box ul li:before,
            .home-article.right ul li a:hover {
                background-color: #256193;
            }

            /* Button color, default #256193 */
            .panel-duel-voting .panel-duel-vote a {
                background-color: #256193;
            }

            /* Menu background color, default #000 */
            #menu-bottom.blurred #menu > .blur-before:after {
                background-color: #000;
            }

            /* Top menu background, default #0D0D0D */
            #header-top {
                background: #0D0D0D;
            }

            /* Sidebar panel titles color, default #333333 */
            #sidebar .panel > h2 {
                color: #333333;
            }

            /* Main titles color, default #353535 */
            #main h2 span {
                color: #353535;
            }

            /* Selection color, default #256193 */
            ::selection {
                background: #256193;
            }

            /* Links hover color, default #256193 */
            .article-icons a:hover,
            a:hover {
                color: #256193;
            }

            /* Image hover background, default #256193 */
            .article-image-out,
            .article-image {
                background: #256193;
            }

            /* Image hover icons color, default #256193 */
            span.article-image span .fa {
                color: #256193;
            }

</style>
<div id="main" itemscope="" itemtype="http://data-vocabulary.org/Review">
    <div class="game-info-left">
        @if($movie->firstImage())
        <img itemprop="image" src="{{ asset($movie->firstImage()->file_name) }}" class="game-poster" alt="" />
        @else
        <img itemprop="image" src="{{ asset('images/posters/2351232-tomb_raider.jpg') }}" class="game-poster" alt="" />
        @endif
        <div class="game-info-details">
            <!--div class="game-info-buttons">
                <a href="#" class="defbutton green"><i class="fa fa-bell"></i>Follow Film</a>
                <a href="games-single-video-single.html" class="defbutton"><i class="fa fa-film"></i>View Trailer</a>
            </div-->
            <div class="game-info-rating">
                <h3>TheNextBigFilm Review</h3>
                <hr />
                <strong itemprop="rating">{{$movie->rating}}</strong>
                <div class="rating-stars">
                    <div class="rating-stars-inner" style="width: 90%;"></div>
                </div>
                <!--a href="post.html" class="defbutton"><i class="fa fa-file-text-o"></i>Read Review</a-->
            </div>
            <!--div class="game-info-buttons">
                <a href="games-single-shop.html" class="defbutton"><i class="fa fa-shopping-cart"></i>Buy game starting from <span class="pricetag">55 &euro;</span></a>
                <a href="#" class="defbutton"><i class="fa fa-gamepad"></i>I have played</a>
            </div-->
            <div class="game-info-graph">
                <div>
                    <span>Release Date</span>
                    <strong itemprop="datePublished" content="2013-03-05">{{date("l, jS F Y", strtotime($movie->release_at))}}</strong>
                </div>
                <div>
                    <span>Genre</span>
                    <strong itemprop="applicationCategory"><a href="games.html">{{$movie->genre->name}}</a></strong>
                </div>
                <meta itemprop="reviewer" content="Datcouch.com">
            </div>
            <!--div class="pegi">
                <img src="images/pegi/pegi-18.gif" class="pegi-age left strike-tooltip" title="Recomended 18+" alt="" />
                <div class="pegi-desc">
                    <img src="images/pegi/bad-language.gif" class="pegi-tool strike-tooltip" title="Bad language" alt="" />
                    <img src="images/pegi/discrimination.gif" class="pegi-tool pegi-disabled" alt="" />
                    <img src="images/pegi/drugs.gif" class="pegi-tool pegi-disabled" alt="" />
                    <img src="images/pegi/fear.gif" class="pegi-tool pegi-disabled" alt="" />
                    <img src="images/pegi/gambling.gif" class="pegi-tool pegi-disabled" alt="" />
                    <img src="images/pegi/online.gif" class="pegi-tool strike-tooltip" title="Multiplater" alt="" />
                    <img src="images/pegi/sex.gif" class="pegi-tool pegi-disabled" alt="" />
                    <img src="images/pegi/violence.gif" class="pegi-tool strike-tooltip" title="Violence" alt="" />
                </div>
                <div class="clear-float"></div>
            </div-->
        </div>
    </div>
    <div class="game-info-right">

        <!-- BEGIN .game-menu -->
        <div class="game-menu" style="border-bottom: 5px solid #921913;">
            <div class="game-overlay-info">
                <h1 itemprop="itemreviewed">{{$movie->name}}</h1>
                <!--span>
                    <a href="games.html">PlayStation 2</a>
                    <a href="games.html">PlayStation 3</a>
                    <a href="games.html">PlayStation 4</a>
                    <a href="games.html">Xbox</a>
                    <a href="games.html">Xbox 360</a>
                    <a href="games.html">Xbox One</a>
                    <a href="games.html">Nintendo Wii</a>
                </span-->
            </div>
            <ul>
                <li class="active" style="background-color: #921913;"><a href="games-single.html"><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;Information</a></li>
                <!--li><a href="games-single-news.html"><i class="fa fa-comments"></i>&nbsp;&nbsp;News</a></li-->
                <!--li><a href="games-single-video.html"><i class="fa fa-film"></i>&nbsp;&nbsp;Video (3)</a></li>
                <li><a href="photo-gallery-single.html"><i class="fa fa-camera-retro"></i>&nbsp;&nbsp;Photos (18)</a></li-->
            </ul>
        <!-- END .game-menu -->
        </div>

        <h2><span>Synopsis</span></h2>        
        <div class="content-padding">
        {{$movie->summary}}

        </div>
        <h2><span>Media</span></h2>
        <div class="content-padding">
            <!-- BEGIN .photo-blocks -->
            <div class="photo-blocks">
                <ul>
                    <li><a href="photo-gallery-single.html" class="article-image-out"><span class="image-comments"><span>101</span></span><span class="article-image"><img src="{{asset('images/photos/image-41.jpg') }}" width="128" height="128" alt="" title="" /></span></a></li>
                    <li><a href="photo-gallery-single.html" class="article-image-out"><span class="image-comments inactive"><span>23</span></span><span class="article-image"><img src="{{asset('images/photos/image-42.jpg') }}" width="128" height="128" alt="" title="" /></span></a></li>
                    <li><a href="photo-gallery-single.html" class="article-image-out"><span class="image-comments"><span>6</span></span><span class="article-image"><img src="{{asset('images/photos/image-43.jpg') }}" width="128" height="128" alt="" title="" /></span></a></li>
                    <li><a href="photo-gallery-single.html" class="article-image-out"><span class="image-comments"><span>12</span></span><span class="article-image"><img src="{{asset('images/photos/image-44.jpg') }}" width="128" height="128" alt="" title="" /></span></a></li>
                    <li><a href="photo-gallery-single.html" class="article-image-out"><span class="image-comments inactive"><span>0</span></span><span class="article-image"><img src="{{asset('images/photos/image-45.jpg') }}" width="128" height="128" alt="" title="" /></span></a></li>
                </ul>
                <div class="clear-float"></div>
            <!-- END .photo-blocks -->
            </div>
        </div>
            @if($movie->bids()->count() > 0 && isset($authUser))

        <h2><span>Stats</span></h2>
        <div class="content-padding">
                <canvas id="myLineChart" width="400" height="400"></canvas>
                <script src="{{ asset('jscript/Chart.min.js') }}"></script>

                <script type="text/javascript">
                    var ctx = document.getElementById("myLineChart").getContext("2d"),
                        data = {
                            labels: ["January", "February", "March", "April", "May", "June", "July"],
                            datasets: [
                                {
                                    label: "My First dataset",
                                    fillColor: "rgba(220,220,220,0.2)",
                                    strokeColor: "rgba(220,220,220,1)",
                                    pointColor: "rgba(220,220,220,1)",
                                    pointStrokeColor: "#fff",
                                    pointHighlightFill: "#fff",
                                    pointHighlightStroke: "rgba(220,220,220,1)",
                                    data: [65, 59, 80, 81, 56, 55, 40]
                                }
                            ]
                        },
                        options = {

                            ///Boolean - Whether grid lines are shown across the chart
                            scaleShowGridLines : true,

                            //String - Colour of the grid lines
                            scaleGridLineColor : "rgba(0,0,0,.05)",

                            //Number - Width of the grid lines
                            scaleGridLineWidth : 1,

                            //Boolean - Whether to show horizontal lines (except X axis)
                            scaleShowHorizontalLines: true,

                            //Boolean - Whether to show vertical lines (except Y axis)
                            scaleShowVerticalLines: true,

                            //Boolean - Whether the line is curved between points
                            bezierCurve : true,

                            //Number - Tension of the bezier curve between points
                            bezierCurveTension : 0.4,

                            //Boolean - Whether to show a dot for each point
                            pointDot : true,

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
                            legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].strokeColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"

                        };

                    var myLineChart = new Chart(ctx).Line(data, options);


                </script>
              
        </div>
        @endif

        <!--h2><span>Follows this game (202)</span></h2>
        <div class="content-padding">
            <ul class="profile-friends-list">
                <li>
                    <a href="user-single.html" class="avatar online user-tooltip">
                        <img src="images/photos/avatar-1.jpg" class="setborder" title="" alt="" />
                    </a>
                </li>
                <li>
                    <a href="user-single.html" class="avatar online user-tooltip">
                        <img src="images/photos/avatar-2.jpg" class="setborder" title="" alt="" />
                    </a>
                </li>
                <li>
                    <a href="user-single.html" class="avatar away user-tooltip">
                        <img src="images/photos/avatar-4.jpg" class="setborder" title="" alt="" />
                    </a>
                </li>
                <li>
                    <a href="user-single.html" class="avatar ingame user-tooltip">
                        <img src="images/photos/avatar-5.jpg" class="setborder" title="" alt="" />
                    </a>
                </li>
                <li>
                    <a href="user-single.html" class="avatar offline user-tooltip">
                        <img src="images/photos/avatar-6.jpg" class="setborder" title="" alt="" />
                    </a>
                </li>
                <li>
                    <a href="user-single.html" class="avatar offline user-tooltip">
                        <img src="images/photos/avatar-7.jpg" class="setborder" title="" alt="" />
                    </a>
                </li>
                <li>
                    <a href="user-single.html" class="avatar offline user-tooltip">
                        <img src="images/photos/avatar-14.jpg" class="setborder" title="" alt="" />
                    </a>
                </li>
                <li>
                    <a href="user-single.html" class="avatar offline user-tooltip">
                        <img src="images/photos/avatar-15.jpg" class="setborder" title="" alt="" />
                    </a>
                </li>
                <li>
                    <a href="user-single.html" class="avatar offline user-tooltip">
                        <img src="images/photos/avatar-16.jpg" class="setborder" title="" alt="" />
                    </a>
                </li>
                <li>
                    <a href="user-single.html" class="avatar offline user-tooltip">
                        <img src="images/photos/avatar-17.jpg" class="setborder" title="" alt="" />
                    </a>
                </li>
                <li>
                    <a href="user-single.html" class="avatar offline user-tooltip">
                        <img src="images/photos/avatar-18.jpg" class="setborder" title="" alt="" />
                    </a>
                </li>
                <li>
                    <a href="user-single.html" class="avatar offline user-tooltip">
                        <img src="images/photos/avatar-19.jpg" class="setborder" title="" alt="" />
                    </a>
                </li>
                <li>
                    <a href="#" class="users-more">+160</a>
                </li>
            </ul>
            <div class="clear-float"></div>
        </div-->

        <!--h2><span>Comments (3)</span></h2-->
        <!-- BEGIN .content-padding -->
        <!--div class="content-padding">
            
            <div class="comment-part">

                <ol id="comments">
                    <li>
                        <div class="comment-inner">
                            <div class="comment-avatar">
                                <img src="http://1.gravatar.com/avatar/b1c65c520efb9520269584aae4323fae?s=73&amp;d=http%3A%2F%2F1.gravatar.com%2Favatar%2Fad516503a11cd5ca435acc9bb6523536%3Fs%3D73&amp;r=G" alt="DatCouch">
                            </div>
                            <div class="comment-content">
                                <div class="comment-header">
                                    <h3><a href="#">DatCouch</a></h3>
                                </div>
                                <p>Lorem ipsum dolor sit amet, ea rebum aeterno qui, cum tale dicta nihil id. Ex eam simul altera. Te sea labores persequeris. An suscipit menandri vel, est error nullam dictas ne. Debet instructior ea pri, vis singulis antiopam consulatu ex.</p>
                                <a class="comment-reply-link post-a" href="#"><i class="fa fa-comment"></i><strong>Reply</strong></a>
                                <span class="post-a"><i class="fa fa-calendar-o"></i> May 2, 2014</span>
                            </div>
                        </div>
                        <ul>
                            <li>
                                <div class="comment-inner">
                                    <div class="comment-avatar">
                                        <img src="http://1.gravatar.com/avatar/b1c65c520efb9520269584aae4323fae?s=73&amp;d=http%3A%2F%2F1.gravatar.com%2Favatar%2Fad516503a11cd5ca435acc9bb6523536%3Fs%3D73&amp;r=G" alt="DatCouch">
                                    </div>
                                    <div class="comment-content">
                                        <div class="comment-header">
                                            <h3><a href="#">DatCouch</a></h3>
                                        </div>
                                        <p>Lorem ipsum dolor sit amet, ea rebum aeterno qui, cum tale dicta nihil id. Ex eam simul altera. Te sea labores persequeris. An suscipit menandri vel, est error nullam dictas ne. Debet instructior ea pri, vis singulis antiopam consulatu ex.</p>
                                        <a class="comment-reply-link post-a" href="#"><i class="fa fa-comment"></i><strong>Reply</strong></a>
                                        <span class="post-a"><i class="fa fa-calendar-o"></i> May 2, 2014</span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <div class="comment-inner">
                            <div class="comment-avatar">
                                <img src="http://1.gravatar.com/avatar/b1c65c520efb9520269584aae4323fae?s=73&amp;d=http%3A%2F%2F1.gravatar.com%2Favatar%2Fad516503a11cd5ca435acc9bb6523536%3Fs%3D73&amp;r=G" alt="DatCouch">
                            </div>
                            <div class="comment-content">
                                <div class="comment-header">
                                    <h3><a href="#">DatCouch</a></h3>
                                </div>
                                <p>Lorem ipsum dolor sit amet, ea rebum aeterno qui, cum tale dicta nihil id. Ex eam simul altera. Te sea labores persequeris. An suscipit menandri vel, est error nullam dictas ne. Debet instructior ea pri, vis singulis antiopam consulatu ex.</p>
                                <a class="comment-reply-link post-a" href="#"><i class="fa fa-comment"></i><strong>Reply</strong></a>
                                <span class="post-a"><i class="fa fa-calendar-o"></i> May 2, 2014</span>
                            </div>
                        </div>
                    </li>
                </ol>
                <div class="comments-pager"></div>

                <div class="comment-form">
                    <a href="#" name="respond"></a>
                    <div id="respond" class="comment-respond">
                        <h3 id="reply-title" class="comment-reply-title"> <small><a rel="nofollow" id="cancel-comment-reply-link" href="/integer-nam-varius/#respond" style="display:none;">Cancel reply</a></small></h3>
                        <form action="http://chronicles.datcouch.com/wp-comments-post.php" method="post" id="commentform" class="comment-form">
                            <p class="comment-notes">Your email address will not be published. Required fields are marked <span class="required">*</span></p>                           
                            <p class="form-name">
                                <label for="author">Name:<span class="required">*</span></label>
                                <input id="author" name="author" type="text" value="" size="30" aria-required="true" placeholder="Name">
                            </p>

                            <p class="form-email">
                                <label for="email">Email:<span class="required">*</span></label>
                                <input id="email" name="email" type="text" value="" size="30" aria-required="true" placeholder="Email">
                            </p>

                            <p class="form-website">
                                <label for="website">Website:</label>
                                <input id="website" name="url" type="text" value="" size="30" aria-required="true" placeholder="Website">
                            </p>
                            <p class="form-comment">
                                <label for="comment">Comment:<span class="required">*</span></label>
                                <textarea id="comment" name="comment" type="text" aria-required="true" placeholder="Comment Text"></textarea>
                            </p>
                            <p class="form-submit">
                                <input name="submit" type="submit" id="submit" value="Post Comment" class="button">
                                <input type="hidden" name="comment_post_ID" value="324" id="comment_post_ID" class="button">
                                <input type="hidden" name="comment_parent" id="comment_parent" value="0" class="button">
                            </p>
                        </form>
                    </div>
                </div>

            </div-->

        <!-- END .content-padding -->
        </div>

    </div>

    <div class="clear-float"></div>
    
</div>

<div class="clear-float"></div>
@endsection