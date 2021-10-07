<?php

namespace App\Notifications;

use App\Channels\FirebaseChannel;
use App\Channels\MailChannel;
use App\Channels\SmsChannel;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use App\Mail\SendEmail;

// channels

// services
use App\Services\JawalService\SendMessage;
use Illuminate\Support\Facades\Mail;

// models
use App\Models\NotificationAppUser;

/* Repository */
use App\Repository\NotificationAppUserRepository;


class SendApproveOrRejectOrderReturnNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $order;
    public $title;
    public $sub_title;
    public $firebase_type;

    public function __construct($order ,$title , $sub_title ,$firebase_type)
    {
        $this->order = $order;
        $this->title = $title;
        $this->sub_title = $sub_title;
        $this->firebase_type = $firebase_type;

    }

    public function via($notifiable)
    {
        return [MailChannel::class , FirebaseChannel::class ];
    }


    public function toFirebase($notifiable)
    {
        $notification = app()->make('notification-repo-service');
        $firebase = app()->make('firebase-service');

        $order = $this->order;
        $user = $order->user;
        $type = notification_status()[$this->firebase_type];

        if($user && $user->notification == 1) {

            $data = [
                'order_id' => $order->id ,
                'type' => $type,
                'status' => $order->status ,
                'status_text' => trans_order_status()[$order->status],
            ];

            $title = $this->title;
            $sub_title = $this->sub_title;

            $firebase->send($title ,$sub_title ,$data ,$user->fcm_token);
        }
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
            'title' => $this->title,
            'sub_title' => $this->title,
            '_message_' => $this->sub_title,
            '_lang_' => $user_lang,
            'platform' => 'web',

        ];
        $_subject_ =  $this->title;
        Mail::to($_email_)->send(new SendEmail($_view_email_ , $_email_ , $_data_ , $_subject_));


    }

    public function toDatabase($notifiable)
    {

    }


}
