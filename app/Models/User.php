<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\FamilyDetail;
use Tymon\JWTAuth\Contracts\JWTSubject;

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
}
