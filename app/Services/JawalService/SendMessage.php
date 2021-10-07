<?php
/**
 * Created by PhpStorm.
 * User: HP15
 * Date: 10/8/2019
 * Time: 5:39 م
 */

namespace App\Services\JawalService;

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Twilio\Rest\Client;

// functions
use App\Services\MobilyService\MobilySMS;
use App\Services\MobilyService\Functions;
use App\Services\MobilyService\Results;

class SendMessage
{


    public $mobile_sms;

    public function __construct()
    {
        $this->jawal_sms = new JawalSMS();
    }

    public function send_make_order_msg($order)
    {

        $order_id =  $order->id;
        $name = $order->user_name;
        $price = $order->total_price;
        $currency = $order->currency->symbol;
        $payment_method_id = $order->payment_method_id;
        $confirm_cod = $order->confirm_cod;
        $number = re_arrange_phone_number($order->user_phone , $order->order_user_shipping->city);

        $get_text = collect(get_setting_messages()['payment_methods'])->where('id', '=', $payment_method_id)->first();
        $get_text = $get_text ? $get_text->text : null;
        $banks = get_setting_messages()['banks'];


        // get_list_of_banks($banks)
        if (!is_null($get_text)) {

            $key_words = ['[order_id]', '[name]', '[price]', '[currency]', '[banks]', '[cod_url]','[bank_transfer_url]'];
            $replaces = [$order_id, $name, $price, $currency, "", url('c') . "/" . $confirm_cod ,url('bank-transfer')."/".$order->order_number];

            $get_new_text = str_replace($key_words, $replaces, $get_text);
            $this->jawal_sms->send_sms($number ,$get_new_text);
        }
    }

    public function send_order_status_msg($number, $get_new_text)
    {

       $this->jawal_sms->send_sms($number, $get_new_text);
    }

}
