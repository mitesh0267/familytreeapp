<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\ContactDetail;
use App\Models\OtherDetail;
use App\Models\FamilyDetail;
use App\Traits\ResponseFormat;
use Illuminate\Support\Facades\Validator;
use DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Api\UserCollection;
use Auth;


class UserController extends Controller
{
    use ResponseFormat;

    public function store(Request $request)
    {

        $validateUser = array_merge(
            User::rules(),
            ContactDetail::rules(),
            FamilyDetail::rules(),
        );
       $validateUserMsg = array_merge(
            ContactDetail::messages(),
            FamilyDetail::messages(),
       );

        $validator = Validator::make($request->all(), $validateUser,$validateUserMsg);
        if ($validator->fails()) {
            return response()->json(["status" => "failed",'code' => 422, "message" => $validator->errors()->all()],422);
        }
        $validator = Validator::make($request->all(), [
            'professional' => 'required',
            'birth_date' => 'required|date|date_format:Y-m-d'
        ]);

        if ($validator->fails()) {
            return response()->json(["status" => "failed",'code' => 422, "message" => $validator->messages()->first()],422);
        }
        
        //User Details 
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "mobile_no" => $request->mobile_no,
            "password" => Hash::make($request->password) ?? "",
            "father_name" => $request->father_name ?? "",
            "professional" => $request->professional ?? "",
            "birth_date" => $request->birth_date,
            "role" => isset($request->role) ? $request->role : "user",
            "is_active" =>  isset($request->is_active) ? $request->is_active : "1",
            "transaction_id" =>  isset($request->transaction_id) ? $request->transaction_id : null,
        ]);

        //contact Details
        $contactDetailsReq = $this->setcontactDetailsPayload($request,$user);
        $contactDetails = ContactDetail::create($contactDetailsReq); 

        
        //family Details
        $familyDetail = $request->family_details;
        $family_Details = [];
        foreach ($familyDetail as $familyData) {
            $is_school_same = isset($familyData['both_school_same']) ? $familyData['both_school_same'] : 'false';
            $schoolPayload = []; 
            $familyDetailsReq = [];
            if($is_school_same) {
                $schoolPayload=[
                    "school_name_1" => $familyData['school_name_1'],
                    "school_name_2" => $familyData['school_name_1']];
            } else {
                $schoolPayload=[
                    "school_name_1" => $familyData['school_name_1'],
                    "school_name_2" => $familyData['school_name_2']];
            }
            $b_college_name = "";
            $m_college_name = "";
            if($familyData['b_degree']) {
                $b_college_name = $familyData['b_college_name'];
            }
            if($familyData['m_degree']) {
                $m_college_name = $familyData['m_college_name'];
            }
            $familyDetailsReq  = array_merge([
                "user_id" => $user->id,
                "name" => $familyData['name'],
                "relation" => $familyData['relation'],
                "birth_date" => $familyData['birth_date'],
                "profile_pic" => $familyData['profile_pic'],
                "married_status" => $familyData['married_status'],
                "b_degree" => isset($familyData['b_degree']) ? $familyData['b_degree'] : false, 
                "b_college_name" => isset($b_college_name) ? $b_college_name : null, 
                "m_degree" => isset($familyData['m_degree']) ? $familyData['m_degree'] : false , 
                "m_college_name" =>isset($m_college_name) ? $m_college_name : null,
            ],$schoolPayload);
            $family_Details[] = FamilyDetail::create($familyDetailsReq); 
        }

         //other Details
        $other_details = OtherDetail::create([
            "user_id" => $user->id,
            "ekling_ji_description" => $request->ekling_ji_description ??"",
            "native_place_description" => $request->native_place_description ?? "",
            "samaj_vadi_name" => $request->samaj_vadi_name ?? "",
            "handled_by" => $request->handled_by ?? "",
            "handled_profile_pic" => $request->handled_profile_pic ?? ""
        ]);
        $response = [
            'user' => $user,
            'contact_details' => $contactDetails,
            'family_details' => $family_Details,
            'other_details' => $other_details,
        ];
        return $this->sendResponse($response);
    }

    public function setcontactDetailsPayload($request,$user)
    {
        $contactDetailsReq = [];
        $is_address_same = isset($request->both_address_same) ? $request->both_address_same : 'false';
        $nativeAddress = []; 
        if($is_address_same) {
            $nativeAddress=[
                "n_address" => $request->p_address,
                "n_city" => $request->p_city,
                "n_pincode" => $request->p_pincode ?? "",
                "n_state" => $request->p_state ?? "",
                "n_contrary" => $request->p_contrary];
        } else {
            $nativeAddress=[
                "n_address" => $request->n_address,
                "n_city" => $request->n_city,
                "n_pincode" => $request->n_pincode ?? "",
                "n_state" => $request->n_state ?? "",
                "n_contrary" => $request->n_contrary];
        }
    
        $contactDetailsReq = array_merge([
            "user_id" => $user->id,
            "mobile_no" => $request->mobile_no,
            "p_address" => $request->p_address,
            "p_city" => $request->p_city,
            "p_pincode" => $request->p_pincode ?? "",
            "p_state" => $request->p_state ?? "",
            "p_contrary" => $request->p_contrary,            
        ],$nativeAddress);
        return $contactDetailsReq;

    }

    public function getUserDetails(Request $request)
    {
        $authUser = Auth::user();
        $user = [];
      
        if ($authUser->role !== "user") {
            $user = User::select("users.*",
            "contact_details.id as contact_details_id",
            "contact_details.user_id as contact_details_user_id ",
            "contact_details.mobile_no",
            "contact_details.p_address",
            "contact_details.p_city",
            "contact_details.p_pincode",
            "contact_details.p_state",
            "contact_details.p_contrary",
            "contact_details.n_address",      
            "contact_details.n_city",
            "contact_details.n_pincode",
            "contact_details.n_state",
            "contact_details.n_contrary",
            "contact_details.both_address_same",
            "other_details.id as other_details_id",
            "other_details.user_id as other_details_user_id",
            "other_details.ekling_ji_description",
            "other_details.native_place_description",
            "other_details.samaj_vadi_name",
            "other_details.handled_by",
            "other_details.handled_profile_pic",)
            ->leftjoin('contact_details', 'contact_details.user_id', '=', 'users.id')
            ->leftjoin('other_details', 'other_details.user_id', '=', 'users.id')
            ->with('familyDetail')
            ->where('role','user');
            $user = $user->where(function ($q) use ($request) {
                if(isset($request->person_name) && !empty($request->person_name)){
                    $q->Where('users.name', 'LIKE', "%" .$request->person_name . "%");
                }
                if(isset($request->place_name) && !empty($request->place_name)){
                    $q->orWhere('contact_details.p_city', 'LIKE', "%" .$request->place_name . "%");
                }
                if(isset($request->degree) && !empty($request->degree)){
                    //$q->orWhere('contact_details.p_city', 'LIKE', "%" .$request->degree . "%");
                }
                if(isset($request->age) && !empty($request->age)){
                    $q->orWhere(DB::raw("timestampdiff (year, birth_date, curdate())"), 'LIKE', "%" .$request->age . "%");
                }
            });
            $user = $user->get();
        }
        return (new UserCollection($user));

    }

    public function setUserProfilePicture(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'picture' => 'required|image:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "failed",'code' => 422, "message" => $validator->messages()->first()],422);
        }
        $uploadedFile = $request->file('picture');
        $filename = time() . "." .$uploadedFile->getClientOriginalName();                   
        //get uploaded profile picture path
        $path = config('filesystems.upload_profile_picture_path');       
        $disk = Storage::disk('local');
        // create a file
        $disk->putFileAs($path, $uploadedFile, $filename);
           
        return $this->sendResponse($filename);
    }

    public function getUser(Request $request, $id)
    {
        $user = User::select("users.*",
        "contact_details.id as contact_details_id",
        "contact_details.user_id as contact_details_user_id ",
        "contact_details.mobile_no",
        "contact_details.p_address",
        "contact_details.p_city",
        "contact_details.p_pincode",
        "contact_details.p_state",
        "contact_details.p_contrary",
        "contact_details.n_address",      
        "contact_details.n_city",
        "contact_details.n_pincode",
        "contact_details.n_state",
        "contact_details.n_contrary",
        "contact_details.both_address_same",
        "other_details.id as other_details_id",
        "other_details.user_id as other_details_user_id",
        "other_details.ekling_ji_description",
        "other_details.native_place_description",
        "other_details.samaj_vadi_name",
        "other_details.handled_by",
        "other_details.handled_profile_pic",)
        ->leftjoin('contact_details', 'contact_details.user_id', '=', 'users.id')
        ->leftjoin('other_details', 'other_details.user_id', '=', 'users.id')
        ->with('familyDetail')
        ->where('users.id',$id)
        ->get();
        return (new UserCollection($user));

    }

    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);
        if($user) {
            $user = $user->update($request->all());
            $contactDetail = ContactDetail::where(['user_id' => $id,'id'=> $request->contact_details_id])->first();
            if (isset($contactDetail) && !empty($contactDetail)) {
                $is_address_same = isset($request->both_address_same) ? $request->both_address_same : 'false';
                if($is_address_same) {
                    $request['n_address'] = $request->p_address;
                    $request['n_city'] = $request->p_city;
                    $request['n_pincode'] = $request->p_pincode;
                    $request['n_state'] = $request->p_state;
                    $request['n_contrary'] = $request->p_contrary;
                } 
                $contactDetail->update($request->all());
            } 

             //family Details
            $familyDetail = isset($request->family_details) ? $request->family_details :[];
            $family_Details = [];
            foreach ($familyDetail as $familyData) {
                $familyDetails = FamilyDetail::where(['user_id' => $id,'id'=> $familyData['id']])->first();
                if (isset($familyDetails) && !empty($familyDetails)) {
                    $is_school_same = isset($familyData['both_school_same']) ? $familyData['both_school_same'] : 'false';
                    $schoolPayload = []; 
                    $familyDetailsReq = [];
                    if($is_school_same) {
                        $familyData["school_name_2"] = $familyData['school_name_1'];
                    } 

                    if(!$familyData['b_degree']) {
                        $familyData['b_college_name'] = '';
                    }
                    if(!$familyData['m_degree']) {
                        $familyData['m_college_name'] = '';
                    }
                    $family_Details[] = $familyDetails->update($familyData); 
                }
            
            }
            
            //other Details
            $otherDetail = OtherDetail::where(['user_id' => $id,'id'=> $request->other_details_id])->first();
            if (isset($otherDetail) && !empty($otherDetail)) {
                $otherDetail->update($request->all());
            }    
            return $this->sendResponse("User Details Updated Successfully");         
        } else {
            return response()->json(["status" => "failed",'code' => 404, "message" => 'User not found'],404);
        }
    }

    public function deleteUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
      
        if($user) {
            DB::beginTransaction();
            $contactDetail = ContactDetail::where('user_id',$id)->delete();
            $familyDetails = FamilyDetail::where('user_id',$id)->delete();
            $otherDetail = OtherDetail::where('user_id',$id)->delete();
            $user->email = $user->email . '_deleted_' . date('Y-m-d H:i:s');
            $user->deleted_at= date('Y-m-d H:i:s');
            $user->save();
            DB::commit();
            return $this->sendResponse("User Details Deleted Successfully");         

        } else {
            return response()->json(["status" => "failed",'code' => 404, "message" => 'User not found'],404);
        }
        
    }

    public function adminRegister(Request $request)
    {
        $validator = Validator::make($request->all(),  User::rules());
        if ($validator->fails()) {
            return response()->json(["status" => "failed",'code' => 422, "message" => $validator->errors()->all()],422);
        }
        
        //User Details 
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "mobile_no" => $request->mobile_no,
            "password" => Hash::make($request->password) ?? "",
            "role" => isset($request->role) ? $request->role : "admin",
            "is_active" =>  isset($request->is_active) ? $request->is_active : "1",
            "transaction_id" =>  isset($request->transaction_id) ? $request->transaction_id : null,
        ]);
        return $this->sendResponse($user);
    }

    public function getRealtions()
    {
        
        $realtion_arr  = ["father" => "Father",
                   "mother" => "Mother",
                   "son" => 'Son',
                   "daughter" => "Daughter",
                   "husband" => "Husband",
                   "wife" => 'Wife',
                   "brother" => "Brother",
                   "sister" => "Sister",
                   "grandfather" => 'Grandfather',
                   "grandmother" => "Grandmother",
                   "grandson" => "Grandson",
                   "granddaughter" => 'Granddaughter',
                   "uncle" => "Uncle",
                   "aunt" => "Aunt",
                   "nephew" => 'Nephew',
                   "niece" => "Niece",
                   "cousin" => "Cousin"];
        return $this->sendResponse($realtion_arr);
    }

}
