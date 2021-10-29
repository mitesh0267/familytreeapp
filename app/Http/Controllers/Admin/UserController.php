<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FamilyDetail;
use App\Models\OtherDetail;
use App\Models\ContactDetail;
use Auth;
use Validator;
use Hash;
use DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $rules = [
            'name' => 'required|string|max:185',
            'father_name' => 'required|string|max:185',
            'professional' => 'required|max:185',
            'birth_date' => 'required|date|date_format:Y-m-d',
            'blood_group' => 'required|max:185',
            'physical_disability' => 'required',

            'p_address' => 'required|max:250',
            'p_city' => 'required|max:250',
            'p_state' => 'required|max:250',
            'p_country' => 'required|max:250',
            'p_pincode' => 'required|max:250',

            'n_address' => 'max:250|nullable',
            'n_city' => 'max:250|nullable',
            'n_state' => 'max:250|nullable',
            'n_country' => 'max:250|nullable',
            'n_pincode' => 'nullable',

            'family_details' => 'required',
            'family_details.*.name' => 'required|string|max:185',
            'family_details.*.relation' => 'required',
            'family_details.*.birth_date' => 'required|date|date_format:Y-m-d',
            'family_details.*.married_status' => 'required|string',
            'family_details.*.school_name_1' => 'nullable|string|max:185',
            'family_details.*.school_name_2' => 'nullable|string|max:185',
            'family_details.*.b_degree' => 'nullable|string|max:185',
            'family_details.*.m_degree' => 'nullable|string|max:185',
            'family_details.*.b_degree_name' => 'nullable|string|max:185',
            'family_details.*.m_degree_name' => 'nullable|string|max:185',
            'family_details.*.b_college_name' => 'nullable|string|max:185',
            'family_details.*.m_college_name' => 'nullable|string|max:185',

            'ekling_ji_description' => 'nullable|max:250',
            'native_place_description' => 'nullable|max:250',
            'samaj_vadi_name' => 'nullable|max:250',
            'handled_by' => 'nullable|max:250',

            'email' => 'required|max:185|unique:users,email,NULL,id,deleted_at,NULL|regex:/(.+)@(.+)\.(.+)/i',
            'mobile_no' => 'required|numeric|digits:10|unique:users,mobile_no,NULL,id,deleted_at,NULL',

            'password' => 'required|min:8',
            'confirm_password' => 'required|min:8|same:password',

            'user_profile_pic' => 'required|max:10000|mimes:jpeg,png,jpg',
            'father_profile_pic' => 'required|max:10000|mimes:jpeg,png,jpg',
        ];

        if(isset($input['id'])){
            unset($rules['user_profile_pic']);
            unset($rules['father_profile_pic']);
            unset($rules['password']);
            unset($rules['confirm_password']);

            $rules['email'] = 'required|max:185|unique:users,email,'.$input['id'].',id,deleted_at,NULL|regex:/(.+)@(.+)\.(.+)/i';
            $rules['mobile_no'] = 'required|numeric|digits:10|unique:users,mobile_no,'.$input['id'].',id,deleted_at,NULL';
        }

        if(isset($input['id']) && request()->hasFile('user_profile_pic')){
            $rules['user_profile_pic'] = 'max:10000|mimes:jpeg,png,jpg';
        }

        if(isset($input['id']) && request()->hasFile('father_profile_pic')){
            $rules['father_profile_pic'] = 'max:10000|mimes:jpeg,png,jpg';
        }

        if(request()->hasFile('handled_profile_pic')){
            $rules['handled_profile_pic'] = 'max:10000|mimes:jpeg,png,jpg';
        }

        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return $response = ['status'=>false,'message'=>$validator->errors()->first(),'url'=>""];
        }else{

            if(isset($input['id'])){
                $obj = User::find($input['id']);
                $message = "User updated successfully !";
            }else{
                $obj = New User();
                $message = "User created successfully !";

                $rules['password'] = Hash::make($rules['password']);
            }

            /*Upload Image*/
            if (request()->hasFile('user_profile_pic')) {
                $file = $request->file('user_profile_pic');
                $name = date("YmdHis")."_user_profile_pic";
                request()->file('user_profile_pic')->move(public_path() . '/file/user/', $name);
                $input['user_profile_pic'] = $name;
            }

            /*Remove user_profile_pic*/
            $olduser_profile_pic = public_path() . '/file/user/'.@$obj->user_profile_pic;
            if (file_exists($olduser_profile_pic) && @$obj->user_profile_pic && request()->hasFile('user_profile_pic')) {   
                unlink($oldProfile);
            }

            /*Upload Image*/
            if (request()->hasFile('father_profile_pic')) {
                $file = $request->file('father_profile_pic');
                $name = date("YmdHis")."_father_profile_pic";
                request()->file('father_profile_pic')->move(public_path() . '/file/user/', $name);
                $input['father_profile_pic'] = $name;
            }

            /*Remove father_profile_pic*/
            $oldfather_profile_pic = public_path() . '/file/user/'.@$obj->father_profile_pic;
            if (file_exists($oldfather_profile_pic) && @$obj->father_profile_pic && request()->hasFile('father_profile_pic')) {   
                unlink($oldProfile);
            }


            /*Upload Image*/
            if (request()->hasFile('handled_profile_pic')) {
                $file = $request->file('handled_profile_pic');
                $name = date("YmdHis")."_handled_profile_pic";
                request()->file('handled_profile_pic')->move(public_path() . '/file/user/', $name);
                $input['handled_profile_pic'] = $name;
            }

            /*Remove handled_profile_pic*/
            $oldhandled_profile_pic = public_path() . '/file/user/'.@$obj->handled_profile_pic;
            if (file_exists($oldhandled_profile_pic) && @$obj->handled_profile_pic && request()->hasFile('handled_profile_pic')) {   
                unlink($oldProfile);
            }

            $family_details = $input['family_details'];
            unset($input['family_details']);

            $obj->fill($input)->save();

            if(@$obj->id){

                $input['user_id'] = $obj->id;

                $other_obj = OtherDetail::where(['user_id' => $input['user_id']])->firstOrNew();
                $other_obj->fill($input)->save();

                $other_obj = ContactDetail::where(['user_id' => $input['user_id']])->firstOrNew();
                $other_obj->fill($input)->save();

                FamilyDetail::where(['user_id' => $input['user_id']])->delete();
                foreach ($family_details as $key => $value) {
                    $value['user_id'] = $input['user_id'];

                    if(isset($value['profile_pic']) && is_object($value['profile_pic'])){
                        $file = $value['profile_pic'];

                        if($file->getSize() <= 100 * 1024 * 1024){ //100MB
                            $name = date("YmdHis") . "_profile_pic" ;
                            $file->move(public_path() . '/file/user/', $name);
                            $value['profile_pic'] = $name;
                        }
                    }

                    if(isset($value['both_school_same']) && is_array($value['both_school_same'])){
                        $value['both_school_same'] = 1;
                    }else{
                        $value['both_school_same'] = 0;
                    }

                    $family_details_obj = New FamilyDetail();
                    $family_details_obj->fill($value)->save();
                }

                return $response = ['status'=>true,'message'=>$message];

            }else{
                return $response = ['status'=>false,'message'=>"Something went wrong !"];
            }

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
        $data = User::with(['other_detail','family_details','contact_detail'])->findOrFail($id);

        return view('admin.user.view',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $edit = User::with(['other_detail','family_details','contact_detail'])->findOrFail($id);

        return view('admin.user.add',compact('edit'));
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

    public function getAll(Request $request){

        $data = User::where('role','user')->orderBy('id','desc')->get();

        return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('action', function($row) {
                                $btn = '<a href="' . route('user.edit',$row->id). '" class="btn btn-icon btn-icon mr-1 btn-primary waves-effect waves-float waves-light">
                                    <i class="fa fa-edit"></i>
                                  </a>';
                                $btn .= ' <a href="javascript:void(0)" data-url="' . route('user.destroy',$row->id) . '" class="btn btn-icon btn-icon mr-2 btn-danger waves-effect waves-float waves-light delete">
                                    <i class="fa fa-trash"></i>
                                  </a>';
                                
                                

                                if($row->edit_to_access){
                                    $btn .= ' <a href="javascript:void(0)" data-url="' . route('user.edit_to_access',$row->id) . '" class="btn btn-icon btn-icon mr- btn-info waves-effect waves-float waves-light edit_to_access" title="Edit Access"><i class="fa fa-user-edit"></i></a>';
                                }else{
                                    $btn .= ' <a href="javascript:void(0)" data-url="' . route('user.edit_to_access',$row->id) . '" class="btn btn-icon btn-icon mr- btn-warning waves-effect waves-float waves-light edit_to_access" title=" No Edit Access"><i class="fa fa-user-edit"></i></a>';
                                }


                                $btn .= '<a href="' . route('user.show',$row->id). '" class="btn btn-icon btn-icon mr-1 btn-primary waves-effect waves-float waves-light" style="margin-left: 5px;">
                                    <i class="fa fa-file"></i>
                                  </a>';


                                return $btn;
                            })
                            ->addColumn('status', function($row) {
                                if($row->is_active){
                                    $btn = ' <a href="javascript:void(0)" data-url="' . route('user.status',$row->id) . '" class="status btn btn-success btn-rounded btn-sm waves-effect waves-light" title="Active">Active</a>';
                                }else{
                                    $btn = ' <a href="javascript:void(0)" data-url="' . route('user.status',$row->id) . '" class="status btn btn-danger btn-rounded btn-sm waves-effect waves-light" title="Inactive">Inactive</a>';
                                }

                                return $btn;
                            })
                            ->rawColumns(['action', 'show','status','image'])
                            ->make(true);
    }

    public function updateStatus($id)
    {
        $data = User::find($id);
        if(!is_null($data)){
            $data->is_active = !$data->is_active;
            $data->save();
            $response = ['status'=>true,'message'=>'Status update successfully !'];
        }else{
            $response = ['status'=>false,'message'=>'Record not found !'];
        }
        return $response;
    }

    public function updateEditToAccess($id)
    {
        $data = User::find($id);
        if(!is_null($data)){
            $data->edit_to_access = !$data->edit_to_access;
            $data->save();
            $response = ['status'=>true,'message'=>'Edit Access update successfully !'];
        }else{
            $response = ['status'=>false,'message'=>'Record not found !'];
        }
        return $response;
    }
}
