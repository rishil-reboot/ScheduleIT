<?php

namespace App\Http\Controllers\Payment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Language;
use App\OfflineGateway;
use App\Package;
use App\PackageInput;
use App\PackageOrder;
use App\PaymentGateway;
use PDF;

class PaystackController extends Controller
{
    public function store(Request $request)
    {
        // Validation Starts
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }



        $bex = $currentLang->basic_extra;
        $be = $currentLang->basic_extended;
        $package_inputs = $currentLang->package_inputs;

        $nda = $request->file('nda');
        $ndaIn = PackageInput::find(1);
        $allowedExts = array('doc', 'docx', 'pdf', 'rtf', 'txt', 'zip', 'rar');

        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'package_id' => 'required',
            'nda' => [
                function ($attribute, $value, $fail) use ($nda, $allowedExts) {

                    $ext = $nda->getClientOriginalExtension();
                    if (!in_array($ext, $allowedExts)) {
                        return $fail("Only doc, docx, pdf, rtf, txt, zip, rar files are allowed");
                    }
                }
            ]
        ];

        if ($ndaIn->required == 1 && $ndaIn->active == 1) {
            if (!$request->hasFile('nda')) {
                $rules["nda"] = 'required';
            }
        }

        foreach ($package_inputs as $input) {
            if ($input->required == 1) {
                $rules["$input->name"] = 'required';
            }
        }

        $conline  = PaymentGateway::whereStatus(1)->whereType('automatic')->count();
        $coffline  = OfflineGateway::wherePackageOrderStatus(1)->count();
        if ($conline + $coffline > 0) {
            $rules["method"] = 'required';
        }

        $request->validate($rules);
        // Validation Ends

        $package = Package::find($request->package_id);


        $fields = [];
        foreach ($package_inputs as $key => $input) {
            $in_name = $input->name;
            if ($request["$in_name"]) {
                $fields["$in_name"] = $request["$in_name"];
            }
        }
        $jsonfields = json_encode($fields);
        $jsonfields = str_replace("\/", "/", $jsonfields);

        $package = Package::findOrFail($request->package_id);

        $in = $request->all();
        $in['name'] = $request->name;
        $in['email'] = $request->email;
        $in['fields'] = $jsonfields;

        if ($request->hasFile('nda')) {
            $filename = uniqid() . '.' . $nda->getClientOriginalExtension();
            $nda->move('assets/front/ndas/', $filename);
            $in['nda'] = $filename;
        }

        $in['package_title'] = $package->title;
        $in['package_price'] = $package->price;
        $in['package_description'] = $package->description;
        $in['method'] = 'Paystack';
        $fileName = str_random(4).time().'.pdf';
        $in['invoice'] = $fileName;
        $in['payment_status'] = 1;
        $po = PackageOrder::create($in);


        $po->order_number = $po->id + 1000000000;
        $po->save();


        // sending datas to view to make invoice PDF
        $fields = json_decode($po->fields, true);
        $data['packageOrder'] = $po;
        $data['fields'] = $fields;

        // generate pdf from view using dynamic datas
        PDF::loadView('pdf.package', $data)->save('assets/front/invoices/' . $fileName);


        // Send Mail to Buyer
        $mail = new PHPMailer(true);

        if ($be->is_smtp == 1) {

            $emailTemplate = \App\EmailTemplate::where('id',\App\EmailTemplate::PACKAGE_ORDER_FOR_BUYER)
                                    ->where('status',1)
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
                    }                                       // Send using SMTP
                    $mail->Host       = $be->smtp_host;                    // Set the SMTP server to send through
                    $mail->SMTPAuth   = ($be->is_smtp_auth == 1) ? true : false;                             // Enable SMTP authentication
                    $mail->Username   = $be->smtp_username;                     // SMTP username
                    $mail->Password   = \Crypt::decryptString($be->smtp_password);                               // SMTP password
                    $mail->SMTPSecure = $be->encryption;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                    $mail->Port       = $be->smtp_port;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                    //Recipients
                    $mail->setFrom($be->from_mail, $be->from_name);
                    $mail->addAddress($request->email, $request->name);     // Add a recipient

                    // Attachments
                    $mail->addAttachment('assets/front/invoices/' . $fileName);         // Add attachments

                    // Content
                    $mail->isHTML(true);                                  // Set email format to HTML

                    $emailTemplate->subject = str_replace(array('###PACKAGE_TITLE###'), array($package->title), $emailTemplate->subject);
                    $mail->Subject = $emailTemplate->subject;

                    $emailTemplate->body_content = str_replace(array('###NAME###'), array($po->name), $emailTemplate->body_content);
                    $mail->Body = view('email_template.transactional.common_email_template',compact('emailTemplate'));

                    $mail->send();
                    
                } catch (Exception $e) {
                    // die($e->getMessage());
                }
            }   
                                             
        }


        // send mail to Admin
         $emailTemplate = \App\EmailTemplate::where('id',\App\EmailTemplate::PACKAGE_ORDER_FOR_ADMIN)
                                    ->where('status',1)
                                    ->first();

        // send mail to Admin

        if (isset($emailTemplate) && !empty($emailTemplate)) {

            try {

                $mail = new PHPMailer(true);
                $mail->setFrom($po->email, $po->name);
                $mail->addAddress($be->from_mail);     // Add a recipient

                // Attachments
                $mail->addAttachment('assets/front/invoices/' . $fileName);         // Add attachments

                // Content
                $mail->isHTML(true);  // Set email format to HTML
                
                $emailTemplate->subject = str_replace(array('###PACKAGE_TITLE###'), array($package->title), $emailTemplate->subject);
                $mail->Subject = $emailTemplate->subject;

                $emailTemplate->body_content = str_replace(array('###ORDER_NUMBER###'), array($po->order_number), $emailTemplate->body_content);
                $mail->Body = view('email_template.transactional.common_email_template',compact('emailTemplate'));

                $mail->send();
            } catch(\Exception $e) {
                // die($e->getMessage());
            }

        }


        session()->flash('success', 'Payment completed!');
        return redirect()->route('front.packageorder.confirmation', [$package->id, $po->id]);
    }
}
