<?php

namespace App\Services;

// models
use App\Models\Cart;
use App\Models\CartProduct;
use App\User;
use App\Models\ProductVariation;
use App\Models\CartProductAttributeValues;

// services
use App\Services\WalletService\WalletUser;

use DB;

class PointService
{


    public function __construct()
    {

    }

    public static function update_user_points($order , $type = "+") {
        DB::transaction(function () use ($order , $type) {
            $user = $order->user;
            //   $price = get_wallet_price(null , $order->order_points);

            if($order->is_add_to_user_points == 0 && $type == "+") {
                if ($user && $user->is_guest == 0) {

                    WalletUser::add_wallet_logs($user , $order , wallet_log_status()['order_point'] , $order->order_points);

                    $user->points = $user->points + $order->order_points;
                    $user->update();

                    $order->is_add_to_user_points = 1;
                    $order->update();
                }
            }else if($order->is_add_to_user_points == 1 && $type == "-") {
                if ($user && $user->is_guest == 0) {

                    WalletUser::add_wallet_logs($user , $order , wallet_log_status()['failed_order'] , $order->order_points);

                    $user->points = $user->points - $order->order_points;
                    $user->update();

                    $order->is_add_to_user_points = 0;
                    $order->update();
                }
            }
        });


    }
    public static function make_order_user_points($order) {
        DB::transaction(function () use ($order) {
            $user = $order->user;

            if ($user && $user->is_guest == 0) {

                if($order->pay_points > 0 && $order->paid_points == 0) {
                    WalletUser::add_wallet_logs($user , $order , wallet_log_status()['buy_order'] , ($order->pay_points - $order->paid_points));
                }else {
                    $points = ($order->pay_points - $order->paid_points);
                    if($points >= 0) {
                        WalletUser::add_wallet_logs($user , $order , wallet_log_status()['update_order_down'] ,$points );
                    }else {
                        WalletUser::add_wallet_logs($user , $order , wallet_log_status()['update_order_up'] ,(-1)*$points );

                    }
                }
                $user->points = $user->points - ($order->pay_points - $order->paid_points);
                $user->update();

                $order->paid_points = $order->pay_points;
                $order->update();
            }
        });



    }

    public static function update_order_user_pay_points($order , $type = "+") {
        DB::transaction(function () use ($order , $type) {
            $user = $order->user;

            if ($user && $user->is_guest == 0) {


                if($type == "+") {

                    WalletUser::add_wallet_logs($user , $order , wallet_log_status()['change_order_to_lock_status'] , $order->pay_points);
                    $user->points = $user->points + $order->pay_points;
                    $user->update();

                    $order->paid_points = 0;
                    $order->update();
                }else {

                    WalletUser::add_wallet_logs($user , $order , wallet_log_status()['change_order_to_active_status'] , $order->pay_points);


                    $user->points = $user->points - $order->pay_points;
                    $user->update();

                    $order->paid_points = $order->pay_points;
                    $order->update();
                }
            }
        });
    }

}