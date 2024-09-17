<?php

namespace App\Http\Controllers\admin;

use App\Models\Step;
use App\Http\Controllers\Controller;
use App\Language;
use Illuminate\Http\Request;
use Validator;
use Session;



class StepsSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->firstOrFail();
        $data['lang_id'] = $lang->id;
        $data['abs'] = $lang->basic_setting;
        $data['abe'] = $lang->basic_extended;
        $data['steps'] = Step::where('language_id', $data['lang_id'])->orderBy('id', 'DESC')->get();

        return view ('admin.home.step.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $messages = [
            'language_id.required' => 'The language field is required'
        ];

        $rules = [
            'language_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'serial_number' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $step = new Step;
        $step->language_id = $request->language_id;
        $step->step_number = $request->step_number;
        $step->title = $request->title;
        $step->description = $request->description;
        $step->serial_number = $request->serial_number;
        $step->image = $request->step_image;
        $step->save();

        Session::flash('success', 'Step added successfully!');
        return "success";
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
            return response()->json(['errors' => $validator->errors(), 'id' => 'step']);
        }

        $filename = time() . '.' . $img->getClientOriginalExtension();
        $request->session()->put('steps', $filename);
        $request->file('file')->move('assets/front/img/steps/', $filename);
        return response()->json(['status' => "session_put", "image" => "step_image", 'filename' => $filename]);
    }



    /**
     * Display the specified resource.
     */
    public function show(step $step)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $step = Step::find($id);
        return view('admin.home.step.edit',compact('step'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, step $step)
    {

        $rules = [
            'title' => 'required',
            'description' => 'required',
            'serial_number' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $step = Step::find($request->step_id);
        $step->step_number = $request->step_number;
        $step->title = $request->title;
        $step->description = $request->description;
        $step->serial_number = $request->serial_number;
        $step->save();
        Session::flash('success', 'Steps updated successfully!');
        return "success";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, step $step)
    {
        $step = Step::findOrFail($request->step_id);
        @unlink('assets/front/img/steps/' . $step->image);
        $step->delete();

        Session::flash('success', 'Step deleted successfully!');
        return back();
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
            return response()->json(['errors' => $validator->errors(), 'id' => 'step']);
        }

        $step = Step::findOrFail($id);
        if ($request->hasFile('file')) {
            $filename = time() . '.' . $img->getClientOriginalExtension();
            $request->file('file')->move('assets/front/img/steps/', $filename);
            @unlink('assets/front/img/steps/' . $step->image);
            $step->image = $filename;
            $step->save();
        }

        return response()->json(['status' => "success", "image" => "Step", 'step' => $step]);
    }
}
