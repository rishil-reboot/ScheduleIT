<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailServer extends Model
{
    protected $table = 'email_server';

    public $timestamps = false;
    
    const YAHOO_COSNT = 4;
    
    public static function getEmailServerDropdown(){

        return self::get();    
    }
}
