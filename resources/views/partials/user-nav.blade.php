        <!-- ***************** - Main Navigation - ***************** -->
        <nav id="navigation" class="navigation">
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/about">About</a></li>
                <li><a href="/rules">How to play</a></li>
                <li><a href="/terms">Terms</a></li>
                <li><a href="/privacy">Privacy</a></li>
                <li><a href="/contact">Get in touch</a></li>
            </ul>

            <div class="account-wrapper">
                <ul id="user-account-nav">
                    @if(isset($authUser))
                    <li><a href="{{URL('auth/logout')}}">Logout</a></li>
                    <li><a href="/dashboard">My Dashboard</a></li>
                    <li><a href="/profile">My Profile</a></li>

                    @else
                    <li><a href="{{URL('auth/login')}}">Login</a></li>
                    <li><a href="/auth/register">Create an account</a></li>
                    @endif
                </ul><!--/ #user-account-nav-->
            </div><!--/ .account-wrapper-->
            
        </nav><!--/ #navigation-->
        <!-- ***************** - END Main Navigation - ******************* -->
