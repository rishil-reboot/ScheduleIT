<?php

namespace App\Http\Controllers\Admin;

use Session;
use Validator;
use App\Gallery;
use App\Calendar;
use App\Language;
use App\CalendarEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CalendarController extends Controller
{
    public function index(Request $request) 
    {
        $data['events'] = CalendarEvent::orderBy('id','DESC')->paginate(10);
        
        return view('admin.calendar.index', $data);
    }

    public function create(){
        $data['mediaData'] = Gallery::all();
        return view('admin.calendar.create',$data);
    }

    public function edit($id){
        $data['mediaData'] = Gallery::all();
        $data['event'] = CalendarEvent::findOrFail($id);
        return view('admin.calendar.edit', $data);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $rules = [
            'title' => 'required|max:255',
        ];

        if ($input['is_recurring'] == 1) {
            
            $rules['start_date'] = 'required';
            $rules['end_date']  = 'required';
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return redirect()->back()->with('errors',$validator->errors());
        }

        $calendar = new CalendarEvent;
        $calendar->title = $request->title;
       
        if ($input['is_recurring'] == 1) {
            
            $calendar->start_date = $request->start_date;
            $calendar->end_date = $request->end_date;

        }else{

            $calendar->start_date = Null;
            $calendar->end_date = Null;
        }

        $calendar->event_note = $request->event_note;
        $calendar->notes = $request->notes;
        $calendar->is_featured = isset($request->is_featured) ? $request->is_featured : 2;

        $calendar->is_recurring = $request->is_recurring;

        if ($request->is_recurring == 2) {

            $calendar->recurring_type = $request->recurring_type;

            if ($calendar->recurring_type == 'yearly') {
                
                $calendar->yearly_type = $request->yearly_type;     
                $calendar->yearly_on_month = $request->yearly_on_month;     
                $calendar->yearly_on_day = $request->yearly_on_day;     
                $calendar->yearly_on_the_setpos = $request->yearly_on_the_setpos;     
                $calendar->yearly_on_the_mixday = $request->yearly_on_the_mixday;     
                $calendar->yearly_on_the_month = $request->yearly_on_the_month;         

                $calendar->monthly_every_month = Null;
                $calendar->monthly_type = Null;
                $calendar->monthly_on_day_days = Null;
                $calendar->monthly_on_the_setpos = Null;
                $calendar->monthly_on_the_mixdays = Null;

                $calendar->weekly_every_week = Null;
                $calendar->weekly_days = Null;

                $calendar->daily_days = Null;
                
                $calendar->hourly_hour = Null;

            }elseif($calendar->recurring_type == 'monthly'){

                $calendar->monthly_every_month = (!empty($request->monthly_every_month)) ? $request->monthly_every_month : 1;
                $calendar->monthly_type = $request->monthly_type;
                $calendar->monthly_on_day_days = $request->monthly_on_day_days;
                $calendar->monthly_on_the_setpos = $request->monthly_on_the_setpos;
                $calendar->monthly_on_the_mixdays = $request->monthly_on_the_mixdays;

                $calendar->yearly_type = Null;     
                $calendar->yearly_on_month = Null;     
                $calendar->yearly_on_day = Null;     
                $calendar->yearly_on_the_setpos = Null;     
                $calendar->yearly_on_the_mixday = Null;     
                $calendar->yearly_on_the_month = Null;     

                $calendar->weekly_every_week = Null;
                $calendar->weekly_days = Null;

                $calendar->daily_days = Null;
                
                $calendar->hourly_hour = Null;

            }elseif($calendar->recurring_type == 'weekly'){

                $calendar->weekly_every_week = (!empty($request->weekly_every_week)) ? $request->weekly_every_week : 1;
                $calendar->weekly_days = implode(',',$request->weekly_days);

                $calendar->yearly_type = Null;     
                $calendar->yearly_on_month = Null;     
                $calendar->yearly_on_day = Null;     
                $calendar->yearly_on_the_setpos = Null;     
                $calendar->yearly_on_the_mixday = Null;     
                $calendar->yearly_on_the_month = Null;     

                $calendar->monthly_every_month = Null;
                $calendar->monthly_type = Null;
                $calendar->monthly_on_day_days = Null;
                $calendar->monthly_on_the_setpos = Null;
                $calendar->monthly_on_the_mixdays = Null;

                $calendar->daily_days = Null;
                
                $calendar->hourly_hour = Null;

            }elseif($calendar->recurring_type == 'daily'){


                $calendar->daily_days =(!empty($request->daily_days)) ? $request->daily_days : 1 ;

                $calendar->yearly_type = Null;     
                $calendar->yearly_on_month = Null;     
                $calendar->yearly_on_day = Null;     
                $calendar->yearly_on_the_setpos = Null;     
                $calendar->yearly_on_the_mixday = Null;     
                $calendar->yearly_on_the_month = Null;     

                $calendar->monthly_every_month = Null;
                $calendar->monthly_type = Null;
                $calendar->monthly_on_day_days = Null;
                $calendar->monthly_on_the_setpos = Null;
                $calendar->monthly_on_the_mixdays = Null;

                $calendar->weekly_every_week = Null;
                $calendar->weekly_days = Null;

                $calendar->hourly_hour = Null;

            }elseif($calendar->recurring_type == 'hourly'){

                $calendar->hourly_hour = (!empty($request->hourly_hour)) ? $request->hourly_hour : 1;

                $calendar->yearly_type = Null;     
                $calendar->yearly_on_month = Null;     
                $calendar->yearly_on_day = Null;     
                $calendar->yearly_on_the_setpos = Null;     
                $calendar->yearly_on_the_mixday = Null;     
                $calendar->yearly_on_the_month = Null;     

                $calendar->monthly_every_month = Null;
                $calendar->monthly_type = Null;
                $calendar->monthly_on_day_days = Null;
                $calendar->monthly_on_the_setpos = Null;
                $calendar->monthly_on_the_mixdays = Null;

                $calendar->weekly_every_week = Null;
                $calendar->weekly_days = Null;

                $calendar->daily_days = Null;

            }

            $calendar->recurring_end_action = $request->recurring_end_action;
            $calendar->end_after_count = ($calendar->recurring_end_action == 'after') ? $request->end_after_count : Null;
            $calendar->end_on_date = ($calendar->recurring_end_action == 'date') ? $request->end_on_date : Null;

        }else{

            $calendar->recurring_type = Null;     
            
            $calendar->yearly_type = Null;     
            $calendar->yearly_on_month = Null;     
            $calendar->yearly_on_day = Null;     
            $calendar->yearly_on_the_setpos = Null;     
            $calendar->yearly_on_the_mixday = Null;     
            $calendar->yearly_on_the_month = Null;     

            $calendar->monthly_every_month = Null;
            $calendar->monthly_type = Null;
            $calendar->monthly_on_day_days = Null;
            $calendar->monthly_on_the_setpos = Null;
            $calendar->monthly_on_the_mixdays = Null;

            $calendar->weekly_every_week = Null;
            $calendar->weekly_days = Null;

            $calendar->daily_days = Null;
            
            $calendar->hourly_hour = Null;

            $calendar->recurring_end_action = Null;
            $calendar->end_after_count = Null;
            $calendar->end_on_date = Null;

        }

        $calendar->save();

        Session::flash('success', 'Event added to calendar successfully!');
        return redirect()->back()->with('success','Event added to calendar successfully!');
    }

    public function update(Request $request)
    {

        $input = $request->all();

        $messages = [
            'start_date.required' => 'Event period is required',
            'end_date.required' => 'Event period is required',
        ];

        $rules = [
            'title' => 'required|max:255',
        ];

        if($input['is_recurring'] == 1) {
            
            $rules['start_date'] = 'required';
            $rules['end_date']  = 'required';
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $calendar = CalendarEvent::findOrFail($request->event_id);
        $calendar->title = $request->title;
        

        if ($input['is_recurring'] == 1) {
            
            $calendar->start_date = $request->start_date;
            $calendar->end_date = $request->end_date;

        }else{

            $calendar->start_date = Null;
            $calendar->end_date = Null;
        }
                
        $calendar->event_note = $request->event_note;
        $calendar->notes = $request->notes;
        $calendar->is_featured = isset($request->is_featured) ? $request->is_featured : 2;

        $calendar->is_recurring = $request->is_recurring;

        if ($request->is_recurring == 2) {

            $calendar->recurring_type = $request->recurring_type;

            if ($calendar->recurring_type == 'yearly') {
                
                $calendar->yearly_type = $request->yearly_type;     
                $calendar->yearly_on_month = $request->yearly_on_month;     
                $calendar->yearly_on_day = $request->yearly_on_day;     
                $calendar->yearly_on_the_setpos = $request->yearly_on_the_setpos;     
                $calendar->yearly_on_the_mixday = $request->yearly_on_the_mixday;     
                $calendar->yearly_on_the_month = $request->yearly_on_the_month;         

                $calendar->monthly_every_month = Null;
                $calendar->monthly_type = Null;
                $calendar->monthly_on_day_days = Null;
                $calendar->monthly_on_the_setpos = Null;
                $calendar->monthly_on_the_mixdays = Null;

                $calendar->weekly_every_week = Null;
                $calendar->weekly_days = Null;

                $calendar->daily_days = Null;
                
                $calendar->hourly_hour = Null;

            }elseif($calendar->recurring_type == 'monthly'){

                $calendar->monthly_every_month = $request->monthly_every_month;
                $calendar->monthly_type = $request->monthly_type;
                $calendar->monthly_on_day_days = $request->monthly_on_day_days;
                $calendar->monthly_on_the_setpos = $request->monthly_on_the_setpos;
                $calendar->monthly_on_the_mixdays = $request->monthly_on_the_mixdays;

                $calendar->yearly_type = Null;     
                $calendar->yearly_on_month = Null;     
                $calendar->yearly_on_day = Null;     
                $calendar->yearly_on_the_setpos = Null;     
                $calendar->yearly_on_the_mixday = Null;     
                $calendar->yearly_on_the_month = Null;     

                $calendar->weekly_every_week = Null;
                $calendar->weekly_days = Null;

                $calendar->daily_days = Null;
                
                $calendar->hourly_hour = Null;

            }elseif($calendar->recurring_type == 'weekly'){

                $calendar->weekly_every_week = $request->weekly_every_week;
                $calendar->weekly_days = implode(',',$request->weekly_days);

                $calendar->yearly_type = Null;     
                $calendar->yearly_on_month = Null;     
                $calendar->yearly_on_day = Null;     
                $calendar->yearly_on_the_setpos = Null;     
                $calendar->yearly_on_the_mixday = Null;     
                $calendar->yearly_on_the_month = Null;     

                $calendar->monthly_every_month = Null;
                $calendar->monthly_type = Null;
                $calendar->monthly_on_day_days = Null;
                $calendar->monthly_on_the_setpos = Null;
                $calendar->monthly_on_the_mixdays = Null;

                $calendar->daily_days = Null;
                
                $calendar->hourly_hour = Null;

            }elseif($calendar->recurring_type == 'daily'){


                $calendar->daily_days = $request->daily_days;

                $calendar->yearly_type = Null;     
                $calendar->yearly_on_month = Null;     
                $calendar->yearly_on_day = Null;     
                $calendar->yearly_on_the_setpos = Null;     
                $calendar->yearly_on_the_mixday = Null;     
                $calendar->yearly_on_the_month = Null;     

                $calendar->monthly_every_month = Null;
                $calendar->monthly_type = Null;
                $calendar->monthly_on_day_days = Null;
                $calendar->monthly_on_the_setpos = Null;
                $calendar->monthly_on_the_mixdays = Null;

                $calendar->weekly_every_week = Null;
                $calendar->weekly_days = Null;

                $calendar->hourly_hour = Null;

            }elseif($calendar->recurring_type == 'hourly'){

                $calendar->hourly_hour = $request->hourly_hour;

                $calendar->yearly_type = Null;     
                $calendar->yearly_on_month = Null;     
                $calendar->yearly_on_day = Null;     
                $calendar->yearly_on_the_setpos = Null;     
                $calendar->yearly_on_the_mixday = Null;     
                $calendar->yearly_on_the_month = Null;     

                $calendar->monthly_every_month = Null;
                $calendar->monthly_type = Null;
                $calendar->monthly_on_day_days = Null;
                $calendar->monthly_on_the_setpos = Null;
                $calendar->monthly_on_the_mixdays = Null;

                $calendar->weekly_every_week = Null;
                $calendar->weekly_days = Null;

                $calendar->daily_days = Null;

            }

            $calendar->recurring_end_action = $request->recurring_end_action;
            $calendar->end_after_count = ($calendar->recurring_end_action == 'after') ? $request->end_after_count : Null;
            $calendar->end_on_date = ($calendar->recurring_end_action == 'date') ? $request->end_on_date : Null;

        }else{

            $calendar->recurring_type = Null;     
            
            $calendar->yearly_type = Null;     
            $calendar->yearly_on_month = Null;     
            $calendar->yearly_on_day = Null;     
            $calendar->yearly_on_the_setpos = Null;     
            $calendar->yearly_on_the_mixday = Null;     
            $calendar->yearly_on_the_month = Null;     

            $calendar->monthly_every_month = Null;
            $calendar->monthly_type = Null;
            $calendar->monthly_on_day_days = Null;
            $calendar->monthly_on_the_setpos = Null;
            $calendar->monthly_on_the_mixdays = Null;

            $calendar->weekly_every_week = Null;
            $calendar->weekly_days = Null;

            $calendar->daily_days = Null;
            
            $calendar->hourly_hour = Null;

            $calendar->recurring_end_action = Null;
            $calendar->end_after_count = Null;
            $calendar->end_on_date = Null;

        }

        $calendar->save();

        Session::flash('success', 'Event date updated in calendar successfully!');
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $calendar = CalendarEvent::findOrFail($request->event_id);
        $calendar->delete();

        Session::flash('success', 'Event deleted successfully!');
        return back();
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        foreach ($ids as $id) {
            $calendar = CalendarEvent::findOrFail($id);
            $calendar->delete();
        }

        Session::flash('success', 'Events deleted successfully!');
        return "success";
    }    

    public function indexCommunityCalendar(Request $request) 
    {
        $data['communityCalendar'] = Calendar::orderBy('id', 'DESC')->paginate(10);
        $data['calendarEvents'] = CalendarEvent::get();
        return view('admin.community_calendar.index', $data);
    }

    public function storeCommunityCalendar(Request $request)
    {
        
        $messages = [

            "slug.check_calendar_slug" => "This slug is already in used.",  
            "view.required" => "Please select view mode to see calendar."  
        ];     
        

        $rules = [
            'name' => 'required|max:255',
            'slug' => 'required|CheckCalendarSlug',
            'view' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules,$messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());

        }

        $calendar = new Calendar;
        $calendar->name = $request->name;
        $calendar->slug = make_slug($request->slug);
        $calendar->view = $request->view;
        $calendar->meta_title = $request->meta_title;
        $calendar->meta_keywords = $request->meta_keywords;
        $calendar->meta_description = $request->meta_description;
        
        $calendar->save();

        $saveEvent = (new \App\CalendarAddedEvent)->saveUpdateCalendarAddEvent($request,$calendar->id);

        Session::flash('success', 'Calendar added successfully!');
        return "success";
    }


    public function editCommunityCalendar($id) 
    {
        $data['communityCalendar'] = Calendar::with(['addedEvents'])->findOrFail($id);
        $data['calendarEvents'] = CalendarEvent::get();

        return view('admin.community_calendar.edit', $data);
    }

    public function updateCommunityCalendar(Request $request)
    {
        $messages = [

            "slug.check_calendar_slug" => "This slug is already in used."  
        ];     
        

        $rules = [
            'name' => 'required|max:255',
            'slug' => 'required|CheckCalendarSlug:'.$request->calandar_id.'',
            "view.required" => "Please select view mode to see calendar."  
        ];

        $validator = Validator::make($request->all(), $rules,$messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return redirect()->back()->with('errors',$validator->errors());
        }

        $calendar = Calendar::findOrFail($request->calandar_id);
        $calendar->name = $request->name;
        $calendar->slug = make_slug($request->slug);
        $calendar->view = $request->view;
        $calendar->meta_title = $request->meta_title;
        $calendar->meta_keywords = $request->meta_keywords;
        $calendar->meta_description = $request->meta_description;
        $calendar->save();

        $saveEvent = (new \App\CalendarAddedEvent)->saveUpdateCalendarAddEvent($request,$calendar->id);
        
        Session::flash('success', 'Calendar updated successfully!');
        return back();
    }

    /**
     * This function is used to delete calendar
     * @author Chirag Ghevariya
     */
    public function deleteCommunityCalendar(Request $request)
    {
        $calendar = Calendar::findOrFail($request->calendar_id);
        $calendar->delete();

        Session::flash('success', 'Calendar deleted successfully!');
        return back();
    }

    /**
     * This function is used to delete calendar 
     * @author Chirag Ghevariya
     */
    public function bulkDeleteCommunityCalendar(Request $request)
    {
        $ids = $request->ids;

        foreach ($ids as $id) {
            $calendar = Calendar::findOrFail($id);
            $calendar->delete();
        }

        Session::flash('success', 'Calendar deleted successfully!');
        return "success";
    }

    /**
     * This function is used to add bulk event to single calendar
     * @author Chirag Ghevariya
     */
    public function addEventToCalendar(Request $request){

        $input = $request->all();

        if (isset($input['ids']) && !empty($input['ids'])) {
            
            foreach ($input['ids'] as $key => $value) {

                $record = \App\CalendarAddedEvent::where('calendar_id',$input['calendar_id'])
                                        ->where('calendar_event_id',$value)
                                        ->first();

                if ($record == null) {

                    $obj = new \App\CalendarAddedEvent;    
                    $obj->calendar_id = $input['calendar_id'];
                    $obj->calendar_event_id =  $value;
                    $obj->save();
                }                        
            }
        }

        Session::flash('success', 'Events are successfully added in calendar list!');
        return "success";
    }
    
    /**
     * This function is used to show all calendar event to single calendar
     * @author Chirag Ghevariya
     */
    public function showCommunityCalendar($id){

        if (session()->has('lang')) {
            $currentLang = \App\Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = \App\Language::where('is_default', 1)->first();
        }

        $bs = $currentLang->basic_setting;

        $calendar = \App\Calendar::with(['addedEvents'])
                                          ->where('id',$id)
                                          ->firstOrFail();
        $formattedEvents = [];

         if (isset($calendar) && !$calendar->addedEvents->isEmpty()) {
            
            foreach($calendar->addedEvents as $key => $event) {

                if ($event->calendarEvent !=null) {

                    $formattedEvents["$key"]['title'] = $event->calendarEvent->title;
                    $event_note = $event->event_note;
                    $formattedEvents["$key"]['description'] = strip_tags($event->event_note);

                    if($event->calendarEvent->is_recurring == 1){

                        $startDate = strtotime($event->calendarEvent->start_date);
                        $formattedEvents["$key"]['start'] = date('Y-m-d H:i' ,$startDate);

                        $endDate = strtotime($event->calendarEvent->end_date);
                        $formattedEvents["$key"]['end'] = date('Y-m-d H:i' ,$endDate);

                        $formattedEvents["$key"]['color'] = "#f09238"; // yellow

                    }else{

                        if ($event->calendarEvent->recurring_type == 'yearly') {
                                
                            $formattedEvents["$key"]['rrule']['freq'] = 'yearly';
                                
                            // 1 On // 2 On the  
                            if ($event->calendarEvent->yearly_type == 1) {

                                $formattedEvents["$key"]['rrule']['bymonth'] = $event->calendarEvent->yearly_on_month;
                                $formattedEvents["$key"]['rrule']['bymonthday'] = $event->calendarEvent->yearly_on_day;

                            }elseif($event->calendarEvent->yearly_type == 2){
                                
                                $formattedEvents["$key"]['rrule']['bysetpos'] = [$event->calendarEvent->yearly_on_the_setpos];
                                $formattedEvents["$key"]['rrule']['byyearday'] = [$event->calendarEvent->yearly_on_the_mixday];
                                $formattedEvents["$key"]['rrule']['bymonth'] = $event->calendarEvent->yearly_on_the_month;
                            }

                            $formattedEvents["$key"]['color'] = "#ff4081";

                        }elseif($event->calendarEvent->recurring_type == 'monthly'){

                            $formattedEvents["$key"]['rrule']['freq'] = 'monthly';
                            $formattedEvents["$key"]['rrule']['interval'] = $event->calendarEvent->monthly_every_month;

                            // 1 On day // 2 On the  
                            if ($event->calendarEvent->monthly_type == 1) {

                                $formattedEvents["$key"]['rrule']['bymonthday'] = $event->calendarEvent->monthly_on_day_days;

                            }elseif($event->calendarEvent->monthly_type == 2){
                                
                                $formattedEvents["$key"]['rrule']['bysetpos'] = [$event->calendarEvent->monthly_on_the_setpos];
                                $formattedEvents["$key"]['rrule']['bymonthday'] = [$event->calendarEvent->monthly_on_the_mixdays];
                            }

                            $formattedEvents["$key"]['color'] = "#6256a9";

                        }elseif($event->calendarEvent->recurring_type == 'weekly'){
                            // dd($event->calendarEvent->weekly_days);
                            $formattedEvents["$key"]['rrule']['freq'] = 'weekly';
                            $formattedEvents["$key"]['rrule']['interval'] = $event->calendarEvent->weekly_every_week;
                            $formattedEvents["$key"]['rrule']['byweekday'] = [$event->calendarEvent->weekly_days];
                            $formattedEvents["$key"]['color'] = "#04aec6"; // ferozi

                        }elseif ($event->calendarEvent->recurring_type == 'hourly') {
                            
                            $formattedEvents["$key"]['rrule']['freq'] = 'hourly';
                            $formattedEvents["$key"]['rrule']['interval'] = $event->calendarEvent->hourly_hour;
                            $formattedEvents["$key"]['color'] = "#3d5afe"; // blue

                        }elseif($event->calendarEvent->recurring_type == 'daily') {

                            $formattedEvents["$key"]['rrule']['freq'] = 'daily';
                            $formattedEvents["$key"]['rrule']['interval'] = $event->calendarEvent->daily_days;
                            $formattedEvents["$key"]['color'] = "#000";
                        
                        }   

                        if ($event->calendarEvent->recurring_end_action == 'after') {
                            
                            $formattedEvents["$key"]['rrule']['count'] = $event->calendarEvent->end_after_count;

                        }elseif($event->calendarEvent->recurring_end_action == 'date'){
                            
                            $formattedEvents["$key"]['rrule']['until'] = $event->calendarEvent->end_on_date;
                        }

                    }   
                }
            }
        }
        
        $data["formattedEvents"] = $formattedEvents;
        $data["calendar"] = $calendar;
        $data['themeSetting'] = $bs;

        return view('admin.community_calendar._get_calendar_view', $data);
    }

    /**
     * This function is used to export single caledar all event data
     * @author Chirag Ghevariya 
     */
    public function exportCommunityCalendar($id){

        $calendar = \App\Calendar::with(['addedEvents'])
                                          ->where('id',$id)
                                          ->firstOrFail();

        $formattedEvents = [];

        define('ICAL_FORMAT', 'Ymd\THis\Z');

        $icalObject = "BEGIN:VCALENDAR
                       VERSION:2.0
                       METHOD:PUBLISH
                       PRODID:-//Charles Oduk//Tech Events//EN\n";

        if (isset($calendar) && !$calendar->addedEvents->isEmpty()) {
            
            foreach($calendar->addedEvents as $key => $event) {

                if ($event->calendarEvent !=null) {
                    
                    $startDate = strtotime($event->calendarEvent->start_date);
                    $sdate = date('Y-m-d H:i' ,$startDate);
                    
                    $endDate = strtotime($event->calendarEvent->end_date);
                    $edate = date('Y-m-d H:i' ,$endDate);
                    
                    $icalObject .=
                               "BEGIN:VEVENT
                               DTSTART:" . date(ICAL_FORMAT, strtotime($sdate)) . "
                               DTEND:" .  date(ICAL_FORMAT, strtotime($edate)) . "
                               DTSTAMP:" . date(ICAL_FORMAT, strtotime($event->calendarEvent->created_at)) . "
                               SUMMARY: ". $event->calendarEvent->title ."
                               UID: ". $event->id ."
                               STATUS:" . strtoupper("Today") . "
                               LAST-MODIFIED:" . date(ICAL_FORMAT, strtotime($event->calendarEvent->updated_at)) . "
                               LOCATION: 
                               DESCRIPTION: ". $event->calendarEvent->notes ."
                               END:VEVENT\n";   
                }
                
            }

        }     
        // close calendar
       $icalObject .= "END:VCALENDAR";

       // Set the headers
       header('Content-type: text/calendar; charset=utf-8');
       header('Content-Disposition: attachment; filename="'.$calendar->name.'.ics"');
      
       $icalObject = str_replace(' ', '', $icalObject);
  
       echo $icalObject;
    }      

    public function calendarSetting(){

        
        $data['abs'] = \App\BasicSetting::first();
        $data['abe'] = \App\BasicExtended::first();

        return view('admin.calendar.settings', $data);        
    }

    public function updateCalendarSetting(Request $request)
    {

        $bss = \App\BasicSetting::all();

        foreach ($bss as $key => $bs) {
            $bs->download_calendar = $request->download_calendar;
            $bs->show_calendar_public_facing = $request->show_calendar_public_facing;
            $bs->calendar_theme = $request->calendar_theme;
            $bs->save();
        }

        Session::flash('success', 'Calendar section successfully updated!');
        return back();
    }

    public function changeRepeatIntervalType(Request $request){

        $input = $request->all();
        
        $event = null;   
        if(isset($input['eventId'])){

            $event = CalendarEvent::where('id',$input['eventId'])->first();    

        }   

        return view('admin.calendar._recurring_event_type_action',compact('input','event'));

    }

    public function changeEndActionType(Request $request){

        $input = $request->all();
        
        $event = null;   
        if(isset($input['eventId'])){

            $event = CalendarEvent::where('id',$input['eventId'])->first();    

        }   
        return view('admin.calendar._recurring_end_action',compact('input','event'));

    }
}

