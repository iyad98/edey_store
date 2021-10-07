<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;

class AdminProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }


    public function boot()
    {
        Blade::if('check_admin', function () {
            $admin = Auth::guard('admin')->user();
            return $admin->is_admin();
        });

        Blade::if('check_auth_admin', function ($pharmacy_id) {
            $admin = Auth::guard('admin')->user();
            $pharmacy_ids = $admin->pharmacies()->pluck('id')->toArray();
            return $admin->admin_role == role()['admin_role'] || in_array($pharmacy_id ,$pharmacy_ids);
        });


        Blade::if('check_role' , function($role) {
            return check_role($role);

        });
        
    }
}
