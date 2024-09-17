<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\InboxwebmailAccount;
use App\InboxwebmailLabel;
use App\InboxwebmailInbox;
use App\InboxwebmailAttachment;
use App\InboxwebmailEmailParser;
use Illuminate\Http\Request;
use DB;
use Validator;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class InboxwebmailController extends Controller
{

    public function index()
    {
        $inboxwebmails = InboxwebmailAccount::paginate(20);

        return view('admin.inboxwebmail.index', compact('inboxwebmails'));
    }

    public function inboxwebmailAdd()
    {
        return view('admin.inboxwebmail.inboxwebmailAdd');
    }

    public function inboxwebmailPost(Request $request)
    {
        $rules = [
            'name'=>'required|max:50',
            'email'=>'required|email',
            'email_server_id'=>'required',
        ];


        if ($request->email_server_id == \App\EmailServer::YAHOO_COSNT) {

            $rules['secondary_password'] = 'required';
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }


        $emailServer = getEmailServerInfo($request->email_server_id);

        // if (function_exists('imap_open')) {
            // try {
                $email = strip_tags($request->email);
                $password = \Crypt::encryptString(strip_tags($request->password));
                $emailArr = explode("@", $email);
                $domain = $emailArr[1];
                $port = '993';
                $host_string = "{" . $domain . ":" . $port . "/imap/ssl/novalidate-cert}INBOX";
                // $mbox = imap_open($host_string, $email, $password);
                // if ($mbox) {
                    $property = new InboxwebmailAccount();
                    $property->name = strip_tags($request->name);
                    $property->email = strip_tags($request->email);
                    $property->password = $password;
                    $property->domain = $emailServer->domain;
                    $property->active = ($request->active)?1:0;
                    $property->d_from_server = ($request->d_from_server)?1:0;
                    $property->e_sign = strip_tags($request->e_sign);
                    $property->email_server_id = $request->email_server_id;
                    $property->secondary_password = ($request->email_server_id == \App\EmailServer::YAHOO_COSNT) ?  \Crypt::encryptString($request->secondary_password) : Null;
                    $property->save();
    
                    // assign default labels
                    $this->saveDefaultLabel($property->id);
                    // imap_close($mbox);
                    
                    \Session::flash('success',"Data saved successfully");
                    return "success";

                    // return redirect()->route('admin.inboxwebmails')->with('success', __('Data saved successfully'));
                // } else {


                //     \Session::flash('success',"Entered Email/password is not correct");
                //     return redirect()->route('admin.inboxwebmail.add');

                // }
            // } catch (\Exception $ex) {

            //     \Session::flash('success',"Entered Email/password is not correct");
            //     return redirect()->route('admin.inboxwebmail.add');
            // }
        // }else{
                
        //     \Session::flash('success',"IMAP function not enabled");
        //     return redirect()->route('admin.inboxwebmail.add');
        // }
    }

    private function saveDefaultLabel($account_id){
        
        $account_id = abs(intval($account_id));
        
        $label = new InboxwebmailLabel();
        $label->account_id = $account_id;
        $label->lb_name = 'Primary';
        $label->lb_code = '888888';
        $label->save();

        $label = new InboxwebmailLabel();
        $label->account_id = $account_id;
        $label->lb_name = 'Promotions';
        $label->lb_code = '1cbfd0';
        $label->save();

        $label = new InboxwebmailLabel();
        $label->account_id = $account_id;
        $label->lb_name = 'Social';
        $label->lb_code = '0c7ce6';
        $label->save();
        return true;
    }

    public function inboxwebmailEdit($id)
    {
        $id = abs(intval($id));
        $property = InboxwebmailAccount::findOrfail($id);
        $allLabelSelect = InboxwebmailLabel::where('account_id', $id)->get();
        return view('admin.inboxwebmail.inboxwebmailEdit', compact('property','allLabelSelect'));
    }


    public function inboxwebmailDelete($id)
    {
        $id = abs(intval($id));
        $property = InboxwebmailAccount::findOrfail($id);
        
        // delete all inbox data attachments
        $allData =  InboxwebmailInbox::where('account_id', $id)->get();
        foreach($allData as $inData){
            $dt_id = $inData->id;
            InboxwebmailAttachment::where("inbox_id", $dt_id)->delete();
            $absolute_path = 'assets/inboxWebmail_files/' . $dt_id;
            $this->inboxwebmail_delete_directory($absolute_path);
        }
        // delete all inbox data
        InboxwebmailInbox::where("account_id", $id)->delete();
        
        // delete all labels
         InboxwebmailLabel::where("account_id", $id)->delete();
        
        // delete account info
        $property->delete();
        
        \Session::flash('success','Data deleted successfully');

        return redirect()->route('admin.inboxwebmails');
    }

    public function inboxwebmailUpdate(Request $request, $id)
    {
        $rules = [
            'name'=>'required|max:50',
            'email'=>'required|email',
            'password'=>'required',
            'email_server_id'=>'required',
        ];

        if ($request->email_server_id == \App\EmailServer::YAHOO_COSNT) {

            $rules['secondary_password'] = 'required';
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $id = abs(intval($id));
        $property = InboxwebmailAccount::findOrfail($id);


        $emailServer = getEmailServerInfo($request->email_server_id);

        // if (function_exists('imap_open')) {
        //      try {
                $email = strip_tags($request->email);
                $password = \Crypt::encryptString(strip_tags($request->password));
                $emailArr = explode("@", $email);
                $domain = $emailArr[1];
                $port = '993';
                $host_string = "{" . $domain . ":" . $port . "/imap/ssl/novalidate-cert}INBOX";
                // $mbox = imap_open($host_string, $email, $password);
                // if ($mbox) {
                    $property->name = strip_tags($request->name);
                    $property->email = strip_tags($request->email);
                    $property->password = $password;
                    $property->domain = $domain;
                    $property->active = ($request->active)?1:0;
                    $property->d_from_server = ($request->d_from_server)?1:0;
                    $property->e_sign = strip_tags($request->e_sign);
                    $property->email_server_id = $request->email_server_id;
                    $property->secondary_password = ($request->email_server_id == \App\EmailServer::YAHOO_COSNT) ? \Crypt::encryptString($request->secondary_password): Null;
                    $property->save();
                    // imap_close($mbox);

                    \Session::flash("success","Data saved successfully");
                    return "success";

                // } else {
                //     return redirect()->back()->withErrors(__('Entered Email/password is not correct'));
                // }
            //  } catch (\Exception $ex) {
            //     return redirect()->back()->withErrors(__('Entered Email/password is not correct'));
            // }
        // }else{
        //     return redirect()->back()->withErrors(__('IMAP function not enabled'));
        // }
    }

    public function inboxwebmailLabels(Request $request, $id)
    {
        $id = abs(intval($id));
        $lbl_code = $request['lbl_code'];

        if(count($lbl_code)>0) {
            foreach ($request['lbl_name'] as $key => $lbs) {
                foreach ($lbs as $lid => $label) {
                    $code = $lbl_code[$key][$lid];
                    if ($label != '' && $code != '') {
                        if ($lid > 0) {
                            $lid = abs(intval($lid));
                            $data =  InboxwebmailLabel::findOrfail($lid);
                            $data->lb_name = strip_tags($label);
                            $data->lb_code = strip_tags($code);
                            $data->save();
                        } else {
                            $data = new InboxwebmailLabel();
                            $data->account_id = $id;
                            $data->lb_name = strip_tags($label);
                            $data->lb_code = strip_tags($code);
                            $data->save();
                        }
                    }
                }
            }
            return redirect()->route('admin.inboxwebmails')->with('success', __('Data saved successfully'));
        }else{
            return redirect()->back()->withErrors(__('Something went wrong'));
        }
    }

    public function inboxwebmailLabelDelete(Request $request)
    {
        $label = InboxwebmailLabel::findOrfail($request->label_id);
        $label->delete();
        return response()->json([
            'success' => __('Record deleted successfully')
        ]);
    }

    public function inboxwebmailView(Request $request, $uid)
    {
        $uid = abs(intval($uid));
        $inboxwebmailAccount = InboxwebmailAccount::findOrfail($uid);
        $allLabelSelect = InboxwebmailLabel::where('account_id', $uid)->get();

        if (isset($request->bulk_action) && $request->bulk_action != '') {
             $bulk_action = strip_tags($request->bulk_action);

            $idArr = $request->inbox;
            if (!empty($idArr) && is_array($idArr)) {
                foreach ($idArr as $dt_id) {
                    $dt_id = abs(intval($dt_id));
                    switch ($bulk_action) {
                        case 'read':
                            $data=  InboxwebmailInbox::findOrfail($dt_id);
                            $data->is_read = 1;
                            $data->save();
                            break;
                        case 'unread':
                            $data=  InboxwebmailInbox::findOrfail($dt_id);
                            $data->is_read = 0;
                            $data->save();
                            break;
                        case 'important':
                            $data=  InboxwebmailInbox::findOrfail($dt_id);
                            $data->is_important = 1;
                            $data->save();
                            break;
                        case 'unimportant':
                            $data=  InboxwebmailInbox::findOrfail($dt_id);
                            $data->is_important = 0;
                            $data->save();
                            break;
                        case 'star':
                            $data=  InboxwebmailInbox::findOrfail($dt_id);
                            $data->is_star = 1;
                            $data->save();
                            break;
                        case 'unstar':
                            $data=  InboxwebmailInbox::findOrfail($dt_id);
                            $data->is_star = 0;
                            $data->save();
                            break;
                        case 'moveinbox':
                            $data=  InboxwebmailInbox::findOrfail($dt_id);
                            $data->is_deleted = 0;
                            $data->save();
                            break;
                        case 'deletep':
                            $data=  InboxwebmailInbox::findOrfail($dt_id);
                            $data->delete();
                            InboxwebmailAttachment::where("inbox_id", $dt_id)->delete();
                            $absolute_path = 'assets/inboxWebmail_files/' . $dt_id;
                            $this->inboxwebmail_delete_directory($absolute_path);
                            break;
                        case 'delete':
                            $data=  InboxwebmailInbox::findOrfail($dt_id);
                            $data->is_deleted = 1;
                            $data->save();
                            break;
                        default:
                            $data=  InboxwebmailInbox::findOrfail($dt_id);
                            $data->is_label = $bulk_action;
                            $data->save();
                            break;
                    }
                }
                return redirect()->back()->with('success', __('Bulk Action performed'));
            } else {
                return redirect()->back()->withErrors(__('No any email selected'));
            }
        }

        if (isset($request->details) && is_numeric($request->details)) {
            $details_uid = abs(intval($request->details));

            $detailData =  InboxwebmailInbox::findOrfail($details_uid);
            if($detailData->account_id == $uid){
                $detailData->is_read = 1;
                $detailData->save();
                $detailAttachments =  InboxwebmailAttachment::where(['inbox_id'=>$details_uid])->get();
            }else{
                $detailAttachments = '';
                $detailData = '';
            }
        } else {
            $detailAttachments = '';
            $detailData = '';
        }

        $sub = '';
        $filter['account_id'] = $uid;
        if (isset($request->sub)) {
            $sub = strip_tags($request->sub);
            switch ($sub) {
                case 'inbox':
                    $filter['is_deleted'] = 0;
                    $filter['is_sent'] = 0;
                    $filter['is_draft'] = 0;
                    break;
                case 'sent':
                    $filter['is_deleted'] = 0;
                    $filter['is_sent'] = 1;
                    break;
                case 'important':
                    $filter['is_deleted'] = 0;
                    $filter['is_important'] = 1;
                    break;
                case 'star':
                    $filter['is_deleted'] = 0;
                    $filter['is_star'] = 1;
                    break;
                case 'trash':
                    $filter['is_deleted'] = 1;
                    break;
                default:
                    $filter['is_label'] = $sub;
                    break;
            }
        }else{
            //$filter .= ' and is_deleted =0 and is_sent =0 and is_draft =0';
            $filter['is_deleted'] = 0;
            $filter['is_sent'] = 0;
            $filter['is_draft'] = 0;
        }

        $inboxItems = InboxwebmailInbox::where($filter)->orderBy('created_at', 'desc')->paginate(20);

        $aj_url = route('admin.inboxwebmail.refdata',$uid).'?i=1';
        $compose_url = route('admin.inboxwebmail.compose',$uid).'?i=1';
        $current_url = route('admin.inboxwebmail.view',$uid).'?i=1';
        $allCounts = array();
        $allCounts['inbox'] = InboxwebmailInbox::where(['account_id'=>$uid,'is_deleted'=>0,'is_sent'=>0,'is_draft'=>0,'is_read'=>0])->count();
        $allCounts['sent'] = InboxwebmailInbox::where(['account_id'=>$uid,'is_deleted'=>0,'is_sent'=>1])->count();
        $allCounts['important'] = InboxwebmailInbox::where(['account_id'=>$uid,'is_deleted'=>0,'is_important'=>1])->count();
        $allCounts['star'] = InboxwebmailInbox::where(['account_id'=>$uid,'is_deleted'=>0,'is_star'=>1])->count();
        $allCounts['trash'] = InboxwebmailInbox::where(['account_id'=>$uid,'is_deleted'=>1])->count();


 $labelData = InboxwebmailLabel::select("inboxwebmail_labels.id", 'inboxwebmail_labels.lb_name', 'inboxwebmail_labels.lb_code', DB::raw('COUNT(inboxwebmail_inboxes.is_label) as cnt'))
                        ->join('inboxwebmail_inboxes', 'inboxwebmail_inboxes.is_label', '=', 'inboxwebmail_labels.id')->where("inboxwebmail_labels.account_id", $uid)->groupBy('inboxwebmail_inboxes.is_label')->get();
          

        return view('admin.inboxwebmail.view', compact('inboxwebmailAccount','inboxItems','allLabelSelect','sub','aj_url','compose_url','allCounts','current_url','uid','detailData','detailAttachments','labelData'));
    }

private function inboxwebmail_delete_directory($dirname) {
         if (is_dir($dirname)){
           $dir_handle = opendir($dirname);
         
     while($file = readdir($dir_handle)) {
           if ($file != "." && $file != "..") {
                if (!is_dir($dirname."/".$file)){
                     unlink($dirname."/".$file);
                }else{
                     $this->inboxwebmail_delete_directory($dirname.'/'.$file);
                }
           }
     }
     closedir($dir_handle);
     rmdir($dirname);
         }
     return true;
}

    public function inboxwebmailCompose(Request $request, $uid){
        $uid = abs(intval($uid));
        $inboxwebmailAccount = InboxwebmailAccount::findOrfail($uid);
        $allLabelSelect = InboxwebmailLabel::where('account_id', $uid)->get();

        if (isset($request->details) && is_numeric($request->details)) {
            $details_uid = abs(intval($request->details));

            $detailData =  InboxwebmailInbox::findOrfail($details_uid);
            if($detailData->account_id == $uid){
                $detailData->is_read = 1;
                $detailData->save();
                $detailAttachments =  InboxwebmailAttachment::where(['inbox_id'=>$details_uid])->get();
            }else{
                $detailAttachments = array();
                $detailData = '';
            }
        } else {
            $detailAttachments = array();
            $detailData = '';
        }
        $filter['account_id'] = $uid;
        $filter['is_deleted'] = 0;
        $filter['is_sent'] = 0;
        $filter['is_draft'] = 0;

        if (isset($request->sub)) {
            $sub = strip_tags($request->sub);
        }else{
            $sub='';
        }
        if (isset($request->r)) {
            $r = abs(intval($request->r));
        }else{
            $r='';
        }
        $inboxItems = '';

        $aj_url = route('admin.inboxwebmail.refdata',$uid).'?i=1';
        $compose_url = route('admin.inboxwebmail.compose',$uid).'?i=1';
        $current_url = route('admin.inboxwebmail.view',$uid).'?i=1';
        $allCounts = array();
        $allCounts['inbox'] = InboxwebmailInbox::where(['account_id'=>$uid,'is_deleted'=>0,'is_sent'=>0,'is_draft'=>0,'is_read'=>0])->count();
        $allCounts['sent'] = InboxwebmailInbox::where(['account_id'=>$uid,'is_deleted'=>0,'is_sent'=>1])->count();
        $allCounts['important'] = InboxwebmailInbox::where(['account_id'=>$uid,'is_deleted'=>0,'is_important'=>1])->count();
        $allCounts['star'] = InboxwebmailInbox::where(['account_id'=>$uid,'is_deleted'=>0,'is_star'=>1])->count();
        $allCounts['trash'] = InboxwebmailInbox::where(['account_id'=>$uid,'is_deleted'=>1])->count();


 $labelData = InboxwebmailLabel::select("inboxwebmail_labels.id", 'inboxwebmail_labels.lb_name', 'inboxwebmail_labels.lb_code', DB::raw('COUNT(inboxwebmail_inboxes.is_label) as cnt'))
                        ->join('inboxwebmail_inboxes', 'inboxwebmail_inboxes.is_label', '=', 'inboxwebmail_labels.id')->where("inboxwebmail_labels.account_id", $uid)->groupBy('inboxwebmail_inboxes.is_label')->get();
          
          
        return view('admin.inboxwebmail.compose', compact('inboxwebmailAccount','inboxItems','allLabelSelect','sub','aj_url','compose_url','allCounts','current_url','uid','detailData','detailAttachments','r','labelData'));
    }

    public function inboxwebmailComposesend(Request $request, $uid)
    {
        // dd($request->all());
        $uid = abs(intval($uid));
        
        $this->validate($request,[
            'subject'=>'required|max:250'
        ]);

        $property = InboxwebmailAccount::findOrfail($uid);
        $details_uid = abs(intval($request->details_uid));

            // save data and send email
            $to = $request->to;
            $cc = $request->cc;
            $bcc = $request->bcc;
 
            $to = $this->inboxWebmail_check_validate_email($to);
            $cc = $this->inboxWebmail_check_validate_email($cc);
            $bcc = $this->inboxWebmail_check_validate_email($bcc);

            $subject = strip_tags($request->subject);
            $message = $body = Self::inboxWebmail_clean_html(nl2br($request->meta_content));
            $sender = strip_tags($property->email);
            $sender_name = strip_tags($property->name);

            if ($to == '' || $subject == '' || $message == '') {
                return redirect()->back()->withErrors( __('To email and Subject is required field'));
            } else {
                $headers = '';
                $attachments = array();

                // $headers .= "From: $sender_name <$sender>\n";
                // $headers .= "Reply-To: <$to>\r\n";
                // $headers .= "Return-Path: <$to>\r\n";

                $headers .= "From: $sender_name <$sender>\n";
                $headers .= "Reply-To: <$sender>\r\n";
                $headers .= "Return-Path: <$to>\r\n";

                if ($cc != '') {
                    $headers .= "Cc:" . $cc."\n";
                }
                if ($bcc != '') {
                    $headers  .= "Bcc:" . $bcc."\n";
                }
                // dd($_FILES["file"]['name'],$request->ex_file);
                $is_attachment = 0;
                if (count($_FILES["file"]['name']) > 0 || count($request->ex_file) > 0) {
                    $is_attachment = 1;
                }

                $data = new InboxwebmailInbox();
                $data->account_id = $uid;
                $data->parent_id = $details_uid;
                $data->e_from = $sender;
                $data->e_to = $to;
                $data->e_reply_to = '';
                $data->e_cc = $cc;
                $data->e_bcc = $bcc;
                $data->e_subject = $subject;
                $data->e_message = $body;
                $data->header_info = json_encode($headers);
                $data->is_attachment = $is_attachment;
                $data->is_sent = 1;
                $data->save();
                $inbox_id = $data->id;

                // dd($inbox_id);

                if ($inbox_id > 0) {

                    // dd(public_path());
                    // dd(count($_FILES["file"]['name']));
                    // save attachments
                    if (count($_FILES["file"]['name']) > 0 || count($request->ex_file) > 0) {

                        $absolute_path = 'assets/inboxWebmail_files/' . $inbox_id;
                        mkdir($absolute_path, 0777);
                        $file_path = $absolute_path . '/index.php';

                        file_put_contents($file_path, '');

                        // manage for existing files.
                        if (isset($request->ex_file) && COUNT($request->ex_file) > 0) {
                            foreach ($request->ex_file as $exfiles) {
                                if ($exfiles != '' && $details_uid > 0) {
                                    $path_arr = explode($details_uid . "/", $exfiles);
                                    $file_name = $path_arr[1];
                                    $file_path = $absolute_path . '/' . $file_name;
                                    $ext = pathinfo($file_path, PATHINFO_EXTENSION);
                                    $documentType = strtolower($ext);


                                        if (copy($exfiles, $file_path)) {
                                            $data = new InboxwebmailAttachment();
                                            $data->inbox_id = $inbox_id;
                                            $data->file_name = $file_name;
                                            $data->file_type = $documentType;
                                            $data->file_bytes = $file_path;
                                            $data->save();

                                            $attachments[] = $file_path;
                                        }
                                   
                                }
                            }
                        }

                        for ($j = 0; $j < count($_FILES["file"]['name']); $j++) {
                            if ($_FILES["file"]["name"][$j] != '') {
                                $file_name = $_FILES["file"]["name"][$j];
                                $file_path = $absolute_path . '/' . $file_name;
                                $ext = pathinfo($file_path, PATHINFO_EXTENSION);
                                $documentType = strtolower($ext);

                                $size_of_uploaded_file = $_FILES["file"]["size"][$j] / 1024; //size in KBs
                                $max_allowed_file_size = 5000; // size in KB
                                
                                $allowed_file_types = array('jpg','jpeg','png','gif','ico','pdf','doc','docx','ppt','pptx','pps','ppsx','odt','xls','xlsx','csv','psd','mp3','m4a','wav','mp4','m4v','mov','wmv','avi','mpg','ogv','3gp','txt');
                                if (in_array($documentType,$allowed_file_types) && ($size_of_uploaded_file < $max_allowed_file_size)) {
                                    if (move_uploaded_file($_FILES["file"]["tmp_name"][$j], $file_path)) {
                                        $data = new InboxwebmailAttachment();
                                        $data->inbox_id = $inbox_id;
                                        $data->file_name = $file_name;
                                        $data->file_type = $documentType;
                                        $data->file_bytes = $file_path;
                                        $data->save();

                                        $attachments[] = $file_path;
                                    }
                                }
                            }
                        }
                    }

                    $this->inboxWebmail_mail_attachment($to, $subject, $message, $headers, $attachments,$inbox_id);
                    return redirect()->route('admin.inboxwebmail.view',$uid)->with('success', __('Email send successfully'));
                } else {
                    return redirect()->back()->withErrors(__('Some Problem occurred'));
                }
            }
    }

   private function inboxWebmail_mail_attachment($to, $subject, $message, $headers, $attachments,$inbox_id) {
    // dd(':in');
        // $semi_rand = md5(time());
        // $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
        // $headers .= "MIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";

        // $message = "This is a multi-part message in MIME format.\n\n" . "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"iso-8859-1\"\n" . "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n";
        // $message .= "--{$mime_boundary}\n";

        // if(count($attachments)>0){
        //         foreach ($attachments as $files) {
        //              $path_arr = explode($inbox_id . "/", $files);
        //              $filename = $path_arr[1];
                                            
        //             $data = file_get_contents($files);
        //             $data = chunk_split(base64_encode($data));

        //             $message .= "Content-Type: {\"application/octet-stream\"};\n" . " name=\"$filename\"\n" .
        //                 "Content-Disposition: attachment;\n" . " filename=\"$filename\"\n" .
        //                 "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
        //             $message .= "--{$mime_boundary}\n";
        //         }
        // }
        // @mail($to, $subject, $message, $headers);

        $message = $message;

        if (session()->has('lang')) {
            $currentLang = \App\Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = \App\Language::where('is_default', 1)->first();
        }

        $be = $currentLang->basic_extended;

        $inboxDetail = \App\InboxwebmailInbox::with('getInboxAccount')
                                        ->has('getInboxAccount')
                                        ->where('id',$inbox_id)->firstOrFail();
        
        // Send Mail to Buyer
        $mail = new PHPMailer(true);

        if ($be->is_smtp == 1) {
                // dd(':in2');
            // try {
                // Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                if($be->mail_driver == \App\BasicExtended::MAIL_DRIVER_SMTP){

                    $mail->isSMTP();
                
                }elseif($be->mail_driver == \App\BasicExtended::MAIL_DRIVER_MAIL){
                
                    $mail->isMail();
                
                }elseif($be->mail_driver == \App\BasicExtended::MAIL_DRIVER_IS_SEND_MAIL){
                
                    $mail->isSendMail();
                }                                            // Send using SMTP
                $mail->Host       = $inboxDetail->getInboxAccount->emailServer->smtp_server_address;                    // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = $inboxDetail->getInboxAccount->email;                     // SMTP username
                if($inboxDetail->getInboxAccount->secondary_password !=null){
                    // dd("in");
                    $mail->Password   = \Crypt::decryptString($inboxDetail->getInboxAccount->secondary_password);                               // SMTP password

                }else{
                    // dd(\Crypt::decryptString($inboxDetail->getInboxAccount->password));
                    $mail->Password   = \Crypt::decryptString($inboxDetail->getInboxAccount->password);                               // SMTP password
                }
                $mail->SMTPSecure = $inboxDetail->getInboxAccount->emailServer->smtp_authentication;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = $inboxDetail->getInboxAccount->emailServer->smtp_port;                                    
                // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                //Recipients
                $mail->setFrom($inboxDetail->getInboxAccount->email, $inboxDetail->getInboxAccount->name);
                $mail->addAddress($inboxDetail->e_to,$inboxDetail->e_to);     // Add a recipient


                if (isset($inboxDetail->e_cc) && $inboxDetail->e_cc !=null) {
                    
                    $eccEmails = explode(',',$inboxDetail->e_cc);

                    if (!empty($eccEmails)) {
                        
                        foreach($eccEmails as $key=>$v){

                            $mail->addCC($v);
                        }
                    }

                }

                if (isset($inboxDetail->e_bcc) && $inboxDetail->e_bcc !=null) {
                    
                    $eccEmails = explode(',',$inboxDetail->e_bcc);

                    if (!empty($eccEmails)) {
                        
                        foreach($eccEmails as $key=>$v){

                            $mail->addBCC($v);
                        }
                    }

                }

                if(count($attachments)>0){
                    foreach ($attachments as $keysFile=>$files) {
                        
                         $mail->addAttachment($files);         // Add attachments
                    }
                }

                // Content
                // $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = $subject;
                $mail->Body    = $message;
                // $mail->addCustomHeader($headers);


                $mail->send();
            // } catch (Exception $e) {
            //     // die($e->getMessage());
            // }
        }
    }

public static function inboxWebmail_clean_html($data){ 
      
        $allow_tags = '<style>,<html>,<body>,<header>,<footer>,<a>,<b>,<br>,<div>,<font>,<h1>,<h2>,<h3>,<h4>,<h5>,<h6>,<head>,<hr>,<img>,<li>,<ol>,<p>,<span>,<strong>,<table>,<td>,<th>,<tr>,<u>,<ul>,<title>';
        $data =  strip_tags($data,$allow_tags);
    
        $data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
        $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
        $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
        $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');
        $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);
        $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

        do
        {
            $old_data = $data;
            $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml|script|alert)[^>]*+>#i', '', $data);
             $data = str_ireplace(array('script','alert','javascript','applet','prompt','<?','&lt;?','?>','?&gt;'), array('','','','','','','',''), $data);
        }
        while ($old_data !== $data);
        return $data;
    }
    
    private function inboxWebmail_check_validate_email($email_txt)
    {
         $result_email = '';
         $result_emailArr = array();
        if (!empty($email_txt)) {
            $email_Arr = explode(",", $email_txt);
            foreach ($email_Arr as $email) {
                $femail = $this->inboxWebmail_parse_validate_email($email);
               
                if ($femail!='' && filter_var(trim($femail),FILTER_VALIDATE_EMAIL)) {
                    $result_emailArr[trim(strip_tags($femail))] = trim(strip_tags($femail));
                }
            }
            
            if (!empty($result_emailArr)) {
                $result_email = implode(',',$result_emailArr);
            }
        }
        
        return $result_email;
    }

    private function inboxWebmail_parse_validate_email($string_email)
    {
        if (empty($string_email)) {
            return '';
        }
        $pattern_email = '/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i';
        preg_match_all($pattern_email, $string_email, $matches);

        if($matches){
            if (isset($matches[0][0])) {
                return $matches[0][0];
            } elseif(isset($matches[0]) && !is_array($matches[0])) {
                return $matches[0];
            }else{
                return '';
            }
        }else{
            return '';
        }
    }

    public function inboxwebmailRefdata(Request $request, $uid){
        
        $uid = abs(intval($uid));
        $inboxwebmailAccount = InboxwebmailAccount::with(['emailServer'])->has('emailServer')->findOrfail($uid);
        if ($inboxwebmailAccount->active == 1) {
            
            if($request->sync_type == 1){

                $chkData = InboxwebmailInbox::where(['account_id'=>$uid])
                                            ->orderBy('created_at', 'desc')
                                            ->where('is_sent',0)
                                            ->first();

            }else{

                $chkData = InboxwebmailInbox::where(['account_id'=>$uid])
                                            ->where('is_sent',1)
                                            ->orderBy('created_at', 'desc')
                                            ->first();
            }
           if(!empty($chkData)){
               $checkDate = $chkData->created_at;
           }else{
               $checkDate = '';
           }
            $host = strip_tags($inboxwebmailAccount->domain);
            $port = '993';
            $user = strip_tags($inboxwebmailAccount->email);
            $pass = ($inboxwebmailAccount->emailServer->id == \App\EmailServer::YAHOO_COSNT) ? \Crypt::decryptString(strip_tags($inboxwebmailAccount->secondary_password)) : \Crypt::decryptString(strip_tags($inboxwebmailAccount->password));
            $d_from_server = abs(intval($inboxwebmailAccount->d_from_server));

            // $host_string = "{" . $host . ":" . $port . "/imap/ssl/novalidate-cert}INBOX";

            $host_string = getCustomeImapHosturl($inboxwebmailAccount->emailServer,$request->sync_type);

            // $host = '{imap.gmail.com:993/ssl}';
            // $mail_con = imap_open($host, $user, $pass);
            // $mailboxes = imap_list($mail_con, $host, '*');
            // dd($mailboxes);

            $parser = new InboxwebmailEmailParser($host_string, $user, $pass, $uid, $d_from_server,$request->sync_type);
            // dd($parser);
            $total = $parser->inboxWebmail_parse($checkDate);

            echo __('Data parse successfully. Total new email =') . $total;
        } else {
            echo __('Account not activated');
        }
        die(__('done'));
    }
    
    

    public function inboxwebmailParse(){
        $inboxwebmails = InboxwebmailAccount::get();
       
        foreach ($inboxwebmails as $inboxwebmail) {
             $uid = abs(intval($inboxwebmail->id));
            $inboxwebmailAccount = InboxwebmailAccount::findOrfail($uid);
          
            if ($inboxwebmailAccount->active == 1) {
                $chkData = InboxwebmailInbox::where(['account_id' => $uid])->orderBy('created_at', 'desc')->first();
                if (!empty($chkData)) {
                    $checkDate = $chkData->created_at;
                } else {
                    $checkDate = '';
                }
              
                $host = strip_tags($inboxwebmailAccount->domain);
                $port = '993';
                $user = strip_tags($inboxwebmailAccount->email);
                $pass = ($inboxwebmailAccount->emailServer->id == \App\EmailServer::YAHOO_COSNT) ? \Crypt::decryptString(strip_tags($inboxwebmailAccount->secondary_password)) : \Crypt::decryptString(strip_tags($inboxwebmailAccount->password));

                $d_from_server = abs(intval($inboxwebmailAccount->d_from_server));

                // $host_string = "{" . $host . ":" . $port . "/imap/ssl/novalidate-cert}INBOX";
                
                $host_string = getCustomeImapHosturl($inboxwebmailAccount->emailServer);
                $parser = new InboxwebmailEmailParser($host_string, $user, $pass, $uid, $d_from_server);
                $total = $parser->inboxWebmail_parse($checkDate);

                echo __('Data parse successfully. Total new email =') . $total;
            } else {
                echo __('Account not activated');
            }
        }
        die(__('done'));
    }

}
