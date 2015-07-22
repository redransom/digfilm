<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\ContributorType;

class ContributorTypeTableSeeder extends Seeder {

    public function run()
    {
        DB::table('contributor_types')->delete();

        ContributorType::create(
                array('name'=>'Actor'),
                array('name'=>'Director')
                );
    }

}