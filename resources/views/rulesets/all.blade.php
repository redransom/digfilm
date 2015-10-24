@extends('layouts.admin')

@section('content')
                    <div class="content">
                        <div class="module">
                            <div class="module-head">
                                <h3>Rule Sets</h3>
                            </div>

                            <div class="module-body">
                                <a class="btn" href="{{route('rulesets.create')}}">Add Rule Set</a>
                            </div>
                            
                            <div class="module-body table">
                                <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped  display" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="30%">Name</th>
                                            <th width="30%">Desc</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $ruleCnt = 1; ?>
                                        @foreach($rulesets as $ruleset)
                                        <tr class="<?php echo (($ruleCnt++ % 2) == 0) ? "odd" : "even"; ?> rating{{$ruleset->id}}">
                                            <td><a href="{{URL('rulesets', array('id'=>$ruleset->id))}}">{{$ruleset->name}}</a></td>
                                            <td>{{$ruleset->description}}</td>
                                            <td><a class="btn btn-mini btn-primary" href="{{URL('rulesets/'.$ruleset->id.'/edit')}}">Edit</a>
                                             {!! Form::open(array('route' => array('rulesets.destroy', $ruleset->id), 'method' => 'delete', 'style'=>'display:inline')) !!}
                                                <button type="submit" class="btn btn-danger btn-mini">Delete</button>
                                            {!! Form::close() !!}
                           
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
<!--/.content-->
@endsection