<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactDetail extends Model
{
    use HasFactory,SoftDeletes;
    public $timestamps = false;
    protected $fillable = [
       'user_id',
       'mobile_no',
       'p_address',
       'p_city',
       'p_pincode',
       'p_state',
       'p_country',
       'n_address',
       'n_city',
       'n_pincode',
       'n_state',
       'n_country',
       'both_address_same',
    ];

    public static function rules()
    {
        return [
            'p_address' => ['required'],
            'p_city' => ['required'],
            'p_pincode' =>  ['required'],
            'p_state' => ['required'],
            'p_country' => ['required'],
            'both_address_same' => ['nullable', 'boolean']
           
        ];

    }

    public static function messages()
    {
        return [
            'p_address.required' => 'The present address field is required.',
            'p_city.required' => 'The present city field is required.',
            'p_pincode.required' => 'The present pincode field is required.',
            'p_state.required' => 'The present state field is required.',
            'p_country.required' => 'The present contrary field is required.',
            'both_address_same.boolean' => 'Same as present address field must be true or false',
        ];
    }
}
