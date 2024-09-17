<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    protected $table = 'calendars';

    public $timestamps = false;
    
    public function language() {
        
        return $this->belongsTo('App\Language');
    }

    public function addedEvents() {
        
        return $this->hasMany('App\CalendarAddedEvent','calendar_id','id');
    }

    public function getEvents() {
        
        return $this->hasMany('App\CalendarAddedEvent','calendar_id','id');
    }

    public static function getCalenderDropdown(){

        return self::get();    
    }
}
