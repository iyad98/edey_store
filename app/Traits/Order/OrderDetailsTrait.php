<?php
/**
 * Created by PhpStorm.
 * User: HP15
 * Date: 04/08/19
 * Time: 10:08 ص
 */

namespace App\Traits\Order;

use Carbon\Carbon;

use App\Models\Order;

trait OrderDetailsTrait
{

    public function get_order_details($id, $currency_type = 2)
    {
        $order = Order::withTrashed()->with(['user', 'currency', 'order_payment', 'admin_discounts', 'payment_method',
            'company_shipping.shipping_company', 'coupon',
            'order_user_shipping.shipping_city.country', 'order_products.product:id,name_ar,name_en,image', 'package.package',
            'order_products.product_attribute_values__.attribute.attribute_type', 'order_products.product_variation:id,product_id,sku'])
            ->find($id);

        $get_remain_replace_time = get_remain_replace_time($order);

        $order->status_text = trans_order_status()[$order->status];
        $order->status_class = order_status_class()[$order->status];
        $order->can_edit = $this->can_edit_order($order->status);
        $order->remain_replace_time = $get_remain_replace_time['remain_replace_time'];
        $order->can_replace = $get_remain_replace_time['can_replace'];
        $order->currency_text = $currency_type == 2 ? "SAR" : $order->currency->code;
        $order->currency_symbol = $currency_type == 2 ? trans('api.currency') : $order->currency->symbol;
        $order->currency_type = $currency_type;
        $exchange_rate = $currency_type == 2 ? 1 : $order->exchange_rate;

        $country_id = $order->order_user_shipping && $order->order_user_shipping->shipping_city && $order->order_user_shipping->shipping_city->country ? $order->order_user_shipping->shipping_city->country->id : -1;
        $city_id = $order->order_user_shipping && $order->order_user_shipping->shipping_city ? $order->order_user_shipping->shipping_city->id : -1;
        $shipping_company_id = $order->company_shipping && $order->company_shipping->shipping_company ? $order->company_shipping->shipping_company->id : -1;


        $order->country_id_selected = $country_id;
        $order->city_id_selected = $city_id;
        $order->shipping_company_id_selected = $shipping_company_id;

        return $this->update_order_as_selected_currency($order, $exchange_rate);
    }

    public function update_order_as_selected_currency($order, $exchange_rate = 1)
    {

        $currency_data['exchange_rate'] = $exchange_rate;
        $order->price = reverse_convert_currency($order->price, $currency_data);
        $order->price_after = reverse_convert_currency($order->price_after, $currency_data);
        $order->tax = reverse_convert_currency($order->tax, $currency_data);
        $order->shipping = reverse_convert_currency($order->shipping, $currency_data);
        $order->coupon_price = reverse_convert_currency($order->coupon_price, $currency_data);
        $order->coupon_automatic_price = reverse_convert_currency($order->coupon_automatic_price, $currency_data);
        $order->admin_discount = reverse_convert_currency($order->admin_discount, $currency_data);
        $order->cash_fees = reverse_convert_currency($order->cash_fees, $currency_data);
        $order->first_order_discount = reverse_convert_currency($order->first_order_discount, $currency_data);
        $order->package_discount_price = reverse_convert_currency($order->package_discount_price, $currency_data);
        $order->total_price = reverse_convert_currency($order->total_price, $currency_data);
        $order->discount_price = reverse_convert_currency($order->discount_price, $currency_data);
        $order->total_coupon_price = reverse_convert_currency($order->total_coupon_price, $currency_data);
        $order->price_after_discount_coupon = reverse_convert_currency($order->price_after_discount_coupon, $currency_data);
        $order->price_before_tax = reverse_convert_currency($order->price_before_tax, $currency_data);


        $order->coupon->map(function ($value) use ($currency_data) {
            $value->coupon_price = reverse_convert_currency($value->coupon_price, $currency_data);
            return $value;
        });

        $order->admin_discounts->map(function ($value) use ($currency_data) {
            $value->price = reverse_convert_currency($value->price, $currency_data);
            return $value;
        });

        $order->order_products->map(function ($value) use ($currency_data) {
            $value->price = reverse_convert_currency($value->price, $currency_data);
            $value->discount_price = reverse_convert_currency($value->discount_price, $currency_data);
            $value->tax = reverse_convert_currency($value->tax, $currency_data);
            $value->total_discount_price = reverse_convert_currency($value->total_discount_price, $currency_data);
            $value->total_price = reverse_convert_currency($value->total_price, $currency_data);
            $value->total_price_after = reverse_convert_currency($value->total_price_after, $currency_data);
            $value->price_after = reverse_convert_currency($value->price_after, $currency_data);

            return $value;
        });
        $order->company_shipping->shipping_company_amount = reverse_convert_currency($order->company_shipping->shipping_company_amount, $currency_data);
        if ($order->package) {
            $order->package->package_discount = reverse_convert_currency($order->package->package_discount, $currency_data);
            $order->package->package_price = reverse_convert_currency($order->package->package_price, $currency_data);

        }

        $currency = $order->currency;
        $currency_code = isset($order->currency_symbol) ? $order->currency_symbol:($currency ? $currency->symbol : "") ;
        $order_shipping = $order->company_shipping;
        $key_words = ['[from]', '[to]'];
        $replaces = [reverse_convert_currency($order_shipping->from , $currency_data)." ".$currency_code , reverse_convert_currency($order_shipping->to ,$currency_data ). " ".$currency_code];

        $get_new_text = str_replace($key_words, $replaces, $order_shipping ? $order_shipping->shipping_company_price_text : "" );

        $order->shipping_text = $get_new_text;
        return $order;

    }


    public function can_edit_order($status)
    {
//        $can_edit = [order_status()['payment_waiting'], order_status()['processing']];
//        return in_array($status, $can_edit) ? 1 : 0;
        return 1;


    }
}