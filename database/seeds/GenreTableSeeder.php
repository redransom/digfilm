<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Genre;

class GenreTableSeeder extends Seeder {

    public function run()
    {
        DB::table('genres')->delete();

        Genre::create(array('name'=>'Horror'));
        Genre::create(array('name'=>'Sci-Fi'));
        Genre::create(array('name'=>'Fantasy'));
        Genre::create(array('name'=>'Thriller'));
        Genre::create(array('name'=>'Comedy'));
        Genre::create(array('name'=>'Rom-Com'));
        Genre::create(array('name'=>'Zom-Com'));
    }

}