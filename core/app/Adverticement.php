<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adverticement extends Model
{
    protected $table = 'advertisement';

    const ADVERTISEMENT_CONST_ONE = 1;
    const ADVERTISEMENT_CONST_TWO = 2;

    public function getDropdown(){

        return self::where('status',1)->pluck('name','id')->toArray();
    }

}
