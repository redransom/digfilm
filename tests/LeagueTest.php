<?php
use App\Models\Movie;

class LeagueTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
       */
	public function testCreateLeague()
	{
        //$this->assetEquals(1, 1);
        //$this->assetEquals(2, 1);
		//$response = $this->action('POST', 'LeagueController@store');

		$response = $this->action('POST', 'LeaguesController@postInvitePlayer', 
			['leagues_id'=>'57', 
			'name'=>[0=>'john', 1 => 'mike'], 
			'email_address'=>[0=>'johntest@gmail.com', 1=>'miketest@gmail.com']]);

		$movie = Movie::first();
		$response = $this->action('POST', 'LeaguesController@postMovie',
			['leagues_id'=>57, 'movies_id'=>$movie->id]);
	}

}
