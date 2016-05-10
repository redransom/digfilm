@extends('layouts.site')

@section('content')
<h2><span>Choose who you want to play!</span></h2>

<div class="content-padding">
    <p>You can select any players from your friends list or invite players to join.</p>
    <div class="photo-blocks">

        <h4>Choose Friends</h4>  
        @if($users->count()>0)
        {!! Form::open(array('route' => 'choose-participants', 'class'=>'form-horizontal row-fluid', 'id'=>'contactform')) !!}
        <p>You can choose <strong>{{$league->rule->max_players - $league->players->count()}}</strong> more players.</p>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="leagues_id" value="{{$league->id}}">
        <ul>
        @foreach($users as $player)
            <li>
            @if(!is_null($player->thumbnail) || $player->thumbnail != '')
            <span class="article-image"><img src="{{asset($player->thumbnail) }}" width="128" height="128" alt="" title="" /></span><!--/a-->
            @else
            <span class="article-image"><img src="{{asset('/images/TNBF.jpg') }}" width="128" height="128" alt="" title="" /></span><!--/a-->
            @endif
            <br/>
            <span>{{$player->fullName()}}&nbsp;{!! Form::checkbox('users_id[]', $player->id, false) !!}</span>
            
            </li>
        @endforeach
        </ul>

        <div class="form-footer">
             <div class="divider--img"></div>
            <input type="submit" name="submit" class="submit-btn btn-small" id="submit" value="Add Friends" />
        </div>

        </form>
        @else
        <p>Sorry, you have no friends currently.</p>
        @endif

    </div>
</div>

<div class="content-padding">
    <h4>Invite Friend</h4>
    <p>Use this form if you have friends who are not playing the game currently and you'd like to invite them.</p>
    {!! Form::open(array('route' => 'league-invite', 'class'=>'form-vertical', 'id'=>'contactform')) !!}
    <div class="the-form league--form">
        <div id="message"></div>
            
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

            @endfor
    </div><!--/ contact-->
    <div class="form-footer">
         <div class="divider--img"></div>
        <input type="submit" name="submit" class="submit-btn btn-small" id="submit" value="Invite" />
    </div>
    </form>
</div>
@endsection