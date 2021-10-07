<?php

namespace App\Http\Resources\Cart;

use Illuminate\Http\Resources\Json\JsonResource;

use Carbon\Carbon;

class CouponResource extends JsonResource
{


    public function toArray($request)
    {
        return [
            'id' => $this->id ,
            'coupon' => $this->coupon ,
            'type' => $this->type->name ,
            'min_price' => $this->min_price ,
            'max_used' => $this->max_used ,
            'start_at' => Carbon::parse($this->start_at)->format('Y-m-d H:i:s') ,
            'expire_date' => Carbon::parse($this->end_at)->format('Y-m-d H:i:s')
        ];
    }
}
