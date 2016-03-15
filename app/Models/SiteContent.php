<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteContent extends Model {

    //
    protected $table = 'site_content';
    protected $fillable = array('section', 'type', 'title', 'summary', 'body', 'thumbnail', 'main_image', 'owners_id', 'meta_keywords', 'meta_description', 'link_url', 'enabled');

    public function owner() {
        return $this->belongsTo("\App\Models\User", "owners_id");
    }

    public function link() {
        return ((!is_null($this->slug) && $this->slug != "") ? $this->slug : $this->id);
    }

    public static function section($section) {
        return SiteContent::where('section', $section)->where('enabled', '1')->first();
    }

    public static function articles($number = 0) {
        return SiteContent::where('type', 'N')->where('enabled', '1')->orderBy('created_at', 'DESC')->limit($number)->get();
    }
}
