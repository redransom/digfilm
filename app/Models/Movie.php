<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model {

    //
    protected $fillable = array('name', 'summary', 'genres_id', 'rating', 'budget', 'enabled', 'release_at', 'availability', 'slug');

    public function contributors() {
        return $this->belongsToMany("\App\Models\Contributor", "movies_contributors", "movies_id", "contributors_id")->withPivot('contributor_types_id');
    }

    public function takings() {
        return $this->hasMany("\App\Models\MovieTaking", 'movies_id', 'id');
    }

    public function media() {
        return $this->hasMany("\App\Models\MovieMedia", 'movies_id', 'id');
    }

    public function leagues() {
        return $this->belongsToMany("\App\Models\League", "league_movies", "movies_id", "leagues_id");
    }

    public function genre() {
        return $this->belongsTo("\App\Models\Genre", 'genres_id');
    }
}
