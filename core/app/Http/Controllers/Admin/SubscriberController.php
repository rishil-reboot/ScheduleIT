<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Subscriber;
use App\BasicSetting;
use App\Mail\ContactMail;
use Session;
use Mail;
use Validator;
use Rap2hpoutre\FastExcel\FastExcel;

class SubscriberController extends Controller
{
    public function index() {
      $data['subscs'] = Subscriber::orderBy('id', 'DESC')->get();
      return view('admin.subscribers.index', $data);
    }

    public function mailsubscriber() {
      return view('admin.subscribers.mail');
    }


    public function edit($subscriberId)
    {
        $data['subscriber'] = Subscriber::findOrFail($subscriberId);
        return view('admin.subscribers.edit', $data);
    }

    public function update(Request $request)
    {

        $messages = [

            'email.check_subscriber_email_exit'=>"This email address is already used."
        ];

        $rules = [

            'email' => 'required|email|CheckSubscriberEmailExit:'.$request->subscriberid.'',
        ];

        $validator = Validator::make($request->all(), $rules,$messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $subscriberId = $request->subscriberid;

        $subscriber = Subscriber::findOrFail($subscriberId);
        $subscriber->email = $request->email;
        $subscriber->save();

        Session::flash('success', 'Subscriber updated successfully!');
        return "success";
    }

    public function subscsendmail(Request $request) {
      $request->validate([
        'subject' => 'required',
        'message' => 'required'
      ]);

      $sub = $request->subject;
      $msg = $request->message;

      $subscs = Subscriber::all();
      $settings = BasicSetting::first();
      $from = $settings->contact_mail;


      Mail::to($subscs)->send(new ContactMail($from, $sub, $msg, true));

      Session::flash('success', 'Mail sent successfully!');
      return back();
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        foreach ($ids as $id) {
            $subscriber = Subscriber::findOrFail($id);
            $subscriber->delete();
        }

        Session::flash('success', 'Subscriber deleted successfully!');
        return "success";
    }

    /**
     * This function is used to export subscriber
     * @author Chirag Ghevariya
     */
    public function export(Request $request){

        $data = Subscriber::all();

        return (new FastExcel($data))->download('subscriber.xlsx', function ($user) {
            return [
                'Email' => $user->email
            ];
        });

    }

    /**
     * This function is used to import subscribers
     * @author Chirag Ghevariya
     */
    public function import(Request $request){

        $input = $request->all();

        $rules = [
            'import_file' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $media_type_image_upload = $request->file('import_file');

        $allowedExts = array('xlsx','xls');
        $rules = [
            'import_file' => [
                function ($attribute, $value, $fail) use ($media_type_image_upload, $allowedExts) {
                    if (!empty($media_type_image_upload)) {
                        $ext = $media_type_image_upload->getClientOriginalExtension();
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only xlsx, xls, file is allowed.");
                        }
                    }
                },
            ],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        if($request->hasFile('import_file')){

            $subscriber = (new FastExcel)->import($request->file('import_file')->getRealPath(), function ($data) {
                        
                            if (isset($data['Email']) && !empty($data['Email'])) {

                                $record = Subscriber::where('email',$data['Email'])->first();

                                if ($record == null) {
                                    $obj = new Subscriber;
                                    $obj->email = $data['Email'];
                                    $obj->save(); 
                                }
                            }
                        });
        }

        Session::flash('success', 'Subscriber successfully imported!');
        return "success";
    }
}
