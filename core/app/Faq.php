<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    public $timestamps = false;

    public function language() {
        return $this->belongsTo('App\Language');
    }

}
