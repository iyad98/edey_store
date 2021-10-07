<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderCouponResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id ,
            'coupon' => $this->coupon_code,
            'price' => number_format($this->coupon_price , round_digit())    ,

        ];
    }
}
