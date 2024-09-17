<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rekognition extends Model
{
   	public function language() {
        return $this->belongsTo('App\Language');
    }
    
}
