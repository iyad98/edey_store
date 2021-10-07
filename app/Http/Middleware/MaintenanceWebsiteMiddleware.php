<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\UserShipping;

class MaintenanceWebsiteMiddleware
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
        if(array_key_exists('close_website' , $get_maintenance_cache_data) && !Auth::guard('admin')->check()) {
            if($get_maintenance_cache_data['close_website']) {
                return redirect()->to('website/maintenance');
                //  abort(503);
            }
        }
        return $next($request);
    }
}
