@extends('layouts.users')

@section('content')
<section class="entry sbr clearfix">
    <div class="title-caption-large">
        <h3>Choose who you want to play!</h3>
    </div>

    <p>You can select any players from your friends list or invite players to join.</p>

    <div class="one-fourth">  
        <h4>Choose Friends</h4>  
        @if($users->count()>0)
        <div id="contact">
            {!! Form::open(array('route' => 'choose-participants', 'class'=>'form-horizontal row-fluid', 'id'=>'contactform')) !!}
                <p>You can choose <strong>{{$league->rule->max_players - $league->players->count()}}</strong> more players.</p>
                <fieldset>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="leagues_id" value="{{$league->id}}">
                    <div class="alignleft">
                        <ul>
                        @foreach($users as $user)
                            <li>{!! Form::checkbox('users_id[]', $user->id, false) !!}&nbsp;&nbsp;{{$user->fullName()}}</li>
                        @endforeach
                        </ul>
                        <br/>
                        <input type="submit" class="button green small" id="submit" value="Add Friends" />
                    </div><!--/ textfield-->
                </fieldset>
            </form>
        </div><!--/ contact-->
        @else
        <p>Sorry, you have no friends currently.</p>
        @endif

    </div>
    <div class="one-fourth">
        <h4>Invite Friend</h4>
        <div id="contact">
            <div id="message"></div>
            {!! Form::open(array('route' => 'league-invite', 'class'=>'form-horizontal row-fluid', 'id'=>'contactform')) !!}
                <fieldset>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="leagues_id" value="{{$league->id}}">
                    <div class="alignleft">
                        @for($player_cnt = 1; $player_cnt <= ($league->rule->max_players - $league->players->count()); $player_cnt++)
                        <h3>Friend  {{$player_cnt}}</h3>
                        <div class="row">
                            <label for="name"><span class="required">*</span>Name:</label>
                            {!! Form::text('name[]', null, ['class'=>'span8', 'placeholder'=>'Enter friends name here...']) !!}
                        </div><!--/ row-->
                        
                        <div class="row">
                            <label for="name"><span class="required">*</span>Email:</label>
                            {!! Form::text('email_address[]', null, ['class'=>'span8', 'placeholder'=>'Enter email address here...']) !!}
                        </div><!--/ row-->
                        @endfor
                        <input type="submit" class="button green small" id="submit" value="Invite" />
                    </div><!--/ textfield-->
                </fieldset>
            </form>
        </div><!--/ contact-->
    </div>
</section>

@endsection