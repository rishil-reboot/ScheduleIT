<?php

namespace App\Http\Controllers\Admin;

use App\BasicExtended;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BasicSetting as BS;
use App\Language;
use Validator;
use Session;

class HerosectionController extends Controller
{
    public function static(Request $request)
    {
        $lang = Language::where('code', $request->language)->firstOrFail();
        $data['lang_id'] = $lang->id;
        $data['abs'] = $lang->basic_setting;
        $data['abe'] = $lang->basic_extended;

        return view('admin.home.hero.static', $data);
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
            return response()->json(['errors' => $validator->errors(), 'id' => 'hero_bg']);
        }

        if ($request->hasFile('file')) {
            $bs = BS::where('language_id', $langid)->firstOrFail();
            @unlink('assets/front/img/' . $bs->hero_bg);
            $filename = uniqid() .'.'. $img->getClientOriginalExtension();
            $img->move('assets/front/img/', $filename);

            $bs->hero_bg = $filename;
            $bs->save();

        }

        return response()->json(['status' => "success", 'image' => 'Hero section image']);
    }

    public function update(Request $request, $langid)
    {
        // dd($request->all());
        $rules = [
            'hero_section_title' => 'nullable',
            'hero_section_title_font_size' => 'required|integer|digits_between:1,3',
            'hero_section_text' => 'nullable',
            'hero_section_text_font_size' => 'required|integer|digits_between:1,3',
            'hero_section_button_text' => 'nullable',
            'hero_section_button_text_font_size' => 'required|integer|digits_between:1,3',
            'hero_section_button_url' => 'nullable',
        ];


        $be = BasicExtended::where('language_id', $langid)->firstOrFail();
        $version = getVersion($be->theme_version);


        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $bs = BS::where('language_id', $langid)->firstOrFail();
        $bs->hero_section_title = $request->hero_section_title;

        $bs->hero_section_text = $request->hero_section_text;
        $bs->hero_section_button_text = $request->hero_section_button_text;
        $bs->hero_section_button_url = $request->hero_section_button_url;
        $bs->save();


        $be->hero_section_title_font_size = $request->hero_section_title_font_size;
        $be->hero_section_button_text_font_size = $request->hero_section_button_text_font_size;

        $be->save();

        Session::flash('success', 'Informations updated successfully!');
        return "success";
    }

    public function video(Request $request)
    {
        $lang = Language::where('code', $request->language)->firstOrFail();
        $data['lang_id'] = $lang->id;
        $data['abs'] = $lang->basic_setting;

        return view('admin.home.hero.video', $data);
    }

    public function videoupdate(Request $request, $langid)
    {
        $rules = [
            'video_link' => 'required|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $bs = BS::where('language_id', $langid)->firstOrFail();
        $videoLink = $request->video_link;
        if (strpos($videoLink, "&") != false) {
            $videoLink = substr($videoLink, 0, strpos($videoLink, "&"));
        }
        $bs->hero_section_video_link = $videoLink;
        $bs->save();

        Session::flash('success', 'Informations updated successfully!');
        return "success";
    }
}
