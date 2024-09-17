<?php

namespace App\Http\Controllers\Admin;

use App\BasicExtended;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BasicSetting;
use App\Language;
use App\WhyChooseUs;
use Session;
use Validator;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        if (empty($request->language)) {
            $data['lang_id'] = 0;
            $data['abs'] = BasicSetting::firstOrFail();
            $data['abe'] = BasicExtended::firstOrFail();
        } else {
            $lang = Language::where('code', $request->language)->firstOrFail();
            $data['lang_id'] = $lang->id;
            $data['abs'] = $lang->basic_setting;
            $data['abe'] = $lang->basic_extended;
        }

        $data['whychooseus'] = WhyChooseUs::where('language_id',$data['lang_id'])
                                            ->where('status',1)
                                            ->paginate(10);

        return view('admin.contact', $data);
    }

    public function update(Request $request, $langid)
    {
        $request->validate([
            'contact_form_title' => 'required|max:255',
            'contact_form_subtitle' => 'required|max:255',
            'contact_address' => 'required|max:255',
            'contact_number' => 'required|max:255',
            'latitude' => 'required|max:255',
            'longitude' => 'required|max:255',
        ]);

        $bs = BasicSetting::where('language_id', $langid)->firstOrFail();
        $bs->contact_form_title = $request->contact_form_title;
        $bs->contact_form_subtitle = $request->contact_form_subtitle;
        $bs->contact_address = $request->contact_address;
        $bs->contact_number = $request->contact_number;
        $bs->latitude = $request->latitude;
        $bs->longitude = $request->longitude;
        $bs->save();

        Session::flash('success', 'Contact page updated successfully!');
        return back();
    }

    public function whystore(Request $request)
    {
        $messages = [
            'language_id.required' => 'The language field is required'
        ];

        $rules = [
            'language_id' => 'required',
            'name' => 'required',
            'status' => 'required',
            'serial_number' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $obj = new WhyChooseUs;
        $obj->language_id = $request->language_id;
        $obj->name = $request->name;
        $obj->description = $request->description;
        $obj->status = $request->status;
        $obj->serial_number = $request->serial_number;
        $obj->save();

        Session::flash('success', 'Text added successfully!');
        return "success";
    }

    public function whyupdate(Request $request)
    {
        $rules = [
            'name' => 'required',
            'status' => 'required',
            'serial_number' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $obj = WhyChooseUs::findOrFail($request->why_choose_id);
        $obj->name = $request->name;
        $obj->description = $request->description;
        $obj->status = $request->status;
        $obj->serial_number = $request->serial_number;
        $obj->save();

        Session::flash('success', 'Text updated successfully!');
        return "success";
    }

    public function whydelete(Request $request)
    {

        $bcategory = WhyChooseUs::findOrFail($request->why_choose_id);
        $bcategory->delete();

        Session::flash('success', 'Record deleted successfully!');
        return back();
    }

    public function whybulk(Request $request)
    {
        $ids = $request->ids;

        foreach ($ids as $id) {
            $bcategory = WhyChooseUs::findOrFail($id);
            $bcategory->delete();
        }

        Session::flash('success', 'Record deleted successfully!');
        return "success";
    }
}
