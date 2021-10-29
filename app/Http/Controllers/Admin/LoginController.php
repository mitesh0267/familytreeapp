<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use Auth;


class LoginController extends Controller
{
	public function __construct()
    {
        $this->middleware('guest');
    }

    public function index()
    {
        return view('admin.auth.login');
    }

    public function checkLogin(Request $request)
    {
    	$data = $request->all();

    	$validator = Validator::make($data, [
            'email' => 'required|exists:users,email,deleted_at,NULL',
            'password' => 'required|min:8',
        ]);
        if ($validator->fails()) {
            return $response = ['status'=>false,'message'=>$validator->errors()->first(),'url'=>""];
        }else{
        	unset($data['_token']);
        	Auth::attempt($data);
            return $response = ['status'=>true,'message'=>'Login successfully.'];
        }


    }
}
