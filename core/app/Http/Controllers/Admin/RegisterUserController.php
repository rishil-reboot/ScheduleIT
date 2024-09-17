<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Session;
use Validator;
use Rap2hpoutre\FastExcel\FastExcel;

class RegisterUserController extends Controller
{
    public function index()
    {
        $users = User::withCount(['booking','transaction'])->paginate(10);

        return view('admin.register_user.index',compact('users'));
    }

    public function view($id)
    {
        $user = User::findOrFail($id);
        $orders = $user->orders()->paginate(10);
        return view('admin.register_user.details',compact('user', 'orders'));
    }

    public function create(){

        return view('admin.register_user.create');
    }

    public function edit($id){

        $data['user'] = User::findOrFail($id);
        return view('admin.register_user.edit', $data);
    }

    public function store(Request $request)
    {

        $messages = [

            'email.check_register_user_email_exit'=>"This email address is already used.",
            'username.check_register_user_username_exit'=>"This username is already used."
        ];

        $rules = [

            'username' => 'required|CheckRegisterUserUsernameExit',
            'email' => 'required|email|CheckRegisterUserEmailExit',
            'number' => 'nullable|numeric|digits:10',
            'shpping_email' => 'nullable|email',
            'billing_email' => 'nullable|email',
            'shpping_number' => 'nullable|numeric|digits:10',
            'billing_number' => 'nullable|numeric|digits:10',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6'
        ];

        $validator = Validator::make($request->all(), $rules,$messages);

        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
            
        $bsetting = \App\BasicSetting::first();

        $obj = new User;

        // Customer details
        $obj->fname = $request->fname;
        $obj->lname = $request->lname;
        $obj->username = $request->username;
        $obj->password = bcrypt($request['password']);
        $obj->email = $request->email;
        $obj->number = $request->number;
        $obj->status = $request->status;
        $obj->country = $request->country;
        $obj->state = $request->state;
        $obj->city = $request->city;
        $obj->address = $request->address;
        $obj->credit = $bsetting->default_credit;

        // Shipping details 

        $obj->shpping_fname = $request->shpping_fname;
        $obj->shpping_lname = $request->shpping_lname;
        $obj->shpping_email = $request->shpping_email;
        $obj->shpping_number = $request->shpping_number;
        $obj->shpping_city = $request->shpping_city;
        $obj->shpping_state = $request->shpping_state;
        $obj->shpping_country = $request->shpping_country;
        $obj->shpping_address = $request->shpping_address;

        // Billing details 

        $obj->billing_fname = $request->billing_fname;
        $obj->billing_lname = $request->billing_lname;
        $obj->billing_email = $request->billing_email;
        $obj->billing_number = $request->billing_number;
        $obj->billing_city = $request->billing_city;
        $obj->billing_state = $request->billing_state;
        $obj->billing_address = $request->billing_address;
        $obj->billing_country = $request->billing_country;

        $obj->save();

        Session::flash('success', 'Customer created successfully!');
        return "success";
    }

    public function update(Request $request)
    {

        $input = $request->all();

        $messages = [

            'email.check_register_user_email_exit'=>"This email address is already used.",
            'username.check_register_user_username_exit'=>"This username is already used."
        ];

        $rules = [

            'username' => 'required|CheckRegisterUserUsernameExit:'.$request->userid.'',
            'email' => 'required|email|CheckRegisterUserEmailExit:'.$request->userid.'',
            'number' => 'nullable|numeric|digits:10',
            'shpping_email' => 'nullable|email',
            'billing_email' => 'nullable|email',
            'shpping_number' => 'nullable|numeric|digits:10',
            'billing_number' => 'nullable|numeric|digits:10',
        ];


        if (isset($input['is_change_password']) && $input['is_change_password'] == 1) {

            $rules['password'] = 'min:6|required_with:password_confirmation|same:password_confirmation';
            $rules['password_confirmation'] = 'min:6';
        
        }

        $validator = Validator::make($request->all(), $rules,$messages);

        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $userId = $request->userid;

        $obj = User::findOrFail($userId);

        // Customer details
        $obj->fname = $request->fname;
        $obj->lname = $request->lname;
        $obj->username = $request->username;
        $obj->email = $request->email;
        $obj->number = $request->number;
        $obj->status = $request->status;
        $obj->country = $request->country;
        $obj->state = $request->state;
        $obj->city = $request->city;
        $obj->address = $request->address;

        if (isset($input['is_change_password']) && $input['is_change_password'] == 1) {

            $obj->password = bcrypt($request['password']);
        }

        // Shipping details 

        $obj->shpping_fname = $request->shpping_fname;
        $obj->shpping_lname = $request->shpping_lname;
        $obj->shpping_email = $request->shpping_email;
        $obj->shpping_number = $request->shpping_number;
        $obj->shpping_city = $request->shpping_city;
        $obj->shpping_state = $request->shpping_state;
        $obj->shpping_country = $request->shpping_country;
        $obj->shpping_address = $request->shpping_address;

        // Billing details 

        $obj->billing_fname = $request->billing_fname;
        $obj->billing_lname = $request->billing_lname;
        $obj->billing_email = $request->billing_email;
        $obj->billing_number = $request->billing_number;
        $obj->billing_city = $request->billing_city;
        $obj->billing_state = $request->billing_state;
        $obj->billing_address = $request->billing_address;
        $obj->billing_country = $request->billing_country;

        $obj->save();

        Session::flash('success', 'Customer details updated successfully!');
        return "success";
    }

    public function userban(Request $request)
    {

        $user = User::findOrFail($request->user_id);
        $user->update([
            'status' => $request->status,
        ]);

        Session::flash('success', $user->username.' status update successfully!');
        return back();
    
    }

    /**
     * This function is used to export customer
     * @author Chirag Ghevariya
     */
    public function export(Request $request){

        $data = User::all();

        return (new FastExcel($data))->download('customer.xlsx', function ($customer) {
            return [
                'First Name' => $customer->fname,
                'Last Name' => $customer->lname,
                'Username' => $customer->username,
                'Email' => $customer->email,
                'Mobile' => $customer->number,
                'Country' => $customer->country,
                'State' => $customer->state,
                'City' => $customer->city,
                'Address' => $customer->address,
                'Billing First Name' => $customer->billing_fname,
                'Billing Last Name' => $customer->billing_lname,
                'Billing Email' => $customer->billing_email,
                'Billing Mobile' => $customer->billing_number,
                'Billing Country' => $customer->billing_country,
                'Billing State' => $customer->billing_state,
                'Billing City' => $customer->billing_city,
                'Billing Address' => $customer->billing_address,
                'Shipping First Name' => $customer->shpping_fname,
                'Shipping Last Name' => $customer->shpping_lname,
                'Shipping Email' => $customer->shpping_email,
                'Shipping Mobile' => $customer->shpping_number,
                'Shipping Country' => $customer->shpping_country,
                'Shipping State' => $customer->shpping_state,
                'Shipping City' => $customer->shpping_city,
                'Shipping Address' => $customer->shpping_address,
                'Email Verified' => $customer->email_verified,
                'Status' => ($customer->status == 1) ? 'Active':'DeActive',
                'Created At' => $customer->created_at,
                'Updated At' => $customer->updated_at,
            ];
        });

    }

    /**
     * This function is used to import subscribers
     * @author Chirag Ghevariya
     */
    public function import(Request $request){

        $input = $request->all();

        $rules = [
            'import_file' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $media_type_image_upload = $request->file('import_file');

        $allowedExts = array('xlsx','xls');
        $rules = [
            'import_file' => [
                function ($attribute, $value, $fail) use ($media_type_image_upload, $allowedExts) {
                    if (!empty($media_type_image_upload)) {
                        $ext = $media_type_image_upload->getClientOriginalExtension();
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only xlsx, xls, file is allowed.");
                        }
                    }
                },
            ],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $bsetting = \App\BasicSetting::first();

        if($request->hasFile('import_file')){

            $subscriber = (new FastExcel)->import($request->file('import_file')->getRealPath(), function ($data) {
                        
                            if (isset($data['username']) && !empty($data['username']) && isset($data['email']) && !empty($data['email']) && isset($data['password']) && !empty($data['password']) && isset($data['status'])) {

                                $record = User::where(function($query) use($data){

                                                    $query->where('username',$data['username'])
                                                          ->orWhere('email',$data['email']);      

                                                })->first();

                                if ($record == null) {

                                    $obj = new User;
                                    $obj->fname = (isset($data['first_name']) && !empty($data['first_name'])) ? $data['first_name'] : Null; 
                                    $obj->lname = (isset($data['last_name']) && !empty($data['last_name'])) ? $data['last_name'] : Null; 
                                    $obj->username = $data['username'];
                                    $obj->email = $data['email'];
                                    $obj->password = \Hash::make($data['password']);
                                    $obj->number = (isset($data['number']) && !empty($data['number'])) ? $data['number'] : Null; 
                                    $obj->country = (isset($data['country']) && !empty($data['country'])) ? $data['country'] : Null; 
                                    $obj->state = (isset($data['state']) && !empty($data['state'])) ? $data['state'] : Null; 
                                    $obj->city = (isset($data['city']) && !empty($data['city'])) ? $data['city'] : Null; 
                                    $obj->address = (isset($data['address']) && !empty($data['address'])) ? $data['address'] : Null;
                                    $obj->credit = $bsetting->default_credit;

                                    $obj->billing_fname = (isset($data['billing_first_name']) && !empty($data['billing_first_name'])) ? $data['billing_first_name'] : Null; 
                                    $obj->billing_lname = (isset($data['billing_last_name']) && !empty($data['billing_last_name'])) ? $data['billing_last_name'] : Null; 
                                    $obj->billing_email = (isset($data['billing_email']) && !empty($data['billing_email'])) ? $data['billing_email'] : Null; 
                                    $obj->billing_number = (isset($data['billing_number']) && !empty($data['billing_number'])) ? $data['billing_number'] : Null; 
                                    $obj->billing_country = (isset($data['billing_country']) && !empty($data['billing_country'])) ? $data['billing_country'] : Null; 
                                    $obj->billing_state = (isset($data['billing_state']) && !empty($data['billing_state'])) ? $data['billing_state'] : Null; 
                                    $obj->billing_city = (isset($data['billing_city']) && !empty($data['billing_city'])) ? $data['billing_city'] : Null; 
                                    $obj->billing_address = (isset($data['billing_address']) && !empty($data['billing_address'])) ? $data['billing_address'] : Null; 

                                    $obj->shpping_fname = (isset($data['shipping_first_name']) && !empty($data['shipping_first_name'])) ? $data['shipping_first_name'] : Null; 
                                    $obj->shpping_lname = (isset($data['shipping_last_name']) && !empty($data['shipping_last_name'])) ? $data['shipping_last_name'] : Null; 
                                    $obj->shpping_email = (isset($data['shipping_email']) && !empty($data['shipping_email'])) ? $data['shipping_email'] : Null; 
                                    $obj->shpping_number = (isset($data['shipping_number']) && !empty($data['shipping_number'])) ? $data['shipping_number'] : Null; 
                                    $obj->shpping_country = (isset($data['shipping_country']) && !empty($data['shipping_country'])) ? $data['shipping_country'] : Null; 
                                    $obj->shpping_state = (isset($data['shipping_state']) && !empty($data['shipping_state'])) ? $data['shipping_state'] : Null; 
                                    $obj->shpping_city = (isset($data['shipping_city']) && !empty($data['shipping_city'])) ? $data['shipping_city'] : Null; 
                                    $obj->shpping_address = (isset($data['shipping_address']) && !empty($data['shipping_address'])) ? $data['shipping_address'] : Null; 
                                    $obj->email_verified = "yes"; 
                                    $obj->status = (isset($data['status'])) ? $data['status'] : 0; 

                                    $obj->save(); 
                                }
                            }
                        });
        }

        Session::flash('success', 'Customer successfully imported!');
        return "success";
    }

    /**
     * Change user credit of the specified user.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateCredit(Request $request) {

        $data = $request->all();
        $data['credit'] = $data['value'];
        $user = User::find($data['userId']);
       
        $user->update($data);
        $array = array();
        $array['success'] = true;
        session()->flash('success_message', trans('admin/user.credit_update_message'));
        echo json_encode($array);
    }

    /**
     * Change user credit of the specified user.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateDefaultCredit(Request $request) {

        $messages = [

            'default_credit.required'=>"This credit field is required."
        ];

        $rules = [

            'default_credit' => 'required|numeric'
        ];

        $validator = Validator::make($request->all(), $rules,$messages);

        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $bs = \App\BasicSetting::get();

        foreach($bs as $key=>$v){

            $obj = $v;
            $obj->default_credit = $request->default_credit;
            $obj->save();
        }
        
        Session::flash('success', 'Credit successfully updated!');
        return back();
    }
}
