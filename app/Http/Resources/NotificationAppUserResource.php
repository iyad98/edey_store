<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationAppUserResource extends JsonResource
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
            'id' => $this->id ,
            'ads_id' => $this->ads_id ,
            'from_user_id' => $this->from_user_id,
            'type' => $this->type,
            'data' => $this->data ,
            'title' => $this->title ,
            'sub_title' => $this->sub_title ,
            'date' => $this->created_at->format('d M Y h:i a') ,
            'read_at' => $this->read_at
        ];
    }
}
