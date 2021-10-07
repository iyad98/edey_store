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

class SendMultiNotificationJob implements ShouldQueue
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
        $ads = $this->data['ads'];
        $from_user = $this->data['from_user'];
        $user_ids = $this->data['user_id'];
        $type = $this->data['type'];

        foreach ($user_ids as $user_id) {
            $data_follow = [
                'from_user_id' => $from_user->id,
                'user_id' => $user_id,
                'type' => $type,
                'ads_id' => $ads->id,
                'data' => ['name' => $from_user->f_name, 'ads_title' => $ads->name ? $ads->name : $ads->name_en]
            ];
            $this->notification->add_notification($data_follow);
        }

    }
}
