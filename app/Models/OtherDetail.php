<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class OtherDetail extends Model
{
    use HasFactory,SoftDeletes;
    public $timestamps = false;
    
    protected $fillable = [
        'user_id',
        'ekling_ji_description',
        'native_place_description',
        'samaj_vadi_name',
        'handled_by',
        'handled_profile_pic'
     ];
     protected $appends = ['HandledProfilePicUrl'];

     public function getHandledProfilePicUrlAttribute($value)
     {     
        $path = config('filesystems.upload_profile_picture_path');       
        $disk = Storage::disk('user_profile');  
        $url = null;
        $data = isset($value) ? $value : (isset($this->handled_profile_pic) ? $this->handled_profile_pic : "");
        if (isset($value)) {
             $profilePicture = $value;            
             $url = $disk->url($path . $profilePicture);
        } else {
            $url = $disk->url($path .'default.png');
        }
        return $url;
     }
}
