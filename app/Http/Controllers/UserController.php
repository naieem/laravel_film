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

    /**
     * Title:login
     * Description: function to login user in portal
     * @param $request paramer
     * @return
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        return response()->json(compact('token'));
    }

    /**
     * Title:login
     * Description: function to login user in portal
     * @param $request paramer
     * @return
     */
    public function verify(Request $request)
    {
        $token = $request->header('Authorization');
        $decryptedToken = JWTAuth::toUser($token);
        if($decryptedToken){
            return response([
                "token"=>$decryptedToken
            ],200);
        }else{
            return response([
                "status"=>false,
                "message"=>"Token has expired"
            ],200);
        }
    }
}
