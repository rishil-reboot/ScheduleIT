<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

    protected $table = 'clients';
    
    public $timestamps = false;

    public function language() {
        return $this->belongsTo('App\Language');
    }
}
