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

class BankNotification
{

    public function __construct()
    {

    }


    public static function send_approve_notification($order)
    {
        self::send_firebase_approve_notification($order);
        self::send_email_approve_notification($order);
    }

    public static function send_reject_notification($order , $reject_reason)
    {
        self::send_firebase_reject_notification($order , $reject_reason);
        self::send_email_reject_notification($order , $reject_reason);
    }


    public static function send_firebase_approve_notification($order)
    {
        $data = [
            'from_user_id' => Auth::guard('admin')->user()->admin_id,
            'user_id' => $order->user->id,
            'type' => notification_status()['approve_bank_transfer'],
            'order_id' => $order->id,
            'status' => $order->status,
            'data' => ['order_id' => $order->id]
        ];
        $send_to_user_notification = (new SendNotificationJob($data));
        dispatch($send_to_user_notification);
    }
    public static function send_email_approve_notification($order)
    {

        $current_lang = app()->getLocale();
        $user_lang = $order && $order->user ? $order->user->lang : ($order ? $order->lang : "ar");

        app()->setLocale($user_lang);

        $bill_email = $order->user_email;

        $_view_email_ = "website.notifications.confirmcod";
        $_email_ = $bill_email;
        $_data_ = [
            'title' => trans('notification.approve_bank_transfer', ['order_id' => $order->id], $user_lang),
            'sub_title' => trans('notification.approve_bank_transfer_description', ['order_id' => $order->id], $user_lang),
            '_message_' => trans('notification.approve_bank_transfer_description', ['order_id' => $order->id], $user_lang),
            '_lang_' => $user_lang,
            'platform' => 'web',

        ];
        $_subject_ = trans('website.bank_transfer_' , [] ,$user_lang );

        $send_email = (new DispatchSendEmail($_view_email_, $_email_, $_data_, $_subject_));
        dispatch($send_email);

        app()->setLocale($current_lang);
    }


    public static function send_firebase_reject_notification($order , $reject_reason)
    {
        $data = [
            'from_user_id' => Auth::guard('admin')->user()->admin_id,
            'user_id' => $order->user->id,
            'type' => notification_status()['reject_bank_transfer'],
            'order_id' => $order->id,
            'status' => $order->status,
            'data' => ['order_id' => $order->id, 'reject_reason' => $reject_reason]
        ];
        $send_to_user_notification = (new SendNotificationJob($data));
        dispatch($send_to_user_notification);

    }
    public static function send_email_reject_notification($order , $reject_reason)
    {
        $current_lang = app()->getLocale();
        $user_lang = $order && $order->user ? $order->user->lang : ($order ? $order->lang : "ar");

        app()->setLocale($user_lang);

        $bill_email = $order->user_email;
        // send email to user ////////////////////////////////
        $_view_email_ = "website.notifications.confirmcod";
        $_email_ = $bill_email;
        $_data_ = [
            'title' => trans('notification.reject_bank_transfer', ['order_id' => $order->id, 'reject_reason' => $reject_reason], $user_lang),
            'sub_title' => trans('notification.reject_bank_transfer_description', ['order_id' => $order->id, 'reject_reason' => $reject_reason],$user_lang),
            '_message_' => trans('notification.reject_bank_transfer_description', ['order_id' => $order->id, 'reject_reason' => $reject_reason], $user_lang),
            '_lang_' => $user_lang,
            'platform' => 'web',

        ];
        $_subject_ = trans('website.bank_transfer_' , [] ,$user_lang );
        $send_email = (new DispatchSendEmail($_view_email_, $_email_, $_data_, $_subject_));
        dispatch($send_email);

        app()->setLocale($current_lang);
    }

}