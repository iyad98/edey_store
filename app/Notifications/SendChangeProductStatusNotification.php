<?php

namespace App\Notifications;

use App\Channels\FirebaseChannel;
use App\Channels\MailChannel;
use App\Mail\SendEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Mail;


class SendChangeProductStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $order;
    public $product;
    public $status;

    public function __construct($order ,$product, $status)
    {

        $this->order = $order;

        $this->product = $product;
        $this->status = $status;
    }


    public function via($notifiable)
    {
        $channels = [ MailChannel::class];
        return $channels;
    }



    public function toMailChannel($notifiable)
    {
        $get_email_sms_data = $this->getEmailSmsData($this->order, $this->product, $this->status);

        if ($get_email_sms_data['key'] == 'order_in_the_warehouse') {

            $_view_email_ = "website_v2.emails.new.order_status_in_the_warehouse";
            $_email_ = $this->order->user_email;
            $_data_ = ['order'=>$this->order,'_message_' => $get_email_sms_data['get_new_text'], '_lang_' => $get_email_sms_data['user_lang']];
            $_subject_ = $get_email_sms_data['subject'];

            Mail::to($_email_)->send(new SendEmail($_view_email_, $_email_, $_data_, $_subject_));
        }


    }

    public function getEmailSmsData($order, $product, $status)
    {

        $current_lang = app()->getLocale();
        $user_lang = $order && $order->user ? $order->user->lang : ($order ? $order->lang : "ar");

        app()->setLocale($user_lang);



        $get_settings = collect(get_setting_messages()['settings']);
        $contact_phone = $get_settings->where('key', '=', 'phone')->first();
        $phone = $contact_phone ? $contact_phone->value : "";

        $order_id = $order->id;
        $product_name= $product->product->name;

        $number = re_arrange_phone_number($order->user_phone, $order->order_user_shipping->city);


        $subject = "";
        $get_new_text = "";
        $key = "product_status";
        switch ($status) {
            case order_status()['in_the_warehouse'] :
                $key = "order_in_the_warehouse";
                $subject = trans('admin.order_in_the_warehouse');
                break;

        }
        if (!is_null($key)) {
            if (in_array($status, [order_status()['in_the_warehouse']])) {
                $lang_value = "value_" . app()->getLocale();
                $get_text = $get_settings->where('key', '=', $key)->first();
                $get_text = $get_text ? $get_text->$lang_value : null;
                if (!is_null($get_text)) {
                    $key_words = ['[name]', '[order_id]', '[order_date]'];
                    $replaces = [$order->user_name, $order_id,$order->created_at];
                    $get_new_text = str_replace($key_words, $replaces, $get_text);

                    $get_new_text = $get_new_text .'<br>'.$product->note_in_the_warehouse;
                }
            }
        }

        return [
            'key' => $key,
            'number' => $number,
            'get_new_text' => $get_new_text,
            'subject' => $subject,
            'user_lang' => $user_lang,
        ];
    }

}
