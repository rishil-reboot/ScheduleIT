<?php

namespace App\Http\Controllers\Admin;

use App\BasicExtended;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Language;
use App\Feature;
use App\Page;
use Validator;
use Session;

class FeatureController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();
        $lang_id = $lang->id;
        $data['features'] = Feature::where('language_id', $lang_id)->orderBy('id', 'DESC')->get();
        $data['pages'] = Page::where('language_id', $lang_id)->orderBy('id', 'DESC')->get();
        $data['lang_id'] = $lang_id;

        return view('admin.home.feature.index', $data);
    }

    public function edit($id)
    {
        $data['feature'] = Feature::findOrFail($id);
        $data['pages'] = Page::where('language_id', $data['feature']->language_id)
                              ->orderBy('id', 'DESC')->get();
        return view('admin.home.feature.edit', $data);
    }

    public function store(Request $request)
    {
        $count = Feature::where('language_id', $request->language_id)->count();
        if ($count == 10) {
            Session::flash('warning', 'You cannot add more than 10 features!');
            return "success";
        }

        $messages = [
            'language_id.required' => 'The language field is required'
        ];

        $rules = [
            'language_id' => 'required',
            'icon' => 'required',
            'title' => 'required|max:50',
            'subtitle'=>'required',
            'color' => 'required',
            'serial_number' => 'required|integer',
            'external_link' => 'nullable|url',
        ];

        $be = BasicExtended::select('theme_version')->first();
        if (getVersion($be->theme_version) == 'car') {
            $rules['color'] = 'nullable';
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $feature = new Feature;
        $feature->icon = $request->icon;
        $feature->language_id = $request->language_id;
        $feature->page_id = $request->page_id;
        $feature->title = $request->title;
        $feature->subtitle = $request->subtitle;
        $feature->external_link = $request->external_link;

        if (getVersion($be->theme_version) != 'car') {
            $feature->color = $request->color;
        }

        $feature->serial_number = $request->serial_number;
        $feature->save();

        Session::flash('success', 'Feature added successfully!');
        return "success";
    }

    public function update(Request $request)
    {
        $rules = [
            'icon' => 'required',
            'title' => 'required|max:50',
            'subtitle'=>'required',
            'color' => 'required',
            'serial_number' => 'required|integer',
            'external_link' => 'nullable|url',
        ];

        $be = BasicExtended::select('theme_version')->first();
        if (getVersion($be->theme_version) == 'car') {
            $rules['color'] = 'nullable';
        }

        $request->validate($rules);

        $feature = Feature::findOrFail($request->feature_id);
        $feature->icon = $request->icon;
        $feature->title = $request->title;
        $feature->subtitle = $request->subtitle;
        $feature->page_id = $request->page_id;
        $feature->external_link = $request->external_link;

        if (getVersion($be->theme_version) != 'car') {
            $feature->color = $request->color;
        }

        $feature->serial_number = $request->serial_number;
        $feature->save();

        Session::flash('success', 'Feature updated successfully!');
        return back();
    }

    public function delete(Request $request)
    {

        $feature = Feature::findOrFail($request->feature_id);
        $feature->delete();

        Session::flash('success', 'Feature deleted successfully!');
        return back();
    }
}
