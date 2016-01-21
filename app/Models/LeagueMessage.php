<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeagueMessage extends Model {

    //
    protected $table = 'league_messages';
    protected $fillable = array('leagues_id', 'owners_id', 'message', 'read_date');

    public function owner() {
        return $this->belongsTo("\App\Models\User", "owners_id");
    }
}
