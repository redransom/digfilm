@extends('layouts.admin')

@section('content')
                    <div class="content">
                        <div class="module">
                            <div class="module-head">
                                <h3>{{$movie->name}}</h3>
                            </div>
                            <div class="module-body">
                                <dl class="dl-horizontal">
                                    <dt>Summary</dt>
                                    <dd>{{$movie->summary}}</dd>
                                    <dt>Genre</dt>
                                    <dd>{{$movie->genre->name}}</dd>
                                    <dt>Rating</dt>
                                    <dd>{{$movie->rating}}</dd>
                                    <dt>Budget</dt>
                                    <dd>${{$movie->budget}}</dd>
                                    <dt>Release Date</dt>
                                    <dd>{{date("D jS M Y", strtotime($movie->release_at))}}</dd>
                                </dl>
                                <ul class="inline">
                                    <li><a href="{{URL('movies/'.$movie->id.'/edit')}}">Edit Movie</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="module">
                            <div class="module-head">
                                <h3>Contributors</h3>
                            </div>

                            <div class="module-body">
                                @if($movie->contributors->count() > 0)
                                <dl class="dl-horizontal">
                                    @foreach($movie->Contributors as $contributor)
                                    <dt>{{$contributor->first_name}} {{$contributor->surname}}</dt>
                                    <dd>{{$types[$contributor->pivot->contributor_types_id]}}</dd>
                                    @endforeach
                                </dl>
                                @else
                                <p>There are no contributors for this movie currently.</p>
                                @endif
                                <ul class="inline">
                                    <li><a href="{{Route('movie-add-contributor', array('id'=>$movie->id))}}">Add Contributor</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="module">
                            <div class="module-head">
                                <h3>Media</h3>
                            </div>
                            <div class="module-body">

                                @if($movie->Media->count() > 0)
                                <ul class="inline">
                                @foreach($movie->Media as $item)
                                    <?php
                                    if ($item->type =='T' && str_contains($item->url, "youtu.be")) {
                                        $url = $item->url;

                                        //only use youtube currently
                                        $path = parse_url($url, PHP_URL_PATH);
                                        $base_url = "http://www.youtube.com/embed".$path;
                                    } else
                                        $base_url = $item->url; //not known where it comes from

                                    ?>
                                    <li>
                                    @if($item->type == 'I')
                                    <img src="{{$item->file_name}}" alt="{{$item->name}}" width="100px"/>
                                    @else
                                    <iframe width="200" height="150" src="{{$base_url}}" frameborder="0" allowfullscreen></iframe>
                                    @endif
                                    <a href="{{Route('movie-remove-media', array($item->id))}}" title="Remove Media {{$item->name}}">x</a>
                                    </li>
                                @endforeach
                                </ul>


                                @else
                                <p>There are no media files/links for this movie currently.</p>
                                @endif
                                <ul class="inline">
                                    <li><a href="{{Route('movie-add-media', array('id'=>$movie->id))}}">Add Media</a></li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="module">
                            <div class="module-head">
                                <h3>Takings History</h3>
                            </div>
                            <div class="module-body">

                                @if($movie->Takings->count() > 0)
                                <table class="table table-striped" width="50%">
                                <thead><th>Amount</th><th>Country</th><th>Date</th></thead>
                                <tbody>
                                @foreach($movie->Takings as $taking)
                                    <tr><td>{{intval($taking->amount)}}M</td><td>{{$taking->country}}</td><td>{{$taking->takings_at}}</td></tr>
                                @endforeach
                                </tbody>
                                </table>
                                @else
                                <p>No takings have been recorded for this movie currently.</p>
                                @endif
                                <ul class="inline">
                                    <li><a href="{{Route('movie-add-takings', array('id'=>$movie->id))}}">Add Takings</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="module">
                            <div class="module-head">
                                <h3>Bid History</h3>
                            </div>
                            <div class="module-body">
                                <ul>
                            @foreach($movie->bids as $bid)
                                <li>&dollar;{{$bid->bid_amount}} at {{date("j M Y H:i", strtotime($bid->created_at))}}</li>
                            @endforeach
                                </ul>
                            </div>

                        </div>
                    </div>
<!--/.content-->
@endsection