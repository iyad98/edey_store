<?php

namespace App\Services\ShippingService;

use App\Models\Setting;

trait AddressShipping {
    
    public function getCompanyAddress() {
        $setting_data = Setting::whereIn('key' , ['phone' , 'email' , 'place'])->get();
        $setting_phone = optional($setting_data->where('key' ,'=' ,'phone')->first())->value;
        $setting_email = optional($setting_data->where('key' ,'=' ,'email')->first())->value;
        $setting_place = optional($setting_data->where('key' ,'=' ,'place')->first())->value_en;

        return [
            'name'         => 'Mamnon' ,
            'phone'        => $setting_phone ,
            'email'        => $setting_email ,
            'place'        => $setting_place,
            'city'         => 'Riyadh',
            'country'      => 'Saudi Arabia',
            'country_code' => 'SA'
        ];
    }
    public function getClientAddress($order) {
        $shipping_data = $order->order_user_shipping;
        $city = $shipping_data->shipping_city;
        $country = $city ? $city->country : null;
        $address = $shipping_data->city2." - ".$shipping_data->state." - ".$shipping_data->address;

        $name = is_null($shipping_data->gift_target_phone) || empty($shipping_data->gift_target_phone) ? $shipping_data->first_name." ".$shipping_data->last_name : $shipping_data->gift_first_name." ".$shipping_data->gift_last_name ;
        $email = is_null($shipping_data->gift_target_phone) || empty($shipping_data->gift_target_phone) ? $shipping_data->email : $shipping_data->gift_target_email;
        $phone = is_null($shipping_data->gift_target_phone) || empty($shipping_data->gift_target_phone) ? $shipping_data->phone : $shipping_data->gift_target_phone;

        return [
            'name'         => $name ,
            'phone'        => $email,
            'email'        => $phone,
            'place'        => $address,
            'city'         => $city->name_en,
            'country'      => $country->name_en,
            'country_code' => $country->iso2
        ];
    }
}