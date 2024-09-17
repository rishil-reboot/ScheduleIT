<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    public $timestamps = true;

    public function bcategory() {
      return $this->belongsTo('App\Bcategory');
    }

    public function adverticement() {

      return $this->belongsTo('App\Adverticement','adverticement_id','id')
                    ->where('status',1);

    }
    
    public function language() {
        return $this->belongsTo('App\Language');
    }
}
