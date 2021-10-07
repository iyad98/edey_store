<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShippingCompanyResource extends JsonResource
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
            'name' => $this->name ,
            'image' => $this->image ,
            'image_web' => $this->image_web ,
            'note' => $this->note ,
            'billing_national_address' => $this->billing_national_address == 1,
            'billing_building_number' => $this->billing_building_number == 1,
            'billing_postalcode_number' => $this->billing_postalcode_number == 1,
            'billing_unit_number' => $this->billing_unit_number == 1,
            'billing_extra_number' => $this->billing_extra_number == 1,
            'accept_user_shipping_address' => $this->accept_user_shipping_address == 1,
        ];
    }
}
