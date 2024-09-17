<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Page;
use App\FormBuilder;
use App\Language;
use App\BasicSetting as BS;
use App\BasicExtended as BE;
use Session;
use Validator;
use App\FormSubmission;
use App\FormBuilderToMail;
use File;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Config;

class FormBuilderController extends Controller
{

    public function __construct()
    {
        $bs = BS::first();
        $be = BE::first();

        Config::set('captcha.sitekey', \Crypt::decryptString($bs->google_recaptcha_site_key));
        Config::set('captcha.secret', \Crypt::decryptString($bs->google_recaptcha_secret_key));
    }

    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();
        $lang_id =$lang->id;
        $data['apages'] = FormBuilder::where('language_id', $lang_id)->orderBy('id', 'DESC')->get();

        $data['lang_id'] = $lang_id;

        return view('admin.form_builder.index', $data);
    }

    public function create()
    {
        $data['tpages'] = FormBuilder::where('language_id', 0)->get();
        return view('admin.form_builder.create', $data);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $slug = make_slug($request->name);

        $messages = [
            'language_id.required' => 'The language field is required',
        ];

        $rules = [
            'language_id' => 'required',
            'name' => 'required|max:50|unique:form_builders',
            'body' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $form_builder = new FormBuilder;
        $form_builder->language_id = $request->language_id;
        $form_builder->name = $request->name;
        $form_builder->short_code = '['.strtolower(str_replace(' ', '_', $request->name)).']';

        $form_builder->body = $request->body;
        $form_builder->save();

        if (isset($input['to_email']) && !empty($input['to_email'])) {

            $obj = new FormBuilderToMail;
            $obj->user_id = $input['to_email'];
            $obj->form_builder_id = $form_builder->id;
            $obj->save();
        }

        Session::flash('success', 'Form created successfully!');
        return "success";
    }

    public function edit($pageID)
    {
        $data['form_builder'] = FormBuilder::with(['formBuilderToEmail'])->findOrFail($pageID);
        return view('admin.form_builder.edit', $data);
    }

    public function update(Request $request)
    {

        $input = $request->all();

        $slug = make_slug($request->name);

        $rules = [
            'name' => 'required|max:50|unique:form_builders,name,'.$request->id,
            'body' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $form_builderID = $request->id;

        $form_builder = FormBuilder::findOrFail($form_builderID);
        $form_builder->language_id = $request->language_id;
        $form_builder->name = $request->name;
        $form_builder->body = $request->body;
        $form_builder->save();

        FormBuilderToMail::where('form_builder_id',$form_builder->id)->delete();

        if (isset($input['to_email']) && !empty($input['to_email'])) {

                $obj = new FormBuilderToMail;
                $obj->user_id = $input['to_email'];
                $obj->form_builder_id = $form_builder->id;
                $obj->save();
        }

        Session::flash('success', 'Form updated successfully!');
        return "success";
    }

    public function delete(Request $request)
    {
        $pageID = $request->pageid;
        $page = FormBuilder::findOrFail($pageID);
        $page->delete();
        Session::flash('success', 'Form deleted successfully!');
        return redirect()->back();
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        foreach ($ids as $id) {
            $page = FormBuilder::findOrFail($id);
            $page->delete();
        }

        Session::flash('success', 'Forms deleted successfully!');
        return "success";
    }
    public function getFormBuilder($id)
    {
        $page = FormBuilder::findOrFail($id);
        echo $page->body;
    }
    public function postFormBuilder(Request $request)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $bs = $currentLang->basic_setting;

        $data = $request->all();

        $messages = [
            'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
            'g-recaptcha-response.captcha' => 'Captcha error! try again later or contact site admin.',
        ];

        $rules = [];

        if ($bs->is_recaptcha == 1) {

            $rules['g-recaptcha-response'] = 'required|captcha';

            $request->validate($rules, $messages);
        }

        $data = $request->all();
        foreach ($data as $key => $value) {
            if(is_array($value)) {
                $data[$key] = implode(',', $value);
            } else if(is_file($value)) {
                $file = $request->file($key);
                if($file) {
                    $destinationPath = 'assets/front/img/form_builder/';
                    if(!File::exists($destinationPath)) {
                        File::makeDirectory($destinationPath, 0777, true, true);
                    }
                    chmod($destinationPath, 0777);
                    $filename=uniqid().'-'.$file->getClientOriginalName();
                    $file->move($destinationPath,$filename);
                    $data[$key]=asset($destinationPath.$filename);
                }
            }

        }
        $form_data = new FormSubmission();
        $form_data->form_id = $data['form_id'];
        unset($data['form_id']);

        if(isset($data['g-recaptcha-response'])){

            unset($data['g-recaptcha-response']);
        }

        $form_data->json_data = json_encode($data);
        $form_data->save();

        $fromData = \App\FormBuilder::with(['formBuilderToEmail'=>function($query){

                                        $query->has('user');
                                    }])
                                    ->where('id',$form_data->form_id)->first();

        if (isset($fromData) && !$fromData->formBuilderToEmail->isEmpty()) {

                $emailTemplate = \App\EmailTemplate::where('id',\App\EmailTemplate::FORM_BUILDER_COMMON)
                                    ->where('status',1)
                                    ->first();

                if (isset($emailTemplate) && !empty($emailTemplate)) {

                    $be =  BE::firstOrFail();
                    try {

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

                        foreach($fromData->formBuilderToEmail as $key=>$v){

                            $mail->addAddress($v->user->email);     // Add a recipient
                        }

                        // Content
                        $mail->isHTML(true);

                        $mail->Subject = $fromData->name .' Inquiry';
                        $bodyMain = view('mail.form_builder_common',compact('fromData','data'))->render();

                        $emailTemplate->body_content = str_replace(array('###INQUIRY_NAME###','###DYNAMIC_CONTENT###'), array($fromData->name,$bodyMain), $emailTemplate->body_content);

                        $mail->Body = view('email_template.transactional.common_email_template',compact('emailTemplate'));

                        $mail->send();

                    } catch(\Exception $e) {
                        // die($e->getMessage());

                    }
                }
        }

        Session::flash('success', 'Form submitted successfully!');
        return "success";

    }
    public function formData($id)
    {
        $page = FormBuilder::findOrFail($id);
        $data['theads'] = json_decode($page->body,true);

        $data['form_data'] = FormSubmission::where('form_id',$id)->orderBy('id', 'desc')->paginate(10);

        return view('admin.form_builder.form_data', $data);
    }
    public function view($id)
    {
        $page = FormSubmission::findOrFail($id);
        $data['json_data'] = json_decode($page->json_data,true);
        $theads = FormBuilder::findOrFail($page->form_id);
        $data['theads'] = json_decode($theads->body,true);
        $data['form_id'] = $page->form_id;

        return view('admin.form_builder.view', $data);
    }
    public function deleteFormData($id)
    {
        $page = FormSubmission::findOrFail($id);
        $page->delete();
        return back()->with('success', 'Record deleted successfully!');
    }
}
