<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\LocationResource;

use App\Http\Resources\CountryResource;
use App\Http\Resources\CityRescourse;
use App\Http\Resources\StateResource;
use App\Http\Resources\NeighborhoodResource;
use App\Http\Resources\ShippingCompanyResource;
class UserShippingResource extends JsonResource
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
            'first_name' => $this->first_name ,
            'last_name' => $this->last_name ,
            'phone' => $this->phone ,
            'country' =>new CountryResource($this->shipping_country) ,
            'city' => new CityRescourse($this->shipping_city) ,
            'city2' => $this->city2 ,
            'state' => $this->state ,

            'street' => $this->street ,
            'avenue' => $this->avenue ,
            'building_number' => $this->building_number ,
            'floor_number' => $this->floor_number ,
            'apartment_number' => $this->apartment_number ,

            'address_1' => $this->address ,
            'email' => $this->email ,
            'billing_shipping_type' => new ShippingCompanyResource($this->billing_shipping_type_) ,
            'billing_national_address' => $this->billing_national_address ,
            'billing_building_number' => $this->billing_building_number ,
            'billing_postalcode_number' => $this->billing_postalcode_number ,
            'billing_unit_number' => $this->billing_unit_number ,
            'billing_extra_number' => $this->billing_extra_number ,
            'platform' => $this->platform ,
            'delivared_name' => $this->delivared_name ,
            'is_default'=>$this->is_default == 1 ? true : false,
            'is_verified'=>$this->is_verified == 1 ? true : false,
            'code'=>$this->code.'' ,
          //   'delivared_lat' => "31.555" ,
           // 'delivared_lng' => "34.555" ,


        ];
    }
}
