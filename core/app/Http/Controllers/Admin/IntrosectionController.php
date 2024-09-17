<?php

namespace App\Http\Controllers\Admin;

use App\BasicExtended;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BasicSetting as BS;
use App\Language;
use App\AboutIntro;
use App\AboutCommunity;
use Validator;
use Session;

class IntrosectionController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->firstOrFail();
        $data['lang_id'] = $lang->id;
        $data['abs'] = $lang->basic_setting;
        $data['abe'] = $lang->basic_extended;
        $data['aboutIntro'] = AboutIntro::where('language_id',$lang->id)->get();

        return view('admin.home.intro-section', $data);
    }

    public function upload(Request $request, $langid)
    {
        // return response()->json(['status' => "success", 'method' => 'upload']);
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
            return response()->json(['errors' => $validator->errors(), 'id' => 'intro_bg']);
        }


        if ($request->hasFile('file')) {
            $bs = BS::where('language_id', $langid)->firstOrFail();
            @unlink('assets/front/img/' . $bs->intro_bg);
            $filename = uniqid() .'.'. $img->getClientOriginalExtension();
            $img->move('assets/front/img/', $filename);

            $bs->intro_bg = $filename;
            $bs->save();

        }

        return response()->json(['status' => "success", 'image' => 'Intro section image']);
    }

    public function upload2(Request $request, $langid)
    {
        // return response()->json(['status' => "success", 'method' => 'upload2']);
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
            return response()->json(['errors' => $validator->errors(), 'id' => 'intro_bg2']);
        }


        if ($request->hasFile('file')) {
            $be = BasicExtended::where('language_id', $langid)->firstOrFail();
            @unlink('assets/front/img/' . $be->intro_bg2);
            $filename = uniqid() .'.'. $img->getClientOriginalExtension();
            $img->move('assets/front/img/', $filename);

            $be->intro_bg2 = $filename;
            $be->save();

        }

        return response()->json(['status' => "success", 'image' => 'Intro section image']);
    }

    public function update(Request $request, $langid)
    {
        $rules = [
            'intro_section_title' => 'required',
            'intro_section_text' => 'required',
            'intro_section_button_text' => 'nullable|max:100',
            'intro_section_button_url' => 'nullable|max:1000',
            'intro_section_video_link' => 'nullable'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $bs = BS::where('language_id', $langid)->firstOrFail();
        $bs->intro_section_title = $request->intro_section_title;
        $bs->intro_section_text = $request->intro_section_text;
        $bs->intro_section_button_text = $request->intro_section_button_text;
        $bs->intro_section_button_url = $request->intro_section_button_url;
        $bs->intro_section_sub_title = $request->intro_section_sub_title;
        $videoLink = $request->intro_section_video_link;
        if (strpos($videoLink, "&") != false) {
            $videoLink = substr($videoLink, 0, strpos($videoLink, "&"));
        }
        $bs->intro_section_video_link = $videoLink;
        $bs->save();

        Session::flash('success', 'Informations updated successfully!');
        return "success";
    }


    public function createAboutintro()
    {
        return view('admin.home.aboutIntro.create');
    }

    public function editAboutintro($id)
    {
        $data['aboutIntro'] = AboutIntro::findOrFail($id);
        return view('admin.home.aboutIntro.edit', $data);
    }

    public function uploadAboutintro(Request $request)
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
            return response()->json(['errors' => $validator->errors(), 'id' => 'about_intro']);
        }

        $filename = time() . '.' . $img->getClientOriginalExtension();
        $request->session()->put('about_intro_image', $filename);
        $request->file('file')->move('assets/front/img/about_intro/', $filename);
        return response()->json(['status' => "session_put", "image" => "about_intro_image", 'filename' => $filename]);
    }

    public function uploadUpdateAboutintro(Request $request, $id)
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
            return response()->json(['errors' => $validator->errors(), 'id' => 'about_intro']);
        }

        $aboutIntro = AboutIntro::findOrFail($id);
        if ($request->hasFile('file')) {
            $filename = time() . '.' . $img->getClientOriginalExtension();
            $request->file('file')->move('assets/front/img/about_intro/', $filename);
            @unlink('assets/front/img/about_intro/' . $aboutIntro->image);
            $aboutIntro->image = $filename;
            $aboutIntro->save();
        }

        return response()->json(['status' => "success", "image" => "About Intro image", 'aboutIntro' => $aboutIntro]);
    }

    public function storeAboutintro(Request $request)
    {
        $messages = [
            'language_id.required' => 'The language field is required'
        ];

        $rules = [
            'language_id' => 'required',
            'about_intro_image' => 'required',
            'name' => 'required|max:50'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $aboutIntro = new AboutIntro;
        $aboutIntro->language_id = $request->language_id;
        $aboutIntro->image = $request->about_intro_image;
        $aboutIntro->name = $request->name;
        $aboutIntro->save();

        Session::flash('success', 'Intro added successfully!');
        return "success";
    }

    public function updateAboutintro(Request $request)
    {
        $rules = [
            'name' => 'required|max:50',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $aboutIntro = AboutIntro::findOrFail($request->about_intro_id);
        $aboutIntro->name = $request->name;
        $aboutIntro->save();

        Session::flash('success', 'Intro updated successfully!');
        return "success";
    }

    public function deleteAboutintro(Request $request)
    {

        $intro = AboutIntro::findOrFail($request->about_intro_id);
        @unlink('assets/front/img/about_intro/' . $intro->image);
        $intro->delete();

        Session::flash('success', 'Intro deleted successfully!');
        return back();
    }

    public function featureAboutintro(Request $request)
    {
        $intro = AboutIntro::find($request->about_intro_id);
        $intro->feature = $request->feature;
        $intro->save();

        if ($request->feature == 1) {
            Session::flash('success', 'Featured successfully!');
        } else {
            Session::flash('success', 'Unfeatured successfully!');
        }

        return back();
    }
}
