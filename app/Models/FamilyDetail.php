<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class FamilyDetail extends Model
{
    use HasFactory,SoftDeletes;
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'name',
        'relation',
        'birth_date',
        'profile_pic',
        'married_status',
        'height',
        'physical_disability',
        'blood_group',
        'school_name_1',
        'school_name_2',
        'both_school_same',
        'b_degree',
        'b_college_name',
        'm_degree',
        'm_college_name',
     ];
     protected $appends = ['age','profile_pic_url'];
    public static function rules()
    {
        return [
            'family_details' => ['required'],
            'family_details.*.name' => ['required','string'],
            'family_details.*.relation' => ['required'],
            'family_details.*.birth_date' => ['required', 'date','date_format:Y-m-d'],
            'family_details.*.married_status' => ['required', 'string','in:married,unmarried']
        ];

    }

    public static function messages()
    {
        return [
            'family_details.required' => 'The family details is required.',
            'family_details.*.name.required' => 'The family details name field is required.',
            'family_details.*.name.string' => 'The family details name field must be a string.',
            'family_details.*.relation.required' => 'The family details relation field is required.',
            'family_details.*.birth_date.required' => 'The family details birth date field is required.',
            'family_details.*.birth_date.date' => 'The family details birth date field is not a valid date.',
            'family_details.*.birth_date.date_format' => 'The family details birth date does not match the format Y-m-d.',
            'family_details.*.married_status.required' => 'The family details married status field is required.',
            'family_details.*.married_status.string' => 'The family details married status field must be a string.',
            'family_details.*.married_status.in' => 'The family details married status is invalid.Allowed:(married, unmarried)'
        ];
    }

    public function getProfilePicUrlAttribute($value)
    {     
        $path = config('filesystems.upload_profile_picture_path');       
        $disk = Storage::disk('user_profile');   
        $url = null;
        if (isset($this->profile_pic)) {
            $profilePicture = $this->profile_pic;           
            $url = $disk->url($path . $profilePicture); 
        } else {
            $url = $disk->url($path .'default.png');
        }
       return $url;
    }
    public function getAgeAttribute(): string
    {
        $from = new \DateTime($this->attributes['birth_date']);
        $to = new \DateTime('today');
        return $from->diff($to)->y;
    }

}
