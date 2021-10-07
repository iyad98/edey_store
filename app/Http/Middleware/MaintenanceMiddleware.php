<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\UserShipping;

class MaintenanceMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $get_maintenance_cache_data = get_maintenance_cache_data();
        if(array_key_exists('close_app' , $get_maintenance_cache_data)) {
            if($get_maintenance_cache_data['close_app']) {
                $msg = Setting::where('key','close_website')->first()->value_ar;
                return response_api(false, $msg , [] , 503);
            }
        }
        return $next($request);
    }
}
