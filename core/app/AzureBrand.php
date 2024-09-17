<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AzureBrand extends Model
{
    
	public function videos() {
      return $this->hasMany('App\Videos');
    }

    public function language() {
        return $this->belongsTo('App\Language');
    }
}
