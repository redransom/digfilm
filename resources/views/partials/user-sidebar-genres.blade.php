 
                <!-- ************** - Categories - ************** -->   
                <div class="categories widget clearfix">
                    
                    <div class="title-caption">
                        <h3>Movie Genres</h3>
                    </div><!--/ .title-caption-->
                    
                    @if(isset($genres_list))
                    <ul>
                        @foreach($genres_list as $genre)
                        <li><div><a href="{{URL('movies-genre', [$genre->id])}}">{{$genre->name}}</a><span>({{$genre->movie_count()}})</span></div></li>
                        @endforeach
                    </ul>
                    @endif
                </div><!--/ .categories-->
                <!-- ************** - END Categories - ************** -->