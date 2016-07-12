 
                <!-- ************** - Categories - ************** -->   
                <div class="panel">
                    <h2><span>Snapshot</span></h2>
                    
                    <div class="panel-content">
						<h3>Won Balance</h3>
						<p>You have <strong>{{number_format($authUser->balance, 2)}} USD</strong> currently.</p>
						<h3>Leagues in?</h3>
						<p>You are currently in <strong>{{$authUser->leagues()->where('enabled', '1')->count()}}</strong> leagues.</p>
						<h3>Won Leagues</h3>
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