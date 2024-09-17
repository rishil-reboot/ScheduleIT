<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AboutIntro extends Model
{
    protected $table = 'about_intro';

    public $timestamps = false;

    public function language() {
        return $this->belongsTo('App\Language');
    }
}
