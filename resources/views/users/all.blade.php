@extends('layouts.admin')

@section('content')

                        <div class="module">
                            <div class="module-head">
                                <h3>
                                    All Members</h3>
                            </div>
                            <div class="module-option clearfix">
                                <form>
                                <div class="input-append pull-left">
                                    <input type="text" class="span3" placeholder="Filter by name...">
                                    <button type="submit" class="btn">
                                        <i class="icon-search"></i>
                                    </button>
                                </div>
                                </form>
                                <div class="btn-group pull-right" data-toggle="buttons-radio">
                                    <button type="button" class="btn">
                                        All</button>
                                    <button type="button" class="btn">
                                        Admin</button>
                                    <button type="button" class="btn">
                                        Player</button>
                                </div>
                            </div>
                            <div class="module-body">
                            @if(isset($users) && !empty($users))

                            <?php $user_count = 0; ?>
                            @foreach($users as $user)

                                @if($user_count == 0 || ($user_count % 2) == 0)
                                <div class="row-fluid">
                                @endif
                                    <div class="span6">
                                        <div class="media user">
                                            <a class="media-avatar pull-left" href="{{URL('users', array('id'=>$user->id))}}">
                                            @if(!is_null($user->thumbnail))
                                            <img src="{{asset($user->thumbnail)}}">
                                            @else
                                            <img src="/admin/images/user.png">
                                            @endif
                                            </a>
                                            <div class="media-body">
                                                <h3 class="media-title">
                                                    {{$user->name}}
                                                </h3>
                                                <p>
                                                    <small class="muted">{{$user->role->first()->display_name}}</small></p>
                                                <div class="media-option btn-group shaded-icon">
                                                    <a class="btn btn-mini btn-primary" href="{{URL('users/'.$user->id.'/edit')}}">Edit</a>
                                                </div>

                                                <div class="media-option btn-group shaded-icon">
                                                    @if($user->enabled)
                                                    <a class="btn btn-mini btn-danger" href="{{URL('users/'.$user->id.'/disable')}}">Disable</a>
                                                    @else
                                                    <a class="btn btn-mini btn-info" href="{{URL('users/'.$user->id.'/enable')}}">Enable</a>
                                                    @endif
                                                </div>
                                                <!--div class="media-option btn-group shaded-icon">
                                                    <button class="btn btn-small">
                                                        <i class="icon-envelope"></i>
                                                    </button>
                                                    <button class="btn btn-small">
                                                        <i class="icon-share-alt"></i>
                                                    </button>
                                                </div-->
                                            </div>
                                        </div>
                                    </div>    
                               @if(($user_count++ % 2) == 1)
                                </div>
                                <!--/.row-fluid-->
                                <br />
                                @endif
                            @endforeach

                                @if(($user_count % 2) == 1)
                                </div>
                                <!--/.row-fluid-->
                                <br />
                                @endif
                            @endif
                                <div class="pagination pagination-centered">

                                <?php echo $users->render(); ?>
                                    <!--ul>
                                        <li><a href="#"><i class="icon-double-angle-left"></i></a></li>
                                        <li><a href="#">1</a></li>
                                        <li><a href="#">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li><a href="#"><i class="icon-double-angle-right"></i></a></li>
                                    </ul-->
                                </div>
                            </div>
                        </div>
@endsection