<?php

namespace App\Services;

// models
use App\Models\PaymentMethod;
use App\Models\ShippingCompany;
use App\Models\City;
use App\Models\ShippingCompanyCity;

class PublicOrderDataService
{


    public function __construct()
    {

    }

    public static function get_shipping_companies($city_id , $all = false) {
        $shipping_companies = ShippingCompany::Active();
        if(!$all) {
            $shipping_companies = $shipping_companies->ShowForUser();
        }
        if($city_id != -1) {
            $shipping_companies = $shipping_companies->InCity($city_id);
        }
        $shipping_companies = $shipping_companies->get();
        return $shipping_companies;
    }
    public static function get_payment_methods($shipping_company , $shipping_city_id) {

        $city = City::find($shipping_city_id);
        $shipping_company_city = ShippingCompanyCity::InCompanyAndCity($shipping_company , $city)->first();
        $payments = self::get_filtered_payment_methods($city , $shipping_company_city);
        return $payments;
    }

    public static function get_filtered_payment_methods($city ,$shipping_company_city) {

        $payments = PaymentMethod::InCountry($city ? $city->country_id : -1)->Active()->get();

        if(!$shipping_company_city) {
            $payments = [];
        }else if($shipping_company_city->cash == 0) {
            $payments = $payments->filter(function ($value){
                return $value->key != "cash";
            })->values();
        }
        return $payments;
    }


}