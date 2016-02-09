<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Role;
use App\Models\User;
use App\Models\RoleUser;

class RoleTableSeeder extends Seeder {

    public function run()
    {
        DB::table('roles')->delete();

        $player = Role::create(
                array('name'=>'Player', 'display_name'=> 'Player of website', 'description'=> 'Plays the game'));
        $admin = Role::create(
                array('name'=>'Admin', 'display_name'=> 'Administration of website', 'description'=> 'Manages the full site to ensure nothing goes wrong.')
                );

        DB::table('role_user')->delete();

        $kinsley = User::where('name', 'Kinsleyr')->first();
        $byron = User::where('name', 'Byront')->first();
        $kinsley2015 = User::where('name', 'Kinsley2015')->first();

        RoleUser::create(
                array('user_id'=>$kinsley->id, 'role_id'=> $admin->id)
                );
        RoleUser::create(
                array('user_id'=>$byron->id, 'role_id'=> $admin->id)
                );
        RoleUser::create(
                array('user_id'=>$kinsley2015->id, 'role_id'=> $player->id)
                );
    }

}