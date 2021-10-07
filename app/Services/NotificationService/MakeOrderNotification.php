<?php

namespace App\Services\NotificationService;

// models
use App\Services\MobilyService\SendMessage;
use App\User;


use DB;

// jobs
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Jobs\DispatchSendEmail;

// services

class MakeOrderNotification
{

    public function __construct()
    {

    }

    public static function send_notification($order) {
        self::send_email($order);
        self::send_sms($order);
    }

    public static function send_email($order) {
        /******************************************/

        $current_lang = app()->getLocale();
        $user_lang = $order && $order->user ? $order->user->lang : "ar";
        app()->setLocale($user_lang);
        /*****************************************/
        $order->status_text = trans_order_status()[$order->status];
        $order->status_class = order_status_class()[$order->status];

        $order->bill_name = $order->user_name;
        $order->bill_email = $order->user_email;
        $order->bill_phone = $order->user_phone;

        $get_text = collect(get_setting_messages()['payment_methods'])->where('id', '=', $order->payment_method_id)->first();
        $get_text = $get_text ? $get_text->text : null;
        $banks = get_setting_messages()['banks'];
        $get_new_text = "";
        if (!is_null($get_text)) {

            $key_words = ['[order_id]', '[name]', '[price]', '[currency]', '[banks]', '[cod_url]'];
            $replaces = [$order->id, $order->bill_name . "<br>", $order->total_price, $order->currency->symbol, get_list_html_ul_of_banks($banks), url('c') . "/" . $order->confirm_cod];
            $get_new_text = str_replace($key_words, $replaces, $get_text);
        }


        $_view_email_ = "email.order_details";
        $_email_ = $order->bill_email;
        $_data_ = ['order' => $order, 'get_new_text' => $get_new_text , '_lang_' => $user_lang];
        $_subject_ = trans('website.order_received');

        $send_email = (new DispatchSendEmail($_view_email_, $_email_, $_data_, $_subject_));
        dispatch($send_email);

        app()->setLocale($current_lang);
    }

    public static function send_sms($order) {

        $current_lang = app()->getLocale();
        $user_lang = $order && $order->user ? $order->user->lang : "ar";
        app()->setLocale($user_lang);

        $number = re_arrange_phone_number($order->user_phone , $order->order_user_shipping->city);
//        $send_message = new SendMessage();
//        $send_message->send_make_order_msg($order);
        app()->setLocale($current_lang);
    }

}