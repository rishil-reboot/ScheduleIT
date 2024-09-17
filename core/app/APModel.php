<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class APModel extends Model
{
    protected $table = "azure_person_model";


    public function videos() {
    	
      return $this->hasMany('App\Videos');
    }

    public function language() {
        return $this->belongsTo('App\Language');
    }
}
