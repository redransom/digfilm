        <!-- ***************** - Main Navigation - ***************** -->
        <nav id="navigation" class="navigation">
            
            <ul>
                <li><a href="about.html">Pages</a>
                    <ul class="sub-menu">
                    <li><a href="/">Home</a></li>
                        <li><a href="about.html">About</a></li>
                        <li><a href="#">Dropdown</a>
                            <ul>
                                <li><a href="#">Dropdown 1</a></li>
                                <li><a href="#">Dropdown 2</a></li>
                                <li><a href="#">Dropdown 3</a></li>
                            </ul>
                        </li>
                        <li><a href="404page.html">404 Page</a></li>
                    </ul><!--/ .sub-menu-->
                </li>
                <li><a href="headings.html">Features</a>
                    <ul class="sub-menu">
                        <li><a href="headings.html">Headings</a></li>
                        <li><a href="images-and-floats.html">Images and floats</a></li>
                        <li><a href="pricing-tables.html">Pricing Tables</a></li>
                        <li><a href="typography.html">Typography</a></li>
                        <li><a href="toggle.html">FAQ Toggle</a></li>
                        <li><a href="tables.html">Tables</a></li>
                        <li><a href="buttons.html">Buttons</a></li>
                        <li><a href="columns.html">Column Layout</a></li>
                        <li><a href="tabs.html">Tabs</a></li>
                    </ul><!--/ .sub-menu-->
                </li>
                <li><a href="gallery.html">Gallery</a></li>
                <li><a href="blog-style-1.html">Blog</a>
                    <ul class="sub-menu">
                        <li><a href="blog-style-1.html">Blog Page</a></li>
                        <li><a href="blog-style-2.html">Alternate Blog Page</a></li>
                        <li><a href="blog-single.html">Blog Single Page</a></li>
                    </ul><!--/ .sub-menu-->
                </li>
                <li><a href="contacts.html">Contacts</a></li>
            </ul>
            
            <div class="account-wrapper">
                <ul id="user-account-nav">
                    @if(isset($authUser))
                    <li><a href="{{URL('auth/logout')}}">Logout</a></li>
                    <li><a href="/profile">My Profile</a></li>

                    @else
                    <li><a href="{{URL('auth/login')}}">Login</a></li>
                    <li><a href="/auth/register">Create an account</a></li>
                    @endif
                </ul><!--/ #user-account-nav-->
            </div><!--/ .account-wrapper-->
            
        </nav><!--/ #navigation-->
        <!-- ***************** - END Main Navigation - ******************* -->
