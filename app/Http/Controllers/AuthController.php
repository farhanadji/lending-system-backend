<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use App\User;
use Auth;

class AuthController extends Controller
{
    public function login(Request $request){
        $this->validate($request, [
            'email' => 'required', 
            'password' => 'required',
        ]);
      
        $user = User::where('email', '=', $request->email)->firstOrFail();
        $status = "error";
        $message = "";
        $data = null;
        $code = 401;
        if($user){
            if(Hash::check($request->password, $user->password)){
                $user->generateToken();
                $status = 'success';
                $message = 'login success';
                $data = $user->toArray();
                $code = 200;
            }else{
                $message = 'password incorrect';
            }
        }else{
            $message = 'email incorrect';
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public function register(Request $request){        
        $status = "error";
        $message = "";
        $data = null;
        $code = 400;
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => "CUSTOMER"
        ]);

        if($user){
            $user->generateToken();
            $status = "success";
            $message = "register success";
            $data = $user->toArray();
            $code = 200;
        }else{
            $message = "register failed";
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ],$code);
    }

    public function logout(Request $request){
        $user = Auth::user();
        if($user){
            $user->api_token = null;
            $user->save();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'logout success',
            'data' => null
        ],200);
    }
}
