<?php

namespace App\Services;

// models
use App\Models\Coupon;
use App\Models\CartProduct;
use App\User;
use App\Models\ProductVariation;
use App\Models\CartProductAttributeValues;

use DB;
use Carbon\Carbon;

class CouponService
{


    public function __construct()
    {

    }


    public static function check_coupon($user , $coupon_code , $get_cart_data) {
        if(empty($coupon_code)) {
            return ['status' => true , 'message' => trans('api.coupon_deleted') , 'data' => []];

        }
        $coupon = Coupon::with('type')->where('coupon', '=', $coupon_code)->first();
        if(!$coupon) {
            return ['status' => false , 'message' => trans('api.coupon_not_available') , 'data' => []];
        }
        if($coupon->start_at >= Carbon::now()->format('Y-m-d H:i:s') ||
            $coupon->end_at <= Carbon::now()->format('Y-m-d H:i:s') ) {

            return ['status' => false , 'message' => trans('api.expire_coupon') , 'data' => []];
        }

        $min_price = $coupon->min_price;
        $get_cart_price = reverse_convert_currency_2($get_cart_data['price'], ['exchange_rate' => $get_cart_data['exchange_rate']]);
        if($get_cart_price < $min_price) {
            return ['status' => false , 'message' => trans('api.coupon_must_gt_min_price' ,['min_price' => convert_currency($min_price , ['exchange_rate' => $get_cart_data['exchange_rate']])]) , 'data' => []];
        }

        $coupons_automatic = Coupon::where('id' , '=' , $coupon->id)->IsActiveAndAutomatic()->first();
        if($coupons_automatic && $coupons_automatic->count() > 0) {
            return ['status' => false , 'message' => trans('api.coupon_already_used') , 'data' => []];
        }
//
//        if ($user) {
//            $count_used = $user->orders()->whereHas('coupon', function ($query1) use ($coupon_code) {
//                $query1->where('coupon_code', '=', $coupon_code);
//            })->count();
//        } else {
//            $count_used = 0;
//        }
//        if ($coupon->max_used <= $count_used) {
//            return ['status' => false, 'message' => trans('api.reach_max_used_coupon'), 'data' => []];
//        }

        return ['status' => true , 'message' => trans('api.coupon_is_available') , 'data' => [
            'coupon' => $coupon
        ]];


    }
}