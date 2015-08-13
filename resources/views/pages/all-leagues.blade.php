@extends('layouts.admin')

@section('content')
                    <div class="content">
                        <div class="module">
                            <div class="module-head">
                                <h3>All Available Leagues</h3>
                            </div>
                            <div class="module-body table">
                                <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped  display" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Players</th>
                                            <th>Created By</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $leagueCnt = 1; ?>
                                        @foreach($leagues as $league)
                                        <tr class="<?php echo (($leagueCnt++ % 2) == 0) ? "odd" : "even"; ?> league{{$league->id}}">
                                            <td><a href="{{URL('pages-league', array('id'=>$league->id))}}">{{$league->name}}</a></td>
                                            <td>{{count($league->players)}}</td>
                                            <td class="center"><a href="{{URL('users/'.$league->owner->id)}}">{{$league->owner->name}}</a></td>
                                            <td>
                                            @if($authUser)
                                            <a class="btn btn-mini btn-primary" href="{{URL('leagues/'.$league->id.'/join/'.$authUser->id)}}">Join</a>
                                            @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
<!--/.content-->
@endsection