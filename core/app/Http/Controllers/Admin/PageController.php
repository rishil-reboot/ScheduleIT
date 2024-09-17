<?php 

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Page;
use App\Language;
use App\BasicSetting as BS;
use Session;
use Validator;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();
        $lang_id = $lang->id;
        $data['apages'] = Page::where('language_id', $lang_id)->orderBy('id', 'DESC')->get();

        $data['lang_id'] = $lang_id;
        return view('admin.page.index', $data);
    }

    public function create()
    {
        $data['tpages'] = Page::where('language_id', 0)->get();
        return view('admin.page.create', $data);
    }

    public function store(Request $request)
    {
        $slug = make_slug($request->slug);

        $messages = [
                     'language_id.required' => 'The language field is required',
                    ];

        $rules = [
                    'language_id' => 'required',
                    'name' => 'required',
                    'slug' => 'required',
                    'title' => 'required',
                    'subtitle' => 'required',
                    'body' => 'required',
                    'status' => 'required',
                    'serial_number' => 'required|integer',
                 ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) 
        {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $page = new Page;
        $page->language_id = $request->language_id;
        $page->name = $request->name;
        $page->title = $request->title;
        $page->title_font_size= $request->title_font_size;
        $page->title_font_style= $request->title_font_style;
        $page->subtitle = $request->subtitle;
        $page->subtitle_font_size= $request->subtitle_font_size;
        $page->subtitle_font_style= $request->subtitle_font_style;
        $page->slug = $slug;
        $page->body = $request->body;
        $page->status = $request->status;
        $page->serial_number = $request->serial_number;
        $page->meta_keywords = $request->meta_keywords;
        $page->meta_description = $request->meta_description;
        $page->gallery_id = (isset($request->gallery_id) && $request->gallery_id !='') ? $request->gallery_id : Null;
        $page->save();

        Session::flash('success', 'Page created successfully!');
        return "success";
    }

    public function edit($pageID)
    {
        $data['page'] = Page::findOrFail($pageID);
        return view('admin.page.edit', $data);
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
            return response()->json(['errors' => $validator->errors(), 'id' => 'page']);
        }

        $page = Page::findOrFail($id);
        if ($request->hasFile('file')) {
            $filename = time() . '.' . $img->getClientOriginalExtension();
            $request->file('file')->move('assets/front/img/page/', $filename);
            @unlink('assets/front/img/page/' . $page->image);
            $page->image = $filename;
            $page->save();
        }

        return response()->json(['status' => "success", "image" => "Page image", 'page' => $page]);
    }

    public function update(Request $request)
    {
        $slug = make_slug($request->slug);

        $rules = [
            'name' => 'required',
            'slug' => 'required',
            'title' => 'required',
            'subtitle' => 'required',
            'body' => 'required',
            'status' => 'required',
            'serial_number' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $pageID = $request->pageid;

        $page = Page::findOrFail($pageID);
        $page->name = $request->name;
        $page->title = $request->title;
        $page->title_font_size= $request->title_font_size;
        $page->title_font_style= $request->title_font_style;
        $page->subtitle = $request->subtitle;
        $page->subtitle_font_size= $request->subtitle_font_size;
        $page->subtitle_font_style= $request->subtitle_font_style;
        $page->slug = $slug;
        $page->body = $request->body;
        $page->status = $request->status;
        $page->serial_number = $request->serial_number;
        $page->meta_keywords = $request->meta_keywords;
        $page->meta_description = $request->meta_description;
        $page->gallery_id = (isset($request->gallery_id) && $request->gallery_id !='') ? $request->gallery_id : Null;
        $page->save();

        Session::flash('success', 'Page updated successfully!');
        return "success";
    }

    public function delete(Request $request)
    {
        $pageID = $request->pageid;
        $page = Page::findOrFail($pageID);
        $page->delete();
        Session::flash('success', 'Page deleted successfully!');
        return redirect()->back();
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        foreach ($ids as $id) {
            $page = Page::findOrFail($id);
            $page->delete();
        }

        Session::flash('success', 'Pages deleted successfully!');
        return "success";
    }
}
