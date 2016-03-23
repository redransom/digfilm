 
                <!-- BEGIN .panel -->
                <div class="panel">
                    <h2><span>Movie Genres</span></h2>
                    <div class="panel-content">

                        <select class="selectdropdown">
                            @if(isset($genres_list))
                                @foreach($genres_list as $genre)
                                <option value="{{URL('movie-genre', [$genre->link()])}}" selected>{{$genre->name}} ({{$genre->movie_count()}})</option>
                                @endforeach
                            @endif
                        </select>

                        
                        
                    </div>
                <!-- END .panel -->
                </div>