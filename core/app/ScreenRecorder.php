<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScreenRecorder extends Model
{
    protected $table = 'screen_recorder';
    
    public function language() {
        return $this->belongsTo('App\Language');
    }
}
