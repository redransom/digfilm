                    <ul class="load-responsive right" rel="Top menu">

        
                        <li><a href="/">Home</a></li>
                        <li><a href="/about">About</a></li>
                        <li><a href="/rules">How to play</a></li>
                        <li><a href="/terms">Terms</a></li>
                        <li><a href="/privacy">Privacy</a></li>
                        <li><a href="/contact">Contact</a></li>
                        <!--li><a href="#drop-the-bass">Read Later<small>2</small></a>
                            <div class="drop">
                                <div class="notify-header">Articles I should to read later</div>
                                <div class="nofify-empty">
                                    <i class="fa fa-folder-open-o"></i>
                                    <b>No articles here yet</b>
                                    <span>You can save articles to read them later</span>
                                </div>
                                <ol class="notify-list">
                                    <li>
                                        <a href="post.html" class="notify-content">
                                            <span class="article-thumb"><img src="images/photos/image-35.jpg" alt="" /></span>
                                            <span class="notify-head">
                                                <span class="notify-user"><b>Lorem Ipsum</b></span>
                                            </span>
                                            <span class="notify-text">Facete eruditi an vis, vel utamur aliquid partiendo ex</span>
                                            <span class="notify-date">11:22, Sep 11, 2012</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="post.html" class="notify-content">
                                            <span class="article-thumb"><img src="images/photos/image-36.jpg" alt="" /></span>
                                            <span class="notify-head">
                                                <span class="notify-user"><b>Lorem Ipsum 2</b></span>
                                            </span>
                                            <span class="notify-text">Te deserunt eleifend usu, patrioque eloquentiam qui in</span>
                                            <span class="notify-date">11:22, Sep 11, 2012</span>
                                        </a>
                                    </li>
                                </ol>
                                <div class="notify-footer"><a href="#clear-read-later">Clear this list</a></div>
                            </div>
                        </li-->
                        @if(isset($authUser))
                        <li><a href="/profile/{{$authUser->id}}"><span>{{$authUser->fullName()}}</span></a>
                            <ul class="sub-menu">
                                <li><a href="/dashboard">Dashboard</a></li>
                                <li><a href="/edit-profile">Profile</a></li>
                                <li><a href="{{URL('auth/logout')}}">Logout</a></li>

                                <!--li><a href="messages.html">Conversation list</a></li>
                                <li><a href="messages-conversation.html">Single conversation</a></li>
                                <li><a href="messages-write.html">Start new conversation</a></li-->
                            </ul>
                        </li>


                        @else
                        <li><a href="{{URL('auth/login')}}">Login</a></li>
                        <!--li><a href="/auth/register">Create an account</a></li-->
                        @endif
                    </ul>