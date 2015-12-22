@extends('layouts.users')

@section('content')
<section class="entry sbr clearfix">
    <div class="title-caption-large">
        <h3>Create Your League</h3>
    </div>

    @if(isset($authUser))
    {!! Form::open(array('route' => 'league-store', 'class'=>'form-horizontal row-fluid', 'id'=>'contactform', 'files'=>true)) !!}
    <p>Use the below form to enter the name of the league you wish to create and select the movies to be auctioned for.</p>
    <div id="contact">
        <div id="message"></div>
            <fieldset>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="source" value="P">
                <input type="hidden" name="users_id" value="{{$authUser->id}}">
                <div class="alignleft">
                    <div class="row">
                        <label for="name"><span class="required">*</span>League Name:</label>
                        {!! Form::text('name', null, ['class'=>'span8', 'placeholder'=>'Enter league name here...']) !!}
                    </div>
                    
                    <div class="row">
                        <label for="name"><span class="required">*</span>Start Date/Time:</label>
                        {!! Form::text('auction_start_date', null, ['class'=>'span8', 'placeholder'=>'YYYY-MM-DD HH:II']) !!}
                    </div>

                    <div class="row">
                        <label for="LeagueFilename">Thumbnail</label>
                        {!! Form::file('file_name', null, ['class'=>'span8', 'placeholder'=>'Enter filename...']) !!}
                    </div>
                </div>
            </fieldset>
    </div><!--/ contact-->
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
    <div class="clear"></div>
        <input type="submit" class="button green small" id="submit" value="Next Step" />
    
    </form>
    @else
    <p>You need to be logged in if you want create a league here for your friends to play in.</p>
    @endif

</section>

@endsection