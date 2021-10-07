<?php

namespace App\Services\Order;

// models
use App\Models\Cart;
use App\Models\Country;
use App\User;
use DB;

use App\Validations\OrderConfirmPhoneValidation;
use Illuminate\Http\Request;
use Carbon\Carbon;

// Notification
use App\Notifications\SendConfirmCodeNotification;
use Illuminate\Support\Facades\Notification;

class OrderConfirmPhoneService
{

    public function __construct()
    {
    }

    public static function send_code(Request $request) {

        $validation = new OrderConfirmPhoneValidation();
        $check_data = $validation->check_send_code($request->toArray());

        if ($check_data['status']) {

            $user = $request->user;
            $session_id =  get_session_key();

            if ($user) {
                $cart = Cart::CheckUserId($user->id)->first();
            } else {
                $cart = Cart::CheckSessionId($session_id)->first();
            }
            if(!$cart) {
                return ['status' => false, 'message' => trans('api.no_cart'), 'data'=> []];
            }
               $phone_code = Country::where('iso2','=',$request->country_code)->first()->phone_code;

            $code = self::generate_code();
            $phone = $phone_code."-".($request->phone * 1);
            $cart->code = $code;
            $cart->phone = $phone;
            $cart->confirm_setps = 2;
            $cart->verified_at = null;
            $cart->update();

            if ($user) {
                $user->phone = $phone;
                $user->phone_verified_at = null;
                $user->confirm_setps = 2;
                $user->update();
            }

            // send notification
            Notification::route('test', 'test')->notify(new SendConfirmCodeNotification(str_replace('-','',$phone) ,$code ) );

            return ['status' => true, 'message' => trans('api.send_code_success'),  'data' =>[
                'phone_code' => $phone_code,
                'phone'      => $request->phone ,
                'steps'      => 2 ,
            ]];
        }else {
            return ['status' => false, 'message' => $check_data['message'],  'data'=> []];
        }
    }
    public static function confirm(Request $request) {
        $user = $request->user;
        $session_id =  get_session_key();
        if ($user) {
            $cart = Cart::CheckUserId($user->id)->first();
        } else {
            $cart = Cart::CheckSessionId($session_id)->first();
        }
        if(!$cart) {
            return ['status' => false, 'message' => trans('api.no_cart'),  'data'=> []];
        }
        $phone_code = Country::where('iso2','=',$request->country_code)->first()->phone_code;
        $phone = $phone_code."-".($request->phone*1);

        $code = $request->code;

        if($cart->phone != $phone) {
            return ['status' => false, 'message' => trans('api.phone_number_has_send_confirm_changed'),  'data'=> []];
        }
        if($cart->code != $code) {
            return ['status' => false, 'message' => trans('api.code_is_wrong'), 'data'=> []];
        }
        $cart->verified_at = Carbon::now();
        $cart->confirm_setps = 3;
        $cart->update();

        if ($user) {
            $user->phone = $phone;
            $user->phone_verified_at = Carbon::now();
            $user->confirm_setps = 3;
            $user->update();
        }

        return ['status' => true, 'message' => trans('api.confirm_code_success'),  'data' =>[
            'phone_code' =>   $phone_code,
            'phone'      => $request->phone ,
            'steps'      => 3 ,
        ]];
    }

    // generate code
    public static function generate_code() {
        return "1234";
        $digits = 4;
        return str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
    }
}