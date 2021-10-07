<?php

namespace App\Notifications;

use App\Channels\FirebaseChannel;
use App\Channels\MailChannel;
use App\Channels\SmsChannel;

use App\Services\MobilyService\SendMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use App\Mail\SendEmail;

// channels

// services
use Illuminate\Support\Facades\Mail;

// models
use App\Models\NotificationAppUser;

/* Repository */

use App\Repository\NotificationAppUserRepository;


class SendChangeOrderStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $order;
    public $status;
    public $shipping_policy;

    public function __construct($order, $shipping_policy, $status)
    {

        $this->order = $order;
        $this->shipping_policy = $shipping_policy;
        $this->status = $status;
    }


    public function via($notifiable)
    {

        $channels = [FirebaseChannel::class, MailChannel::class ];
        return $channels;
    }


    public function toFirebase($notifiable)
    {

        $notification = app()->make('notification-repo-service');
        $firebase = app()->make('firebase-service');

        $order = $this->order;
        $user = $order->user;
        $type = notification_status()['orders'];

        if ($user && $user->notification == 1) {

            $data = [
                'order_id' => $order->id,
                'type' => $type,
                'status' => $order->status,
                'status_text' => trans_orignal_order_status()[$order->status],
            ];


            $get_title_sub_title_notification = $notification->get_title_sub_title_notification($type, $data, $user->lang);
            $title = $get_title_sub_title_notification['title'];
            $sub_title = $get_title_sub_title_notification['sub_title'];

            $firebase->send($title, $sub_title, $data, $user->fcm_token);

        }
    }

    public function toMailChannel($notifiable)
    {
        $get_email_sms_data = $this->getEmailSmsData($this->order, $this->shipping_policy, $this->status);

        if (!is_null($get_email_sms_data['key'])) {

            if (in_array($this->order->status,[orignal_order_status()['canceled']]))
            {
                $_view_email_ = "website_v2.emails.new.order_status_canceled";

            }else{
                $_view_email_ = "website_v2.emails.new.order_status";

            }

            $_email_ = $this->order->user_email;
            $_data_ = ['order' => $this->order,'_message_' => $get_email_sms_data['get_new_text'], '_lang_' => $get_email_sms_data['user_lang']];
            $_subject_ = $get_email_sms_data['subject'];

            Mail::to($_email_)->send(new SendEmail($_view_email_, $_email_, $_data_, $_subject_));
        }


    }


    public function toSms($notifiable)
    {
//        $send_message = new SendMessage();
//        $get_email_sms_data = $this->getEmailSmsData($this->order, $this->shipping_policy, $this->status);
//        if (!is_null($get_email_sms_data['key'])) {
//            $send_message->send_order_status_msg($get_email_sms_data['number'], $get_email_sms_data['get_new_text']);
//        }

    }


    public function getEmailSmsData($order, $shipping_policy, $status)
    {

        $current_lang = app()->getLocale();
        $user_lang = $order && $order->user ? $order->user->lang : ($order ? $order->lang : "ar");

        app()->setLocale($user_lang);

        /************** send message and email *************/

        $get_settings = collect(get_setting_messages()['settings']);
        $contact_phone = $get_settings->where('key', '=', 'phone')->first();
        $phone = $contact_phone ? $contact_phone->value : "";


        $shipping_company = $order->company_shipping ? $order->company_shipping->shipping_company : null;
        $order_id = $order->id;
        $shipping_url = $shipping_company->tracking_url;
        $shipping_phone = $shipping_company->phone;
        $number = re_arrange_phone_number($order->user_phone, $order->order_user_shipping->city);


        $subject = "";
        $get_new_text = "";
        $key = "order_status";
        switch ($status) {
            case orignal_order_status()['processing'] :
                $key = "shipping_order";
                $subject = trans('admin.order_shipment');
                $phone = $shipping_phone;
                break;
            case orignal_order_status()['finished'] :
                $key = "finished_order";
                $subject = trans('admin.order_finished');
                break;
            case orignal_order_status()['failed'] :
                $key = "failed_order";
                $subject = trans('admin.order_failed');
                break;
            case orignal_order_status()['canceled'] :
                $key = "cancel_order";
                $subject = trans('admin.order_canceled');
                break;


        }
        if (!is_null($key)) {

            if (in_array($status, [orignal_order_status()['processing'],orignal_order_status()['failed'] ,orignal_order_status()['canceled'], orignal_order_status()['finished']])) {
                $lang_value = "value_" . app()->getLocale();
                $get_text = $get_settings->where('key', '=', $key)->first();
                  $get_text = $get_text ? $get_text->$lang_value : null;

                if (!is_null($get_text)) {
                    $key_words = ['[order_id]', '[shipping_policy]', '[shipping_url]', '[phone]','[order_date]','[name]'];
                    $replaces = [$order->id, $shipping_policy, $shipping_url, $phone,$order->created_at, $order->user_name];
                    $get_new_text = str_replace($key_words, $replaces, $get_text);
                }
            } else {
                $subject = trans('admin.order_changed_status');
                $get_new_text = trans('admin.notify_change_status_to', ['order_id' => $order_id, 'status' => trans_orignal_order_status()[$status]]);
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
