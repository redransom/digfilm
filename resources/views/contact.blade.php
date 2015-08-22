@extends('layouts.users')

@section('content')
<div class="title-caption-large">
    <h3>Contacts</h3>
</div><!--/ .title-caption-large-->

<div class="contacts-wrapper">
    <p>
        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt 
        ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco 
        laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur 
        adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim 
        ad minim veniam, quis commodo consequat.
    </p>
    
    <section class="contact-address clearfix">
        <div class="one-fourth">
            <strong>Address Info 1:</strong> <br />
            <span>123 Main Street Los Angeles, CA, 94101</span> <br />
            <strong>Phone:</strong> 
            <span> +1 800 123 4567</span> <br />
            <strong>FAX:</strong> 
            <span> +1 800 891 2345</span> <br />
            <strong>Email:</strong>
            <a href="#">testmail@sitename.com</a>   
        </div>
        <div class="one-fourth last">
            <strong>Address Info 1:</strong> <br />
            <span>123 Main Street Los Angeles, CA, 94101</span> <br />
            <strong>Phone:</strong> 
            <span> +1 800 123 4567</span> <br />
            <strong>FAX:</strong> 
            <span> +1 800 891 2345</span> <br />
            <strong>Email:</strong>
            <a href="#">testmail@sitename.com</a>   
        </div>
    </section>
    
    <div class="sep"></div>

    <h5>Leave a Reply</h5>

    <div id="contact">
        <div id="message"></div>
        <form method="post" action="contact.php" id="contactform">
            <fieldset>
                <div class="alignleft">
                    <div class="row">
                        <label for="name"><span class="required">*</span>Your Name:</label>
                        <input type="text" name="name" id="name" />
                    </div><!--/ row-->
                    <div class="row">
                        <label for="email"><span class="required">*</span>E-mail:</label>
                        <input type="text" name="email" id="email" />
                    </div><!--/ row-->
                    <div class="row">
                        <label for="phone">Phone:</label>
                        <input type="text" name="phone" id="phone" />
                    </div><!--/ row-->
                    <div class="row">
                        <label for="subject">Subject</label>
                        <select name="subject" id="subject">
                            <option value="Support">Support</option>
                            <option value="a Sale">Sales</option>
                            <option value="a Bug fix">Report a bug</option>
                        </select>
                    </div><!--/ row-->
                    <div class="row">
                        <img src="image.php" alt="" style="vertical-align: middle;" /><input name="verify" type="text" id="verify" size="6" value="" style="width: 50px; margin: 0 0 0 8px; vertical-align: middle;" />
                    </div><!--/ row-->
                    <input type="submit" class="button green small" id="submit" value="Submit" />
                </div><!--/ textfield-->
                <div class="alignright">
                    <label for="comments">Message:</label>
                    <textarea name="comments" id="comments" cols="30" rows="10"></textarea>
                </div><!--/ areafield-->
            </fieldset>
        </form>
    </div><!--/ contact-->
    
</div><!--/ .contacts-wrapper-->
@endsection