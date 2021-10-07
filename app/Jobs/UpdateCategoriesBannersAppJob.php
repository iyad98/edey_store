<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
/*  Models */
use App\User;
/* Repository */
use App\Repository\NotificationAppUserRepository;

class UpdateCategoriesBannersAppJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;



    public function __construct( )
    {

    }


    public function handle()
    {
        update_categories_banners_app();
    }
}
