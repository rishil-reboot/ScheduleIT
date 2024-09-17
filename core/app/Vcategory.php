<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vcategory extends Model
{
    

    public function videos() {
      return $this->hasMany('App\Videos');
    }

    public function language() {
        return $this->belongsTo('App\Language');
    }
}
