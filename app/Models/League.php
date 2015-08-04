<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class League extends Model {

    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'users_id'];


    public function Owner() {
        return $this->belongsTo("\App\Models\User", "users_id");
    }

    public function Players() {
        return $this->belongsToMany("\App\Models\User", "league_users", "league_id", "user_id");
    }
}
