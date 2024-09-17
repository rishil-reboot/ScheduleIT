<?php

namespace App\Http\Controllers\Admin;

use Session;
use Validator;
use App\Member;
use App\Gallery;
use App\Language;
use App\BasicSetting as BS;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->firstOrFail();
        $data['lang_id'] = $lang->id;
        $data['abs'] = $lang->basic_setting;
        $data['members'] = Member::where('language_id', $data['lang_id'])->get();

        return view('admin.home.member.index', $data);
    }

    public function create()
    {
        $data['mediaData'] = Gallery::all();
        return view('admin.home.member.create',$data);
    }

    public function edit($id)
    {
        $data['member'] = Member::findOrFail($id);
        $data['mediaData'] = Gallery::all();
        return view('admin.home.member.edit', $data);
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
            return response()->json(['errors' => $validator->errors(), 'id' => 'member']);
        }

        $filename = time() . '.' . $img->getClientOriginalExtension();
        $request->session()->put('member_image', $filename);
        $request->file('file')->move('assets/front/img/members/', $filename);
        return response()->json(['status' => "session_put", "image" => "member_image", 'filename' => $filename]);
    }

    public function teamUpload(Request $request, $langid)
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
            return response()->json(['errors' => $validator->errors(), 'id' => 'team_bg']);
        }

        if ($request->hasFile('file')) {
            $bs = BS::where('language_id', $langid)->firstOrFail();
            @unlink('assets/front/img/' . $bs->team_bg);
            $filename = uniqid() .'.'. $img->getClientOriginalExtension();
            $img->move('assets/front/img/', $filename);

            $bs->team_bg = $filename;
            $bs->save();

        }

        return response()->json(['status' => "success", 'image' => 'Team section background image']);
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
            return response()->json(['errors' => $validator->errors(), 'id' => 'member']);
        }

        $member = Member::findOrFail($id);
        if ($request->hasFile('file')) {
            $filename = time() . '.' . $img->getClientOriginalExtension();
            $request->file('file')->move('assets/front/img/members/', $filename);
            @unlink('assets/front/img/members/' . $member->image);
            $member->image = $filename;
            $member->save();
        }

        return response()->json(['status' => "success", "image" => "Member image", 'member' => $member]);
    }

    public function store(Request $request)
    {
        $slug = make_slug($request->slug);
        $messages = [
            'language_id.required' => 'The language field is required'
        ];

        $rules = [
            'language_id' => 'required',
            'member_image' => 'required',
            'name' => 'required|max:50',
            'slug' => 'required',
            'rank' => 'required|max:50',
            'facebook' => 'nullable',
            'twitter' => 'nullable',
            'linkedin' => 'nullable',
            'instagram' => 'nullable',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $member = new Member;
        $member->language_id = $request->language_id;
        $member->image = $request->member_image;
        $member->name = $request->name;
        $member->rank = $request->rank;
        $member->slug = $slug;
        $member->body = $request->body;
        $member->facebook = $request->facebook;
        $member->twitter = $request->twitter;
        $member->linkedin = $request->linkedin;
        $member->instagram = $request->instagram;
        $member->meta_keywords = $request->meta_keywords;
        $member->meta_description = $request->meta_description;
        $member->display_facebook = $request->display_facebook;
        $member->display_instagram = $request->display_instagram;
        $member->display_linkedin = $request->display_linkedin;
        $member->display_twitter = $request->display_twitter;
        $member->save();

        Session::flash('success', 'Member added successfully!');
        return "success";
    }

    public function update(Request $request)
    {
        $slug = make_slug($request->slug);

        $rules = [
            'name' => 'required|max:50',
            'slug' => 'required',
            'rank' => 'required|max:50',
            'facebook' => 'nullable',
            'twitter' => 'nullable',
            'linkedin' => 'nullable',
            'instagram' => 'nullable',
            'body' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $member = Member::findOrFail($request->member_id);
        $member->name = $request->name;
        $member->rank = $request->rank;
        $member->slug = $slug;
        $member->body = $request->body;
        $member->facebook = $request->facebook;
        $member->twitter = $request->twitter;
        $member->linkedin = $request->linkedin;
        $member->instagram = $request->instagram;
        $member->meta_keywords = $request->meta_keywords;
        $member->meta_description = $request->meta_description;
        $member->display_facebook = $request->display_facebook;
        $member->display_instagram = $request->display_instagram;
        $member->display_linkedin = $request->display_linkedin;
        $member->display_twitter = $request->display_twitter;
        $member->save();

        Session::flash('success', 'Member updated successfully!');
        return "success";
    }

    public function textupdate(Request $request, $langid)
    {
        $request->validate([
            'team_section_title' => 'required|max:25',
            'team_section_subtitle' => 'required|max:250',
        ]);

        $bs = BS::where('language_id', $langid)->firstOrFail();
        $bs->team_section_title = $request->team_section_title;
        $bs->team_section_subtitle = $request->team_section_subtitle;
        $bs->save();

        Session::flash('success', 'Text updated successfully!');
        return back();
    }

    public function delete(Request $request)
    {

        $member = Member::findOrFail($request->member_id);
        @unlink('assets/front/img/members/' . $member->image);
        $member->delete();

        Session::flash('success', 'Member deleted successfully!');
        return back();
    }

    public function feature(Request $request)
    {
        $member = Member::find($request->member_id);
        $member->feature = $request->feature;
        $member->save();

        if ($request->feature == 1) {
            Session::flash('success', 'Featured successfully!');
        } else {
            Session::flash('success', 'Unfeatured successfully!');
        }

        return back();
    }

    public function getPreview(Request $request){

        $data['page'] = Member::where('id', $request->id)->firstOrFail();

        return view('admin.home.member.preview', $data);
    }
}
