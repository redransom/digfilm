<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteContent extends Model {

    //
    protected $table = 'site_content';
    protected $fillable = array('section', 'type', 'title', 'summary', 'body', 'thumbnail', 'main_image', 'owners_id', 'meta_keywords', 'meta_description', 'link_url');

    public function owner() {
        return $this->belongsTo("\App\Models\User", "owners_id");
    }

    public function link() {
        return ((!is_null($this->slug) && $this->slug != "") ? $this->slug : $this->id);
    }

}
