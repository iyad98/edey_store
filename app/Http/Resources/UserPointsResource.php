<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserPointsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'user_id' => $this->id ,
            'first_name' => $this->first_name ? $this->first_name : "" ,
            'phone' => $this->phone ? $this->phone : "" ,
            'points_count' => $this->points_count ? $this->points_count : "" ,

        ];
    }
}
