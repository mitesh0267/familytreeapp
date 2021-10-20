<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;


class ApiController extends Controller
{
    
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        //valid credential
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:8'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(["status" => "failed",'code' => 422, "message" => $validator->messages()->first()],422);
        }

        //Crean token
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['status' => "failed", 'code' => 400,'message' => 'Login credentials are invalid.',], 400);
            }
        } catch (JWTException $e) {
            return $credentials;
                return response()->json([
                        'status' => "failed",
                        'code' => 500,
                        'message' => 'Could not create token.',
                    ], 500);
        }
        //Token created, return with success response and jwt token
        $user = JWTAuth::user();
        return response()->json([
            "email" => $user->email,
            "role" => $user->role,
            "id" => $user->id,
            'token' => $token,
            'success' => true,
            "code"=> "200"
        ]);
    }
 
}
