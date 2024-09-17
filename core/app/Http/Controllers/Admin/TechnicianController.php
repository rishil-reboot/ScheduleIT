<?php

namespace App\Http\Controllers\Admin;

use App\Models\Technician;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Role;
use App\Testimonial;
use Illuminate\Http\Request;
use Validator;
use Session;
use Illuminate\Support\Facades\DB;

class TechnicianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $data['users'] = User::all();
        $data['technicians'] = Technician::select('id','user_id','specialization','experience_years','availability_status')->with('user')->get();
        $data['role_id'] = Role::where('name', 'technician')->pluck('id')->first();
        return view('admin.technician.index', $data);

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
        // dd($request->all());
        $messages = [
            'first_name.required' => 'First name  is required',
            'last_name' => 'Last name is required.',
            'email.required' => 'Email id required',
            'password.required'=> 'password field is required',

          ];

          $rules = [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:admins',
            'password' => 'required|confirmed',

          ];


      $validator = Validator::make($request->all(), $rules, $messages);
      if ($validator->fails()) {
        $errmsgs = $validator->getMessageBag()->add('error', 'true');
        return response()->json($validator->errors());
      }

      DB::beginTransaction();

      try {
        $user = new User;
        $user->role_id = $request->role_id;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->address = $request->address;
        $user->password = bcrypt($request->password);
        $user->save();

        Technician::create([
            'user_id' => $user->id,
            'specialization' => $request->specialization,
            'experience_years' => $request->experience_years,
            'availability_status' => $request->status
        ]);

        DB::commit();
        Session::flash('success', 'Technician created successfully!');
        return "success";
    } catch (\Exception $e) {
        dd($e->getMessage());
        DB::rollBack();
        return response()->json(['error' => 'Failed to create technician.'] . $e->getMessage());
    }
    }

    /**
     * Display the specified resource.
     */
    public function show(Technician $technician)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {
        $technician= Technician::with('user')->findOrFail($id);
        // dd($technician);
        return view('admin.technician.edit',compact('technician'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
{
    // Validation messages and rules
    // dd($request->all());
    $messages = [
        'first_name.required' => 'First name is required',
        'last_name.required' => 'Last name is required',
        'password.confirmed' => 'Password confirmation does not match',
    ];

    $rules = [
        'first_name' => 'required|max:255',
        'last_name' => 'required|max:255',
    ];
    // Validate request
    $validator = Validator::make($request->all(), $rules, $messages);
    if ($validator->fails()) {
        return response()->json($validator->errors());
    }

    DB::beginTransaction();

    try {
        $user = User::find($request->user_id);
        $user->first_name = $request->input('first_name', $user->first_name);
        $user->last_name = $request->input('last_name', $user->last_name);
        $user->phone_number = $request->input('phone_number', $user->phone_number);
        $user->address = $request->input('address', $user->address);
        $user->save();

        $technician = Technician::where('user_id', $user->id)->firstOrFail();
        $technician->specialization = $request->input('specialization', $technician->specialization);
        $technician->experience_years = $request->input('experience_years', $technician->experience_years);
        $technician->availability_status = $request->input('availability_status', $technician->availability_status);
        // dd($technician->availability_status);

        $technician->save();

        DB::commit();

        Session::flash('success', 'Technician updated successfully!');
        return response()->json('success');
    } catch (\Exception $e) {
        // dd($e->getMessage());
        DB::rollBack();
        return response()->json(['error' => 'Failed to update technician. ' . $e->getMessage()]);
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        // dd($request->all());


          $user = User::findOrFail($request->user_id);
          $user->delete();

          Session::flash('success', 'User deleted successfully!');
          return back();
    }
}
