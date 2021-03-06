<?php

namespace App\Http\Controllers;

use App\HTTP\Controllers;
use App\HTTP\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;
// use Tymon\JWTAuth\Facades\JWTAuth;

class APIRegisterController extends Controller
{

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ])->first();

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('token'));

        
    }

}
