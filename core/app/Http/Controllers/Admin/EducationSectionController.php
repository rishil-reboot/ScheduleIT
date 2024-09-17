<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BasicSetting as BS;
use App\Language;
use Validator;
use Session;

class EducationSectionController extends Controller
{
    public function index(Request $request)
    {
        if (empty($request->language)) {
            $data['lang_id'] = 0;
            $data['abs'] = BS::firstOrFail();
        } else {
            $lang = Language::where('code', $request->language)->firstOrFail();
            $data['lang_id'] = $lang->id;
            $data['abs'] = $lang->basic_setting;
        }
        return view('admin.home.education-section', $data);
    }

    public function update(Request $request, $langid)
    {
        $rules = [
            'education_section_subtitle' => 'required',
            'education_section_title' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $bs = BS::where('language_id', $langid)->firstOrFail();
        $bs->education_section_subtitle = $request->education_section_subtitle;
        $bs->education_section_title = $request->education_section_title;
        $bs->save();

        Session::flash('success', 'Texts updated successfully!');
        return "success";
    }
}
