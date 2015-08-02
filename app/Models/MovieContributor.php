<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovieContributor extends Model {

    //
    protected $fillable = array('movie_id', 'contributor_id', 'star');
}
