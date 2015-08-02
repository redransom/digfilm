<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model {

    //
    protected $fillable = array('name', 'summary', 'genre', 'rating', 'budget');

    public function contributors() {
        return $this->hasMany("\App\Models\Contributors", "movies_contributors", "movies_id", "contributors_id");
    }

}
