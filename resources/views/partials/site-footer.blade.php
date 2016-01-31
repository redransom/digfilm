<div class="wrapper">
            <!-- BEGIN .footer -->
            <div class="footer">

                <div class="footer-top"></div>
                
                <div class="footer-content">

                    @include('partials.site-footer-articles')                
                        
                    <!-- BEGIN .panel -->
                    <div class="panel">
                        <h2>Contact Information</h2>
                        <div class="panel-content">
                            
                            <div>
                                <h4>What do we stand for ?</h4>
                                <p>TODO: Byron - we need some content for this!</p>

                                <a href="mailto:contact@thenextbigfilm.com" class="icon-line">
                                    <i class="fa fa-comment"></i><span>contact@thenextbigfilm.com</span>
                                </a>
            
                                <span class="icon-line">
                                    <i class="fa fa-map-marker"></i><span>Yorkshire, England</span>
                                </span>
            
                            </div>
                            
                        </div>
                    <!-- END .panel -->
                    </div>
                    
                    @include('partials.site-footer-genres')

                </div>

                <div class="footer-bottom">
                    <div class="left">&copy; Copyright <?php echo date("Y"); ?> <strong>TheNextBigFilm</strong> designed by <strong>redransom.co.uk</strong></div>
                    <div class="right">
                        <ul>
                            <li><a href="/">Homepage</a></li>
                            <li><a href="/news">News</a></li>
                            <li><a href="/rules">Rules</a></li>
                            <li><a href="/about">About</a></li>
                        </ul>
                    </div>
                    <div class="clear-float"></div>
                </div>
                
            <!-- END .footer -->
            </div>
        </div>   