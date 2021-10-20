<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use JWTAuth;
use DB;
use App\Traits\ResponseFormat;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Hash;
use App\Mail\SendResetPwdSuccessMail;
use Illuminate\Support\Str;


class AuthenticationController extends Controller
{
    use ResponseFormat;

    public function sendResetLinkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "failed",'code' => 422, "message" => $validator->messages()->first()],422);
        }
        $user = User::where('email', $request->email)->first();
        if($user) {
            $payload = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email
            ];
            $token = Str::random(80);
            //Create Password Reset Token
            \DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $token
            ]);
            //Get the token just created above
           $tokenData = \DB::table('password_resets')->where('email', $request->email)->first();
           if ($this->sendResetEmail($request->email, $tokenData->token)) {
            return $this->sendResponse("We have sent password reset link to your email address. Please check your inbox for next steps");
            } else {
                return response()->json([
                    "status" =>"failed",
                    'code' => 400,
                    "message" => "A Network Error occurred. Please try again."
                ], 400);
            } 

        }
    }

    public function sendResetEmail($email, $token)
    {
        //Retrieve the user from the database
        $user = User::where('email', $email)->first();

        //Generate, the password reset link. The token generated is embedded in the link
        $link = config('app.url'). '/api/pw/reset' . '?token='.$token . '&email=' . urlencode($user->email);
        
        $mailData = [
            "link" => $link,
            "email" => $email,
            "name" => $user->name
        ];
        
        try {
            \Mail::to($email)->send(new ResetPasswordMail($mailData));
            return true;
        } catch(\Exception $e) {    
            return false;
        }
    }

    public function resetPassword(Request $request)
    {
      
        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed'
        ]);
        //check if input is valid before moving on
        if ($validator->fails()) {
            return response()->json(["status"=>"failed",'code' => 422,"message"=>$validator->messages()->first()],422);
        }
        $password = $request->password;
      
        // Validate the token
        $tokenData = \DB::table('password_resets')->where('token', $request->token)->first();
        // Redirect the user back to the password reset request form if the token is invalid
        if (!$tokenData) return response([ 
                "status" =>"failed",
                'code' => 400,
                "message" =>"Resest Password link is expired"
        ],400);
        $user = User::where('email', $tokenData->email)->first();
        // Redirect the user back if the email is invalid
        if(!$user) {
            return response()->json(["status" => "failed",'code' => 400,"message" => "user not found"],400);
        }
            $user->password = Hash::make($password);
            $user->update();
            $this->sendResetPasswordSuccessEmail($tokenData->email);

            //Delete the token
            \DB::table('password_resets')->where('email', $user->email)->delete();
            return $this->sendResponse("Password Successfully Changed");  
    }

    public function sendResetPasswordSuccessEmail($email)
    {
        //Retrieve the user from the database
        $user = User::where('email', $email)->first();  
        try {
            \Mail::to($email)->send(new SendResetPwdSuccessMail($user));
            return true;
        } catch(\Exception $e) {    
            return false;
        }
    }
}
