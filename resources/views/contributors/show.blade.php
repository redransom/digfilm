@extends('layouts.admin')

@section('content')
                    <div class="content">
                        <div class="module">
                            <div class="module-head">
                                <h3>{{$contributor->first_name}} {{$contributor->surname}}</h3>
                            </div>

                            <div class="module-head">
                                <h3>Films</h3>
                            </div>

                            <dl class="dl-horizontal">
                                @foreach($contributor->movies as $movie)
                                <dt>{{$movie->name}}</dt>
                                @endforeach
                            </dl>
                        </div>
                    </div>
<!--/.content-->
@endsection