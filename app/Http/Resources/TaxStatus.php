<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaxStatus extends JsonResource
{


    public function toArray($request)
    {
        return [
            'id' => $this->id ,
            'name' => $this->name ,
            'key' => $this->key ,
        ];
    }
}
