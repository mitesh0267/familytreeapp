<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use Auth;

class RegistrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.auth.register');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|string|max:185',
            'email' => 'required|max:185|unique:users,email,NULL,id,deleted_at,NULL|regex:/(.+)@(.+)\.(.+)/i',
            'mobile_no' => 'required|numeric|digits:10|unique:users,mobile_no,NULL,id,deleted_at,NULL',
            'password' => 'required|min:8',
            'confirm_password' => 'required|min:8|same:password',
            'is_read_terms_and_conditions' => 'accepted',
        ],['is_read_terms_and_conditions.accepted'=>'The terms and conditions must be accepted.']);
        if ($validator->fails()) {
            return $response = ['status'=>false,'message'=>$validator->errors()->first(),'url'=>""];
        }else{
            $input = [
                'role' => 'admin',
                'name' => $data['name'],
                'email' => $data['email'],
                'mobile_no' => $data['mobile_no'],
                'password' => \Hash::make($data['password']),
                'is_active'=>1,
            ];
            $user = User::create($input);

            return $response = ['status'=>true,'message'=>'Account created successfully.'];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
