<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use App\Mail\SendEmail;

// channels
use App\Channels\FirebaseChannel;
use App\Channels\SmsChannel;
use App\Channels\MailChannel;

// services
use App\Services\JawalService\SendMessage;
use Illuminate\Support\Facades\Mail;

class SendCheckOrderReturnNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $order;
    public $check_return_order_token;
    public function __construct($order , $check_return_order_token)
    {
        $this->order = $order;
        $this->check_return_order_token = $check_return_order_token;
    }


    public function via($notifiable)
    {
        $channels = [MailChannel::class , SmsChannel::class];
        return $channels;
    }



    public function toMailChannel($notifiable)
    {
        $order = $this->order;
        $current_lang = app()->getLocale();
        $user_lang = $order && $order->user ? $order->user->lang : ($order ? $order->lang : "ar");

        app()->setLocale($user_lang);

        $bill_email = $order->user_email;

        $_view_email_ = "website.notifications.confirmcod";
        $_email_ = $bill_email;
        $_data_ = [
            'title' => trans('notification.check_return_order_title', [], $user_lang),
            'sub_title' => trans('notification.check_return_order_title', [], $user_lang),
            '_message_' => trans('notification.check_return_order', ['link' => $this->get_link()], $user_lang),
            '_lang_' => $user_lang,
            'platform' => 'web',

        ];
        $_subject_ = trans('notification.check_return_order_title', [], $user_lang);
        Mail::to($_email_)->send(new SendEmail($_view_email_ , $_email_ , $_data_ , $_subject_));

    }
    public function toDatabase($notifiable)
    {
        return [];
    }
    public function toSms($notifiable)
    {
//        $order = $this->order;
//        $number = re_arrange_phone_number($order->user_phone , $order->order_user_shipping->city);
//        $text = trans('notification.check_return_order' , ['link' => $this->get_link()]);
//        $send_message = new SendMessage();
//        $send_message->send_order_status_msg($number, $text);
    }


    public function get_link() {
        return \LaravelLocalization::localizeUrl('my-account/orders')."/".$this->order->order_number."?check_return_order_token=".$this->check_return_order_token;
    }

}
