<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Language;
use App\Testimonial;
use App\Adverticement;
use App\BasicSetting as BS;
use App\BasicExtended as BE;
use Validator;
use Session;

class AdvertisementController extends Controller
{
    public function index(Request $request)
    {
        $data['testimonials'] = Adverticement::orderBy('id', 'DESC')->get();

        return view('admin.advertisement.index', $data);
    }

    public function create()
    {
        return view('admin.advertisement.create');
    }

    public function edit($id)
    {
        $data['testimonial'] = Adverticement::findOrFail($id);
        return view('admin.advertisement.edit', $data);
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
            return response()->json(['errors' => $validator->errors(), 'id' => 'adverticement']);
        }

        $filename = time() . '.' . $img->getClientOriginalExtension();
        $request->session()->put('advertisement_image', $filename);
        $request->file('file')->move('assets/front/img/advertisement/', $filename);
        return response()->json(['status' => "session_put", "image" => "advertisement_image", 'filename' => $filename]);
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
            return response()->json(['errors' => $validator->errors(), 'id' => 'adverticement']);
        }

        $testimonial = Adverticement::findOrFail($id);
        if ($request->hasFile('file')) {
            $filename = time() . '.' . $img->getClientOriginalExtension();
            $request->file('file')->move('assets/front/img/advertisement/', $filename);
            @unlink('assets/front/img/advertisement/' . $testimonial->image);
            $testimonial->image = $filename;
            $testimonial->save();
        }

        return response()->json(['status' => "success", "image" => "Adverticement", 'testimonial' => $testimonial]);
    }

    public function store(Request $request)
    {
        $messages = [
            
            'iframe_data.required'=>'The iframe field is required.'
        ];

        $rules = [
            'name' => 'required',
            'serial_number' => 'required|integer',
        ];

        if (isset($request->add_type) && $request->add_type == 1) {
            
            $rules['description'] = 'required';
            
        }elseif (isset($request->add_type) && $request->add_type == 2) {
            
            $rules['iframe_data'] = 'required';
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $testimonial = new Adverticement;
        $testimonial->name = $request->name;
        $testimonial->image = isset($request->advertisement_image) ? $request->advertisement_image : Null;
        $testimonial->add_type = $request->add_type;

        if (isset($request->add_type) && $request->add_type == 1) {

            $testimonial->link = isset($request->link) ? $request->link : Null;
            $testimonial->description = isset($request->description) ? $request->description : Null;    
            $testimonial->iframe_data = Null;

        }else{

            $testimonial->link = Null;
            $testimonial->description = Null;    
            $testimonial->iframe_data = isset($request->iframe_data) ? $request->iframe_data : Null;    ;
        }

        $testimonial->serial_number = $request->serial_number;
        $testimonial->save();

        Session::flash('success', 'Adverticement added successfully!');
        return "success";
    }

    public function update(Request $request)
    {
        $rules = [
            'name' => 'required',
            'serial_number' => 'required|integer',
        ];


        if (isset($request->add_type) && $request->add_type == 1) {
            
            $rules['description'] = 'required';
            
        }elseif (isset($request->add_type) && $request->add_type == 2) {
            
            $rules['iframe_data'] = 'required';
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $testimonial = Adverticement::findOrFail($request->adverticement_id);
        $testimonial->name = $request->name;
        $testimonial->add_type = $request->add_type;
        
        if (isset($request->add_type) && $request->add_type == 1) {

            $testimonial->link = isset($request->link) ? $request->link : Null;
            $testimonial->description = isset($request->description) ? $request->description : Null;    
            $testimonial->iframe_data = Null;

        }else{

            $testimonial->link = Null;
            $testimonial->description = Null;    
            $testimonial->iframe_data = isset($request->iframe_data) ? $request->iframe_data : Null;    ;
        }

        $testimonial->serial_number = $request->serial_number;
        $testimonial->save();

        Session::flash('success', 'Adverticement updated successfully!');
        return "success";
    }

    public function delete(Request $request)
    {
        $testimonial = Adverticement::findOrFail($request->adverticement_id);
        @unlink('assets/front/img/adverticement/' . $testimonial->image);
        $testimonial->delete();

        Session::flash('success', 'Adverticement deleted successfully!');
        return back();
    }

    public function feature(Request $request)
    {
        $product = \App\Adverticement::find($request->adverticement_id);
        $product->status = $request->status;
        $product->save();

        if ($request->status == 1) {
            Session::flash('success', 'Featured successfully!');
        } else {
            Session::flash('success', 'Unfeatured successfully!');
        }

        return back();
    }
}
