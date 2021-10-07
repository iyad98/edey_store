<?php

namespace App\Services;

// models
use App\Models\Cart;
use App\Models\CartProduct;
use App\User;
use App\Models\ProductVariation;
use App\Models\CartProductAttributeValues;

use DB;

class CartService
{


    public function __construct()
    {

    }

    public static function update_cart_when_change_country($user, $country_id, $website = false)
    {
        if ($user) {
            $cart = $user->cart;
        } else if (!$website) {
            $cart = null;
        } else {
            $cart = Cart::where('session_id', '=', get_session_key())->first();
        }

        if ($cart) {
            CartProduct::where('cart_id', '=', $cart->id)->ProductCountry($country_id)->delete();
        }

    }

    public static function copy_products_from_guest_to_user($new_user, $device_id, $website = false)
    {

        if ($website) {
            $cart = Cart::where('session_id', '=', get_session_key())->first();
        } else {
            $user = User::GetGuest($device_id)->first();
            $cart = $user ? $user->cart : null;
        }

        if ($cart) {
            $new_cart = $new_user->cart;
            if (!$new_cart) {
                $new_cart = Cart::create([
                    'user_id' => $new_user->id,
                    'session_id' => null,
                    'tax' => 0,
                    'shipping' => 0
                ]);
            }

            $cart_products = CartProduct::where('cart_id', '=', $cart->id)->with('attribute_values')->get();

            foreach ($cart_products as $cart_product) {

                $new_cart_product = CartProduct::updateOrCreate(
                    [
                        'cart_id' => $new_cart->id,
                        'product_id' => $cart_product->product_id,
                        'product_variation_id' => $cart_product->product_variation_id,
                        'key' => $cart_product->key,


                    ],
                    [
                        'price' => $cart_product->price,
                        'discount_price' => $cart_product->discount_price,
                        'quantity' => $cart_product->quantity,
                    ]
                );
                $attribute_values = $cart_product->attribute_values->pluck('id')->toArray();
                $new_cart_product->attribute_values()->sync($attribute_values);

            }
        }

    }

    public static function update_order_product_quantity($order, $get_type = "-")
    {
        DB::transaction(function () use ($order ,$get_type ) {
            if($get_type == "+" && $order->is_discount_product_quantity == 1) {
                $type = "+";
                $order->is_discount_product_quantity = 0;
                $order->update();

            }else if($get_type == "-" && $order->is_discount_product_quantity == 0) {
                $type = "-";
                $order->is_discount_product_quantity = 1;
                $order->update();
            }else {
                $type = null;
            }
            if(!is_null($type)) {
                $order_products = $order->order_products;
                $products_variation = ProductVariation::whereIn('id', $order_products->pluck('product_variation_id')->toArray())->get();
                foreach ($order_products as $order_product) {
                    $product_variation = $products_variation->where('id', '=', $order_product->product_variation_id)->first();
                    if ($product_variation) {

                        switch ($type) {
                            case "+" :
                                $product_variation->stock_quantity = $product_variation->stock_quantity + $order_product->quantity;
                                break;
                            case "-" :
                                $product_variation->stock_quantity = $product_variation->stock_quantity - $order_product->quantity;

                                if ( $product_variation->stock_quantity == 0 ){
                                   CartProduct::where('product_variation_id',$product_variation->id)->delete();
                                }
                                break;
                        }
                        $product_variation->update();
                    }

                }

            }
        });


    }

    public static function update_product_variation( $product_variation , $quantity_before , $quantity_after ) {

        if($quantity_after > $quantity_before ) {
            $type = "-";
            $quantity = $quantity_after - $quantity_before;

        }else if($quantity_after < $quantity_before) {
            $type = "+";
            $quantity = $quantity_before - $quantity_after;

        }else {
            $type = "";
            $quantity = 0;
        }
        switch ($type) {
            case "+" :
                $product_variation->stock_quantity = $product_variation->stock_quantity + $quantity;
                break;
            case "-" :
                $product_variation->stock_quantity = $product_variation->stock_quantity - $quantity;
                break;
        }
        $product_variation->update();

    }

    public static function update_cart_when_update_product() {

        CartProductAttributeValues::whereHas('cart_product' , function ($query){
            $query->GetDeletedCartProduct();
        })->delete();
        CartProduct::GetDeletedCartProduct()->delete();
    }

    public static function delete_cart($cart , $order) {
        if(is_null($cart)) {
            $user_id = $order->user_id;
            $session_id = $order->session_id;
            if(!is_null($user_id)) {
                $cart = Cart::where('user_id' , '=' , $user_id)->first();
            }else {
                $cart = Cart::where('session_id' , '=' , $session_id)->first();
            }
        }
        if($cart) {
            $cart->products()->delete();
           // $cart->delete();
        }
    }
}