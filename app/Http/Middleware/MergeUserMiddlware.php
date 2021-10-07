<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\UserShipping;

class MergeUserMiddlware
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


        $excepts_url_device_id = get_list_excepts_url_device_id();
        $device_id = $request->device_id;
        $fcm_token = $request->fcm_token;
        $platform = $request->platform;

        if(Auth::guard('api')->check()) {
            $user = Auth::guard('api')->user();
        }else {
            if($device_id && !in_array($request->url() , $excepts_url_device_id)) {
                $user = User::updateOrCreate(['device_id' => $device_id], [
                    'device_id' => $device_id ,
                    'fcm_token' => $fcm_token ,
                    'is_guest' => 1 ,
                    'platform' => $platform

                ]);
                UserShipping::updateOrCreate(['user_id' => $user->id]);
            }else {
                $user = null;
            }
        }



        $request->merge(['user' => $user]);

        // for currency_data
        $price_tax_in_products = get_cart_data_cache()['price_tax_in_products'];
        $price_tax_in_cart = get_cart_data_cache()['price_tax_in_cart'];
        $get_country_code_data = get_country_code($request, $user);
        $get_currency_data = get_currency_data($get_country_code_data);
        $request->request->add([
            'price_tax_in_products' => $price_tax_in_products == 1,
            'price_tax_in_cart' => $price_tax_in_cart == 1 ,
            'get_currency_data' => $get_currency_data,
            'get_country_code_data' => $get_country_code_data,
        ]);

        return $next($request);
    }
}
