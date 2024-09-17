<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;


class ApiController extends Controller
{

    public function index()
    {
        $users= User::all();
        if(!$users){
            return response()->json(['message' => 'User not found', 'status'=> 404]);
        }
        return response()->json([
            'message' => 'List of Users',
            'users' => $users,
            'status'=>200
        ]);
    }


    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found', 'status'=> 404]);
        }

        return response()->json(['user'=>$user,'status'=>200]);
    }

}
