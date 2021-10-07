<?php

namespace App\Notifications;

use App\Services\MobilyService\SendMessage;
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
use Illuminate\Support\Facades\Mail;

class SendMakeOrderNotification extends Notification 
{
    use Queueable;

    public $order;
    public function __construct($order)
    {

        $this->order = $order;
    }


    public function via($notifiable)
    {
        /*, SmsChannel::class */
        $channels = [MailChannel::class];
//        if($this->order->is_guest == 0) {
//            $channels[] = 'database';
//        }
        return $channels;
    }
    public function toMailChannel($notifiable)
    {
        $order = $this->order;
        /******************************************/

        $current_lang = app()->getLocale();
        $user_lang = $order && $order->user ? $order->user->lang : ($order ? $order->lang : "ar");
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

            $key_words = ['[order_id]', '[name]', '[price]', '[currency]', '[banks]', '[cod_url]','[bank_transfer_url]'];
            $replaces = [$order->id, $order->bill_name . "<br>", $order->total_price, $order->currency->symbol, get_list_html_ul_of_banks($banks), url('c') . "/" . $order->confirm_cod , url('bank-transfer')."/".$order->order_number];
            $get_new_text = str_replace($key_words, $replaces, $get_text);
        }

        $_view_email_ = "website_v2.emails.new.order_details";
        $_email_ = $order->bill_email;

        $_data_ = ['order' => $order, 'get_new_text' => $get_new_text , '_lang_' => $user_lang];
        $_subject_ = trans('website.order_received');

        Mail::to($_email_)->send(new SendEmail($_view_email_ , $_email_ , $_data_ , $_subject_));

        // (new SendEmail($_view_email_, $_email_ , $_data_ , $_subject_))->to($_email_);

        app()->setLocale($current_lang);


    }
    public function toDatabase($notifiable)
    {
        return [];
    }
//    public function toSms($notifiable)
//    {
//        $order = $this->order;
//
//        $current_lang = app()->getLocale();
//        $user_lang = $order && $order->user ? $order->user->lang : ($order ? $order->lang : "ar");
//        app()->setLocale($user_lang);
//
//        $send_message = new SendMessage();
//
//        $send_message->send_make_order_msg($order);
//
//        app()->setLocale($current_lang);
//    }


}
