@extends('layouts.admin')

@section('content')
                    <div class="content">
                        <div class="module">
                            <div class="module-head">
                                <h3>Leagues</h3>
                            </div>
                            @if($leagues->count() > 0)
                            <div class="module-body table">

                                <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped  display" width="100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Players</th>
                                            <th>Movies</th>
                                            <th>Start?</th>
                                            <th>Owned By</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $leagueCnt = 1; 

                                        $stage = $leagues[0]->auction_stage;
                                        $stage_array = [null=>'Not Ready', '0'=>'Start Set', '1'=>'Movies Chosen', '2'=>'Auctions Live', '3'=>'Rosters'];
                                        ?>
                                        @foreach($leagues as $league)
                                        <?php if (is_null($league->auction_start_date)) $start = ""; else $start = date("j M Y H:i", strtotime($league->auction_start_date)); ?>
                                        @if($stage != $league->auction_stage || $leagueCnt == 1)
                                            <tr><td colspan='6'>{{$stage_array[$league->auction_stage]}}</td></tr>
                                            <?php $stage = $league->auction_stage; ?>
                                        @endif
                                        <tr class="<?php echo (($leagueCnt++ % 2) == 0) ? "odd" : "even"; ?> user{{$league->id}}">
                                            <td>{{$league->id}}</td>
                                            <td><a href="{{URL('league', array('id'=>$league->id))}}">{{$league->name}}</a></td>
                                            <td>{{count($league->players)}}</td>
                                            <td>{{$league->movies()->count()}}</td>
                                            <td>{{$start}}</td>
                                            <td class="center"><a href="{{URL('users/'.$league->owner->id)}}">{{$league->owner->name}}</a></td>
                                            <td>
                                            <a class="btn btn-mini btn-primary" href="{{URL('leagues/'.$league->id.'/edit')}}">Edit</a>
                                            @if($league->enabled)
                                            <a class="btn btn-mini btn-warning" href="{{URL('leagues/'.$league->id.'/disable')}}">Disable</a>
                                            @else
                                            <a class="btn btn-mini btn-info" href="{{URL('leagues/'.$league->id.'/enable')}}">Enable</a>
                                            @endif
                                            @if(!is_null($league->rule))
                                            <a class="btn btn-mini btn-inverse" href="{{URL('leagues/'.$league->id.'/rules')}}">Rules</a>
                                            @endif
                                            @if(!$league->enabled)

                                            {!! Form::open(array('route' => array('leagues.destroy', $league->id), 'method' => 'delete', 'style'=>'display:inline')) !!}
                                                <button type="submit" class="btn btn-danger btn-mini">Delete</button>
                                            {!! Form::close() !!}
                                            @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="module-body">
                            <p>There are no leagues with this status.</p>
                            </div>
                            @endif
                            @if($paginate)
                            <div class="pagination pagination-centered">
                                <?php echo $leagues->render(); ?>
                            </div>
                            @endif
                        </div>
                    </div>
<!--/.content-->
@endsection