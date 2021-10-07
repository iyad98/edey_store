<?php

namespace App\Http\Middleware;

use Closure;

use Auth;
use App\Models\AdminFcm;

class MergeAdminFcmMiddleware
{

    public function handle($request, Closure $next)
    {

        $admin = Auth::guard('admin')->user();
        $fcm = AdminFcm::where('admin_id' , '=' , $admin->admin_id)
            ->where('session_id' , '=' , Auth::guard('admin')->getSession()->getId())
            ->first();

        $request->merge(['admin_fcm' => $fcm ? $fcm->fcm : null]);
        return $next($request);
    }
}
