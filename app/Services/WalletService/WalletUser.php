<?php

namespace App\Services\WalletService;

// models
use App\Models\Cart;
use App\Models\CartProduct;
use App\User;
use App\Models\ProductVariation;
use App\Models\CartProductAttributeValues;
use App\Models\WalletLog;

use Illuminate\Database\Eloquent\SoftDeletes;

class WalletUser
{
    public function __construct()
    {

    }

    public static function add_wallet_logs($user , $order, $type, $points)
    {

        $points_before = $user->points;
        $points_after = null;
        switch ($type) {
            case wallet_log_status()['order_point'] :
                $points_after = $points_before + $points;
                break;

            case wallet_log_status()['buy_order'] :
                $points_after = $points_before - $points;
                break;

            case wallet_log_status()['update_order_up'] :
                $points_after = $points_before + $points;
                break;

            case wallet_log_status()['update_order_down'] :
                $points_after = $points_before - $points;
                break;

            case wallet_log_status()['failed_order'] :
                $points_after = $points_before - $points;
                break;

            case wallet_log_status()['change_order_to_lock_status'] :
                $points_after = $points_before + $points;
                break;
            case wallet_log_status()['change_order_to_active_status'] :
                $points_after = $points_before - $points;
                break;
        }

        if(!is_null($points_after)) {
            $user->wallet_log()->create([
                'type' => $type ,
                'order_id' => $order->id ,
                'points_before' => $points_before ,
                'points' => $points ,
                'points_after' => $points_after
            ]);
        }
    }


}