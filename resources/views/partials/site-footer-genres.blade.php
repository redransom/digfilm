                <!-- BEGIN .panel -->
                <div class="panel">
                    <h2>Movie Genres</h2>
                    <div class="panel-content">

                        <div class="tagcloud">
                            @if(isset($genres_list))
                                @foreach($genres_list as $genre)
                                <a href="{{URL('movie-genre', [$genre->link()])}}">{{$genre->name}} ({{$genre->movie_count()}})</a>
                                @endforeach
                            @endif
                        </div>
                        
                    </div>
                <!-- END .panel -->
                </div>