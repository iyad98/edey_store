<?php

namespace App\Http\Controllers\Api;


use App\Http\Resources\Cart\CartSimpleProductResource;
use App\Models\Setting;
use App\Models\UserShipping;
use App\Repository\CartRepository;
use App\Repository\ProductRepository;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

// models
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\Coupon;
use App\Models\PaymentMethod;
use App\Models\ProductAttributeValue;
use App\Models\CouponChecked;
use App\Models\ShippingCompanyCity;
use App\Models\City;

use App\User;
// Resource
use App\Http\Resources\Cart\CartProductResource;
use App\Http\Resources\Cart\CouponResource;
use Illuminate\Validation\Rule;

// services
use App\Services\CouponService;

class CartController extends Controller
{

    public $cart;
    public $Product;

    public function __construct(ProductRepository $Product, CartRepository $cart)
    {
        $this->product = $Product;
        $this->cart = $cart;
    }


    public function get_user_cart_products(Request $request)
    {
        $request->request->add([
            'is_bill' => false,
        ]);
        $response['data'] = $this->cart->get_user_cart_products($request);
        return response_api(true, trans('api.done'), $response);
    }

    public function get_bill(Request $request)
    {

        $user = $request->user;
        if(!$user) {
            return response_api(false, trans('api.error'), []);
        }
        $banks = get_setting_messages()['banks'];

        $payment_method = $request->filled('payment_method') ? $request->payment_method : -1;

        $get_payment_method = PaymentMethod::find($payment_method);

        $user_shipping_info = UserShipping::where('user_id',$user->id)->where('id',$request->user_shipping_id)->first();
        $user->shipping_info = $user_shipping_info;
        $user_shipping_info->billing_shipping_type = $request['billing_shipping_type'];
        $user_shipping_info->save();

        if ($user->shipping_info->billing_shipping_type_) {
            $shipping_company = $user->shipping_info->billing_shipping_type_;
            $shipping_city_id = $user->shipping_info->city;

            $city = City::find($shipping_city_id);
            $shipping_company_city = ShippingCompanyCity::InCompanyAndCity($shipping_company , $city)->first();

            if ($get_payment_method && $get_payment_method->key == "cash" && $shipping_company_city->cash == 0) {
                return response_api(false, trans('api.shipping_company_not_cash'), []);
            }

            $request->request->add([
                'is_bill' => true,
                'shipping_company' => $shipping_company,
                'shipping_company_city' => $shipping_company_city ,
                'cash_value' => $get_payment_method && $get_payment_method->key == "cash"  && $shipping_company_city->cash == 1 ? true : false
            ]);

            $payment_note = gte_payment_note();


            $bank_note = $payment_note->where('key', '=', 'bank_transfer')->first()->note;
            $key_words = ['[banks]'];
            $replaces = [get_list_html_ul_of_banks($banks)];
            $get_new_bank_note = str_replace($key_words, $replaces, $bank_note );


            $response['data'] = $this->cart->get_user_cart_products($request);
            $response['cash_note'] = $payment_note->where('key' , '=' , 'knet')->first()->note;
            $response['bank_note'] = $get_new_bank_note;
            $response['visa_note'] = $payment_note->where('key' , '=' , 'visa')->first()->note;
            $response['checkout_label'] = Setting::where('key','checkout_label')->first()->value;


            return response_api(true, trans('api.done'), $response);
        } else {
            return response_api(false, trans('api.select_shipping_company'), []);
        }

    }

    public function add_or_update_product_to_cart(Request $request)
    {

        try {
            $check_data = $this->cart->check_add_product_to_cart($request);
            $request->request->add(['get_tax' => get_tax()]);
            if ($check_data['status']) {

                $user = $request->user;
                $product_id = $request->product_id;
                $attribute_values = $request->filled('attribute_values') ? $request->attribute_values : [];
                $quantity = $request->quantity <= 0 ? 1 : $request->quantity;

                $key = $this->product->get_key_product($product_id, $attribute_values);


                if ($key == '*') {
                    $product_variation = ProductVariation::where('product_id', '=', $product_id)
                        ->with('stock_status')
                        ->where('is_default_select', '=', 1)->first();

                    $attribute_values = ProductAttributeValue::whereHas('attribute_product', function ($query) use ($product_id) {
                        $query->where('product_id', '=', $product_id);
                    })->where('is_selected', '=', 1)
                        ->pluck('attribute_value_id')
                        ->toArray();


                    sort($attribute_values);
                    $key = count($attribute_values) > 0 ? implode("-", $attribute_values) : "*";
                } else {
                    $product_variation = ProductVariation::where('product_id', '=', $product_id)
                        ->with('stock_status')
                        ->where('key', '=', $key)->first();
                    sort($attribute_values);
                    $key = implode("-", $attribute_values);
                }


                $check_if_in_cart = $user && $user->cart && $user->cart->products()->where('product_id', '=', $product_id)->where('product_variation_id',$product_variation->id)->first();
                if(!$check_if_in_cart && !$user) {
                    $cart = Cart::where('session_id' , '=' , $request->session_id)->first();
                    $check_if_in_cart = $cart && $cart->products()->where('product_id', '=', $product_id)->first();
                }
                if($request->from_website == 1) {
                    $quantity = $product_variation->min_quantity;
                }


                /*
                if($check_if_in_cart) {
                    if($request->has('from_website')) {
                        $quantity = $quantity + $check_if_in_cart->quantity;
                    }
                }
                */

                if ($product_variation->stock_status->key != "available") {
                    return response_api(false, trans('api.product_not_available'), []);
                }

                if ($product_variation->stock_quantity ==  0) {
                    return response_api(false, trans('api.product_not_available'), []);
                }
                
                if ($product_variation->stock_quantity < $quantity) {
                    return response_api(false, trans('api.must_less_max_quantity', ['quantity' => $product_variation->stock_quantity]), []);
                }

                if ($product_variation->min_quantity > $quantity) {
                    return response_api(false, trans('api.must_greater_than_min_quantity', ['quantity' => $product_variation->min_quantity]), []);
                }



                if ($check_if_in_cart) {
                    $add = false;
                } else {
                    $add = true;
                }
                $data = [
                    'product_id' => $product_variation->product_id,
                    'product_variation_id' => $product_variation->id,
                    'price' => $product_variation->regular_price,
                    'discount_price' => $product_variation->regular_price -$product_variation->discount_price,
                    'quantity' => $quantity,
                    'attribute_values' => $attribute_values,
                    'key' => $key,

                ];

                $add_to_cart = $this->cart->add_or_update_product_to_cart($user, $data , $request->session_id);
                if ($add_to_cart['status']) {


                    if($add_to_cart['from_session']) {
                        $cart_user = $this->cart->CheckSessionId($request->session_id)->first();
                    }else {
                        $cart_user = $this->cart->where('user_id', '=', $user->id)->first();
                    }

                    $cart_product = $cart_user->products()->with(['product_variation.product.tax_status',
                        'attribute_values.attribute.attribute_type'])
                        ->where('cart_products.id', '=', $add_to_cart['id'])
                        ->first();

                    $request->request->add(['session_id' => $add_to_cart['from_session'] ? $add_to_cart['from_session'] : null ]);

                    $get_cart_data = $this->cart->get_user_cart_products($request);

                    $total_price = $get_cart_data['total_price'];
//                    $total_price_after = $get_cart_data['total_price_after'];

                    $count_products = $get_cart_data['count_products'];
                    $count_quantity = $get_cart_data['count_quantity'];

                    $response['data'] = new CartSimpleProductResource($cart_product);
                    $response['total_price'] = $total_price;
//                    $response['total_price_after'] = $total_price_after;
                    $response['count_products'] = $count_products;
                    $response['count_quantity'] = $count_quantity;
                    $response['add'] = $add;

                    $response['data']=  collect(['product' => new CartSimpleProductResource($cart_product),
                        'total_price' => $total_price,
                        'count_products' =>  $count_products,
                        'count_quantity' =>  $count_quantity,
                        'add' =>  $add,
                    ]);


                    if ($add) {
                        return response_api(true, trans('api.added_product_to_cart'), $response);
                    } else {
                        return response_api(true, trans('api.updated_product_to_cart'), $response);
                    }

                } else {
                    return response_api(false, trans('api.error'), []);
                }
            } else {
                return response_api(false, $check_data['message'], []);
            }


        }catch (\Exception $e) {
            return response_api(false, $e->getMessage(), []);
        }catch (\Error $e) {
            return response_api(false, $e->getMessage(), []);
        }


    }

    public function remove_product_from_cart(Request $request, $cart_product_id)
    {

        $request = $request->merge(
            ['cart_product_id' => $cart_product_id]
        );
        $check_data = $this->cart->check_remove_product_from_cart($request);
        if ($check_data['status']) {

            $request->request->add(['get_tax' => get_tax()]);
            $user = $request->user;
            $data['cart_product_id'] = $request->cart_product_id;

            $remove_form_cart = $this->cart->remove_product_from_cart($user, $data);
//            $total_price = $this->cart->get_user_cart_products($request)['price'];


            //return $cart_product;
            $get_cart_data = $this->cart->get_user_cart_products($request);


//            $response['total_price'] =  $get_cart_data['total_price'];
////            $response['total_price_after'] = $get_cart_data['total_price_after'];
//
//            $response['count_products'] = $get_cart_data['count_products'];
//            $response['count_quantity'] = $get_cart_data['count_quantity'];

            $response['data']=  collect(['total_price' => $get_cart_data['total_price'],
                'count_products' => $get_cart_data['count_products'],
                'count_quantity' =>  $get_cart_data['count_quantity']
            ]);



            if ($remove_form_cart) {
                return response_api(true, trans('api.removed_product_from_cart'), $response);
            } else {
                return response_api(false, trans('api.error'), $response);
            }
        } else {
            $response['data']=  collect(['total_price' => 0,
                'count_products' => 0,
                'count_quantity' => 0
            ]);

            return response_api(false, $check_data['message'], $response);
        }

    }

    public function check_coupon(Request $request)
    {

        $user = $request->user;
        $coupon_code = $request->coupon_code;
        $get_cart_data = $this->cart->get_user_cart_products($request);

        $check_coupon = CouponService::check_coupon($user , $coupon_code ,$get_cart_data );
        if(!$check_coupon['status']) {
            return response_api(false, $check_coupon['message'], []);

        }else {
            $get_cart_data = $this->cart->get_user_cart_products($request);
            if($get_cart_data['coupon']['id'] == -1) {
                return response_api(false, trans('api.coupon_not_condition'), []);
            }
            $coupon = $check_coupon['data']['coupon'];
            $response['data'] = new CouponResource($coupon);
            return response_api(true, trans('api.coupon_is_available'), $response);
        }


    }

    public function check_shipping_company($request, $user)
    {

    }
}
