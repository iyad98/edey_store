<?php

namespace App\Providers;

use App\Models\Category;
use App\Services\CloudStorage\AwsService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

use App\Http\Controllers\Admin\Order\ChangeOrderStatusController;
use App\Repository\NotificationAppUserRepository;

use App\Services\FileService;
use App\Services\Firebase;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('change-status-order-controller' , ChangeOrderStatusController::class);
        $this->app->bind('notification-repo-service' , NotificationAppUserRepository::class);
        $this->app->bind('firebase-service' , Firebase::class);
        // file facade
        $this->app->bind('file-Service' ,function (){
            return new FileService();
        });

        $this->app->bind('aws-Service' ,AwsService::class);


        view()->share([
            'categories' => Category::query()->where('parent',null)->get()
        ]);

    }
}
