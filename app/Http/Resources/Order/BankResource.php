<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class BankResource extends JsonResource
{


    public function toArray($request)
    {
        return [
            'id' => $this->id ,
            'name' => $this->name ,
            'image' => $this->image ,
            'iban' => $this->iban,
        ];
    }
}
