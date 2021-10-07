<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderPackageResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->package_id ?$this->package_id : -1 ,
            'name' => $this->package ? $this->package->name : '',
            'discount' => $this->package_discount ? $this->package_discount : 0 ,
            'price' => $this->package_price ? $this->package_price : 0 ,
            'free_shipping' => $this->free_shipping == 1 ,

        ];
    }
}
