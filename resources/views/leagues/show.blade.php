@extends('layouts.admin')

@section('content')
                    <div class="content">
                        <div class="module">
                            <div class="module-head">
                                <h3>League {{$league->name}} details</h3>
                            </div>
                            <dl class="dl-horizontal">
                                <dt>Name</dt>
                                <dd>{{$league->name}}</dd>
                                <dt>Owned By</dt>
                                <dd>{{$league->Owner->name}}</dd>
                            </dl>

                            <div class="module-head">
                                <h3>Players</h3>
                            </div>
                            
                        </div>
                    </div>
<!--/.content-->
@endsection