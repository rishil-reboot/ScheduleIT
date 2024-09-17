<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\EmailTemplate;
use App\Language;
use Validator;
use Session;

class EmailTemplateController extends Controller
{
    public function index(Request $request)
    {

        $lang = Language::where('code', $request->language)->first();

        $lang_id = $lang->id;
        $data['bcategorys'] = EmailTemplate::where('language_id', $lang_id)
                                            ->orderBy('id', 'ASC')
                                            ->paginate(10);

        $data['lang_id'] = $lang_id;

        return view('admin.email_template.template.index', $data);
    }

    public function create()
    {
        return view('admin.basic.email.template.create');
    }

    public function edit($id)
    {
        $data['bcategory'] = EmailTemplate::findOrFail($id);
        return view('admin.basic.email.template.edit', $data);
    }

    public function store(Request $request)
    {
        $messages = [
            'language_id.required' => 'The language field is required'
        ];

        $rules = [
            'name' => 'required',
            'subject' => 'required',
            'serial_number' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $bcategory = new EmailTemplate;
        $bcategory->image = $request->template;
        $bcategory->name = $request->name;
        $bcategory->serial_number = $request->serial_number;
        $bcategory->body_content = $request->body_content;
        $bcategory->subject = $request->subject;
        $bcategory->save();

        Session::flash('success', 'Email template added successfully!');
        return "success";
    }

    public function update(Request $request)
    {
        $rules = [
            'name' => 'required',
            'subject' => 'required',
            'serial_number' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $bcategory = EmailTemplate::findOrFail($request->template_id);
        $bcategory->name = $request->name;
        $bcategory->status = $request->status;
        $bcategory->serial_number = $request->serial_number;
        $bcategory->body_content = $request->body_content;
        $bcategory->subject = $request->subject;
        $bcategory->save();

        Session::flash('success', 'Email Template updated successfully!');
        return "success";
    }

    public function delete(Request $request)
    {

        $bcategory = EmailTemplate::findOrFail($request->template_id);
        $bcategory->delete();

        Session::flash('success', 'Email template deleted successfully!');
        return back();
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        foreach ($ids as $id) {
            $bcategory = EmailTemplate::findOrFail($id);
            $bcategory->delete();
        }

        Session::flash('success', 'Email Template deleted successfully!');
        return "success";
    }

    public function upload(Request $request)
    {
        $img = $request->file('file');
        $allowedExts = array('jpg', 'png', 'jpeg');

        $rules = [
            'file' => [
                function ($attribute, $value, $fail) use ($img, $allowedExts) {
                    if (!empty($img)) {
                        $ext = $img->getClientOriginalExtension();
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only png, jpg, jpeg image is allowed");
                        }
                    }
                },
            ],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json(['errors' => $validator->errors(), 'id' => 'template']);
        }

        $filename = time() . '.' . $img->getClientOriginalExtension();
        $request->session()->put('template_image', $filename);
        $request->file('file')->move('assets/front/img/template/', $filename);
        return response()->json(['status' => "session_put", "image" => "template", 'filename' => $filename]);
    }

    public function uploadUpdate(Request $request, $id)
    {
        $img = $request->file('file');
        $allowedExts = array('jpg', 'png', 'jpeg');

        $rules = [
            'file' => [
                function ($attribute, $value, $fail) use ($img, $allowedExts) {
                    if (!empty($img)) {
                        $ext = $img->getClientOriginalExtension();
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only png, jpg, jpeg image is allowed");
                        }
                    }
                },
            ],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json(['errors' => $validator->errors(), 'id' => 'blog']);
        }

        $blog = EmailTemplate::findOrFail($id);
        if ($request->hasFile('file')) {
            $filename = time() . '.' . $img->getClientOriginalExtension();
            $request->file('file')->move('assets/front/img/template/', $filename);
            @unlink('assets/front/img/template/' . $blog->image);
            $blog->image = $filename;
            $blog->save();
        }

        return response()->json(['status' => "success", "image" => "Template image", 'blog' => $blog]);
    }

    /**
     * This function is used to show email template preview
     * @author Chirag Ghevariya
     */
    public function preview($id){

        $emailTemplate = EmailTemplate::where('id',$id)->firstOrFail();

        return view('email_template.transactional.common_email_template',compact('emailTemplate'));
        
    }

    /**
     * This function is used to update template footer section
     * @author Chirag Ghevariya
     * 
    */
    public function updateFooterSection(Request $request){

        $settings = \App\BasicSetting::all();

        foreach($settings as $key=>$v){

            $v->template_footer_content = $request->template_footer_content;
            $v->save();
        }    

        Session::flash('success', 'Template footer section updated successfully!');
        return back();
    }
}
