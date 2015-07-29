<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Movie;

class MovieTableSeeder extends Seeder {

    public function run()
    {
        DB::table('movies')->delete();

        //set user up for me & byron
        Movie::create(
                array('name' => 'The Avengers Assemble', 'summary'=>'Super Heros Unite', 'genre'=>'Action', 'rating'=>5, 'budget'=>150)
                );
        Movie::create(
                array('name' => 'Hick', 'summary'=>'Light comedy about a womaniser', 'genre'=>'Comedy', 'rating'=>2, 'budget'=>40)
                );
    }

}