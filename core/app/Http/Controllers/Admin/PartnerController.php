<?php

namespace App\Http\Controllers\Admin;

use Session;
use Validator;
use App\Gallery;
use App\Partner;
use App\Language;
use App\PartnerProduct;
use App\BasicSetting as BS;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PartnerController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();

        $lang_id = $lang->id;
        $data['partners'] = Partner::where('language_id', $lang_id)->orderBy('id', 'DESC')->get();

        $data['lang_id'] = $lang_id;
        $data['abs'] = $lang->basic_setting;
        $data['mediaData'] = Gallery::all();

        return view('admin.home.partner.index', $data);
    }

    public function edit($id)
    {
        $data['mediaData'] = Gallery::all();
        $data['partner'] = Partner::findOrFail($id);
        return view('admin.home.partner.edit', $data);
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
        $request->session()->put('partner_image', $filename);
        $request->file('file')->move('assets/front/img/partners/', $filename);
        return response()->json(['status' => "session_put", "image" => "partner_image", 'filename' => $filename]);
    }

    public function store(Request $request)
    {

        $input = $request->all();

        $messages = [
            'language_id.required' => 'The language field is required'
        ];

        $rules = [
            'language_id' => 'required',
            'partner_image' => 'required',
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

        $partner = new Partner;
        $partner->language_id = $request->language_id;
        $partner->name = $request->name;
        $partner->slug = $request->slug;
        $partner->description = $request->description;
        $partner->long_description = $request->long_description;
        $partner->meta_keyword = $request->meta_keyword;
        $partner->meta_description = $request->meta_description;
        $partner->image = $request->partner_image;
        $partner->serial_number = $request->serial_number;
        $partner->url = $request->url;
        $partner->company_address = $request->company_address;
        $partner->contact_person_name = $request->contact_person_name;
        $partner->save();


        if (isset($input['product_id']) && !empty($input['product_id'])) {

            foreach($input['product_id'] as $key=>$v){

                $obj = new PartnerProduct;
                $obj->partner_id = $partner->id;
                $obj->product_id = $v;
                $obj->save();

            }

        }

        Session::flash('success', 'Partner added successfully!');
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

        $partner = Partner::findOrFail($id);
        if ($request->hasFile('file')) {
            $filename = time() . '.' . $img->getClientOriginalExtension();
            $request->file('file')->move('assets/front/img/partners/', $filename);
            @unlink('assets/front/img/partners/' . $partner->image);
            $partner->image = $filename;
            $partner->save();
        }

        return response()->json(['status' => "success", "image" => "Partner", 'partner' => $partner]);
    }

    public function update(Request $request)
    {

        $input = $request->all();

        $rules = [
            'name' => 'required',
            'slug' => 'required',
            'url' => 'nullable|url',
            'serial_number' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $partner = Partner::findOrFail($request->partner_id);
        $partner->name = $request->name;
        $partner->slug = $request->slug;
        $partner->description = $request->description;
        $partner->long_description = $request->long_description;
        $partner->meta_keyword = $request->meta_keyword;
        $partner->meta_description = $request->meta_description;
        $partner->serial_number = $request->serial_number;
        $partner->url = $request->url;
        $partner->company_address = $request->company_address;
        $partner->contact_person_name = $request->contact_person_name;
        $partner->save();

        PartnerProduct::where('partner_id',$partner->id)->delete();

        if (isset($input['product_id']) && !empty($input['product_id'])) {

            foreach($input['product_id'] as $key=>$v){

                $obj = new PartnerProduct;
                $obj->partner_id = $partner->id;
                $obj->product_id = $v;
                $obj->save();

            }

        }

        Session::flash('success', 'Partner updated successfully!');
        return "success";
    }

    public function delete(Request $request)
    {

        $partner = Partner::findOrFail($request->partner_id);
        @unlink('assets/front/img/partners/' . $partner->image);
        $partner->delete();

        Session::flash('success', 'Partner deleted successfully!');
        return back();
    }

    public function updateSection(Request $request)
    {
        $request->validate([
            'partner_section_title' => 'required',
            'partner_section_subtitle' => 'required',
        ]);

        $bs = BS::get();

        foreach($bs as $key=>$v){

            $data = $v;

            $data->partner_section_title = $request->partner_section_title;
            $data->partner_section_subtitle = $request->partner_section_subtitle;
            $data->partner_section_description = $request->partner_section_description;
            $data->partner_meta_keyword = $request->partner_meta_keyword;
            $data->partner_meta_description = $request->partner_meta_description;
            $data->save();

        }

        Session::flash('success', 'Text updated successfully!');
        return back();
    }

    public function getProduct(Request $request,$id){

        $prodcut = \App\Product::where('language_id',$id)
                            ->where('status',1)
                            ->where('is_featured',1)
                            ->pluck('title','id')->toArray();

        return view('admin.home.partner._get_product',compact('prodcut'));                   
    }
}
