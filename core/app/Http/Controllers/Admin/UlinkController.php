<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Language;
use App\Ulink;
use Validator;
use Session;
use App\FooterGroupLinkName;

class UlinkController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();
        $lang_id = $lang->id;
        $data['aulinks'] = Ulink::where('language_id', $lang_id)->get();
        $data['lang_id'] = $lang_id;
        $data['groupName'] = \App\FooterGroupLinkName::orderBy('serial_number','ASC')->get();

        return view('admin.footer.ulink.index', $data);
    }

    public function edit($id)
    {
        $data['ulink'] = Ulink::findOrFail($id);
        return view('admin.footer.ulink.edit', $data);
    }

    public function store(Request $request)
    {
        $messages = [
            'language_id.required' => 'The language field is required'
        ];

        $rules = [
            'language_id' => 'required',
            'name' => 'required|max:255',
            'url' => 'required|max:255'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $ulink = new Ulink;
        $ulink->language_id = $request->language_id;
        $ulink->name = $request->name;
        $ulink->url = $request->url;
        $ulink->footer_group_link_name_id = $request->footer_group_link_name_id;
        $ulink->save();

        Session::flash('success', 'Useful link added successfully!');
        return "success";
    }

    public function update(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'url' => 'required|max:255'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $ulink = Ulink::findOrFail($request->ulink_id);
        $ulink->name = $request->name;
        $ulink->url = $request->url;
        $ulink->footer_group_link_name_id = $request->footer_group_link_name_id;
        $ulink->save();

        Session::flash('success', 'Useful link updated successfully!');
        return "success";
    }

    public function delete(Request $request)
    {

        $ulink = Ulink::findOrFail($request->ulink_id);
        $ulink->delete();

        Session::flash('success', 'Ulink deleted successfully!');
        return back();
    }
}
