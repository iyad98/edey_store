<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckCountryWebsiteMiddleware
{

    public function handle($request, Closure $next)
    {

        $request->request->add([
            'country_code_session' => session()->get('country_code')
        ]);
        return $next($request);
    }
}
