<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\ApiCommanFunctionController as ApiCommanFunctionController;
use Str;

class CommonApiController extends ApiCommanFunctionController
{

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {

        $input = $request->all();

        $validator = Validator::make($input, [
            'email' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {

            return $this->sendError($validator->errors()->first(), [], 422);
        }

        $credentials = request(['email', 'password']);

        if (!$token = auth('api')->attempt($credentials)) {

            return $this->sendError('Unauthorized', [], 401);
        }
        $user = auth('api')->user(); // Get the authenticated user

        return $this->respondWithToken($token,$user);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $data = auth('api')->user();
        if ($data != null) {

            return $this->sendResponse(200, auth('api')->user(), 'User data successfully retrived.');
        } else {

            return $this->sendResponse(401, [], 'Data not found.');
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {

        auth('api')->logout();

        return $this->sendResponse(200, [], 'Logout successfully done.');
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token,$user)
    {
        $message='';
        if($user->role_id == '0'){
            // dd("in");
            $message = "Enter your role";
        }
        return response()->json([
            'status' => 200,
            'access_token' => $token,
            'message' => $message,
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => $user
        ]);
    }

    public function register(Request $request)
    {
        $input = $request->all();
        // dd($input);
        $validator = Validator::make($input, [
            'full_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), [], 422);
        }

        // Create a new user record
        $user = new User();
        $nameParts = explode(' ', $input['full_name'], 2);
        // dd($nameParts);
        $fname = $nameParts[0] ?? null;
        $lname = $nameParts[1] ?? null;

        $user->first_name = $fname;
        $user->last_name= $lname;
        $user->email = $input['email'];
        $user->password = bcrypt($input['password']); // Hash the password
        $user->unique_id= Str::random(20);
        if ($user->save()) {
            $token = auth('api')->login($user);
            return $this->respondWithToken($token,$user);
        } else {
            return $this->sendError('Registration failed', [], 500);
        }
    }

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found', 'status'=> 404]);
        }

        return response()->json(['user'=>$user,'status'=>200]);
    }



    // public function addWebpageMonitor(Request $request){

    //     try {

    //         //Get the logged in user
    //         $user = \App\User::find(auth('api')->id());
    //         // //Get the available webpages of the current user
    //         // $pages = \App\Models\Monitor::where('user_id', $user->id)
    //         //     ->where('type', 'webpage')
    //         //     ->whereNull('deleted_at')
    //         //     ->count();

    //         /*
    //         * refer app/Policies/MonitorPolicy.php
    //         */

    //         //Check whether the user is active or not
    //         if (!$user->can('isActive', Monitor::class)) {

    //             return $this->sendError(__('You are not allowed to add webpage, please contact support'),[],422);
    //         }

    //         //Check whether the user have a plan or not
    //         if ($user->can('view', Monitor::class)) {

    //             return $this->sendError(__('Add a plan'),[],422);
    //         }

    //         //Check whether the user's order is confirmed or not
    //         if (!$user->can('orderConfirm', Monitor::class)) {

    //             return $this->sendError(__('Your order is not confirmed.  wait sometime or Contact support'),[],422);
    //         }

    //         //Check whether the user's adding limit exceeded or not
    //         if (!$user->can('createWebpage', [Monitor::class, $pages])) {

    //             return $this->sendError(__('Limit exceeded'),[],422);

    //         }


    //         //Form validation
    //         $validator = Validator::make($request->all(), [
    //             'name' => 'required | unique:App\Models\Monitor,name,NULL,uuid,deleted_at,NULL',
    //             'url' => 'required',
    //             'expected_response_code' => 'required|numeric',
    //             'interval' => 'required',
    //             'email' => 'nullable|email'
    //         ]);
    //         if ($validator->fails()) {

    //             return $this->sendError($validator->errors()->first(),[],422);
    //         }

    //         //Get logged in user
    //         $user = auth('api')->user();
    //         $type = 'webpage';

    //         /*
    //          * service class that interact with the Monitor model.
    //          * refer app/Models/Services/MonitorService.php
    //          */
    //         $monitorService = new MonitorService();
    //         //Add webpage using addMonitor() function in the MonitorService
    //         //case of successfull addition of webpage

    //         $monitor = $monitorService->apiAddMonitor($request, $user, $type);

    //         return $this->sendResponse(200,$monitor,'Success!');

    //     } catch (\Exception $e) {

    //         return $this->sendResponse(401,[],'Something went wrong');
    //     }

    // }
}
