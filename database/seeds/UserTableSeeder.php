<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        //set user up for me & byron
        User::create(
                array('email' => 'kinsley@redransom.co.uk', 'name'=>'Kinsleyr', 'password'=>Hash::make('password'))
                );
        User::create(
                array('email' => 'mavenstar1002@gmail.com', 'name'=>'Byront', 'password'=>Hash::make('password'))
                );
        User::create(
                array('email' => 'kinsleyr@gmail.com', 'name'=>'Kinsley2015', 'password'=>Hash::make('password'))
                );

    }

}