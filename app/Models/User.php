<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\FamilyDetail;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Storage;


class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable,SoftDeletes;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'email',
        'mobile_no',
        'password',
        'father_name',
        'professional',
        'birth_date',
        'role',
        'is_active',
        'transaction_id',
        'height',
        'physical_disability',
        'blood_group',
        'father_profile_pic',
        'user_profile_pic',
        'edit_to_access',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected $appends = ['user_profile_pic_url','father_profile_pic_url'];


    public static $professionals = [
        'Bussiness',
        'Job',
        'Goverment Job',
    ];

    public static $blood_groups = [
        'A+',
        'A-',
        'B+',
        'B-',
        'AB+',
        'AB-',
        'O+',
        'O-',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }

    public static function rules()
    {
        return [
            'name' => ['required', 'string'],
            'father_name' => ['nullable', 'string'],
            'email' => ['required', 'email','unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'password_confirmation' => ['required','same:password'],
            'height' => ['nullable', 'numeric'],
            'physical_disability' => ['nullable', 'boolean']
        ];

    }

    public function familyDetail()
    {
        return $this->hasMany(FamilyDetail::class);
    }

    public function getAgeAttribute() {
        if(isset($this->birth_date)) {
            return \Carbon\Carbon::parse($this->birth_date)->diff(\Carbon\Carbon::now())->y;
        }
    }
    
    public function getFatherProfilePicUrlAttribute($value)
    {     
      $url = null;
      $path = config('filesystems.upload_profile_picture_path');       
      $disk = Storage::disk('user_profile');   
        if (isset($this->father_profile_pic)) {
            $profilePicture = $this->father_profile_pic;             
            $url = $disk->url($path . $profilePicture);
        }else {
            $url = $disk->url($path .'default.png');
        }
       return $url;
    }
    public function getUserProfilePicUrlAttribute($value)
    {     
      $url = null;
      $path = config('filesystems.upload_profile_picture_path');       
      $disk = Storage::disk('user_profile');   
        if (isset($this->user_profile_pic)) {
            $profilePicture = $this->user_profile_pic;
            $url = $disk->url($path . $profilePicture);
        }else {
            $url = $disk->url($path .'default.png');
        }
       return $url;
    }

    public function family_details()
    {
        return $this->hasMany(FamilyDetail::class);
    }

    public function other_detail()
    {
        return $this->hasOne(OtherDetail::class);
    }

    public function contact_detail()
    {
        return $this->hasOne(ContactDetail::class);
    }
}
