<?php

namespace App\Observers;
use DB;
use App\Models\LeagueUser;

/**
 * Observes the League model
 */
class LeagueObserver 
{
    /**
     * Function will be triggerd when a new league is created
     * 
     * @param League $model
     */
    public function created($model)
    {
    	//DB::update(DB::raw("UPDATE league_roster SET total_gross = ".$model->amount.", value_for_money = ((".$model->amount." / bid_amount) / 100000) WHERE movies_id = ".$model->movies_id." AND takings_end_date > NOW()"));
         if ($model->type != 'U')
            $leagueuser = LeagueUser::create( ['user_id'=>$model->users_id, 'league_id'=>$model->id, 'balance'=>100] );
    }
}