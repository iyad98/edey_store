<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
/*  Models */
use App\Models\NotificationAppUser;
/* Repository */
use App\Repository\NotificationAppUserRepository;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $data;
    public $notification;

    public function __construct($data )
    {
        $this->data = $data;
        $this->notification = new NotificationAppUserRepository(new NotificationAppUser());
    }


    public function handle()
    {


        $all = array_key_exists('all' , $this->data) && $this->data['all'];
        if($all) {
            $this->notification->add_notification_to_all($this->data);
        }else {
            $this->notification->add_notification($this->data);
        }

    }
}
