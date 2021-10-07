<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\LocationResource;

use App\Http\Resources\UserShippingResource;
use App\Http\Resources\PackageResource;
use App\Http\Resources\CountryResource;

class UserResource extends JsonResource
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
           'user_id' => $this->id ,
           'first_name' => $this->first_name ? $this->first_name : "" ,
           'last_name' => $this->last_name ? $this->last_name : "" ,
           'user_avatar' => $this->image ,
           'user_email' => $this->email ,
           'mobile' => $this->phone ? ($this->phone  *1).'': "" ,
           'platform' => $this->platform,
           'user_role' => "customer",
           'access_token' => $this->api_token ,
           'points_count'=>$this->points_count,
           'points_price'=> round($this->points_price,round_digit()),

           'cart_product_count' =>$this->cart ? $this->cart->products()->count() : 0 ,
           'count_quantity' =>$this->cart ? (int)$this->cart->products()->sum('quantity') : 0 ,
           'shipping_info' => new UserShippingResource($this->shipping_info),
           'package' => new PackageResource($this->package) ,
           'country' => new CountryResource($this->country),
           'notification' => $this->notification == 1
       ];
    }
}
