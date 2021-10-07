<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class ProviderMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::guard('api')->user();
        if ($user->type != type()['provider'] && $user->sub_type != 0) {
            return response_api(false, trans('api.no_auth'), "");
        }
        return $next($request);
    }
}
