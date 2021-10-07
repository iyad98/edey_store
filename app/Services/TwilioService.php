<?php
/**
 * Created by PhpStorm.
 * User: HP15
 * Date: 10/8/2019
 * Time: 5:39 م
 */

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Twilio\Rest\Client;

class TwilioService
{

    public $sid;
    public $token;
    public $phone_number;

    public function __construct()
    {
        $this->sid = env('TWILIO_SID');
        $this->token = env('TWILIO_TOKEN');
        $this->phone_number = env('TWILIO_PHONE_NUMBER');
    }


    public function send_order_status($phone ,$send_message ) {
        $client = new Client($this->sid, $this->token);
        $message = $client->messages->create(
            $phone, // Text this number
            array(
                'from' => $this->phone_number, // From a valid Twilio number
                'body' => $send_message
            )
        );
    }
    public function send_message($phone , $message) {
        $client = new Client($this->sid, $this->token);
        $send_message = "Welcome to saree3 app , your verification code is : {$message}";
        $message = $client->messages->create(
            $phone, // Text this number
            array(
                'from' => $this->phone_number, // From a valid Twilio number
                'body' => $send_message
            )
        );
        //dd($message);
    }

    public function send_password($phone , $message) {
        $client = new Client($this->sid, $this->token);
        $send_message = "Welcome to saree3 app , your new password is : {$message}";
        $message = $client->messages->create(
            $phone, // Text this number
            array(
                'from' => $this->phone_number, // From a valid Twilio number
                'body' => $send_message
            )
        );
        //dd($message);
    }


}