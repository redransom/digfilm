<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contributor extends Model {

    //
    protected $fillable = array('first_name', 'surname', 'thumbnail');

    public function movies() {
        return $this->belongsToMany("\App\Models\Movie", "movies_contributors", "contributors_id", "movies_id");
    }
}
