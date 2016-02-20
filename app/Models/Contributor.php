<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contributor extends Model {

    //
    protected $fillable = array('first_name', 'surname', 'thumbnail', 'meta_keywords', 'meta_description');

    public function movies() {
        return $this->belongsToMany("\App\Models\Movie", "movies_contributors", "contributors_id", "movies_id");
    }
}
