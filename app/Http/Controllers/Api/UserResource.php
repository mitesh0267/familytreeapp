<?php

namespace  App\Http\Controllers\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\OtherDetail;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
     
        $no_of_son_daughter = 0;

        if(isset($this->FamilyDetail) && !empty($this->FamilyDetail)) {
            foreach ($this->FamilyDetail as $key => $data) {
                $relation = isset($data['relation']) ? strtolower($data['relation']) : "";
                 if(in_array($relation,['son','daughter'])) {
                     $no_of_son_daughter++;
                 }
            } 
        }
        $obj = new OtherDetail();
        return [
            "id" => $this->id,
            "name" => $this->name,
            "father_name" => $this->father_name,
            "professional" => $this->professional,
            "birth_date" => $this->birth_date,
            "age" => isset($this->age) ? $this->age : 0,
            'email' => $this->email,
            'mobile_no' => $this->mobile_no,
            "role" => $this->role,
            'is_active' => $this->is_active,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            'contact_details_id' => $this->contact_details_id,
            "contact_details_user_id" => $this->contact_details_user_id,
            "p_address" => $this->p_address,
            "p_city" => $this->p_city,
            "p_pincode" => $this->p_pincode,
            "p_state" => $this->p_state,
            'p_contrary' => $this->p_contrary,
            'n_address' => $this->n_address,
            "n_city" => $this->n_city,
            'n_pincode' => $this->n_pincode,
            'n_state' => $this->n_state,
            "n_contrary" => $this->n_contrary,
            "both_address_same" => $this->both_address_same,
            "other_details_id" => $this->other_details_id,
            "other_details_user_id" => $this->other_details_user_id,
            'ekling_ji_description' => $this->ekling_ji_description,
            'native_place_description' => $this->native_place_description,
            "samaj_vadi_name" => $this->samaj_vadi_name,
            'handled_by' => $this->handled_by,
            'handled_profile_pic' => $obj->getHandledProfilePicPath($this->handled_profile_pic),
            'family_detail' => $this->FamilyDetail,
            'no_of_son_daughter' => $no_of_son_daughter
        ];
    }
}
