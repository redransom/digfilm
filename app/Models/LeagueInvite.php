<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeagueInvite extends Model {

    //
    protected $table = 'league_invites';
    protected $fillable = array('leagues_id', 'users_id', 'name', 'email', 'status');
}
