<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Calendar;

class CalendarAddedEvent extends Model
{
    protected $table = 'calendar_added_events';
        
    public $timestamps = false;
    
    public function calendar() {
        
        return $this->belongsTo('App\Calendar','calendar_id','id');
    }

    public function calendarEvent(){

        return $this->belongsTo('App\CalendarEvent','calendar_event_id','id');
    }

    public function saveUpdateCalendarAddEvent($request,$id){

        self::where('calendar_id',$id)->delete();

        $input = $request->all();

        if (isset($input['event_id'])) {

            foreach($input['event_id'] as $key=>$v){

                $obj = new self;
                $obj->calendar_id = $id;
                $obj->calendar_event_id = $v;
                $obj->save();
            }
        }
    }
}
