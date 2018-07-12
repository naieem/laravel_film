<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Validator;
use JWTAuth;
use JWTFactory;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Title:register
     * Description: function to register user
     * @param $request paramer
     * @return
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'name' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }


        try{
            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => bcrypt($request->get('password')),
            ]);
            if($user){
                return response([
                    "status" => true,
                    "message" => "User created succefully"
                ], 200);
            }
        }catch(\Illuminate\Database\QueryException $error){
            return [
                'status' => false,
                'message' =>$error->errorInfo[2]
            ];
        }
    }
}
