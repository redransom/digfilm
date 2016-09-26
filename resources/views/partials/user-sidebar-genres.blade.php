 
                <!-- BEGIN .panel -->
                <div class="panel">
                    <h2><span>Our movie database</span></h2>
                    <div class="panel-content">

                        <select class="selectdropdown">
                            @if(isset($genres_list))
                                @foreach($genres_list as $listgenre)
                                <option value="{{URL('movie-genre', [$listgenre->link()])}}" 
                                @if(isset($genre) && $listgenre->id == $genre->id) 
                                selected
                                @endif
                                >{{$listgenre->name}} ({{$listgenre->movie_count()}})</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                <!-- END .panel -->
                </div>