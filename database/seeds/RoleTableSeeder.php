<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Role;
use App\Models\RoleUser;
class RoleTableSeeder extends Seeder {

    public function run()
    {
        DB::table('roles')->delete();

        Role::create(
                array('name'=>'Player', 'display_name'=> 'Player of website', 'description'=> 'Plays the game'));
        Role::create(
                array('name'=>'Admin', 'display_name'=> 'Administration of website', 'description'=> 'Manages the full site to ensure nothing goes wrong.')
                );

        DB::table('role_user')->delete();

        RoleUser::create(
                array('user_id'=>'1', 'role_id'=> '2'),
                array('user_id'=>'2', 'role_id'=> '2')
                );
    }

}