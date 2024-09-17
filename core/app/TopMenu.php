<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TopMenu extends Model
{
    protected $table = 'top_menus';
    
    public function language() {
        return $this->belongsTo('App\Language');
    }
}
