@extends('layouts.site')

@section('content')
<div class="signup-panel">

    <div class="left">
        <h2><span>Get In Touch</span></h2>
        <div class="content-padding">

            <p class="p-padding">Would you like to tell us something?</p>
            @if (count($errors) > 0)
            <p>
                @foreach ($errors->all() as $error)
                    <span class="the-error-msg">{{ $error }}</span>
                @endforeach
            </p>
            @endif
            <div class="the-form" style="margin-top:10px;">
                <form method="post" action="{{route('contact')}}" id="contactform" class="form-vertical">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <p>
                        <label for="name"><span class="required">*</span>Your Name:</label>
                        <input type="text" name="name" id="name" />
                    </p>
                    <p>
                        <label for="email"><span class="required">*</span>E-mail:</label>
                        <input type="text" name="email" id="email" />
                    </p>
                    <p>
                        <label for="reason">Reason</label>
                        <select name="reason" id="reason">
                            <option value="Gamplay">Gameplay & Rules</option>
                            <option value="Problems">Technical Problems</option>
                            <option value="Suggestions">Suggestions & Ideas</option>
                            <option value="Investors">Investors</option>
                            <option value="Advertisement">Advertisement</option>
                            <option value="Account">Account Issues</option>
                        </select>
                    </p>
                    <p>
                        <label for="message">Message</label>
                        <textarea name="message" id="message" cols="30" rows="10"></textarea>
                    </p>
                    <p class="form-footer">
                        <input type="submit" class="button green small" id="submit1" value="Submit" />
                    </p>
                </form>
            </div>
        </div>
    </div>

    <div class="right">
        @if(isset($content))
        <h2><span>{{$content->title}}</span></h2>
        <div class="content-padding">
        {!! $content->body !!}
        </div>
        @endif
    </div>


@endsection