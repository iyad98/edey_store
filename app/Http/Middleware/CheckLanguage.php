<?php

namespace App\Http\Middleware;

use Closure;

class CheckLanguage
{

    public function handle($request, Closure $next)
    {
        $language = $request->server('HTTP_ACCEPT_LANGUAGE');
        if($language) {
            app()->setLocale($language);
        }else {
            app()->setLocale('en');
        }
        if(auth()->guard('api')->check()) {
            $user = auth()->guard('api')->user();
            $user->lang = app()->getLocale();
            $user->update();
        }
        return $next($request);
    }
}
