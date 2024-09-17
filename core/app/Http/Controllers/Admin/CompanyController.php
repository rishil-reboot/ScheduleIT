<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use App\Http\Controllers\Controller;
use App\Models\Technician;
use App\Role;
use Illuminate\Http\Request;
use Validator;
use Session;
use Illuminate\Support\Facades\DB;
use Svg\Tag\Rect;
use App\Models\User;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['companies'] = Company::select('id','user_id','establised_year')->with('user')->get();
        $data['role_id'] = Role::where('name', 'company')->pluck('id')->first();
        return view ('admin.customer.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

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
        $user = new User();
        $user->role_id = $request->role_id;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->address = $request->address;
        $user->password = bcrypt($request->password);
        $user->save();

        Company::create([
            'user_id' => $user->id,
            'establised_year' => $request->establised_year,
            'industry_type' => $request->industry_type,
        ]);

        DB::commit();
        Session::flash('success', 'Company created successfully!');
        return "success";
    } catch (\Exception $e) {
        dd($e->getMessage());
        DB::rollBack();
        return response()->json(['error' => 'Failed to created company.'] . $e->getMessage());
    }
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $user->delete();

        Session::flash('success', 'User deleted successfully!');
        return back();
    }
}
