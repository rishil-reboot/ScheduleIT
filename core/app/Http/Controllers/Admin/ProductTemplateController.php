<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Language;
use App\ProductTemplate;
use App\BasicSetting as BS;
use App\BasicExtended as BE;
use Validator;
use Session;

class ProductTemplateController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->firstOrFail();
        $data['lang_id'] = $lang->id;
        $data['abs'] = $lang->basic_setting;
        $data['abe'] = $lang->basic_extended;
        $data['testimonials'] = ProductTemplate::where('language_id', $data['lang_id'])->orderBy('id', 'DESC')->get();

        return view('admin.product.product_template.index', $data);
    }

    public function edit($id)
    {
        $data['testimonial'] = ProductTemplate::findOrFail($id);
        return view('admin.product.product_template.edit', $data);
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
        $request->file('file')->move('assets/front/img/product_template/', $filename);
        return response()->json(['status' => "session_put", "image" => "template_image", 'filename' => $filename]);
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
            return response()->json(['errors' => $validator->errors(), 'id' => 'template']);
        }

        $testimonial = ProductTemplate::findOrFail($id);
        if ($request->hasFile('file')) {
            $filename = time() . '.' . $img->getClientOriginalExtension();
            $request->file('file')->move('assets/front/img/product_template/', $filename);
            @unlink('assets/front/img/product_template/' . $testimonial->image);
            $testimonial->image = $filename;
            $testimonial->save();
        }

        return response()->json(['status' => "success", "image" => "Template", 'testimonial' => $testimonial]);
    }

    public function store(Request $request)
    {
        $messages = [
            'language_id.required' => 'The language field is required'
        ];

        $rules = [
            'language_id' => 'required',
            'template_image' => 'required',
            'name' => 'required|max:50',
            'serial_number' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $testimonial = new ProductTemplate;
        $testimonial->language_id = $request->language_id;
        $testimonial->name = $request->name;
        $testimonial->image = $request->template_image;
        $testimonial->serial_number = $request->serial_number;
        $testimonial->save();

        Session::flash('success', 'Product template added successfully!');
        return "success";
    }

    public function update(Request $request)
    {
        $rules = [
            'name' => 'required|max:50',
            'serial_number' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $testimonial = ProductTemplate::findOrFail($request->template_id);
        $testimonial->name = $request->name;
        $testimonial->serial_number = $request->serial_number;
        $testimonial->save();

        Session::flash('success', 'Product template updated successfully!');
        return "success";
    }

    public function delete(Request $request)
    {
        $testimonial = ProductTemplate::findOrFail($request->template_id);
        @unlink('assets/front/img/product_template/' . $testimonial->image);
        $testimonial->delete();

        Session::flash('success', 'Product template deleted successfully!');
        return back();
    }
}
