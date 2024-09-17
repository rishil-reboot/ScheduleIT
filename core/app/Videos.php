<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Videos extends Model
{
    public $timestamps = false;
    protected $table = "azure_videos";
    public function vcategory() {
      return $this->belongsTo('App\Vcategory');
    }

    public function portfolios() {
      return $this->hasMany('App\Portfolio');
    }

    public function language() {
      return $this->belongsTo('App\Language');
    }
}
