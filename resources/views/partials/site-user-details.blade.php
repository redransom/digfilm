 
                <!-- ************** - Categories - ************** -->   
                <div class="panel">
                    <h2>Snapshot</h2>
                    
                    <div class="panel-content">
						<h3>Won Balance</h3>
						<p>You have <strong>{{number_format($authUser->balance, 2)}} USD</strong> currently.</p>
						<h3>Leagues in?</h3>
						<p>You are currently in <strong>{{$authUser->leagues()->where('enabled', '1')->count()}}</strong> leagues.</p>
						<h3>Won Leagues</h3>
						<p>You have won <strong>0</strong> leagues so far!</p>
                    </div>

                </div>