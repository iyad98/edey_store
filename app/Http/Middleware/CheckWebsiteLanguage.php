<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

use LaravelLocalization;

class CheckWebsiteLanguage
{

    public function handle($request, Closure $next)
    {

        $lang = LaravelLocalization::setLocale();
        if(is_null($lang)) {
            $lang = 'ar';
        }
        app()->setLocale($lang);
        session()->put('website_lang' ,$lang);
//        if(!session()->has('website_lang')) {
//            session()->put('website_lang' , 'ar');
//        }
//        if(Auth::guard('web')->check()) {
//            $lang = Auth::guard('web')->user()->lang;
//            session()->put('website_lang' , $lang);
//        }
//
//        session()->put('website_lang' , 'ar');
//        app()->setLocale(session()->get('website_lang'));
//
        return $next($request);
    }
}
