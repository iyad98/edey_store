<?php
/**
 * Created by PhpStorm.
 * User: HP15
 * Date: 10/8/2019
 * Time: 5:39 م
 */

namespace App\Services;
use Illuminate\Support\Str;
use Carbon\Carbon;
class Firestore
{

    public $firestore_path;
    public $server_key;


    public function __construct()
    {
        $this->firestore_path = env('FIRESTORE_PATH');
        $this->server_key = env('SERVER_KEY');
    }

    public function update_message_Firestore($path ,$data) {



        $firestore_data = [
            "media_url" => ["stringValue" => $data['media_url']],
            "message_type" => ["stringValue" => $data['message_type']],
            "msg" => ["stringValue" => $data['msg']],
            "sender_id" => ["stringValue" => $data['sender_id']],
            "time" => ["timestampValue" => Carbon::now()],
        ];
        $data = ["fields" => (object)$firestore_data];


        $json = json_encode($data);

        $url = "$this->firestore_path".$path.Str::random(20);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array('Content-Type: application/json',
                'Content-Length: ' . strlen($json),
                'X-HTTP-Method-Override: PATCH'),
            CURLOPT_URL => $url . '?key=' . $this->server_key,
            CURLOPT_USERAGENT => 'cURL',
            CURLOPT_POSTFIELDS => $json
        ));

        $response = curl_exec($curl);
        curl_close($curl);
    }

    public function mark_order_as_finish($path , $status) {

        $get_data = $this->get_order_details($path);
        $firestore_data = [
            "order_id" => ["integerValue" =>$get_data['order_id'] ],
            "is_finish" => ["integerValue" => $status],
            "created_at" => ["timestampValue" =>$get_data['created_at'] ],
        ];
        $data = ["fields" => (object)$firestore_data];


        $json = json_encode($data);

        $url = "$this->firestore_path".$path;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array('Content-Type: application/json',
                'Content-Length: ' . strlen($json),
                'X-HTTP-Method-Override: PATCH'),
            CURLOPT_URL => $url . '?key=' . $this->server_key,
            CURLOPT_USERAGENT => 'cURL',
            CURLOPT_POSTFIELDS => $json
        ));

        $response = curl_exec($curl);
        curl_close($curl);
    }

    public function get_order_details($path) {
        $url = "$this->firestore_path".$path;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));
        $jsonResponse = curl_exec($ch);
        $jsonResponse = json_decode(curl_exec($ch), true);
        curl_close($ch);
        $data = [
            'order_id' => $jsonResponse['fields']['order_id']['integerValue'],
            'created_at' => $jsonResponse['fields']['created_at']['timestampValue'],
            'is_finish' => $jsonResponse['fields']['is_finish']['integerValue']
        ];
        return $data;
    }


}