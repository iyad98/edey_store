<?php

namespace App\Services\NotificationService;

// models
use App\User;
use Illuminate\Support\Facades\Auth;


use DB;

// jobs
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Jobs\DispatchSendEmail;
use App\Jobs\SendNotificationJob;

// services
use App\Services\JawalService\SendMessage;

class ChangeOrderStatusNotification
{

    public function __construct()
    {

    }

    public static function send_notification($order, $shipping_policy, $status) {
        self::send_firebase_notification($order, $shipping_policy, $status);
        self::send_email_and_sms($order, $shipping_policy, $status);
    }

    public static function send_firebase_notification($order, $shipping_policy, $status) {
        $data = [
            'from_user_id' => Auth::guard('admin')->user()->admin_id,
            'user_id' => $order->user_id,
            'type' => notification_status()['orders'],
            'order_id' => $order->id,
            'status' => $order->status,
            'data' => ['order_id' => $order->id]
        ];
        $send_to_user_notification = (new SendNotificationJob($data));
        dispatch($send_to_user_notification);
        
    }
    public static function send_email_and_sms($order, $shipping_policy, $status) {
        
//        $send_message = new SendMessage();

        $current_lang = app()->getLocale();
        $user_lang = $order && $order->user ? $order->user->lang : "ar";

        app()->setLocale($user_lang);

        /************** send message and email *************/
        
        $get_settings = collect(get_setting_messages()['settings']);
        $contact_phone = $get_settings->where('key' , '=' , 'phone')->first();
        $phone = $contact_phone ? $contact_phone->value : "";


        $shipping_company = $order->company_shipping ? $order->company_shipping->shipping_company : null;
       // $number = $order->user_phone;
        $number = re_arrange_phone_number($order->user_phone , $order->order_user_shipping->city);

        $order_id = $order->id;
        $shipping_url = $shipping_company->tracking_url;
        $shipping_phone = $shipping_company->phone;

        
        $subject = "";
        $key = null;
        switch ($status) {
            case order_status()['shipment'] :
                $key = "shipping_order";
                $subject = trans('admin.order_shipment');
                $phone = $shipping_phone;
                break;
            case order_status()['canceled'] :
                $key = "cancel_order";
                $subject = trans('admin.order_canceled');
                break;
            case order_status()['failed'] :
                $key = "failed_order";
                $subject = trans('admin.order_failed');
                break;

        }
        if (!is_null($key)) {

            $lang_value = "value_".app()->getLocale();
            $get_text = $get_settings->where('key', '=', $key)->first();
            $get_text = $get_text ? $get_text->$lang_value : null;

            if (!is_null($get_text)) {
                $key_words = ['[order_id]', '[shipping_policy]', '[shipping_url]', '[phone]'];
                $replaces = [$order_id, $shipping_policy, $shipping_url, $phone];

                $get_new_text = str_replace($key_words, $replaces, $get_text);


                // send sms
//                $send_message->send_order_status_msg($number, $get_new_text);

                // send email
                $_view_email_ = "website.notifications.confirmcod";
                $_email_ = $order->user_email;
                $_data_ = ['_message_' => $get_new_text , '_lang_' => $user_lang];
                $_subject_ = $subject;

                $send_email = (new DispatchSendEmail($_view_email_, $_email_, $_data_, $_subject_));
                dispatch($send_email);

            }

        }

        app()->setLocale($current_lang);
    }
    

}