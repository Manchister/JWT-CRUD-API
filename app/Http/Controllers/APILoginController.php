<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers;
use App\User;
use JWTFactory;
use JWTAuth;
use Response;
use Validator;

class APILoginController extends Controller
{

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|max:255',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $cred = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($cred)) {
                return response()->json(['error', 'invalid email or password', [401]]);
            }
        } catch (JWTExp $e) {
            return response()->json(['error', 'could not create the token', [500]]);
        }

        return response()->json(compact('token'));
    }
    
}
