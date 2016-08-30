<?php

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
		$response = $this->action('POST', 'LeagueController@store');
	}

}
