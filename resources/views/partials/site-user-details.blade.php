 
                <!-- ************** - Categories - ************** -->   
                <div class="panel">
                    <h2><span>{{$authUser->name}}'s profile</span></h2>
                    
                    <div class="panel-content">
						<h3>Current Balance</h3>
						<p>You have <strong>{{number_format($authUser->balance)}} USD</strong> currently.</p>
						<h3>On-going leagues</h3>
						<p>You are currently in <strong>{{$authUser->inLeagues()->count()}}</strong> leagues.</p>
						<h3>Leagues won</h3>
						<p>You have won <strong>{{$authUser->winTotal()}}</strong> leagues so far!</p>
						@if(!is_null($authUser->thumbnail) && $authUser->thumbnail != "") 
						<h3>Profile Image</h3>
                        <style>
                        img.mugshot {
                            max-width: 135px;
                            max-height: 200px;
                        }
                        </style>
						<p><img src="{{asset($authUser->thumbnail)}}" alt="Player Mugshot" class="mugshot"/></p>
						@endif
                    </div>

                </div>