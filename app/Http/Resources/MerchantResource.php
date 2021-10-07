<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class MerchantResource extends JsonResource
{


    public function toArray($request)
    {
        return [
            'id' => $this->id ,
            'store_name' => $this->store_name ,
            'logo_store' => $this->logo_store ,
            'image_banar_store' => $this->image_banar_store ,
            'phone_store' => $this->phone_store ,
            'phone_whatsapp_store' => $this->phone_whatsapp_store ,
            'facebook_link' => $this->facebook_link ,
            'twitter_link' => $this->twitter_link ,
            'instagram_link' => $this->instagram_link ,
            'email' => $this->email ,
            'merchant_first_name' => $this->merchant_first_name ,
            'merchant_last_name' => $this->merchant_last_name ,
            'identification_number' => $this->identification_number ,
            'phone_merchants' => $this->phone_merchants ,
            'about_us_merchants' => $this->about_us_merchants,
            'commercial_register_number' => $this->commercial_register_number,
            'maroof_number' => $this->maroof_number,
            'country_id' => $this->country_id,
            'city_id' => $this->city_id,
            'area_id' => $this->area_id,
            'address_store' => $this->address_store,
            'street_store' => $this->street_store,
            'nearest_public_place' => $this->nearest_public_place,
            'active' => $this->active,
            'account_barea' => $this->account_barea,
            'status' => $this->status,
            'platform' => $this->platform,
        ];
    }
}
