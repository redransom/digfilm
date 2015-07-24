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
                                        Customer</button>
                                </div>
                            </div>
                            <div class="module-body">
                            @if(isset($users) && !empty($users))

                            @for($user_row = 0; $user_row<(count($users)/2); $user_row++)
                                <div class="row-fluid">
                                @for($user_no = $user_row; $user_no < ($user_row+2); $user_no++)
                                <?php $user = $users[$user_no]; ?>
                                    <div class="span6">
                                        <div class="media user">
                                            <a class="media-avatar pull-left" href="{{URL('users', array('id'=>$user->id))}}">
                                                <img src="images/user.png">
                                            </a>
                                            <div class="media-body">
                                                <h3 class="media-title">
                                                    {{$user->name}}
                                                </h3>
                                                <p>
                                                    <small class="muted">{{$user->role->first()->display_name}}</small></p>
                                                <div class="media-option btn-group shaded-icon">
                                                    <button class="btn btn-small">
                                                        <i class="icon-envelope"></i>
                                                    </button>
                                                    <button class="btn btn-small">
                                                        <i class="icon-share-alt"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>    
                                @endfor
                                </div>
                                <!--/.row-fluid-->
                                <br />
                            @endfor
                            @endif
                                <div class="pagination pagination-centered">
                                    <ul>
                                        <li><a href="#"><i class="icon-double-angle-left"></i></a></li>
                                        <li><a href="#">1</a></li>
                                        <li><a href="#">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li><a href="#"><i class="icon-double-angle-right"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
@endsection