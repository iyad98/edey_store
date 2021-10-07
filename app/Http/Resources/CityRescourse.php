<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\StoreResource;

class CityRescourse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id ,
            'name' => $this->name ,
        ];
        if($request->has('show_stores')) {
            $data['stores'] = StoreResource::collection($this->stores);
        }
        return $data;
    }
}
