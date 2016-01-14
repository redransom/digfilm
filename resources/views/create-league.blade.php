@extends('layouts.site')

@section('content')
<h2><span>Create Your League</span></h2>
<div class="content-padding">

    @if(isset($authUser))
    <div class="the-form" style="margin-top:40px;">
    {!! Form::open(array('route' => 'league-store', 'class'=>'form-vertical', 'id'=>'contactform', 'files'=>true)) !!}
        <p>Use the below form to enter the name of the league you wish to create and select the movies to be auctioned for.</p>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="source" value="P">
        <input type="hidden" name="users_id" value="{{$authUser->id}}">

        <p>
            <label for="LeagueName">League Name:</label>
            {!! Form::text('name', null, ['class'=>'span8', 'placeholder'=>'Enter league name here...']) !!}
        </p>
                    
        <p>
            <label for="LeagueDescription">League Slogan:</label>
            {!! Form::textarea('description', null, ['class'=>'span8', 'placeholder'=>'Enter slogan for your league.', 'rows'=>'2']) !!}
        </p>

        <p>
            <label for="LeagueAuctionStartDate">Start Date/Time:</label>
            {!! Form::text('auction_start_date', null, ['class'=>'span8', 'placeholder'=>'YYYY-MM-DD HH:II']) !!}
        </p>

        <p>
            <label for="LeagueFilename">Thumbnail:</label>
            {!! Form::file('file_name', null, ['class'=>'span8', 'placeholder'=>'Enter filename...']) !!}
        </p>

    </div>
    <div class="clear"></div>

    @foreach($rules as $rule)
    <!-- ************ - Small Package - ************** -->  
        <div class="small-package">
            <div class="head-title"><h3><span>{{$rule->name}}</span> Rules</h3></div>
            <div class="price">
                {{$rule->min_players}} to {{$rule->max_players}} players<br/>
                {{$rule->min_movies}} to {{$rule->max_movies}} movies
            </div><!--/ price-->
            <div class="content-price">
                <p>
                    {{$rule->description}}
                </p>
            </div><!--/ content-price-->
            <div class="foot-price">
                <input type="radio" name="rule_set" value="{{$rule->id}}"/>
                <a href="#" class="button medium yellow">Choose</a>  
            </div><!--/ foot-price-->
        </div><!--/ small-package-->

    @endforeach
    <p class="form-footer">
        <input type="submit" name="submit" id="submit" value="Next Step" />
    </p>
    </form>
    @else
    <p>You need to be logged in if you want create a league here for your friends to play in.</p>
    @endif

</div>

@endsection