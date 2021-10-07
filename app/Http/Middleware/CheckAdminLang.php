<?php

namespace App\Http\Middleware;

use Closure;

use Auth;

class CheckAdminLang
{

    public function handle($request, Closure $next)
    {
    //    return response()->json(Auth::guard('admin')->user());
        app()->setLocale('ar');
        return $next($request);
    }
}
