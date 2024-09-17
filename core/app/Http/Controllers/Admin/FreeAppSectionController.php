<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FreeAppSection;
use App\Models\FreeAppSectionImage;
use Validator;
use Session;
use App\Language;
use Svg\Tag\Rect;

class FreeAppSectionController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();

        $lang_id = $lang->id;
        $data['apps'] = FreeAppSection::where('language_id', $lang_id)->orderBy('id', 'DESC')->paginate(10);
        $data['lang_id'] = $lang_id;

        return view ('admin.home.free_app.index',$data);
    }

    public function create()
    {
        return view ('admin.home.free_app.create');
    }


    public function store(Request $request)
    {
        $input = $request->all();
        $slug = make_slug($request->title);

        $rules = [
            'language_id' => 'required',
            'title' => 'required|max:255',
            'subtitle' => 'required|max:255',
            // 'slider_images' => 'required',
        ];

        $messages = [
            'title.required' => 'title is required',
            'subtitle.required' => 'subtitle is required',
            'language_id.required' => 'The language field is required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $in = $request->all();
        $in['slug'] = $slug;

        $freeAppSection = FreeAppSection::create($in);

        return response()->json(['status' => 'success', 'free_app_section_id' => $freeAppSection->id]);
    }




    public function sliderstore(Request $request)
    {
        $img = $request->file('file');
        $allowedExts = ['jpg', 'png', 'jpeg'];

        $rules = [
            'file' => [
                function ($attribute, $value, $fail) use ($img, $allowedExts) {
                    $ext = $img->getClientOriginalExtension();
                    if (!in_array($ext, $allowedExts)) {
                        return $fail("Only png, jpg, jpeg images are allowed");
                    }
                },
            ]
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $filename = uniqid() . '.jpg';
        $img->move('assets/front/img/free-app/sliders/', $filename);

        $pi = new FreeAppSectionImage;
        $pi->image = $filename;
        $pi->free_app_section_id = $request->app_id;
        $pi->save();

        return response()->json(['status' => 'success', 'file_id' => $pi->id]);
    }


    public function edit($id)
    {
        $freeAppSection = FreeAppSection::with('freeAppsectionImages')->findOrFail($id);
        return view('admin.home.free_app.edit', compact('freeAppSection'));
    }


    public function destroy(Request $request)
    {
        $freeAppSection = FreeAppSection::findOrFail($request->app_id);
        foreach ($freeAppSection->freeAppsectionImages as $key => $pi) {
            @unlink('assets/front/img/free-app/sliders/' . $pi->image);
            $pi->delete();
        }
        // @unlink('assets/front/img/free-app/sliders/' . $pi->image);
        $freeAppSection->delete();

        Session::flash('success', 'freeAppSection deleted successfully!');
        return back();
    }

    public function sliderrmv(Request $request)
    {
        $pi = FreeAppSectionImage::findOrFail($request->fileid);
        @unlink('assets/front/img/free-app/sliders/' . $pi->image);
        $pi->delete();
        return $pi->id;
    }


    public function update(Request $request)
    {
        $slug = make_slug($request->title);

        $rules = [
            'title' => 'required|max:255',
            'subtitle' => 'required|max:255',
        ];

        $messages = [
            'title.required' => 'title is required',
             'subtitle.required' => 'subtitle is required'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $FreeAppSection = FreeAppSection::findOrFail($request->app_id);
        $FreeAppSection->title= $request->title;
        $FreeAppSection->slug = $slug;
        $FreeAppSection->subtitle= $request->subtitle;
        $FreeAppSection->save();

        Session::flash('success', 'Free app updated successfully!');
        return "success";

        }

        public function sliderUpdate(Request $request)
        {
            $img = $request->file('file');
            $allowedExts = ['jpg', 'png', 'jpeg'];

            $rules = [
                'file' => [
                    function ($attribute, $value, $fail) use ($img, $allowedExts) {
                        $ext = $img->getClientOriginalExtension();
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only png, jpg, jpeg images are allowed");
                        }
                    },
                ]
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $filename = uniqid() . '.jpg';
            $img->move('assets/front/img/free-app/sliders/', $filename);
            $FreeAppSection = FreeAppSectionImage::findOrFail($request->app_id);
            $pi = new FreeAppSectionImage;
            $pi->image = $filename;
            $pi->free_app_section_id = $request->app_id;
            $pi->save();

            return response()->json(['status' => 'success', 'file_id' => $pi->id]);
        }


        public function images($appid)
        {
            $images = FreeAppSectionImage::where('free_app_section_id', $appid)->get();
             return $images;
        }


        public function bulkDelete(Request $request)
        {
            $ids = $request->ids;
            foreach ($ids as $id) {
            $freeAppSection = FreeAppSection::findOrFail($id);

            foreach ($freeAppSection->freeAppsectionImages as $pi) {
                @unlink('assets/front/img/free-app/sliders/' . $pi->image);
                $pi->delete();
            }
            }
            foreach ($ids as $id) {
            $portfolio = FreeAppSection::findOrFail($id);
            $portfolio->delete();
            }

            Session::flash('success', 'Records deleted successfully!');
            return "success";
        }


}
