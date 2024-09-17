<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\Datatable\SSP;
use App\Helpers\Common;
use App\BookingService;
use App\User;
use App\Booking;
use App\BookingDetail;
use Validator;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\Admin\BookingStatusMail;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use App\Language;
use Session;

class BookingController extends Controller {

    /**
     * Booking Model
     * @var Booking
     */
    protected $booking;
    protected $pageLimit;
    protected $serviceList;

    /**
     * Inject the models.
     * @param Booking $booking
     */
    public function __construct(Booking $booking) {
        $this->booking = $booking;
        $this->pageLimit = config('settings.pageLimit');
        $this->serviceList = ['' => trans('admin/booking.select_service')] + BookingService::pluck('title', 'id')->all();
        $this->userList = ['' => trans('admin/booking.select_user')] + User::select('id','username')->pluck('username', 'id')->toArray();
    }

    /**
     * Display a listing of bookings
     *
     * @return Response
     */
    public function index(Request $request) {
        //reset search
        if ($request->isMethod('post')) {
            $request->session()->forget('SEARCH');
        }
        if ($request->has('reset')) {
            $request->session()->forget('SEARCH');
            return redirect()->back();
        }
        //end code
        
        if ($request->get('search_by') != '') {
            session(['SEARCH.SEARCH_BY' => trim($request->get('search_by'))]);
        }

        if ($request->get('search_txt') != '') {
            session(['SEARCH.SEARCH_TXT' => trim($request->get('search_txt'))]);
        }

        if ($request->get('service_id') != '') {
            session(['SEARCH.SERVICE_ID' => trim($request->get('service_id'))]);
        }

        if ($request->get('user_id') != '') {
            session(['SEARCH.USER_ID' => trim($request->get('user_id'))]);
        }

        if ($request->get('search_date') != '') {
            session(['SEARCH.SEARCH_DATE' => trim($request->get('search_date'))]);
        }
        
        $query = Booking::select('*');
        if ($request->session()->get('SEARCH.SEARCH_BY') != '') {
            $query = Booking::select('*');

            if ($request->session()->get('SEARCH.SEARCH_BY') == 'service') {
                $query->where('service_id', $request->session()->get('SEARCH.SERVICE_ID'));
            }

            if ($request->session()->get('SEARCH.SEARCH_BY') == 'user') {
                $query->where('user_id', $request->session()->get('SEARCH.USER_ID'));
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
                $date = date('Y-m-d', strtotime($request->session()->get('SEARCH.SEARCH_DATE')));

                $queryDate = BookingDetail::select('booking_id');
                $queryDate->where(DB::raw("date(start_time)"), '=', $date);
                $bookingIdArray = $queryDate->orderBy('start_time', 'DESC')->get()->toArray();
                $query->whereIn('id', $bookingIdArray);
            }

            $bookings = $query->orderBy('created_at', 'desc')->paginate($this->pageLimit);
        }else{
            $userId = request()->segment(3);
            if ($userId) {
                $bookings = $query->userBy($userId)->orderBy('created_at', 'DESC')->paginate($this->pageLimit);
            } else {
                $bookings = $query->orderBy('created_at', 'DESC')->paginate($this->pageLimit);
            }
        }

        // dd($bookings);
//        $bookings = $query->orderBy('created_at', 'DESC')->toSql();
//        echo $bookings;
//        $bindings = $query->getBindings();
//        dd($bindings);
        $serviceList = $this->serviceList;
        $userList = $this->userList;
        return view('admin/booking/booking/bookingList', compact('bookings', 'serviceList', 'userList'));
    }

    /**
     * Display the specified booking.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $booking = Booking::findOrFail($id);
        return view('admin/booking/booking/bookingDetails', compact('booking'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        Booking::destroy($id);

        Session::flash('success', trans('admin/booking.booking_delete_message'));
        $array = array();
        $array['success'] = true;
        //$array['message'] = 'Booking deleted successfully!';
        echo json_encode($array);
    }

    public function changeBookingStatus(Request $request) {

        if (session()->has('lang')) {
            
            $currentLang = Language::where('code', session()->get('lang'))->first();

        } else {

            $currentLang = Language::where('is_default', 1)->first();
        }

        $bs = $currentLang->basic_setting;
        $be = $currentLang->basic_extended;

        $data = $request->all();

        $booking = Booking::find($data['id']);
        $booking->status = $data['value'];
        $booking->save();

        if ($data['value'] == 'cancel') {
            $user = User::find($booking->user->id);
            $user->credit = $user->credit + $booking->amount;
            $user->save();
        }

        $userEmail = $booking->user->email;
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

        \Session::flash('success', trans('admin/booking.booking_status_message'));
        $array = array();
        $array['success'] = true;
        $array['message'] = trans('admin/booking.booking_status_message');
        echo json_encode($array);
    }

    /**
     *  export transactions-list.csv
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request) {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=bookings-list.csv');
        $output = fopen('php://output', 'w');
        fputcsv($output, array('Service', 'Name', 'Email', 'Mobile', 'Credits', 'Date', 'Booking Status'));

        $bookings = Booking::orderBy('created_at', 'DESC')->get();
        foreach ($bookings as $data) {
            $date = '';
            $spots = $data->bookingDetail;
            foreach ($spots as $key => $spot) {
                $date .= ' (' . ($key + 1) . ') ' . date('d-m-Y h:i A', strtotime($spot->start_time)) . 'to' . date('d-m-Y h:i A', strtotime($spot->end_time));
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

    public function setting(){

        
        $data['abs'] = \App\BasicSetting::first();
        $data['abe'] = \App\BasicExtended::first();

        return view('admin.booking.setting', $data);        
    }

    public function updateSettings(Request $request)
    {

        $bss = \App\BasicSetting::all();

        foreach ($bss as $key => $bs) {

            $bs->booking_payment = $request->booking_payment;
            $bs->save();
        }

        Session::flash('success', 'Booking payment successfully updated!');
        return back();
    }

        /**
     * This function is used to get email setting of booking while any booking spot time ending 
     * @author Chirag Ghevariya
     */
    public function emailSetting(){

        $data['abs'] = \App\BasicSetting::first();

        return view('admin.booking.email_setting', $data);        
    }

    /**
     * This function is use to store bookign spot email description data
     * @author Chirag Ghevariya
     */
    public function updateEmailSettings(Request $request){

        $bss = \App\BasicSetting::all();

        foreach ($bss as $key => $bs) {

            $bs->booking_spot_description = $request->booking_spot_description;
            $bs->save();
        }

        Session::flash('success', 'Booking email settings successfully updated!');
        return back();
    }

    /**
     * This function is used to send mail when booking spot time is over
     * @author Chirag Ghevariya
     */
    public function runBookingSpotCronJob(){


        $bookingSpotDetails = \App\BookingDetail::with(['booking'=>function($query){

                                    $query->where('status','confirm')
                                            ->whereHas('user',function($q){

                                                $q->where('status',1);
                                            })
                                            ->has('service');

                                }])
                                ->whereHas('booking',function($query){

                                    $query->where('status','confirm')
                                            ->whereHas('user',function($q){

                                                $q->where('status',1);
                                            })
                                            ->has('service');

                            })
                            ->whereDate('end_time','<',\Carbon\Carbon::now())
                            ->where('is_cone_run',2)
                            ->get();

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $bs = $currentLang->basic_setting;
        $be = $currentLang->basic_extended;

        if ($be->is_smtp == 1) {

            foreach($bookingSpotDetails as $key=>$v){


                // try {
                   
                    $obj = $v;
                    $obj->is_cone_run = 1;
                    $obj->save();

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
                   $mail->addAddress($v->booking->user->email, $v->booking->user->fname .' '.$v->booking->user->lname);

                   // Content
                   $mail->isHTML(true);

                   $mail->Subject = "Your booking spot time is over";
                   $mail->Body    = view('mail.booking.booking_spot_ending_time',compact('v','bs'))->render();
                   $mail->send();

                // } catch (Exception $e) {
                   

                // }
            }

        }

        return "success";
        
    }    

        /**
     * Display a listing of bookings
     *
     * @return Response
     */
    public function myBooking(Request $request) {

        $authDetail = \Auth::user();
        //reset search
        if ($request->isMethod('post')) {
            $request->session()->forget('SEARCH');
        }
        if ($request->has('reset')) {
            $request->session()->forget('SEARCH');
            return redirect()->back();
        }
        //end code
        
        if ($request->get('search_by') != '') {
            session(['SEARCH.SEARCH_BY' => trim($request->get('search_by'))]);
        }

        if ($request->get('search_txt') != '') {
            session(['SEARCH.SEARCH_TXT' => trim($request->get('search_txt'))]);
        }

        if ($request->get('service_id') != '') {
            session(['SEARCH.SERVICE_ID' => trim($request->get('service_id'))]);
        }

        if ($request->get('user_id') != '') {
            session(['SEARCH.USER_ID' => trim($request->get('user_id'))]);
        }

        if ($request->get('search_date') != '') {
            session(['SEARCH.SEARCH_DATE' => trim($request->get('search_date'))]);
        }
        
        $query = Booking::select('*')
                        ->whereHas('bookingServiceAdminUser',function($query) use($authDetail){

                            $query->where('admin_id',$authDetail->id);

                        });

        if ($request->session()->get('SEARCH.SEARCH_BY') != '') {
            $query = Booking::select('*');

            if ($request->session()->get('SEARCH.SEARCH_BY') == 'service') {
                $query->where('service_id', $request->session()->get('SEARCH.SERVICE_ID'));
            }

            if ($request->session()->get('SEARCH.SEARCH_BY') == 'user') {
                $query->where('user_id', $request->session()->get('SEARCH.USER_ID'));
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
                $date = date('Y-m-d', strtotime($request->session()->get('SEARCH.SEARCH_DATE')));

                $queryDate = BookingDetail::select('booking_id');
                $queryDate->where(DB::raw("date(start_time)"), '=', $date);
                $bookingIdArray = $queryDate->orderBy('start_time', 'DESC')->get()->toArray();
                $query->whereIn('id', $bookingIdArray);
            }

            $bookings = $query->orderBy('created_at', 'desc')->paginate($this->pageLimit);
        }else{
            $userId = request()->segment(3);
            if ($userId) {
                $bookings = $query->userBy($userId)->orderBy('created_at', 'DESC')->paginate($this->pageLimit);
            } else {
                $bookings = $query->orderBy('created_at', 'DESC')->paginate($this->pageLimit);
            }
        }

        $serviceList =  ['' => trans('admin/booking.select_service')] + BookingService::whereHas('bookingServiceUser',function($query){
            
                                    $query->where('admin_id',\Auth::user()->id);

                                })->pluck('title', 'id')->all();
        $userList = $this->userList;
        return view('admin/booking/booking/myBookingList', compact('bookings', 'serviceList', 'userList'));
    }
}
