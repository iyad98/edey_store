<?php

namespace App\Listeners;

use App\Events\TestEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TestListener
{

    public function __construct()
    {

    }


    public function handle(TestEvent $event)
    {
        $event->user->name = "AAAAA";
        $event->user->update();
    }
}
