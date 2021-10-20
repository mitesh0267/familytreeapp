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

     public function getHandledProfilePicPath($value)
     {     
        $url = null;
        if (isset($value)) {
             $profilePicture = $value;
             if ($profilePicture) {
                 $path = config('filesystems.upload_profile_picture_path');       
                 $disk = Storage::disk('public');               
                // $url = $disk->url("app".$path . $profilePicture);
                 $url = storage_path('app/').$path . $profilePicture;
             } 
         }
        return $url;
     }
}
