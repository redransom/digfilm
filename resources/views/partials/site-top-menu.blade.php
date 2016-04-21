                    <ul class="load-responsive right" rel="Top menu">
                        @if(isset($authUser))
                        <li><a href="/dashboard"><span>Hi {{$authUser->forenames}}</span></a>
                            <ul class="sub-menu">
                                <li><a href="/dashboard">Dashboard</a></li>
                                <li><a href="/edit-profile">Profile</a></li>
                                <li><a href="{{URL('auth/logout')}}">Logout</a></li>
                            </ul>
                        </li>
                        @else
                        <li><a href="{{URL('auth/login')}}">Login</a></li>
                        @endif
        
                        <li><a href="/contact">Contact</a></li>
                        <li><a href="/privacy">Privacy</a></li>
                        <li><a href="/terms">Terms</a></li>
                        <li><a href="/about">About</a></li>
                        
                    </ul>