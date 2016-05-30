<?php

namespace App\Observers;
use DB;

/**
 * Observes the MovieTaking model
 */
class MovieTakingObserver 
{
    /**
     * Function will be triggerd when a user is updated
     * 
     * @param MovieTaking $model
     */
    public function created($model)
    {
    	DB::update(DB::raw("UPDATE league_roster SET total_gross = ".$model->amount.", value_for_money = ((".$model->amount." / bid_amount) / 100000) WHERE movies_id = ".$model->movies_id." AND takings_end_date > NOW()"));
    }
}