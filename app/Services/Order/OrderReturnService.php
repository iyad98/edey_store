<?php

namespace App\Services\Order;

// models
use App\User;
use App\Models\Product;
use App\Models\OrderProduct;
use App\Models\Order;

use DB;

use Illuminate\Http\Request;
use Carbon\Carbon;

// notification
use Illuminate\Support\Facades\Notification;
use App\Notifications\SendCheckOrderReturnNotification;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class OrderReturnService
{

    public function __construct()
    {
    }

    public static function return_order_product($order , $order_products) {


        if(!$order) {
            return ['status' => false, 'message' => trans('api.order_not_found'), 'data'=> []];
        }
        if(in_array($order->status , [6 , 9 , 10])) {
            return ['status' => false, 'message' => trans('api.order_is_already_returned'), 'data'=> []];
        }
        if(Carbon::parse($order->created_at)->addDays(10) < Carbon::now() ) {
            return ['status' => false, 'message' => trans('api.you_exceeded_time_to_return'), 'data'=> []];
        }
        $order_products = $order->order_products()->whereIn('order_products.id' ,$order_products)->get();
        if($order_products->count() <= 0) {
            return ['status' => false, 'message' => trans('api.select_products_to_return'), 'data'=> [$order_products->count()]];
        }


        $products_cant_returned = Product::whereIn('id' , $order_products->pluck('product_id')->toArray())
            ->where('can_returned' , '=' , 0)->pluck('name_ar')->toArray();

        if(count($products_cant_returned) > 0) {
            return ['status' => false, 'message' => trans('api.this_product_cant_returned' , ['products' =>implode(" , " ,$products_cant_returned) ]), 'data'=> []];
        }



        $return_order_data = get_date_order_status()[order_status()['return_order']];
        $order->status = order_status()['return_order'];
        $order->$return_order_data = Carbon::now();
        $order->update();

        $order->order_products()->whereIn('order_products.id' ,$order_products->pluck('id'))->update([
            'is_returned' => 1
        ]);

        $order->return_order_at = Carbon::parse($order->return_order_at)->format('Y-m-d h:i a');
        return ['status' => true, 'message' => trans('api.send_return_order_success'), 'data'=> [
            'order' => $order
        ]];
    }

    public static function check_return_order($request) {
        $order_id = $request->id;
        $phone = $request->phone;
        $order = Order::where('id' , '=' , $order_id)->where('user_phone' ,'=' , $phone)->first();
        if($order) {
            $check_return_order_token = Str::uuid()->toString().Str::random(100).time();
            $order->check_return_order_token = Hash::make($check_return_order_token);
            $order->update();
            Notification::route('test', 'test')->notify(new SendCheckOrderReturnNotification($order , $check_return_order_token) );
            return ['status' => true, 'message' => trans('api.send_link_return_order_to_email_phone'), 'data'=> []];
        }else {
            return ['status' => false, 'message' => trans('api.order_with_data_not_found'), 'data'=> []];
        }
    }
}