<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\RuleSet;

class RuleSetTableSeeder extends Seeder {

    public function run()
    {
        DB::table('rule_sets')->delete();

        //set user up for me & byron
        RuleSet::create(
                array('name' => 'Speed Auction 1', 'description'=>'Super fast auction for a quick result', 'auction_duration'=>2, 'ind_film_countdown'=>10, 'min_movies'=>50, 
                     'max_movies'=>80, 'max_players'=>6, 'min_bid' => 0.5, 'max_bid'=> 5, 'start_time'=>'18:00:00', 'close_time'=>'20:00:00')
                );
        RuleSet::create(
                array('name' => 'Speed Auction 2', 'description'=>'Fast auction for a quick result', 'auction_duration'=>4, 'ind_film_countdown'=>15, 'min_movies'=>50, 
                     'max_movies'=>80, 'max_players'=>10, 'min_bid' => 0.5, 'max_bid'=> 5, 'start_time'=>'18:00:00', 'close_time'=>'22:00:00')
                );
        RuleSet::create(
                array('name' => 'Strategic Auction', 'description'=>'Slow auction with a lot of options', 'auction_duration'=>24, 'ind_film_countdown'=>300, 'min_movies'=>50, 
                     'max_movies' => 100, 'min_players' => 10, 'max_players' => 15, 'min_bid' => 0.5, 'randomizer'=> 'Y', 'auction_movie_release'=>'Group 10', 
                     'start_time'=>'18:00:00', 'close_time'=>'18:00:00')
                );
        RuleSet::create(
                array('name' => 'Blind Auction', 'description'=>'Blind auction', 'auction_duration'=>4, 'ind_film_countdown'=>15, 'min_movies'=>50, 
                     'max_movies'=>80, 'max_players'=>10, 'min_bid' => 0.5, 'max_bid'=> 5, 'start_time'=>'18:00:00', 'close_time'=>'22:00:00')
                );
    }

}