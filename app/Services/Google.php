<?php
/**
 * Created by PhpStorm.
 * User: HP15
 * Date: 10/8/2019
 * Time: 5:39 م
 */

namespace App\Services;


class Google
{

    public $google_api_key ;

    public function __construct()
    {
        $this->google_api_key= env('GOOGLE_API_KEY');
        $this->gecode_url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=";
    }


    public function get_address_from_lat_lng($lat, $lng , $language = 'ar')
    {
        try {
            $from_place = json_decode('[' . file_get_contents($this->gecode_url . $lat . ',' . $lng . "&language=$language&key=$this->google_api_key") . ']', true);
            return $from_place[0]['results'][0]['formatted_address'];
        }catch (\Exception $e) {
            return "";
        }

    }

}