<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Resources\Json\ResourceCollection;


class UserCollection extends ResourceCollection
{
    public $collects = 'App\Http\Controllers\Api\UserResource';

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        
        return [
            'data' => $this->collection,
            "status"=> "success",
            'code'  => 200,
        ];
    }
}
