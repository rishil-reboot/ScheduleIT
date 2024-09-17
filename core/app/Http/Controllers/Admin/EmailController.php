<?php

namespace App\Http\Controllers\Admin;

use App\BasicExtended;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Illuminate\Contracts\Encryption\DecryptException;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function mailFromAdmin() {
        $data['abe'] = BasicExtended::first();
        // dd(\Crypt::decryptString($data['abe']->smtp_password));

        $data['bcategorys'] = \App\EmailTemplate::orderBy('id', 'ASC')
                                            ->paginate(10);
                                            
        return view('admin.basic.email.mail_from_admin', $data);
    }

    public function updateMailFromAdmin(Request $request) {
        $messages = [
            'from_mail.required_if' => 'The smtp host field is required when smtp status is active.',
            'from_name.required_if' => 'The from name field is required when smtp status is active.',
            'smtp_host.required_if' => 'The smtp host field is required when smtp status is active.',
            'smtp_port.required_if' => 'The smtp port field is required when smtp status is active.',
            'encryption.required_if' => 'The encryption field is required when smtp status is active.',
            'smtp_username.required_if' => 'The smtp username field is required when smtp status is active.',
            'smtp_password.required_if' => 'The smtp password field is required when smtp status is active.'
        ];

        $request->validate([
            'from_mail' => 'required_if:is_smtp,1',
            'from_name' => 'required_if:is_smtp,1',
            'is_smtp' => 'required',
            'mail_driver' => 'required',
            'is_smtp_auth' => 'required',
            'smtp_host' => 'required_if:is_smtp,1',
            'smtp_port' => 'required_if:is_smtp,1',
            'encryption' => 'required_if:is_smtp,1',
            'smtp_username' => 'required_if:is_smtp,1',
            'smtp_password' => 'required_if:is_smtp,1',
        ], $messages);

        $bes = BasicExtended::all();
        foreach ($bes as $key => $be) {
            $be->from_mail = $request->from_mail;
            $be->from_name = $request->from_name;
            $be->is_smtp = $request->is_smtp;
            $be->smtp_host = $request->smtp_host;
            $be->smtp_port = $request->smtp_port;
            $be->encryption = $request->encryption;
            $be->smtp_username = $request->smtp_username;
            $be->mail_driver = $request->mail_driver;
            $be->is_smtp_auth = $request->is_smtp_auth;
            $be->smtp_password = CommonFunctionForMailString($request->smtp_password,$be->smtp_password,100);
            
            
            $be->save();
        }

        Session::flash('success', 'SMTP configuration updated successfully!');
        return back();
    }

    public function mailToAdmin() {
        $data['abe'] = BasicExtended::first();
        return view('admin.basic.email.mail_to_admin', $data);
    }

    public function updateMailToAdmin(Request $request) {
        $messages = [
            'to_mail.required' => 'Mail Address is required.'
        ];

        $request->validate([
            'to_mail' => 'required',
        ], $messages);

        $bes = BasicExtended::all();
        foreach ($bes as $key => $be) {
            $be->to_mail = $request->to_mail;
            $be->save();
        }

        Session::flash('success', 'Mail address updated successfully!');
        return back();
    }

    public function sendTestUpdate(Request $request) {
        // dd("inm");
        $messages = [
            'test_mail_to.required' => 'This email address field is required.',
        ];

        $request->validate([
            'test_mail_to' => 'required|email',
        ], $messages);


        $bse = \App\BasicExtended::get();

        foreach($bse as $key=>$be){

            $be->test_mail_to = $request->test_mail_to;
            $be->email_template_id = $request->email_template_id;
            $be->save();
        }

        $be = \App\BasicExtended::first();
        
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
        $mail->addAddress($request->test_mail_to, "Test");

        // Content
        $mail->isHTML(true);
        $emailTemplate = \App\EmailTemplate::where('id',$request->email_template_id)->first();
        if (isset($emailTemplate) && !empty($emailTemplate)) {
            
            $mail->Subject = $emailTemplate->subject;
            $mail->Body    = view('email_template.transactional.common_email_template',compact('emailTemplate'))->render();

        }else{

            $mail->Subject = "Test mail.";
            $mail->Body    = "test mail check content";
        }
        $mail->send();
        
        Session::flash('success', 'Test mail successfully send!');
        return back();

    }
}
