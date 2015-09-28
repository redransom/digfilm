<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model {

    //
    protected $table = 'genres';
    protected $fillable = array('name');

    //TODO: Has many movies..
    public function movies() {
        return $this->hasMany("\App\Models\Movie", 'genres_id', 'id');
    }

    public function movie_count() {
        return $this->movies()->count();
    }

}