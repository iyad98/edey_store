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

class SendConfirmCodeNotification extends Notification
{
    use Queueable;

    public $phone;
    public $code;

    public function __construct($phone , $code)
    {
        $this->phone = $phone;
        $this->code = $code;
    }


    public function via($notifiable)
    {
        $channels = [SmsChannel::class];
        return $channels;
    }


    public function toDatabase($notifiable)
    {
        return [];
    }
    public function toSms($notifiable)
    {
        $text = trans('notification.send_confirm_code' , ['code' => $this->code]);
        $send_message = new SendMessage();
        $send_message->send_order_status_msg($this->phone, $text);

    }


}
