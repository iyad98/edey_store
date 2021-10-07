<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class StockStatusResource extends JsonResource
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
