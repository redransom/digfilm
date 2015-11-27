<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Genre;

class GenreTableSeeder extends Seeder {

    public function run()
    {
        DB::table('genres')->delete();

/*        Genre::create(array('name'=>'Horror'));
        Genre::create(array('name'=>'Sci-Fi'));
        Genre::create(array('name'=>'Fantasy'));
        Genre::create(array('name'=>'Thriller'));
        Genre::create(array('name'=>'Comedy'));
        Genre::create(array('name'=>'Rom-Com'));
        Genre::create(array('name'=>'Zom-Com'));
*/
        Genre::create(array('id'=>1, 'name' => 'Action'));
        Genre::create(array('id'=>2, 'name' => 'Adventure'));
        Genre::create(array('id'=>3, 'name' => 'Animation'));
        Genre::create(array('id'=>4, 'name' => 'Biography'));
        Genre::create(array('id'=>5, 'name' => 'Comedy'));
        Genre::create(array('id'=>6, 'name' => 'Crime'));
        Genre::create(array('id'=>7, 'name' => 'Documentary'));
        Genre::create(array('id'=>8, 'name' => 'Drama'));
        Genre::create(array('id'=>9, 'name' => 'Family'));
        Genre::create(array('id'=>10, 'name' => 'Fantasy'));
        Genre::create(array('id'=>11, 'name' => 'Historical'));
        Genre::create(array('id'=>12, 'name' => 'Historical Fiction'));
        Genre::create(array('id'=>13, 'name' => 'Horror'));
        Genre::create(array('id'=>14, 'name' => 'Magical Realism'));
        Genre::create(array('id'=>15, 'name' => 'Musical'));
        Genre::create(array('id'=>16, 'name' => 'Mystery'));
        Genre::create(array('id'=>17, 'name' => 'Paranoid'));
        Genre::create(array('id'=>18, 'name' => 'Philosophical'));
        Genre::create(array('id'=>19, 'name' => 'Political'));
        Genre::create(array('id'=>20, 'name' => 'Romance'));
        Genre::create(array('id'=>21, 'name' => 'Saga'));
        Genre::create(array('id'=>22, 'name' => 'Satire'));
    }

}