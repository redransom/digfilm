<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Rating;

class RatingTableSeeder extends Seeder {

    public function run()
    {
        DB::table('ratings')->delete();

        //set user up for me & byron
        Rating::create(array('name' => 'U', 'country'=>'UK'));
        Rating::create(array('name' => 'PG', 'country'=>'UK'));
        Rating::create(array('name' => '12A', 'country'=>'UK'));
        Rating::create(array('name' => '12', 'country'=>'UK'));
        Rating::create(array('name' => '15', 'country'=>'UK'));
        Rating::create(array('name' => '18', 'country'=>'UK'));
        Rating::create(array('name' => 'R18', 'country'=>'UK'));

        Rating::create(array('name' => 'G', 'country'=>'US'));
        Rating::create(array('name' => 'PG', 'country'=>'US'));
        Rating::create(array('name' => 'PG-13', 'country'=>'US'));
        Rating::create(array('name' => 'R', 'country'=>'US'));
        Rating::create(array('name' => 'NC-17', 'country'=>'US'));
    }


}