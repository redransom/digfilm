@extends('layouts.users')

@section('content')
<h2><span>Choose who you want to play!</span></h2>
<div class="content-padding">
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
                        @foreach($users as $player)
                            <li>
                            @if(!is_null($player->thumbnail) || $player->thumbnail != '')
                            <span class="article-image"><img src="{{asset($player->thumbnail) }}" width="128" height="128" alt="" title="" /></span><!--/a-->
                            @else
                            <span class="article-image"><img src="{{asset('/images/TNBF.jpg') }}" width="128" height="128" alt="" title="" /></span><!--/a-->
                            @endif
                            <span>{{$player->fullName()}}</span>
                            {!! Form::checkbox('users_id[]', $player->id, false) !!}&nbsp;&nbsp;{{$player->fullName()}}
                            </li>
                        @endforeach
                        </ul>
                        <br/>
                        <input type="submit" class="league-btn" id="submit" value="Add Friends" />
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
        <div class="the-form league--form">
            <div id="message"></div>
            {!! Form::open(array('route' => 'league-invite', 'class'=>'form-vertical', 'id'=>'contactform')) !!}
                
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="leagues_id" value="{{$league->id}}">



                    @for($player_cnt = 1; $player_cnt <= ($league->rule->max_players - $league->players->count()); $player_cnt++)
                    <h3>Friend  {{$player_cnt}}</h3>
                    <div class="form--item">
                        <label for="LeagueName"><span class="required">*</span>Name:</label>
                        {!! Form::text('name[]', null, ['class'=>'span8', 'placeholder'=>'Enter friends name here...']) !!}
                    </div>
                    <div class="form--item">
                        <label for="LeagueName"><span class="required">*</span>Email:</label>
                        {!! Form::text('email_address[]', null, ['class'=>'span8', 'placeholder'=>'Enter email address here...']) !!}
                    </div>

                    <!--div class="row">
                        <label for="name"><span class="required">*</span>Name:</label>
                        {!! Form::text('name[]', null, ['class'=>'span8', 'placeholder'=>'Enter friends name here...']) !!}
                    </div>
                    <div class="row">
                        <label for="name"><span class="required">*</span>Email:</label>
                        {!! Form::text('email_address[]', null, ['class'=>'span8', 'placeholder'=>'Enter email address here...']) !!}
                    </div-->
                    @endfor
                    <input type="submit" class="league-btn" id="submit" value="Invite" />
                    </div><!--/ textfield-->
                </fieldset>
            </form>
        </div><!--/ contact-->
    </div>
</section>

@endsection