<?php

namespace App\Http\Controllers\Admin;

use Session;
use Validator;
use App\Client;
use App\Gallery;
use App\Language;
use App\BasicSetting as BS;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();

        $lang_id = $lang->id;
        $data['partners'] = Client::where('language_id', $lang_id)->orderBy('id', 'DESC')->get();
        $data['lang_id'] = $lang_id;
        $data['abs'] = $lang->basic_setting;
        $data['mediaData'] = Gallery::all();
        return view('admin.home.client.index', $data);
    }

    public function edit($id)
    {
        $data['partner'] = Client::findOrFail($id);
        $data['mediaData'] = Gallery::all();
        return view('admin.home.client.edit', $data);
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
            return response()->json(['errors' => $validator->errors(), 'id' => 'partner']);
        }

        $filename = time() . '.' . $img->getClientOriginalExtension();
        $request->session()->put('client_image', $filename);
        $request->file('file')->move('assets/front/img/client/', $filename);
        return response()->json(['status' => "session_put", "image" => "client_image", 'filename' => $filename]);
    }

    public function store(Request $request)
    {
        $messages = [
            'language_id.required' => 'The language field is required'
        ];

        $rules = [
            'language_id' => 'required',
            'client_image' => 'required',
            'name' => 'required',
            'slug' => 'required',
            'url' => 'nullable|url',
            'serial_number' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $partner = new Client;
        $partner->language_id = $request->language_id;
        $partner->name = $request->name;
        $partner->slug = $request->slug;
        $partner->description = $request->description;
        $partner->long_description = $request->long_description;
        $partner->meta_keyword = $request->meta_keyword;
        $partner->meta_description = $request->meta_description;
        $partner->image = $request->client_image;
        $partner->serial_number = $request->serial_number;
        $partner->url = $request->url;
        $partner->address = $request->address;
        $partner->state = $request->state;
        $partner->city = $request->city;
        $partner->zip = $request->zip;
        $partner->save();

        Session::flash('success', 'Client added successfully!');
        return "success";
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
            return response()->json(['errors' => $validator->errors(), 'id' => 'partner']);
        }

        $partner = Client::findOrFail($id);
        if ($request->hasFile('file')) {
            $filename = time() . '.' . $img->getClientOriginalExtension();
            $request->file('file')->move('assets/front/img/client/', $filename);
            @unlink('assets/front/img/client/' . $partner->image);
            $partner->image = $filename;
            $partner->save();
        }

        return response()->json(['status' => "success", "image" => "Partner", 'partner' => $partner]);
    }

    public function update(Request $request)
    {
        $rules = [
            'url' => 'nullable|url',
            'serial_number' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $partner = Client::findOrFail($request->partner_id);
        $partner->name = $request->name;
        $partner->slug = $request->slug;
        $partner->description = $request->description;
        $partner->long_description = $request->long_description;
        $partner->meta_keyword = $request->meta_keyword;
        $partner->meta_description = $request->meta_description;
        $partner->serial_number = $request->serial_number;
        $partner->url = $request->url;
        $partner->address = $request->address;
        $partner->state = $request->state;
        $partner->city = $request->city;
        $partner->zip = $request->zip;
        $partner->save();

        Session::flash('success', 'Client updated successfully!');
        return "success";
    }

    public function delete(Request $request)
    {

        $partner = Client::findOrFail($request->partner_id);
        @unlink('assets/front/img/client/' . $partner->image);
        $partner->delete();

        Session::flash('success', 'Client deleted successfully!');
        return back();
    }

    public function updateSection(Request $request)
    {
        $request->validate([
            'client_section_title' => 'required',
            'client_section_subtitle' => 'required',
        ]);

        $bs = BS::get();

        foreach($bs as $key=>$v){

            $data = $v;

            $data->client_section_title = $request->client_section_title;
            $data->client_section_subtitle = $request->client_section_subtitle;
            $data->client_section_description = $request->client_section_description;
            $data->client_meta_keyword = $request->client_meta_keyword;
            $data->client_meta_description = $request->client_meta_description;
            $data->save();

        }

        Session::flash('success', 'Text updated successfully!');
        return back();
    }

}
