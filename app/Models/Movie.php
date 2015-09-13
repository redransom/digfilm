<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model {

    //
    protected $fillable = array('name', 'summary', 'genre', 'rating', 'budget', 'enabled');

    public function Contributors() {
        return $this->belongsToMany("\App\Models\Contributor", "movies_contributors", "movies_id", "contributors_id")->withPivot('contributor_types_id');
    }

    public function Takings() {
        return $this->hasMany("\App\Models\MovieTaking", 'movies_id', 'id');
    }

    public function Media() {
        return $this->hasMany("\App\Models\MovieMedia", 'movies_id', 'id');
    }

    public function Leagues() {
        return $this->belongsToMany("\App\Models\League", "league_movies", "movies_id", "leagues_id");
    }


}
