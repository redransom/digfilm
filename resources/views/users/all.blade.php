@extends('layouts.admin')

@section('content')

                        <div class="module">
                            <div class="module-head">
                                <h3>
                                    All Members</h3>
                            </div>
                            <div class="module-option clearfix">
                                {!! Form::open(array('route' => array('users-admin-search'), 'method'=>'PUT')) !!}
                                <div class="input-append pull-left">
                                    <input type="text" class="span3" placeholder="Filter by name..." name="users-search-text" value="{{(isset($search) ? $search : "")}}">
                                    <button class="btn" type="submit">
                                        <i class="icon-search"></i>
                                    </button>
                                </div>
                                </form>
                                <div class="btn-group pull-right" data-toggle="buttons-radio">
                                    <a class="btn" href="{{URL('users')}}">All</a>
                                    <a class="btn" href="{{URL('users/Admin')}}">Admin</a>
                                    <a class="btn" href="{{URL('users/Player')}}">Player</a>
                                </div>
                            </div>
                            @if(isset($users) && !empty($users))

                            <div class="module-body table">
                                <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped  display" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="5%">ID</th>
                                            <th width="15%">Name</th>
                                            <th width="15%">Email</th>
                                            <th>Desc</th>
                                            <th width="9%">Role</th>
                                            <th width="13%">Created</th>
                                            <th width="20%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $userCnt = 1; ?>
                                        @foreach($users as $user)
                                        <tr class="<?php echo (($userCnt++ % 2) == 0) ? "odd" : "even"; ?> user{{$user->id}}">
                                            <td>{{$user->id}}</td>
                                            <td><a href="{{URL('user', array('id'=>$user->id))}}">{{$user->name}}</a></td>
                                            <td>{{$user->email}}</td>
                                            <td>{{$user->description}}</td>
                                            <td>{{(($user->hasRole("Admin")) ? "Admin" : "Player")}}</td>
                                            <td>{{date("d M Y", strtotime($user->created_at))}}</td>
                                            <td><a class="btn btn-mini btn-primary" href="{{URL('user/'.$user->id.'/edit')}}">Edit</a>
                                                @if($user->enabled)
                                                <a class="btn btn-mini btn-danger" href="{{URL('user/'.$user->id.'/disable')}}">Disable</a>
                                                @else
                                                <a class="btn btn-mini btn-info" href="{{URL('user/'.$user->id.'/enable')}}">Enable</a>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="pagination pagination-centered">
                            <?php echo $users->render(); ?>
                            </div>
                            @endif
                        </div>
                    </div>
@endsection