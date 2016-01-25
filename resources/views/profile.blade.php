@extends('layouts.site')

@section('content')
    
    <!-- BEGIN .user-profile -->
    <div class="user-profile">
        
        <div class="profile-shadow"></div>

        <!-- BEGIN .profile-left-side -->
        <div class="profile-left-side">

            <div class="the-profile-top">
                <div class="profile-user-name">
                    <h1>{{$authUser->name}}</h1>
                    <!--div class="sttaa"><span>Now:</span>Reading thread "<a href="forum-single.html">Wanna be millionaire ?</a>"</div-->
                </div>

                <div class="avatar online">
                    <div class="avatar-button"><a href="#"><i class="fa fa-camera-retro"></i>Change Photo</a></div>
                    @if(!is_null($authUser->thumbnail))
                    <img src="{{asset($authUser->thumbnail)}}" class="setborder" alt="" />
                    @else
                    <img src="{{asset('images/photos/avatar-13.jpg')}}" class="setborder" alt="" />
                    @endif
                </div>
                
                <div>
                    <!--<ul class="user-button-list">
                        <li><span class="info-msg">The one who digs a hole, has a shovel!</span></li>
                    </ul> -->

                    <div class="user-panel-about">
                        <div>
                            <b><i class="fa fa-male"></i>About me</b>
                            @if($authUser->description != "")
                            <p>{{$authUser->description}}</p>
                            @else
                            <p>Silence is golden...</p>
                            @endif
                        </div>

                        <!--div class="user-achievements">
                            <b><i class="fa fa-trophy"></i>My achievements</b>
                            <p>
                                <span class="ach strike-tooltip" title="Joined Revelio"><i class="fa fa-unlock-alt"></i></span>
                                <span class="ach strike-tooltip" title="Here from beginning"><i class="fa fa-bar-chart-o"></i></span>
                                <span class="ach strike-tooltip" title="Active on forums"><i class="fa fa-comments-o"></i></span>
                                <span class="ach strike-tooltip" title="Writes a lot"><i class="fa fa-keyboard-o"></i></span>
                                <span class="ach strike-tooltip" title="Admin aproved"><i class="fa fa-thumbs-up"></i></span>
                                <span class="ach strike-tooltip" title="Helps everyone"><i class="fa fa-medkit"></i></span>
                                <span class="ach strike-tooltip" title="Night owl"><i class="fa fa-moon-o"></i></span>
                                <span class="ach strike-tooltip" title="Comes and plays"><i class="fa fa-gamepad"></i></span>
                            </p>
                        </div-->
                    </div>

                    <ul class="user-button-list">
                        <!--li><a href="messages-write.html" class="defbutton profile-button"><i class="fa fa-comment"></i>Private message</a></li>
                        <li><a href="#" class="defbutton profile-button"><i class="fa fa-coffee"></i>Follow him</a></li-->
                        <li><a href="#" class="defbutton profile-button disabled"><i class="fa fa-wrench"></i>Change profile info</a></li>
                        <!--li><a href="#" class="defbutton profile-button disabled"><i class="fa fa-ban"></i>Ban this user</a></li-->
                    </ul>
                </div>
            </div>
            
            <!--div class="the-profile-navi">
                <ul class="profile-navi">
                    <li><a href="#top"><span class="left-avatar"><img src="images/photos/avatar-1.jpg" alt="" /></span>Viewing <b>Datcouch</b> profile<br />Back to top<span class="clear-float"></span></a></li>
                    <li class="active"><a href="user-single.html"><i class="fa fa-globe"></i>Profile information</a></li>
                    <li><a href="user-single-guestbook.html"><i class="fa fa-comment-o"></i>Guest book</a></li>
                    <li><a href="user-single-comments.html"><i class="fa fa-comment"></i>My comments</a></li>
                    <li><a href="user-single-blog.html"><i class="fa fa-book"></i>Personal blog</a></li>
                    <li><a href="user-single-music.html"><i class="fa fa-music"></i>Music playlist</a></li>
                    <li><a href="user-single-friends.html"><i class="fa fa-users"></i>Friends<span class="notif">10</span></a></li>
                    <li><a href="user-single-threads.html"><i class="fa fa-comments-o"></i>Forum topics<span class="notif">66</span></a></li>
                    <li><a href="user-single-instagram.html"><i class="fa fa-camera-retro"></i>Instagram photos</a></li>
                </ul>
                
                <div class="profile-panel instagram">
                    <div class="pieces">
                        <a href="https://instagram.com/marcisbee/" target="_blank"><img src="https://scontent-fra.cdninstagram.com/hphotos-xfp1/t51.2885-15/e15/10576140_778241095547266_331905980_n.jpg" alt="" /></a>
                        <a href="https://instagram.com/marcisbee/" target="_blank"><img src="https://scontent-fra.cdninstagram.com/hphotos-xpa1/outbound-distilleryimage1/t0.0-17/OBPTH/427393eef7af11e2b65722000a9e00be_7.jpg" alt="" /></a>
                        <a href="https://instagram.com/marcisbee/" target="_blank"><img src="https://scontent-fra.cdninstagram.com/hphotos-xpa1/outbound-distilleryimage5/t0.0-17/OBPTH/3259ed5670c711e2a9dd22000a9e29a7_7.jpg" alt="" /></a>
                    </div>
                    <div class="clear-float"></div>
                </div>
            </div-->

        <!-- END .profile-left-side -->
        </div>

        <!-- BEGIN .profile-right-side -->
        <div class="profile-right-side">

            <h2><span>Profile Summary</span></h2>
            <!-- BEGIN .content-padding -->
            <div class="content-padding">

                <!-- BEGIN .info-blocks -->
                <div class="info-blocks">
                    <ul>
                        <li><a href="#" class="info-block"><b>1.2k</b><span>Friends</span></a></li>
                        <li><a href="#" class="info-block"><b>29</b><span>Articles</span></a></li>
                        <li><a href="#" class="info-block"><b>300</b><span>Forum posts</span></a></li>
                        <li><a href="#" class="info-block"><b>23</b><span>Games</span></a></li>
                        <li><a href="#" class="info-block"><b>40</b><span>Photos</span></a></li>
                        <li><span class="info-block"><b>777</b><span>Rating</span></span></li>
                    </ul>
                    <div class="clear-float"></div>
                <!-- END .info-blocks -->
                </div>
                
                <div>
                    <div style="width:350px;" class="left">
                        <h2 style="margin-left:-30px;"><span>Profile Information</span></h2>
                        
                        <ul class="profile-info">
                            <li>
                                <span class="first">Name, Surname:</span>
                                <span class="last">John Doe</span>
                            </li>
                            <li>
                                <span class="first">Gender:</span>
                                <span class="last">Male</span>
                            </li>
                            <li>
                                <span class="first">Birthday:</span>
                                <span class="last">11.September, 1992</span>
                            </li>
                            <li>
                                <span class="first">Location:</span>
                                <span class="last">United Kingdom, London</span>
                            </li>
                            <li>
                                <span class="first">Signed up:</span>
                                <span class="last">4 years ago</span>
                            </li>
                        </ul>

                        <div class="clear-float"></div>
                    </div>

                    <div style="width:300px;" class="right">
                        
                        <h2 style="margin-left: -30px;"><span>Friends (202)</span></h2>
                        
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
                        </ul>
                        <div class="clear-float"></div>

                        <a href="user-single-friends.html" class="defbutton"><i class="fa fa-users"></i>View all 202 friends</a>
                        
                    </div>

                    <div class="clear-float"></div>
                </div>
                
                <div class="photo-blocks">
                    <ul>
                        <li><a href="user-single-instagram-single.html" class="article-image-out"><span class="image-comments"><span>101</span></span><span class="article-image"><img src="http://distilleryimage10.s3.amazonaws.com/e7b6a2329d6f11e2be5722000a9f15cb_6.jpg" width="128" height="128" alt="" title="" /></span></a></li>
                        <li><a href="user-single-instagram-single.html" class="article-image-out"><span class="image-comments inactive"><span>23</span></span><span class="article-image"><img src="http://distilleryimage6.s3.amazonaws.com/74cada18729f11e2beb322000aaa0754_6.jpg" width="128" height="128" alt="" title="" /></span></a></li>
                        <li><a href="user-single-instagram-single.html" class="article-image-out"><span class="image-comments"><span>6</span></span><span class="article-image"><img src="http://distilleryimage5.s3.amazonaws.com/948b75cc967311e29b3722000a1fa50e_6.jpg" width="128" height="128" alt="" title="" /></span></a></li>
                        <li><a href="user-single-instagram-single.html" class="article-image-out"><span class="image-comments"><span>12</span></span><span class="article-image"><img src="http://distilleryimage11.s3.amazonaws.com/b62786f06ccd11e28a5622000a1fbe35_6.jpg" width="128" height="128" alt="" title="" /></span></a></li>
                        <li><a href="user-single-instagram-single.html" class="article-image-out"><span class="image-comments inactive"><span>0</span></span><span class="article-image"><img src="http://distilleryimage8.s3.amazonaws.com/5e7dfe7270b811e286b422000a9d0dd8_6.jpg" width="128" height="128" alt="" title="" /></span></a></li>
                    </ul>
                    <div class="clear-float"></div>
                </div>
                
                <div>
                    <center>
                        <a href="user-single-instagram.html" class="defbutton"><i class="fa fa-camera-retro"></i>View all instagram photos</a>
                    </center>
                </div>
                
                <!-- BEGIN .music-blocks -->
                <div class="music-blocks">
                    <ul>
                        <li>
                            <ol>
                                <li><a href="user-single-music-single.html"><span class="music-img"><img src="http://i4.ytimg.com/vi/AHitulGaS9k/default.jpg" alt=""></span><b>Jonas Brothers</b><span>Pom Poms</span><span class="clear-float"></span></a></li>
                                <li><a href="user-single-music-single.html"><span class="music-img"><img src="http://i4.ytimg.com/vi/vIAQuDkhXpQ/default.jpg" alt=""></span><b>Feint</b><span>Snake Eyes (Feat. CoMa)</span><span class="clear-float"></span></a></li>
                                <li><a href="user-single-music-single.html"><span class="music-img"><img src="http://i4.ytimg.com/vi/rNpBahr49mA/default.jpg" alt=""></span><b>Ellie Goulding</b><span>Figure 8</span><span class="clear-float"></span></a></li>
                            </ol>
                        </li>
                        <li>
                            <ol>
                                <li><a href="user-single-music-single.html"><span class="music-img"><img src="http://i4.ytimg.com/vi/4Xk_pViVP_k/default.jpg" alt=""></span><b>Foster The People</b><span>Don't Stop (TheFatRat Remix)</span><span class="clear-float"></span></a></li>
                                <li><a href="user-single-music-single.html"><span class="music-img"><img src="http://i4.ytimg.com/vi/qizlN1Ow1Fc/default.jpg" alt=""></span><b>JIKES &amp; Greg Cooke</b><span>Its Amazing</span><span class="clear-float"></span></a></li>
                                <li><a href="user-single-music-single.html"><span class="music-img"><img src="http://i4.ytimg.com/vi/FU4cnelEdi4/default.jpg" alt=""></span><b>Netsky</b><span>Puppy</span><span class="clear-float"></span></a></li>
                            </ol>
                        </li>
                    </ul>
                    <div class="clear-float"></div>
                <!-- END .music-blocks -->
                </div>
                
                <div>
                    <center>
                        <a href="user-single-music.html" class="defbutton"><i class="fa fa-music"></i>View all songs</a>
                    </center>
                </div>
                
            <!-- END .content-padding -->
            </div>


            <h2><span>Guest Book</span></h2>
            <!-- BEGIN .content-padding -->
            <div class="content-padding">
                
                <div class="comment-part">

                    <!-- BEGIN #comments -->
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
                    <!-- #comment-## -->
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
                        </div><!-- #respond -->
                    </div>
    
                </div>

            <!-- END .content-padding -->
            </div>

        <!-- END .profile-right-side -->
        </div>

        <div class="clear-float"></div>

    <!-- END .user-profile -->
    </div>


@endsection