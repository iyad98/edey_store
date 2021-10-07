<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

use App\Models\Country;

class MergeUserWebsiteMiddlware
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

        if(Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            if($user->lang != app()->getLocale()) {
                $user->lang = app()->getLocale();
                $user->update();
            }
        }else {
            $user = null;
        }
        $request->merge(['user' => $user]);

        // for currency_data
        $price_tax_in_products = get_cart_data_cache()['price_tax_in_products'];
        $price_tax_in_cart = get_cart_data_cache()['price_tax_in_cart'];
        $country_code = get_country_code($request, $user , true);
        $get_currency_data = get_currency_data($country_code);
        $country = Country::where('iso2' , '=' , $country_code)->first();

        $request->request->add([
            'price_tax_in_products' => $price_tax_in_products == 1,
            'price_tax_in_cart' => $price_tax_in_cart == 1 ,
            'get_currency_data' => $get_currency_data,
            'get_country_data' => $country ,
        ]);
        return $next($request);
    }
}
