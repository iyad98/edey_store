<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\UserShippingResource;
use App\Http\Resources\Order\OrderProductResource;
use App\Http\Resources\Order\OrderCouponResource;
use App\Http\Resources\Order\OrderPackageResource;
use App\Http\Resources\Order\OrderAdminDiscountResource;
use Carbon\Carbon;

class OrderDetailsResource extends JsonResource
{

    public function toArray($request)
    {


        $get_remain_replace_time = get_remain_replace_time($this);
        $request->request->add(['currency' => $this->currency->symbol]);
        return [
            'id' => $this->id,
            'status_text' => trans_orignal_order_status()[$this->status],
            'status' => $this->status,
            'payment_method' => $this->payment_method ? $this->payment_method->name : "",
            'company_shipping' => $this->company_shipping ? $this->company_shipping->shipping_company_name : "",
            'coupons' => OrderCouponResource::collection($this->coupon),
            'coupon' => "",
            'user_shipping' => new UserShippingResource($this->order_user_shipping),
            'price' => number_format($this->price , round_digit(), '.', ''),
            'price_after' => number_format($this->price_after , round_digit(), '.', '') ,
            'price_after_discount_coupon' =>number_format( $this->price_after_discount_coupon, round_digit(), '.', '') ,
            'tax' => number_format($this->tax, round_digit(), '.', '') ,
            'shipping' =>number_format( $this->shipping, round_digit(), '.', '') ,
            'coupon_price' => number_format( $this->coupon_price, round_digit(), '.', '') ,
            'coupon_code' => $this->coupon_code ? $this->coupon_code->coupon : "",
            'coupon_automatic_price' => number_format(  $this->coupon_automatic_price, round_digit(), '.', '') ,
            'coupon_automatic_code' => $this->coupon_automatic_code,
            'first_order_discount' => number_format( $this->first_order_discount, round_digit(), '.', '') ,
            'admin_discounts' => OrderAdminDiscountResource::collection($this->admin_discounts),
            'package' => new OrderPackageResource($this->package),
            'cash_fees' => number_format( $this->cash_fees , round_digit(), '.', ''),
            'return_order_note_text' => $this->return_order_note_text,

            'return_order_note_file' =>  !empty(explode("/uploads/ads/", $this->return_order_note_file)[1])? $this->return_order_note_file : null,
            'shipping_policy'=>$this->shipping_policy,

            'total_price' =>number_format(  $this->total_price , round_digit(), '.', ''),
            'currency' => $this->currency->symbol,
            'products' => OrderProductResource::collection($this->order_products),
            'date' => $this->created_at,
            'remain_replace_time' => $get_remain_replace_time['remain_replace_time'],
            'can_replace' => $get_remain_replace_time['can_replace'] ,
            'payment_url' => $request->has('payment_url') ? $request->payment_url : null
        ];
    }
}
