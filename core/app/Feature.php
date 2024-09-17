<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Page;

class Feature extends Model
{
    public $timestamps = false;

    public function language() {
        return $this->belongsTo('App\Language');
    }

    public function page() {
        return $this->belongsTo('App\Page','page_id','id');
    }
}
