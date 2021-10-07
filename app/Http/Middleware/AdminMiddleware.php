<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
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
        $admin = auth()->guard('admin')->user();

        if($admin->is_admin()) {
            return $next($request);
        }else {
            if($request->ajax() || $request->wantsJson()) {
                return general_response(false, false, "", trans('admin.no_auth'), "", []);
            }else {
                abort(503);
            }
        }


    }
}
