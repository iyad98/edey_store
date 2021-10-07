<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\User;
class CheckRoleMiddleware
{

    public function handle($request, Closure $next , $roles)
    {

        $admin = Auth::guard('admin')->user();

        if(Auth::guard('admin')->check() && ($admin->super_admin == 1 || $admin->hasPermissions($roles))) {
            return $next($request);
        }else {
            if($request->ajax() || $request->wantsJson()) {
                return general_response(false, false, trans('admin.no_auth'), trans('admin.no_auth'), "", []);

            }else {
                return redirect('admin');
            }
        }



    }



}
