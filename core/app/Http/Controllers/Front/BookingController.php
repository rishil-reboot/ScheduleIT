<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\BookingService;
use App\BookingSchedule;
use App\Booking;
use App\BookingDetail;
use App\User;
use Validator;
use DateTime;
use DatePeriod;
use DateInterval;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\Frontend\BookingMail;
use App\Mail\Admin\BookingStatusMail;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use App\Language;

class BookingController extends Controller {
    
    protected $serviceList;
    protected $auth;
    
    public function __construct() {
        
        $this->basicSetting = \App\BasicSetting::first();
        $this->auth = \Auth::user();
        $this->pageLimit = config('settings.pageLimitFront');
        $this->serviceList = ['' => 'Select Service'] + BookingService::pluck('title', 'id')->all();
    }

    public function index(Request $request) {
        
        //reset search
        if ($request->isMethod('post')) {
            $request->session()->forget('SEARCH');
        }
        //end code
        if ($request->has('reset')) {
            $request->session()->forget('SEARCH');
            return redirect()->route('front.booking.search');
        }
        $serviceList = $this->serviceList;
        
        $user_id = \Auth::user()->id;

        if ($request->get('search_by') != ''){
            session(['SEARCH.SEARCH_BY' => trim($request->get('search_by'))]);
        }
        
        if ($request->get('search_txt') != '') {
            session(['SEARCH.SEARCH_TXT' => trim($request->get('search_txt'))]);
        }
        
        if ($request->get('service_id') != '') {
            session(['SEARCH.SERVICE_ID' => trim($request->get('service_id'))]);
        }
        
        if ($request->get('search_date') != '') {
            session(['SEARCH.SEARCH_DATE' => trim($request->get('search_date'))]);
        }
        
        $query = Booking::select('*')->where('user_id',$user_id);
        if ($request->session()->get('SEARCH.SEARCH_BY') != '') {
            
            if ($request->session()->get('SEARCH.SEARCH_BY') == 'service') {
                $query->where('service_id', $request->session()->get('SEARCH.SERVICE_ID'));
            }
            
            if ($request->session()->get('SEARCH.SEARCH_BY') == 'name') {
                $query->where('full_name', 'LIKE', '%' . $request->session()->get('SEARCH.SEARCH_TXT') . '%');
            }
            
            if ($request->session()->get('SEARCH.SEARCH_BY') == 'email') {
                $query->where('email', 'LIKE', '%' . $request->session()->get('SEARCH.SEARCH_TXT') . '%');
            }
            
            if ($request->session()->get('SEARCH.SEARCH_BY') == 'phone') {
                $query->where('phone', 'LIKE', '%' . $request->session()->get('SEARCH.SEARCH_TXT') . '%');
            }
            
            if ($request->session()->get('SEARCH.SEARCH_BY') == 'booking_date') {
                $date = date('Y-m-d',strtotime($request->session()->get('SEARCH.SEARCH_DATE')));
                
                $queryDate = BookingDetail::select('booking_id');
                $queryDate->where(DB::raw("date(start_time)"),'=',$date);
                $bookingIdArray = $queryDate->orderBy('start_time', 'DESC')->get()->toArray();
                $query->whereIn('id', $bookingIdArray);
            }
            
            $bookings = $query->orderBy('created_at','desc')->paginate($this->pageLimit);

            return view('front.booking.booking.bookingList',  compact('bookings','serviceList'));
            
        } else {
            $bookings = $query->orderBy('created_at','desc')->paginate($this->pageLimit);
        }

        return view('front.booking.booking.bookingList', compact('bookings','serviceList'));
    }

    /**
     * Store a newly created booking in storage.
     *
     * @return Response
     */
    public function store(Request $request) {

        if (session()->has('lang')) {
            
            $currentLang = Language::where('code', session()->get('lang'))->first();

        } else {

            $currentLang = Language::where('is_default', 1)->first();
        }

        $bs = $currentLang->basic_setting;
        $be = $currentLang->basic_extended;

        $rules = array(
            'full_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required'
        );

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $service = BookingService::find($data['service_id']);
        $amount = $service->price * count($request->get('spots'));
        
        $bs = $this->basicSetting;

        //check available credit before booking
        $user_id = \Auth::user()->id;
        $credit = \Auth::user()->credit;
        
        if (isset($bs) && $bs->booking_payment == 1) {
            
            if($credit<$amount){
                return redirect()->back()->with('error_message',trans('user/booking.booking_error_message'))->withInput();
            }
        }

        //end code
        
        $data['user_id'] = \Auth::user()->id;
        $data['amount'] = $amount;
        $data['status'] = 'pending';
        
        $booking = Booking::create($data);
        $lastInsertId = $booking->id;
        //$lastInsertId = 2;
        
        if (isset($bs) && $bs->booking_payment == 1) {

            //update user credit
            $newCredit = $credit - $amount;
            User::where('id', $user_id)->update(array('credit' => $newCredit));
            //end code
        }
        
        
        //store booking spots
        if ($request->get('spots')) {
            $resevationDate = date('Y-m-d',$request->get('reservation_date'));
            //echo $resevationDate;
            for($i=0;$i< count($request->get('spots'));$i++){
                    $timeArray = explode('-', $data['spots'][$i]);
                    $start_time =  $resevationDate.' '.$timeArray[0];
                    $end_time =  $resevationDate.' '.$timeArray[1];
                    //echo $start_time."==".$end_time."<br>";
                    $c = new BookingDetail;
                    $c->booking_id = $lastInsertId;
                    $c->start_time = $start_time;
                    $c->end_time = $end_time;
                    $c->save();
            }
        }
        //end code
        
        //send booking mail to user and bcc to admin

        $basicExtendedSetting = \App\BasicExtended::first();

        if (isset($basicExtendedSetting) && $basicExtendedSetting->is_smtp == 1) {

            try{

                $mail = new PHPMailer(true);

                $mail->isSMTP();
                $mail->Host       = $be->smtp_host;
                $mail->SMTPAuth   = ($be->is_smtp_auth == 1) ? true : false;
                $mail->Username   = $be->smtp_username;
                $mail->Password   = \Crypt::decryptString($be->smtp_password);
                $mail->SMTPSecure = $be->encryption;
                $mail->Port       = $be->smtp_port;

                //Recipients
                $mail->setFrom($be->from_mail, $be->from_name);
                $mail->addAddress(\Auth::user()->email);     // Add a recipient
                $mail->addBcc($basicExtendedSetting->from_mail);     // Add a recipient

                // Content
                $mail->isHTML(true);
                $subject = $bs->website_title.' Booking';
                $mail->Subject = $subject;

                $bodyMain = view('front.emails.booking',compact('booking'))->render();

                $mail->Body    = $bodyMain;
                $mail->send();


            }
            catch(\Exception $e){

            }
        }

        // Send mail to admin assign user 

        $serviceAdminUser = \App\BookingServiceAdminUser::where('booking_service_id',$service->id)
                                                        ->pluck('admin_id')
                                                        ->unique()
                                                        ->toArray();

        
        if (isset($serviceAdminUser) && !empty($serviceAdminUser)) {

            $assignUser = \App\Admin::whereIn('id',$serviceAdminUser)
                                    ->where('status',1)
                                    ->get();

            if(!$assignUser->isEmpty()){

                try {
                    
                    $formattedEvents = [];

                    $icsData = $booking->bookingDetail;

                    if (isset($icsData) && !$icsData->isEmpty()) {
                        
                        define('ICAL_FORMAT', 'Ymd\THis\Z');

                        $icalObject = "BEGIN:VCALENDAR
                               VERSION:2.0
                               METHOD:PUBLISH
                               PRODID:-//Charles Oduk//Tech Events//EN\n";

                        foreach($icsData as $key => $v) {

                            $startDate = strtotime($v->start_time);
                            $sdate = date('Y-m-d H:i' ,$startDate);
                            
                            $endDate = strtotime($v->end_time);
                            $edate = date('Y-m-d H:i' ,$endDate);
                            

                            $icalObject .=
                                       "BEGIN:VEVENT
                                       DTSTART:" . date(ICAL_FORMAT, strtotime($sdate)) . "
                                       DTEND:" .  date(ICAL_FORMAT, strtotime($edate)) . "
                                       DTSTAMP:" . date(ICAL_FORMAT, strtotime($booking->created_at)) . "
                                       SUMMARY: ". $booking->service->title ."
                                       UID: ". $v->id ."
                                       STATUS:" . strtoupper("Today") . "
                                       LAST-MODIFIED:" . date(ICAL_FORMAT, strtotime($v->updated_at)) . "
                                       LOCATION: 
                                       DESCRIPTION: ". '' ."
                                       END:VEVENT\n";   
                        }

                        // close calendar
                       $icalObject .= "END:VCALENDAR";

                       // Set the headers
                       header('Content-type: text/calendar; charset=utf-8');
                       header('Content-Disposition: attachment; filename="'.$booking->service->title.'_'.$booking->id.'.ics"');

                       $filename = $booking->service->title.'_'.$booking->id.'.ics';

                       $icalObject = str_replace(' ', '', $icalObject);

                       \Storage::put('assets/booking/uploadfile/' . $filename , $icalObject);
                       \File::move(getBasePath().'/core/storage/app/assets/booking/uploadfile/'.$filename,getBasePath().'/assets/booking/uploadfile/'.$filename);     
                    }
                    

                   // echo $icalObject;
       
                    foreach($assignUser as $key=>$v){

                        $mail = new PHPMailer(true);

                        if($be->mail_driver == \App\BasicExtended::MAIL_DRIVER_SMTP){

                            $mail->isSMTP();
                        
                        }elseif($be->mail_driver == \App\BasicExtended::MAIL_DRIVER_MAIL){
                        
                            $mail->isMail();
                        
                        }elseif($be->mail_driver == \App\BasicExtended::MAIL_DRIVER_IS_SEND_MAIL){
                        
                            $mail->isSendMail();
                        }
                        $mail->Host       = $be->smtp_host;
                        $mail->SMTPAuth   = ($be->is_smtp_auth == 1) ? true : false;
                        $mail->Username   = $be->smtp_username;
                        $mail->Password   = \Crypt::decryptString($be->smtp_password);
                        $mail->SMTPSecure = $be->encryption;
                        $mail->Port       = $be->smtp_port;

                        //Recipients
                        $mail->setFrom($be->from_mail, $be->from_name);

                        $nameOfUser = $v->first_name .' '.$v->last_name;
                        $mail->addAddress($v->email,$nameOfUser);     // Add a recipient
                        // Content
                        $mail->isHTML(true);
                        $mail->Subject = "Service ".$service->title.' Booked';

                        if (isset($icsData) && !$icsData->isEmpty()) {
                            
                            $filename = $booking->service->title.'_'.$booking->id.'.ics';
                            $filePath = getBasePath().'/assets/booking/uploadfile/'.$filename;
                            if (file_exists($filePath)) {

                                $mail->addAttachment('assets/booking/uploadfile/' . $filename);         // Add attachments
                            }
                        }


                        $htmlData = view('mail.booking._send_mail_to_assign_user', compact('booking','service','data','nameOfUser'))->render();

                        $mail->Body = $htmlData;
                        $mail->send();
                    
                    }
                

                } catch(\Exception $e) {

                }

            }   

        }

            
        return redirect('user/booking')->with('success', trans('user/booking.booking_success_message'));
    }
    
    /**
     *  export transactions-list.csv
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request) {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=bookings-list.csv');
        $output = fopen('php://output', 'w');
        fputcsv($output, array('Service', 'Name', 'Email', 'Mobile', 'Credits', 'Date','Booking Status'));

        $user_id = \Auth::user()->id;
        $bookings = Booking::where('user_id',$user_id)->orderBy('created_at','DESC')->get();
        foreach ($bookings as $data) {
            $date = '';
            $spots = $data->bookingDetail;
            foreach ($spots as $key => $spot){
                $date .= ' ('.($key+1).') '.date('d-m-Y h:i A', strtotime($spot->start_time)) .'to'. date('d-m-Y h:i A', strtotime($spot->end_time));
            }
            fputcsv($output, array(
                $data->service->title,
                $data->full_name,
                $data->email,
                $data->phone,
                $data->amount,
                $date,
                $data->status
                    )
            );
        }
        fclose($output);
        exit;
    }
    
    /**
     * check booking status and refund credit to user if their booking is still pending and date was passed.
     * 
     * @author Dhaval
     * @param  Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function cronBookingStatus(){

        if (session()->has('lang')) {
            
            $currentLang = Language::where('code', session()->get('lang'))->first();

        } else {

            $currentLang = Language::where('is_default', 1)->first();
        }

        $bs = $currentLang->basic_setting;
        $be = $currentLang->basic_extended;

        //get pending bookings whose date has been passed
        $bookings = Booking::select('bookings.*','bd.start_time','bd.end_time')
                    ->join('bookings_details as bd','bookings.id','=','bd.booking_id')
                    ->where('status','pending')
                    ->where(DB::raw("date(start_time)"),'<=',date("Y-m-d"))->groupBy('bookings.id')->get();
        foreach ($bookings as $key => $booking){
            $booking->status = 'cancel';
            $booking->save();
            $user = User::find($booking->user_id);
            $user->credit = $user->credit + $booking->amount;
            $user->save();
            
            $userEmail = $user->email;
            //send booking mail to user and bcc to admin
            
            try{

                $mail = new PHPMailer(true);

                if($be->mail_driver == \App\BasicExtended::MAIL_DRIVER_SMTP){

                    $mail->isSMTP();
                
                }elseif($be->mail_driver == \App\BasicExtended::MAIL_DRIVER_MAIL){
                
                    $mail->isMail();
                
                }elseif($be->mail_driver == \App\BasicExtended::MAIL_DRIVER_IS_SEND_MAIL){
                
                    $mail->isSendMail();
                }
                $mail->Host       = $be->smtp_host;
                $mail->SMTPAuth   = ($be->is_smtp_auth == 1) ? true : false;
                $mail->Username   = $be->smtp_username;
                $mail->Password   = \Crypt::decryptString($be->smtp_password);
                $mail->SMTPSecure = $be->encryption;
                $mail->Port       = $be->smtp_port;

                //Recipients
                $mail->setFrom($be->from_mail, $be->from_name);
                $mail->addAddress($userEmail);     // Add a recipient

                // Content
                $mail->isHTML(true);
                $subject = $bs->website_title.' Booking Status';
                $mail->Subject = $subject;

                $bodyMain = view('admin.emails.bookingStatus',compact('booking'))->render();

                $mail->Body    = $bodyMain;
                $mail->send();


            }catch(\Exception $e){

            }

        }
    }

    public function show(Request $request){

    }
}   