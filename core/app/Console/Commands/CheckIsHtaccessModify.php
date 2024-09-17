<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use PHPMailer\PHPMailer\PHPMailer;
use App\Language;

class CheckIsHtaccessModify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:htaccess';
    protected $description = 'Check if .htaccess file is modified'; 

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $lang = Language::firstOrFail();
        $abs = $lang->basic_extra;

        if($abs->is_detect_htaccess_change == 1){

            $path = str_replace('/core','',base_path('.htaccess'));
        
            $storedTimestamp = Storage::get('htaccess_timestamp.txt');
            // dd($storedTimestamp);

            if(File::exists($path)) {
                $currentTimestamp = File::lastModified($path);
                // dd($currentTimestamp);
                if ($storedTimestamp !== false && $currentTimestamp > intval($storedTimestamp)) {
                    $this->sendEmailNotification();
                }

                Storage::put('htaccess_timestamp.txt', $currentTimestamp);
                $this->info('success');
            } else {
                $this->error('.htaccess file does not exist.');
            }
        }
    }

    protected function sendEmailNotification()
    {
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
        $mail->addAddress($be->to_mail, "Test");

        // Content
        $mail->isHTML(true);
        // $emailTemplate = \App\EmailTemplate::where('id',$request->email_template_id)->first();
        // if (isset($emailTemplate) && !empty($emailTemplate)) {
            
        //     $mail->Subject = $emailTemplate->subject;
        //     $mail->Body    = view('email_template.transactional.common_email_template',compact('emailTemplate'))->render();

        // }else{

            $mail->Subject = ".htaccess change detected!!!";
            $mail->Body    = "Tes from dev your htaccess has been changed";
        // }

        $mail->send();
    }
}
