<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\LeagueMessage;

class LeagueMessageTableSeeder extends Seeder {

    public function run()
    {
        DB::table('league_messages')->delete();

        //set user up for me & byron
        LeagueMessage::create(
            array('leagues_id'=>48, 'owners_id' => '7', 'message'=>'Hi does this work?')
            );
        LeagueMessage::create(
            array('leagues_id'=>48, 'owners_id' => '8', 'message'=>'Yes you idiot you just posted shit!')
            );
        LeagueMessage::create(
            array('leagues_id'=>48, 'owners_id' => '7', 'message'=>'Ha thanks for your help!')
            );
    }

}