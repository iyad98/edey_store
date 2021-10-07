<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
/*  Models */
use App\Models\NotificationAdmin;
/* Repository */
use App\Repository\NotificationAdminRepository;

class SendNotificationAdminJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $data;
    public $notification;

    public function __construct($data )
    {
        $this->data = $data;
        $this->notification = new NotificationAdminRepository(new NotificationAdmin());
    }


    public function handle()
    {

        $this->notification->add_notification($this->data);
    }
}
