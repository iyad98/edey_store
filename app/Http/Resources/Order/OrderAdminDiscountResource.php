<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderAdminDiscountResource extends JsonResource
{


    public function toArray($request)
    {
        return [
            'name' => trans('api.admin_discount' , ['discount_rate' => $this->discount_rate]) ,
            'discount_rate' => $this->discount_rate,
            'price' => $this->price ,
        ];
    }
}
