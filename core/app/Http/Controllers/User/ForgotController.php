<?php

namespace App\Http\Controllers\User;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use App\Language;
use Session;
use App\BasicExtra;
use Str;

class ForgotController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest');
    }


    public function showForgotForm()
    {
        $bex = BasicExtra::first();

        if ($bex->is_user_panel == 0) {
            return back();
        }

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $be = $currentLang->basic_extended;
        $version = getVersion($be->theme_version);

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;
        if($version=='apper-theme')
        {
            return view('front.theme.forgot', $data);
        }
        return view('front.forgot', $data);
    }

    public function forgot(Request $request)
    {

        $request->validate([
            'email' => 'required'
        ]);
        // Validation Starts
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $input =  $request->all();
        $be = $currentLang->basic_extended;

        if (User::where('email', '=', $request->email)->count() > 0) {
            // user found
            $admin = User::where('email', '=', $request->email)->firstOrFail();
            $autopass = Str::random(8);
            $input['password'] = bcrypt($autopass);
            $admin->update($input);
            $subject = __("Reset Password Request");
            $msg = __("Your New Password is : ") . $autopass;

            $mail = new PHPMailer(true);


            if ($be->is_smtp == 1) {

                $emailTemplate = \App\EmailTemplate::where('id', \App\EmailTemplate::RESET_PASSWORD_REQUEST)
                    ->where('status', 1)
                    ->first();

                if (isset($emailTemplate) && !empty($emailTemplate)) {

                    try {
                        //Server settings
                        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                        if($be->mail_driver == \App\BasicExtended::MAIL_DRIVER_SMTP){

                            $mail->isSMTP();

                        }elseif($be->mail_driver == \App\BasicExtended::MAIL_DRIVER_MAIL){

                            $mail->isMail();

                        }elseif($be->mail_driver == \App\BasicExtended::MAIL_DRIVER_IS_SEND_MAIL){

                            $mail->isSendMail();
                        }                                          // Send using SMTP
                        $mail->Host       = $be->smtp_host;                    // Set the SMTP server to send through
                        $mail->SMTPAuth   = ($be->is_smtp_auth == 1) ? true : false;                               // Enable SMTP authentication
                        $mail->Username   = $be->smtp_username;                     // SMTP username
                        $mail->Password   = \Crypt::decryptString($be->smtp_password);                               // SMTP password
                        $mail->SMTPSecure = $be->encryption;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                        $mail->Port       = $be->smtp_port;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                        //Recipients
                        $mail->setFrom($be->from_mail, $be->from_name);
                        $mail->addAddress($request->email);     // Add a recipient

                        // Add attachments

                        // Content
                        $mail->isHTML(true);


                        $mail->Subject = $emailTemplate->subject;

                        $emailTemplate->body_content = str_replace(array('###PASSWORD_CODE###'), array($autopass), $emailTemplate->body_content);

                        $mail->Body = view('email_template.transactional.common_email_template', compact('emailTemplate'));

                        $mail->send();
                    } catch (Exception $e) {
                        die($e->getMessage());
                    }
                }
            }

            Session::flash('success', 'Your Password Reseted Successfully. Please Check your email for new Password.');

            return back();
        } else {

            // user not found
            Session::flash('err', 'No Account Found With This Email.');
            return back();
        }
    }
}
