<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Movie;

class MovieTableSeeder extends Seeder {

    public function run()
    {
        //DB::table('movies')->delete();

        //set user up for me & byron
        Movie::create(array('name' => 'The Hateful Eight', 'summary'=>'Tarantino', 'genre'=>1, 'rating'=>5, 'budget'=>150, 'release_at'=>'2016-01-08'));
        Movie::create(array('name' => 'The Revenant', 'summary'=>'Horror', 'genre'=>2, 'rating'=>2, 'budget'=>40, 'release_at'=>'2016-01-08'));
        Movie::create(array('name' => 'The Forest', 'summary'=>'Horror', 'genre'=>3, 'rating'=>2, 'budget'=>40, 'release_at'=>'2016-01-08'));
        Movie::create(array('name' => 'The 5th Wave', 'summary'=>'Horror', 'genre'=>4, 'rating'=>2, 'budget'=>40, 'release_at'=>'2016-01-15'));
        Movie::create(array('name' => '13 Hours', 'summary'=>'Horror', 'genre'=>5, 'rating'=>2, 'budget'=>40, 'release_at'=>'2016-01-15'));
        Movie::create(array('name' => 'Ride Along 2', 'summary'=>'Horror', 'genre'=>6, 'rating'=>2, 'budget'=>40, 'release_at'=>'2016-01-15'));
        Movie::create(array('name' => 'The Nut Job 2', 'summary'=>'Horror', 'genre'=>7, 'rating'=>2, 'budget'=>40, 'release_at'=>'2016-01-15'));
        Movie::create(array('name' => 'Norm of the North', 'summary'=>'Horror', 'genre'=>1, 'rating'=>2, 'budget'=>40, 'release_at'=>'2016-01-15'));
        Movie::create(array('name' => 'Dirty Grandpa', 'summary'=>'Horror', 'genre'=>2, 'rating'=>2, 'budget'=>40, 'release_at'=>'2016-01-22'));
        Movie::create(array('name' => 'Risen', 'summary'=>'Horror', 'genre'=>2, 'rating'=>3, 'budget'=>40, 'release_at'=>'2016-01-22'));
        Movie::create(array('name' => 'The Boy', 'summary'=>'Horror', 'genre'=>2, 'rating'=>4, 'budget'=>40, 'release_at'=>'2016-01-22'));
        Movie::create(array('name' => 'Fifty Shades of Black', 'summary'=>'Horror', 'genre'=>5, 'rating'=>2, 'budget'=>40, 'release_at'=>'2016-01-29'));
        Movie::create(array('name' => 'Kung Fu Panda 3', 'summary'=>'Horror', 'genre'=>6, 'rating'=>2, 'budget'=>40, 'release_at'=>'2016-01-29'));
        Movie::create(array('name' => 'Jane Got a Gun', 'summary'=>'Horror', 'genre'=>7, 'rating'=>2, 'budget'=>40, 'release_at'=>'2016-01-29'));

        Movie::create(array('name' => 'The Choice', 'summary'=>'Horror', 'genre'=>1, 'rating'=>2, 'budget'=>40, 'release_at'=>'2016-02-05'));
        Movie::create(array('name' => 'Pride and Predjudice and Zombies', 'summary'=>'Horror', 'genre'=>2, 'rating'=>2, 'budget'=>40, 'release_at'=>'2016-02-05'));
        Movie::create(array('name' => 'Hail Caeser', 'summary'=>'Horror', 'genre'=>3, 'rating'=>2, 'budget'=>40, 'release_at'=>'2016-02-05'));
        Movie::create(array('name' => 'Deadpool', 'summary'=>'Horror', 'genre'=>4, 'rating'=>2, 'budget'=>40, 'release_at'=>'2016-02-12'));
        Movie::create(array('name' => 'Zoolander 2', 'summary'=>'Horror', 'genre'=>5, 'rating'=>2, 'budget'=>40, 'release_at'=>'2016-02-12'));
        Movie::create(array('name' => 'How to be Single', 'summary'=>'Horror', 'genre'=>6, 'rating'=>2, 'budget'=>40, 'release_at'=>'2016-02-12'));
        Movie::create(array('name' => 'Shut In', 'summary'=>'Horror', 'genre'=>7, 'rating'=>2, 'budget'=>40, 'release_at'=>'2016-02-19'));
        Movie::create(array('name' => 'Race', 'summary'=>'Horror', 'genre'=>1, 'rating'=>2, 'budget'=>40, 'release_at'=>'2016-02-19'));

        Movie::create(array('name' => 'London Has Fallen', 'summary'=>'Horror', 'genre'=>2, 'rating'=>2, 'budget'=>40, 'release_at'=>'2016-03-04'));
        Movie::create(array('name' => 'Zootopia', 'summary'=>'Horror', 'genre'=>3, 'rating'=>2, 'budget'=>40, 'release_at'=>'2016-03-04'));
        Movie::create(array('name' => 'Grimsby', 'summary'=>'Horror', 'genre'=>4, 'rating'=>2, 'budget'=>40, 'release_at'=>'2016-03-04'));
        Movie::create(array('name' => 'Knight of Cups', 'summary'=>'Horror', 'genre'=>5, 'rating'=>2, 'budget'=>40, 'release_at'=>'2016-03-04'));
        Movie::create(array('name' => 'The Young Messiah', 'summary'=>'Horror', 'genre'=>6, 'rating'=>2, 'budget'=>40, 'release_at'=>'2016-03-11'));
        Movie::create(array('name' => 'Valencia', 'summary'=>'Horror', 'genre'=>7, 'rating'=>2, 'budget'=>40, 'release_at'=>'2016-03-11'));
        Movie::create(array('name' => 'The Divergent Series: Allegiance', 'summary'=>'Horror', 'genre'=>1, 'rating'=>2, 'budget'=>40, 'release_at'=>'2016-03-18'));
        Movie::create(array('name' => 'Monster Trucks', 'summary'=>'Horror', 'genre'=>2, 'rating'=>2, 'budget'=>40, 'release_at'=>'2016-03-18'));
        Movie::create(array('name' => 'Batman v Superman: Dawn of Justice', 'summary'=>'Horror', 'genre'=>3, 'rating'=>2, 'budget'=>40, 'release_at'=>'2016-03-25'));
        Movie::create(array('name' => 'The Jungle Book', 'summary'=>'Horror', 'genre'=>4, 'rating'=>2, 'budget'=>40, 'release_at'=>'2016-04-15'));
        Movie::create(array('name' => 'Amityville: The Reawakening', 'summary'=>'Horror', 'genre'=>5, 'rating'=>2, 'budget'=>40, 'release_at'=>'2016-04-15'));

    }

}