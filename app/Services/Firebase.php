<?php
/**
 * Created by PhpStorm.
 * User: HP15
 * Date: 10/8/2019
 * Time: 5:39 م
 */

namespace App\Services;


class Firebase
{

    public $fcm_url;
    public $server_key;
    public $firebase_database_url;

    public function __construct()
    {
        $this->fcm_url = 'https://fcm.googleapis.com/fcm/send';
        $this->server_key = 'AAAAxlOX1sY:APA91bFJncyleisknKy1eXbMW7AxzvxGjPXInAomGGG91JLhHoIHD_15eJspYyJICtPDk54Oug7IUJ66Rajga5PCxjGZmQFo1WMnTjTibpFfmpDoJfrlB22SaXYjjGa2odYjEbnavo2B';
        $this->firebase_database_url = 'https://jeena-71e60.firebaseio.com';
    }

    /*               push notification                     */
    public function send($title, $subTitle, $data, $token)
    {
        $registration_ids = is_array($token) ? $token : [$token];
        $data['title'] = $title;
        $data['sub_title'] = $subTitle;
        $fields = array(
            'registration_ids' => $registration_ids,
            'data' => $data,
            'notification' => [
                'title' => $title,
                'body' => $subTitle,
                'sound' => 'default'
            ]
        );

        $fields = json_encode($fields , true);
        $curl = curl_init();

        curl_setopt_array($curl,
            array(CURLOPT_URL => "$this->fcm_url",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $fields,
                CURLOPT_HTTPHEADER =>
                    array("authorization: key=$this->server_key",
                        "content-type: application/json"),));

        $response = curl_exec($curl);
      //  dd($response);
        // return $response;
        $err = curl_error($curl);
        curl_close($curl);
    }

    public function send_without_notification_builder($title, $subTitle, $data, $token)
    {
        $registration_ids = is_array($token) ? $token : [$token];
        $data['title'] = $title;
        $data['sub_title'] = $subTitle;
        $fields = array(
            'registration_ids' => $registration_ids,
            'data' => $data,
        );

        $fields = json_encode($fields , true);
        $curl = curl_init();

        curl_setopt_array($curl,
            array(CURLOPT_URL => "$this->fcm_url",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $fields,
                CURLOPT_HTTPHEADER =>
                    array("authorization: key=$this->server_key",
                        "content-type: application/json"),));

        $response = curl_exec($curl);
        //  dd($response);
        // return $response;
        $err = curl_error($curl);
        curl_close($curl);
    }

    
    public function send_web($title, $subTitle, $data, $token)
    {
        $registration_ids = is_array($token) ? $token : [$token];
        $data['title'] = $title;
        $data['sub_title'] = $subTitle;
        $fields = array(
            'registration_ids' => $registration_ids,
            'data' => $data,
//            'notification' => [
//                'title' => $title,
//                'body' => $subTitle,
//                'sound' => 'default'
//            ],

            'fcm_options' => [
                'link' => 'https://dummypage.com'
            ]

        );

        $fields = json_encode($fields);
        $curl = curl_init();

        curl_setopt_array($curl,
            array(CURLOPT_URL => "$this->fcm_url",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $fields,
                CURLOPT_HTTPHEADER =>
                    array("authorization: key=$this->server_key",
                        "content-type: application/json"),));

        $response = curl_exec($curl);

       // return $response;
        $err = curl_error($curl);
        curl_close($curl);
    }


    /*  real time database  */

    public function add_data($data)
    {

        $data = json_encode($data);
        $url = "$this->firebase_database_url/orders.json";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));
        $jsonResponse = json_decode(curl_exec($ch), true);
        curl_close($ch);
        return $jsonResponse['name'];

    }

    public function get_data($id)
    {
        $url = "$this->firebase_database_url/drivers/$id.json";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));
        $jsonResponse = curl_exec($ch);
        $jsonResponse = json_decode(curl_exec($ch), true);
        curl_close($ch);
        return $jsonResponse;

    }

    public function get_all_data()
    {
        $url = "$this->firebase_database_url/drivers.json";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));
        $jsonResponse = json_decode(curl_exec($ch), true);
        curl_close($ch);
        return $jsonResponse;
    }
}