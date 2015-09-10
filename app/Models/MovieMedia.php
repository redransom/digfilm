<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovieMedia extends Model {

    //
    protected $fillable = array('name', 'file_name', 'movies_id', 'description', 'type');

}
