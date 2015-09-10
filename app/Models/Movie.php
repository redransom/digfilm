<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model {

    //
    protected $fillable = array('name', 'summary', 'genre', 'rating', 'budget', 'enabled');

    public function contributors() {
        return $this->belongsToMany("\App\Models\Contributor", "movies_contributors", "movies_id", "contributors_id")->withPivot('contributor_types_id');
    }

    public function takings() {
        return $this->hasMany("\App\Models\MovieTaking", 'movies_id', 'id');
    }

    public function media() {
        return $this->hasMany("\App\Models\MovieMedia", 'movies_id', 'id');
    }
}
