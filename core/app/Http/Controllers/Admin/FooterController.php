<?php

namespace App\Http\Controllers\Admin;

use Session;
use Validator;
use App\Gallery;
use App\Language;
use App\BasicSetting as BS;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FooterController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->firstOrFail();
        $data['lang_id'] = $lang->id;
        $data['abs'] = $lang->basic_setting;
        $data['mediaData'] = Gallery::all();

        return view('admin.footer.logo-text', $data);
    }

    public function upload(Request $request, $langid)
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
            return response()->json(['errors' => $validator->errors(), 'id' => 'footer_logo']);
        }

        if ($request->hasFile('file')) {
            $bs = BS::where('language_id', $langid)->firstOrFail();
            @unlink('assets/front/img/' . $bs->footer_logo);
            $filename = uniqid() .'.'. $img->getClientOriginalExtension();
            $img->move('assets/front/img/', $filename);

            $bs->footer_logo = $filename;
            $bs->save();

        }

        return response()->json(['status' => "success", 'image' => 'Footer logo']);
    }

    public function update(Request $request, $langid)
    {
        $rules = [
            'footer_text' => 'required',
            'newsletter_text' => 'required|max:255',
            'copyright_text' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $bs = BS::where('language_id', $langid)->firstOrFail();
        $bs->footer_text = $request->footer_text;
        $bs->newsletter_text = $request->newsletter_text;
        $bs->copyright_text = $request->copyright_text;
        $bs->new_your_address = $request->new_your_address;
        $bs->florida_address = $request->florida_address;
        $bs->vegas_address = $request->vegas_address;
        $bs->united_kingdom_address = $request->united_kingdom_address;
        $bs->save();

        Session::flash('success', 'Footer text updated successfully!');
        return "success";
    }

    public function poweredBy(Request $request)
    {
        if (\Auth::user()->role_id != 0) {

            Session::flash('success', 'Access denied !');
            return redirect()->route('admin.dashboard');
        }

        $lang = Language::where('code', $request->language)->firstOrFail();
        $data['lang_id'] = $lang->id;
        $data['abs'] = $lang->basic_setting;
        $data['mediaData'] = Gallery::all();

        return view('admin.footer.powered-by', $data);
    }

    public function poweredByUpload(Request $request, $langid)
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
            return response()->json(['errors' => $validator->errors(), 'id' => 'powered_by_logo']);
        }

        if ($request->hasFile('file')) {
            $bs = BS::where('language_id', $langid)->firstOrFail();
            @unlink('assets/front/img/' . $bs->powered_by_logo);
            $filename = uniqid() .'.'. $img->getClientOriginalExtension();
            $img->move('assets/front/img/', $filename);

            $bs->powered_by_logo = $filename;
            $bs->save();

        }

        return response()->json(['status' => "success", 'image' => 'Power by logo']);
    }

    public function poweredByUpdate(Request $request, $langid)
    {
        
        $rules = [
            'powered_by_text' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $bs = BS::where('language_id', $langid)->firstOrFail();
        $bs->powered_by_text = $request->powered_by_text;
        $bs->powered_by_section = $request->powered_by_section;
        $bs->powered_by_url = $request->powered_by_url;
        $bs->save();

        Session::flash('success', 'Powered by section updated successfully!');
        return "success";
    }

}
