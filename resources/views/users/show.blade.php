@extends('layouts.admin')

@section('content')
                        <div class="module">
                            <div class="module-body">
                                <div class="profile-head media">
                                    <a href="#" class="media-avatar pull-left">
                                        @if(!is_null($user->thumbnail))
                                        <img src="{{asset($user->thumbnail)}}">
                                        @else
                                        <img src="/admin/images/user.png">
                                        @endif
                                    </a>
                                    <div class="media-body">
                                        <h4>
                                            {{$user->forenames}} {{$user->surname}}<small>{{$user->name}}</small>
                                        </h4>
                                        <p class="profile-brief">
                                            @if(!is_null($user->description))
                                            {{$user->description}}
                                            @endif
                                            <dl>
                                                <dt>Email</dt>
                                                <dd>{{$user->email}}</dd>
                                                <dt>Balance</dt>
                                                <dd>{{is_null($user->balance) ? "zero" : $user->balance." USD"}}</dd>
                                            </dl>
                                        </p>
                                        <!--div class="profile-details muted">
                                            <a href="#" class="btn"><i class="icon-plus shaded"></i>Send Friend Request </a>
                                            <a href="#" class="btn"><i class="icon-envelope-alt shaded"></i>Send message </a>
                                        </div-->
                                    </div>
                                </div>
                                <ul class="profile-tab nav nav-tabs">
                                    <li class="active"><a href="#activity" data-toggle="tab">Leagues</a></li>
                                    <!--li><a href="#friends" data-toggle="tab">Friends</a></li>
                                    <li><a href="#leagues" data-toggle="tab">Leagues</a></li-->
                                </ul>
                                <div class="profile-tab-content tab-content">
                                    <div class="tab-pane fade active in" id="activity">
                                        <div class="stream-list">
                                            
                                            @foreach($user->inLeagues as $league)
                                            <div class="media stream">
                                                <a href="{{Route('league', [$league->id])}}" title="League Details" class="media-avatar medium pull-left">
                                                    @if ($league->hasImage())
                                                    <img src="{{asset($league->file_name)}}">
                                                    @else
                                                    <img src="{{asset('images/TNBF.jpg')}}">
                                                    @endif
                                                </a>
                                                <div class="media-body">
                                                    <div class="stream-headline">
                                                        <h5 class="stream-author">{{$league->name}}<small>{{$league->end_date}}</small></h5>
                                                        <div class="stream-text">
                                                            {{$league->description}}
                                                        </div>
                                                        <div class="stream-attachment photo">
                                                            <div class="responsive-photo">
                                                                <img src="images/img.jpg" alt="" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--/.stream-headline-->
                                                    <div class="stream-options">
                                                        <a href="{{Route('league-remove-player', $league->id)}}" class="btn btn-small"><i class="icon-thumbs-up shaded"></i>Remove Player </a>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                           
                                        </div>
                                        <!--/.stream-list-->
                                    </div>
                                    
                                </div>
                            </div>
                            <!--/.module-body-->
                        </div>
                        <!--/.module-->
@endsection