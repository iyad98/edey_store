<?php

namespace App\Notifications;

use App\Channels\FirebaseChannel;
use App\Channels\MailChannel;
use App\Channels\SmsChannel;
use App\Mail\SendEmail;
use App\Models\NotificationAppUser;
use App\Repository\NotificationAppUserRepository;
use App\Services\JawalService\SendMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


class SendRejectBankTransferNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $order;
    public $reject_reason;

    public function __construct($order, $reject_reason)
    {
        $this->order = $order;
        $this->reject_reason = $reject_reason;

    }


    public function via($notifiable)
    {
        return [MailChannel::class ,  SmsChannel::class , FirebaseChannel::class ];
    }


    public function toFirebase($notifiable)
    {
        $notification = app()->make('notification-repo-service');
        $firebase = app()->make('firebase-service');

        $order = $this->order;
        $user = $order->user;
        $type = notification_status()['reject_bank_transfer'];

        if ($user && $user->notification == 1) {

            $data = [
                'order_id' => $order->id,
                'type' => $type,
                'status' => $order->status,
                'status_text' => trans_order_status()[$order->status],
                'reject_reason' => $this->reject_reason
            ];

            $get_title_sub_title_notification = $notification->get_title_sub_title_notification($type, $data, $user->lang);
            $title = $get_title_sub_title_notification['title'];
            $sub_title = $get_title_sub_title_notification['sub_title'];

            $firebase->send($title, $sub_title, $data, $user->fcm_token);
        }

    }

    public function toMailChannel($notifiable)
    {
        $order = $this->order;
        $user_lang = $order && $order->user ? $order->user->lang : ($order ? $order->lang : "ar");

        app()->setLocale($user_lang);

        $bill_email = $order->user_email;
        // send email to user ////////////////////////////////
        $_view_email_ = "website.notifications.confirmcod";
        $_email_ = $bill_email;
        $_data_ = [
            'title' => trans('notification.reject_bank_transfer', ['order_id' => $order->id, 'reject_reason' => $this->reject_reason], $user_lang),
            'sub_title' => trans('notification.reject_bank_transfer_description', ['order_id' => $order->id, 'reject_reason' => $this->reject_reason], $user_lang),
            '_message_' => trans('notification.reject_bank_transfer_description', ['order_id' => $order->id, 'reject_reason' => $this->reject_reason], $user_lang),
            '_lang_' => $user_lang,
            'platform' => 'web',

        ];
        $_subject_ = trans('website.bank_transfer_', [], $user_lang);
        Mail::to($_email_)->send(new SendEmail($_view_email_, $_email_, $_data_, $_subject_));


    }

    public function toSms($notifiable)
    {
//        $send_message = new SendMessage();
//        $order = $this->order;
//
//        $user_lang = $order && $order->user ? $order->user->lang : ($order ? $order->lang : "ar");
//        app()->setLocale($user_lang);
//
//        $message = trans('notification.reject_bank_transfer_message' , [
//            'user_name' => $order->user_name ,
//            'order_id' => $order->id ,
//            'reject_reason' => $this->reject_reason
//        ]);
//        $number = $order->user_phone;
//
//        $send_message->send_order_status_msg($number, $message);
    }


    public function toDatabase($notifiable)
    {

    }


}
