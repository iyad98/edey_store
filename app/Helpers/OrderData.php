<?php

use App\Models\Point;

function get_point_data()
{
    return \App\Models\Setting::where('key','point_price')->first();
}

function get_order_points( $total_price)
{
    $order_point = get_point_data();
    return $order_point ? ($total_price / $order_point->value) : 0;
}

function get_wallet_price($points)
{
//    if (!$setting) {
//        $setting = get_point_data();
//    }
    $setting = get_point_data();
    $wallet_point = $setting->where('key', 'wallet')->first();
    if(!$wallet_point || $wallet_point->price == 0) return 0;

    return $wallet_point ? ($points * ($wallet_point->price)) / ($wallet_point->points == 0 ? 1 : $wallet_point->points) : 0;
}

function get_wallet_point($setting, $price)
{
    if (!$setting) {
        $setting = get_point_data();
    }
    $wallet_point = $setting->where('key', 'wallet')->first();
    if(!$wallet_point || $wallet_point->price == 0) return 0;

    return $wallet_point ? ($price * ($wallet_point->points)) / $wallet_point->price : 0;
}