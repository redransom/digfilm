<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeagueUser extends Model {

    //
    protected $table = 'league_users';
    protected $fillable = array('league_id', 'user_id', 'balance');
/*
    public static function clearBalances($id) {
        $this->where('leagues_id', $id)->update(['balance'=>100]);
    }*/
}
