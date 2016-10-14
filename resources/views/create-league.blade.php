@extends('layouts.site')

@section('content')
<h2><span>Create Your League</span></h2>

<div class="content-padding">
    <p>Use the below form to enter the name of the league you wish to create and select the movies to be auctioned for.</p>
    @if(isset($authUser))
    <div class="the-form league--form">
    {!! Form::open(array('route' => 'league-store', 'class'=>'form-vertical', 'id'=>'contactform', 'files'=>true)) !!}
        <div class="divider--img"></div>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="source" value="P">
        <input type="hidden" name="users_id" value="{{$authUser->id}}">

        <div class="form--item">
            <label for="LeagueName">League Name:</label>
            {!! Form::text('name', null, ['class'=>'span8', 'placeholder'=>'Enter league name here...']) !!}
        </div>
                    
        <div class="form--item">
            <label for="LeagueDescription">League Slogan:</label>
            {!! Form::textarea('description', null, ['class'=>'span8', 'placeholder'=>'Enter slogan for your league.', 'rows'=>'2']) !!}
        </div>

        <script>
        $(function() {
            $('#datepicker').datepicker( "option", "dateFormat", "yy-mm-dd");
        });
        </script>

       <div class="form--item">
            <label for="LeagueAuctionStartDate">Start Date/Time:</label>
            {!! Form::text('auction_start_date', null, ['class'=>'span8', 'id'=>'datepicker', 'placeholder'=>'YYYY-MM-DD HH:II']) !!}
       </div>

        <div class="form--item">
            <label>League Profile Pic:</label>
            <style>
                input.leagueProfile {padding-right:25px !important}
            </style>
            {!! Form::file('file_name', ['class'=>'leagueProfile']) !!}
            <p style="float: right; clear: both; padding-top: 5px; width: 62% !important; margin-right: 10px"><strong>NOTE</strong> Best image size 115px (width) by 166px (height).</p>
       </div>

    </div>
    <div class="clear"></div>

    @if($rules->count() == 1)
    <input type="hidden" name="rule_sets_id" value="{{$rules[0]->id}}" />

    @else

    <h3>Available Rules</h3>
    <p>Please choose a rule set to use for your league. For further information please review the rules <a href="rules">section</a>.</p>
    <div  style="float: right; clear: both; padding-top: 5px; width: 64% !important;">
    @foreach($rules as $rule)
    <!-- ************ - Small Package - ************** -->  
        <div class="small-package">
            <div class="head-title"><h3><span>{{$rule->name}}</span></h3></div>
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
                <input type="radio" name="rule_sets_id" value="{{$rule->id}}" 
                @if($default_rule == $rule->id)
                checked="checked"
                @endif
                />
            </div><!--/ foot-price-->
        </div><!--/ small-package-->

    @endforeach
    </div>
    @endif
    <div class="form-footer">
         <div class="divider--img"></div>
        <input type="submit" name="submit" class="submit-btn btn-small" id="submit" value="Next Step" />
    </div>
    </form>
    @else
    <p>You need to be logged in if you want create a league here for your friends to play in.</p>
    @endif

</div>

@endsection