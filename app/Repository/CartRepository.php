<?php
/**
 * Created by PhpStorm.
 * User: HP15
 * Date: 16/8/2019
 * Time: 7:12 م
 */

namespace App\Repository;

// models
use App\Http\Resources\Cart\CartProductResource;
use App\Http\Resources\Cart\CartSimpleProductResource;
use App\Http\Resources\CategoryResourceDFT;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\CouponType;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\Setting;
use App\Services\SWWWTreeTraversal;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

// Resource

// services

class CartRepository
{
    public $cart;

    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    public function __call($name, $arguments)
    {
        return $this->cart->$name(...$arguments);
    }


    /*  main functions */
    public function get_user_cart_products(Request $request)
    {

        $user = $request->user;
        $session_id = $request->session_id;
        $request->request->add(['get_tax' => get_tax()]);

        if ($user) {
            $cart = Cart::CheckUserId($user->id)->first();
        } else {
            $cart = Cart::CheckSessionId($session_id)->first();
        }

        $coupon_code = $request->filled('coupon_code') ? $request->coupon_code : "";
        $coupon = null;
        $coupon_automatic = null;
        $is_discount_by_coupon = false;
        $get_coupons_automatic_data = [];
        $get_package_discount = null;

        $amount = 0;
        $amount_text = "";
        $to_price_text = "";
        $type = "";
        $original_price_text_ar = "";
        $original_price_text_en = "";
        $shipping_price_from = 0;
        $shipping_price_to = 0;

        $run_coupons_automatic = false;
        $admin_discounts = [];

        $coupon_tax = 0;
        $coupon_automatic_tax = 0;

        if ($cart) {

            $coupon = Coupon::with('type')->Active()->IsNotAutomatic()->where('coupon', '=', $coupon_code)->first();
            $cart_products = $cart->products()->with(['product.tax_status', 'product.automatic_active_coupon.type', 'attribute_values.attribute.attribute_type'])->get();
            $products = CartProductResource::collection($cart_products);
            $get_cart_products = collect($products);
            $quantity_count = $get_cart_products->sum('quantity');

            $get_cart_product_ids = $get_cart_products->pluck('id')->toArray();
            $tax = $get_cart_products->sum('tax');


            $price = $get_cart_products->sum('total_price');

            $price_after = $get_cart_products->sum('total_price_after');
            $price_with_tax = $get_cart_products->sum('final_total_price_after');

            $products_count = $products->count();

//            $price = number_format($price, round_digit());
//            $tax = number_format($tax, round_digit());
//            $price_after = number_format($price_after, round_digit());
//

            $shipping = number_format(Setting::where('key', 'shipping')->first()->value, round_digit());
            $cash = 0;

            if ($request->is_bill) {

                $get_shipping_and_cash = $this->get_shipping_and_cash($request, $price, $products_count);

                $shipping = $get_shipping_and_cash['shipping'];
                $cash = $get_shipping_and_cash['cash'];

                $type = $get_shipping_and_cash['type'];
                $amount = $get_shipping_and_cash['amount'];
                $amount_text = $get_shipping_and_cash['amount_text'];
                $to_price_text = $get_shipping_and_cash['to_price_text'];
                $original_price_text_ar = $get_shipping_and_cash['original_price_text_ar'];
                $original_price_text_en = $get_shipping_and_cash['original_price_text_en'];
                $shipping_price_from = $get_shipping_and_cash['price_from'];
                $shipping_price_to = $get_shipping_and_cash['price_to'];
            }
            //  $tax = $tax + ($request->get_tax / 100 * $shipping);
            // some operations


            $total_price = $price + $shipping + $cash;


            $first_order_discount = $this->get_first_order_discount($user, $session_id, $price);
            // package discount
            $get_package_discount = $this->get_package_discount_data($request, $user, $shipping, $price, $total_price);
            $shipping = $get_package_discount['shipping'];
            $total_price = $get_package_discount['total_price'];

            // coupon

            $coupon_price_data = $this->get_coupon_price_data($request, $request->get_tax, $user, $coupon, $get_cart_product_ids, $get_cart_products, $price, $shipping, $total_price);
            $coupon_price = $coupon_price_data['coupon_price'];
            $coupon_type = $coupon_price_data['coupon_type'];
            $coupon_famous_price = $coupon_price_data['coupon_famous_price'];
            $shipping = $coupon_price_data['shipping'];
            $total_price = $coupon_price_data['total_price'];
            $is_discount_by_coupon = $coupon_price_data['is_discount_by_coupon'];
            $coupon_tax = $coupon_price_data['coupon_tax'];

            if ($coupon_price <= 0) {
                $run_coupons_automatic = true;
            }
            $get_coupons_automatic_with_shipping_data = $this->get_coupons_automatic_data($request, $request->get_tax, $run_coupons_automatic, $user, $get_cart_products, $price, $shipping, $total_price);
            $get_coupons_automatic_data = $get_coupons_automatic_with_shipping_data['coupons_automatic'];
            $shipping = $get_coupons_automatic_with_shipping_data['shipping'];
            $coupon_automatic_price = number_format($get_coupons_automatic_with_shipping_data['coupon_automatic_price'], round_digit());
            $total_price = $get_coupons_automatic_with_shipping_data['total_price'];
            $coupon_automatic_tax = $get_coupons_automatic_with_shipping_data['coupon_tax'];


            //   if ($run_coupons_automatic && $coupon_automatic_price <= 0) {
            $admin_discounts = $this->get_admin_discounts($request, $get_cart_products->groupBy('discount_rate')->map(function ($value) {
                return $value->sum('total_discount_price');
            }));

            $total_admin_discounts = collect($admin_discounts)->sum('price');
            $total_price = $total_price > $total_admin_discounts ? $total_price - $total_admin_discounts : $total_price;

            //   }


            // first order discount
            if ($total_price >= $first_order_discount) {
                $total_price = $total_price - $first_order_discount;
            } else {
                $first_order_discount = 0;
            }


        } else {
            $products = [];
            $products_count = 0;
            $price = 0;
            $price_with_tax = 0;
            $price_after = 0;
            $tax = 0;
            $total_price = 0;
            $coupon_price = 0;
            $coupon_automatic_price = 0;
            $shipping = 0;
            $coupon_type = "";
            $cash = 0;
            $first_order_discount = 0;
            $quantity_count = 0;
        }
        $coupon_price = number_format($coupon_price, round_digit());
        $coupon_automatic_price = number_format($coupon_automatic_price, round_digit());


        //////////////////// taxes //////////////////////
        $shipping_tax = ($request->get_tax / 100 * $shipping);

        $cash_tax = ($request->get_tax / 100 * $cash);
        $product_coupon_tax = ($coupon_tax + $coupon_automatic_tax);


        $tax = $tax + $shipping_tax + $cash_tax - $product_coupon_tax;

        $total_price = $total_price + $tax;

        ////////////////////////////////////////////////////////

        if ($products) {
            $response['products'] = CartSimpleProductResource::collection($products);

        } else {
            $response['products'] = [];

        }

        $response['count_products'] = $products_count;
        $response['count_quantity'] = $quantity_count;


        $response['price'] = number_format($price, round_digit(), '.', '');

        $response['price_after'] = number_format($price_after, round_digit(), '.', '');

        $response['price_with_tax'] = number_format($price_with_tax, round_digit(), '.', '');

        $response['price_before_tax'] = number_format($total_price - $tax, round_digit(), '.', '');
        $response['price_without_tax'] = number_format($total_price - $tax, round_digit(), '.', '');

        $response['price_after_discount_coupon'] = number_format($total_price - $tax - $cash - $shipping, round_digit(), '.', '');

        $response['total_price'] = number_format($total_price, round_digit(), '.', '');


        $response['tax'] = number_format($tax, round_digit(), '.', '');
        $response['tax_percentage'] = $request->get_tax;
        $response['tax_text'] = trans('api.tax_text', ['tax' => $request->get_tax]);
        $response['is_bill'] = $request->is_bill;


        $response['coupons_automatic'] = $get_coupons_automatic_data;
        $response['admin_discounts'] = $admin_discounts;

        $response['coupon_price'] = $is_discount_by_coupon ? number_format($coupon_price, round_digit(), '.', '') : number_format(0, round_digit(), '.', '');
        $response['coupon_automatic_price'] = count($get_coupons_automatic_data) > 0 ? number_format($coupon_automatic_price, round_digit()) : number_format(0, round_digit(), '.', '');
        $response['price_after_discount_coupon'] = number_format($total_price - $tax - $cash - $shipping, round_digit(), '.', '');
//        $response['total_price_after'] = round($total_price - $tax, round_digit()); //9

        $response['currency'] = $request->get_currency_data ? $request->get_currency_data['symbol'] : get_currency();
        $response['currency_id'] = $request->get_currency_data ? $request->get_currency_data['id'] : get_currency();
        $response['exchange_rate'] = $request->get_currency_data ? $request->get_currency_data['exchange_rate'] : 1;

        $shipping_company = $request->shipping_company;
        $response['shipping'] = number_format($shipping, round_digit(), '.', '');
        $response['shipping_company'] = [
            'id' => $shipping_company ? $shipping_company->id : -1,
            'name' => $shipping_company ? $shipping_company->name : "",
            'type' => $type,
            'amount' => $amount,
            'amount_text' => $amount_text,
            'to_price_text' => $to_price_text,
            'original_price_text_ar' => $original_price_text_ar,
            'original_price_text_en' => $original_price_text_en,
            'shipping_price_from' => $shipping_price_from,
            'shipping_price_to' => $shipping_price_to,
            'shipping_company_city_id' => $request->shipping_company_city ? $request->shipping_company_city->id : -1,

        ];
        $response['cash_value'] = number_format($cash, round_digit(), '.', '');

        $response['package'] = [
            'id' => optional($get_package_discount['package'])->id ?? -1,
            'name' => optional($get_package_discount['package'])->name ?? "",
            'discount' => $get_package_discount['package_discount'] ?? 0,
            'price' => number_format($get_package_discount['package_price'], round_digit(), '.', '') ?? number_format(0, round_digit(), '.', ''),
            'free_shipping' => optional($get_package_discount['package'])->free_shipping == 1 ? true : false,
            'replace_hours' => optional($get_package_discount['package'])->replace_hours ?? 0,
        ];
        $response['first_order_discount'] = number_format($first_order_discount, round_digit(), '.', '') ?? number_format(0, round_digit(), '.', '');

        $check_discount_by_coupon = $is_discount_by_coupon && $coupon;
        $response['coupon'] = [
            'id' => $check_discount_by_coupon ? $coupon->id : -1,
            'coupon' => $check_discount_by_coupon ? $coupon->coupon : "",
            'price' => $check_discount_by_coupon ? number_format($coupon_price, round_digit(), '.', '') : number_format(0, round_digit(), '.', ''),
            'type' => $check_discount_by_coupon ? $coupon->type->key : "",
            'type_text' => $check_discount_by_coupon ? $coupon_type : "",
            'user_famous_id' => $check_discount_by_coupon ? $coupon->user_famous_id : null,
            'user_famous_rate' => $check_discount_by_coupon ? $coupon->user_famous_rate : 0,
            'user_famous_price' => $check_discount_by_coupon ? number_format($coupon_famous_price, round_digit(), '.', '') : number_format(0, round_digit(), '.', ''),

        ];
        return $response;
    }

    public function add_or_update_product_to_cart($user, $data, $session_id = null)
    {

        $from_session = false;
        if ($user && $user->cart()->count() > 0) {
            $user_cart = $user->cart;
        } else if ($user) {
            $user_cart = Cart::create([
                'user_id' => $user->id,
                'tax' => 0,
                'shipping' => 0
            ]);
        } else {

            $user_cart = Cart::CheckSessionId($session_id)->first();
            if (!$user_cart) {
                $user_cart = Cart::create([
                    'user_id' => null,
                    'session_id' => $session_id,
                    'tax' => 0,
                    'shipping' => 0
                ]);
            }
            $from_session = $session_id;
        }

        // get_data_to_add_cart_or_order

        $cart_product = $user_cart->products()->updateOrCreate(
            [
                'cart_id' => $user_cart->id,
                'product_id' => $data['product_id'],
                'product_variation_id' => $data['product_variation_id'],
                'key' => $data['key']

            ],
            $data
        );
        $cart_product->attribute_values()->sync($data['attribute_values']);
        return ['status' => true, 'id' => $cart_product->id, 'from_session' => $from_session];

    }

    public function remove_product_from_cart($user, $data)
    {
        if ($user->cart()->count() > 0) {
            $user_cart = $user->cart;
        } else {
            return false;
        }

        $cart_product_id = $data['cart_product_id'];
        CartProduct::find($cart_product_id)->delete();

        return true;

    }


    /* validations */
    public function check_add_product_to_cart(Request $request)
    {

        $rules = [
            'product_id' => [
                'required', 'integer',
                Rule::exists('products', 'id')->whereNull('deleted_at')
            ],
            'quantity' => 'required|integer|gt:0'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors();
            $get_one_message = get_error_msg($rules, $messages);
            return ['status' => false, 'message' => $get_one_message];
        } else {

            return ['status' => true, 'message' => ""];

        }
    }

    public function check_remove_product_from_cart(Request $request)
    {
        $rules = [
            'cart_product_id' => 'required|integer|exists:cart_products,id',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors();
            $get_one_message = get_error_msg($rules, $messages);
            return ['status' => false, 'message' => $get_one_message];
        } else {
            return ['status' => true, 'message' => ""];
        }
    }


    public function get_available_with_not_available_product_categories($categories, $get_cart_product_ids)
    {

        $categories_tree_cache = get_categories_cache();

        $available_categories = $categories->where('type', '=', 1)->pluck('id')->toArray();
        $not_available_categories = $categories->where('type', '=', 0)->pluck('id')->toArray();


        $available_tree = json_decode(collect($categories_tree_cache)->whereIn('id', $available_categories), true);


        $available_conf = array('tree' => $available_tree);
        $available_instance = new SWWWTreeTraversal($available_conf);
        $get_available_category_ids = $available_instance->get();

        $available_product_categories = Product::whereHas('categories', function ($query) use ($get_available_category_ids) {
            $query->whereIn('category_id', $get_available_category_ids);
        })->whereIn('products.id', $get_cart_product_ids)
            ->pluck('products.id')->toArray();


        $not_available_tree = json_decode(collect($categories_tree_cache)->whereIn('id', $not_available_categories), true);


        $not_available_conf = array('tree' => $not_available_tree);
        $not_available_instance = new SWWWTreeTraversal($not_available_conf);
        $get_not_available_category_ids = $not_available_instance->get();

        $not_available_product_categories = Product::whereHas('categories', function ($query) use ($get_not_available_category_ids) {
            $query->whereIn('category_id', $get_not_available_category_ids);
        })->whereIn('products.id', $get_cart_product_ids)
            ->pluck('products.id')->toArray();

        return [
            'is_have_available_categories' => count($available_categories) > 0,
            'is_have_not_available_categories' => count($not_available_categories) > 0,
            'available_product_categories' => $available_product_categories,
            'not_available_product_categories' => $not_available_product_categories
        ];
    }

    public function get_cart_coupon_products($coupon, $cart_product_ids)
    {
        $get_available_and_not_available_category_ids = $this->get_available_with_not_available_product_categories($coupon->categories, $cart_product_ids);
        $categories = $coupon->categories()->where('type', '=', 1)->pluck('id')->toArray();
        $excluded_categories = $coupon->categories()->where('type', '=', 0)->pluck('id')->toArray();

        $products = $coupon->products()->whereIn('products.id', $cart_product_ids)->where('type', '=', 1)->pluck('id')->toArray();
        $excluded_products = $coupon->products()->whereIn('products.id', $cart_product_ids)->where('type', '=', 0)->pluck('id')->toArray();

        $available_products_from_category = $get_available_and_not_available_category_ids['available_product_categories'];
        $not_available_products_from_category = $get_available_and_not_available_category_ids['not_available_product_categories'];

        $product_category_ids = [];
        $new_product_ids = [];
        $new_product_category_ids = [];
        if (count($categories) <= 0 && count($excluded_categories) <= 0 && count($products) <= 0 && count($excluded_products) <= 0) {
            $new_product_ids = $cart_product_ids;
        } else {

            if (count($products) > 0) {
                $new_product_ids = $products;
            } else if (count($categories) <= 0) {
                $product_ids = $cart_product_ids;

                foreach ($product_ids as $product_id) {
                    if (!in_array($product_id, $excluded_products) && !in_array($product_id, $not_available_products_from_category)) {
                        $new_product_ids[] = $product_id;
                    }
                }

            }

            if (count($categories) > 0) {
                $product_category_ids = $available_products_from_category;
            } else if ((count($products) <= 0) || (count($products) > 0 && (count($excluded_products) > 0 || count($excluded_categories) > 0))) {
                $product_category_ids = $cart_product_ids;
            }
            foreach ($product_category_ids as $product_category_id) {
                if (!in_array($product_category_id, $excluded_products) && !in_array($product_category_id, $not_available_products_from_category)) {
                    $new_product_category_ids[] = $product_category_id;
                }
            }

        }
        return [
            'available_all_products' => array_merge($new_product_ids, $new_product_category_ids)
        ];

    }

    public function get_available_with_not_available_product_categories_($categories)
    {

        $available_categories = $categories->where('type', '=', 1)->pluck('id')->toArray();
        $not_available_categories = $categories->where('type', '=', 0)->pluck('id')->toArray();


        $available_category_ids = Category::with('children')
            ->whereIn('id', $available_categories)
            ->select('id')
            ->get();

        $available_tree = CategoryResourceDFT::collection($available_category_ids);
        $available_tree = json_decode(collect($available_tree), true);


        $available_conf = array('tree' => $available_tree);
        $available_instance = new SWWWTreeTraversal($available_conf);
        $get_available_category_ids = $available_instance->get();

        $available_product_categories = Product::whereHas('categories', function ($query) use ($get_available_category_ids) {
            $query->whereIn('category_id', $get_available_category_ids);
        })->pluck('products.id')->toArray();


        $not_available_category_ids = Category::with('children')
            ->whereIn('id', $not_available_categories)
            ->select('id')
            ->get();

        $not_available_tree = CategoryResourceDFT::collection($not_available_category_ids);
        $not_available_tree = json_decode(collect($not_available_tree), true);


        $not_available_conf = array('tree' => $not_available_tree);
        $not_available_instance = new SWWWTreeTraversal($not_available_conf);
        $get_not_available_category_ids = $not_available_instance->get();

        $not_available_product_categories = Product::whereHas('categories', function ($query) use ($get_not_available_category_ids) {
            $query->whereIn('category_id', $get_not_available_category_ids);
        })->pluck('products.id')->toArray();

        return [
            'available_product_categories' => $available_product_categories,
            'not_available_product_categories' => $not_available_product_categories
        ];
    }

    //
    public function get_coupon_price_data($request, $tax_percentage, $user, $coupon, $get_cart_product_ids, $get_cart_products, $price_after, $shipping, $total_price, $updated = false)
    {

        $coupon_price = 0;
        $coupon_product_price = 0;
        $coupon_famous_price = 0;
        $coupon_type = "";
        $coupon_code = $coupon ? $coupon->coupon : "";
        $is_discount_by_coupon = false;

        $coupon_tax = 0;

        if ($updated) {
            $count_used = 0;
        } else {
            if ($user) {
                $count_used = $user->orders()->whereHas('coupon', function ($query1) use ($coupon_code) {
                    $query1->where('coupon_code', '=', $coupon_code);
                })->count();
            } else {
                $count_used = 0;
            }

        }

        if ($coupon && reverse_convert_currency_2($price_after, $request->get_currency_data) >= $coupon->min_price && $coupon->max_used > $count_used) {

            $user_famous_rate = $coupon->user_famous_rate;
            $user_famous_id = $coupon->user_famous_id;

            if (in_array($coupon->type->key, ['fixed_discount_products', 'percent_discount_for_products'])) {


                $get_cart_coupon_products_data = $this->get_cart_coupon_products($coupon, $get_cart_product_ids);

                $available_all_products = $get_cart_coupon_products_data['available_all_products'];

                $coupon_type_key = $coupon->type->key;
                $coupon_value = $coupon->value;


                foreach ($get_cart_products as $get_cart_product) {

                    /* if($get_cart_product['discount_price'] != 0) {
                         continue;
                     }*/
                    $check = in_array($get_cart_product['id'], $available_all_products);
                    if ($check) {

                        if (($coupon->apply_for_discount_product == 1 && $get_cart_product['total_price_after'] != $get_cart_product['total_price']) || $get_cart_product['total_price_after'] == $get_cart_product['total_price']) {
                            if ($coupon_type_key == "fixed_discount_products") {
                                $original_product_coupon_price = (convert_currency($coupon_value, $request->get_currency_data) * $get_cart_product['quantity']);

                            } else {
                                $original_product_coupon_price = ($coupon_value / 100) * ($get_cart_product['total_price_after']);
                            }
                            $coupon_product_price += $original_product_coupon_price;
                            if ($get_cart_product['tax'] > 0) {
                                $coupon_tax += ($tax_percentage / 100 * $original_product_coupon_price);
                            }
                        }


                    }

                }

            }
            $coupon_famous_price = $user_famous_id ? ($user_famous_rate / 100) * $price_after : 0;

            $coupon_type = $coupon->type->name;
            switch ($coupon->type->key) {
                case "fixed_discount_shipping_cart" :
                    $coupon_price = convert_currency($coupon->value, $request->get_currency_data);
                    break;
                case "fixed_discount_products" :
//                    if ($coupon_product_price >= convert_currency($coupon->value, $request->get_currency_data)) {
//                        $coupon_price = $coupon_product_price;
//                    }
                    $coupon_price = $coupon_product_price;
                    break;
                case "percent_discount_for_shopping_cart" :
                    $coupon_price = ($coupon->value / 100 * $total_price);
                    break;
                case "percent_discount_for_products" :
                    $coupon_price = $coupon_product_price;
                    break;

                case "free_shipping" :
                    //  $coupon_price = $shipping;
                    $is_discount_by_coupon = $shipping > 0 ? true : false;
                    $total_price = $total_price > $shipping ? $total_price - $shipping : 0;
                    $shipping = 0;
                    break;
            }
        }


        if ($total_price >= $coupon_price) {
            $total_price = $total_price - $coupon_price;
            $is_discount_by_coupon = true;
        }

        return [
            'coupon_price' => number_format($coupon_price, round_digit(), '.', ''),
            'coupon_type' => $coupon_type,
            'coupon_famous_price' => number_format($coupon_famous_price, round_digit(), '.', ''),
            'total_price' => $total_price,
            'is_discount_by_coupon' => $is_discount_by_coupon,
            'shipping' => $shipping,
            'coupon_tax' => $coupon_tax,
        ];
    }

    public function get_coupons_automatic_data($request, $tax_percentage, $run_coupons_automatic, $user, $cart_products, $price_after, $shipping, $total_price)
    {

        $coupon_tax = 0;
        $coupon_product_price = 0;
        if ($run_coupons_automatic) {
            $get_coupons_code = [];
            foreach ($cart_products as $p) {
                $get_product = isset($p->product) ? $p->product : $p['product'];
                if ($get_product && $get_product->automatic_active_coupon) {
                    $get_coupons_code[] = $get_product->automatic_active_coupon->coupon;
                }
            }


            $coupons_automatic = [];
            if ($user) {
                $coupon_used = Order::where('user_id', '=', $user->id)
                    ->leftJoin('order_coupon', 'order_coupon.order_id', '=', 'orders.id')
                    ->whereIn('order_coupon.coupon_code', $get_coupons_code)
                    ->select('order_coupon.coupon_code', DB::raw('count(*) as coupon_used'))
                    ->groupBy('order_coupon.coupon_code')
                    ->get();
            } else {
                $coupon_used = 0;
            }


            foreach ($cart_products as $cart_product) {
                $coupon_price = 0;
                $is_discount = false;
                $get_product = isset($cart_product->product) ? $cart_product->product : $cart_product['product'];
                $coupon_automatic = $get_product && $get_product->automatic_active_coupon ? $get_product->automatic_active_coupon : null;

                //
                if ($coupon_automatic) {
                    if ($user) {
                        $get_coupon_used = $coupon_used->where('coupon_code', '=', $coupon_automatic->coupon)->first();
                        $count_used = $get_coupon_used ? $get_coupon_used->coupon_used : -1;
                    } else {
                        $count_used = 0;
                    }

                } else {
                    $count_used = -1;
                }


                if ($coupon_automatic && reverse_convert_currency_2($price_after, $request->get_currency_data) >= $coupon_automatic->min_price && $coupon_automatic->max_used > $count_used) {


                    if (($coupon_automatic->apply_for_discount_product == 1 && $cart_product['total_price_after'] != $cart_product['total_price']) || $cart_product['total_price_after'] == $cart_product['total_price']) {
                        if ($coupon_automatic->type->key == "fixed_discount_products") {
                            $coupon_product_price = (convert_currency($coupon_automatic->value, $request->get_currency_data) * $cart_product['quantity']);
                        } else {
                            $coupon_product_price = ($coupon_automatic->value / 100) * ($cart_product['total_price_after']);
                        }
                        if ($cart_product['tax'] > 0) {
                            $coupon_tax += ($tax_percentage / 100 * $coupon_product_price);
                        }

                    }

                    ////////////////////////////

                    switch ($coupon_automatic->type->key) {
                        case "fixed_discount_shipping_cart" :
                            $coupon_price = convert_currency($coupon_automatic->value, $request->get_currency_data);
                            $is_discount = true;
                            break;
                        case "fixed_discount_products" :
//                            if ($coupon_product_price >= convert_currency($coupon_automatic->value, $request->get_currency_data)) {
//                                $coupon_price = $coupon_product_price;
//                            }
                            $coupon_price = $coupon_product_price;
                            $is_discount = true;
                            break;
                        case "percent_discount_for_shopping_cart" :
                            $coupon_price = ($coupon_automatic->value / 100 * $total_price);
                            break;
                        case "percent_discount_for_products" :
                            $coupon_price = $coupon_product_price;
                            $is_discount = true;
                            break;
                        case "free_shipping" :
                            //  $coupon_price = $shipping;
                            $is_discount = $shipping > 0 ? true : false;
                            $total_price = $total_price > $shipping ? $total_price - $shipping : 0;
                            $shipping = 0;
                            break;
                    }
                    ///////////////////////////////
                    $check_coupon_found_in_coupons_automatic = -1;
                    foreach ($coupons_automatic as $key => $p) {
                        if ($p['id'] == $coupon_automatic->id) {
                            $check_coupon_found_in_coupons_automatic = $key;
                            break;
                        }
                    }

                    if ($is_discount) {
                        if ($check_coupon_found_in_coupons_automatic != -1) {
                            $coupons_automatic[$check_coupon_found_in_coupons_automatic]['price'] += $coupon_price;
                        } else {
                            $coupons_automatic[] = [
                                'id' => $coupon_automatic->id,
                                'coupon' => $coupon_automatic->coupon,
                                'price' => number_format($coupon_price, round_digit(), '.', ''),
                                'type' => $coupon_automatic->type->key,
                                'type_text' => $coupon_automatic->type->name,
                                'is_discount_by_coupon' => true,
                            ];
                        }
                    }


                }
            }

            $get_coupons_automatic_data = [];
            $coupon_automatic_price = 0;
            foreach ($coupons_automatic as $key => $coupon_automatic_data) {

                if ($total_price >= $coupon_automatic_data['price']) {
                    $coupon_automatic_price += number_format($coupon_automatic_data['price'], round_digit(), '.', '');
                    $total_price = $total_price - $coupon_automatic_data['price'];
                } else {
                    $get_coupons_automatic_data[$key]['is_discount_by_coupon'] = false;
                }
            }

            $get_coupons_automatic_data = collect($coupons_automatic)->filter(function ($value, $key) {
                return $value['is_discount_by_coupon'];
            })->values();

        } else {
            $get_coupons_automatic_data = [];
            $coupon_automatic_price = 0;
        }


        return [
            'coupons_automatic' => $get_coupons_automatic_data,
            'coupon_automatic_price' => number_format($coupon_automatic_price, round_digit(), '.', ''),
            'shipping' => $shipping,
            'total_price' => $total_price, round_digit(),
            'coupon_tax' => $coupon_tax,
        ];
    }

    public function get_shipping_and_cash($request, $sub_total_price, $product_count = 1)
    {


        $shipping_from = "";
        $shipping_to = "";
        $sub_total_price_reverse = reverse_convert_currency_2($sub_total_price, $request->get_currency_data);

        $shipping_company_city = $request->shipping_company_city;

        $get_price = $shipping_company_city->shipping_company_prices
            ->where('from', '<=', $sub_total_price_reverse)
            ->where('to', '>', $sub_total_price_reverse)
            ->first();
        if ($get_price == null) {
            $get_price = $shipping_company_city->shipping_company_fixed_prices_for_product;

        }

        if ($get_price) {
            if ($get_price->type == "fixed") {
                $shipping = convert_currency($get_price->price, $request->get_currency_data);
            } elseif ($get_price->type == "perpiece") {
                $shipping = $product_count * $get_price->price;
            } else {
                $shipping = $sub_total_price * ($get_price->price / 100);
            }
            $shipping_from = convert_currency($get_price->from, $request->get_currency_data) . " " . ($request->get_currency_data ? $request->get_currency_data['symbol'] : get_currency());
            $shipping_to = convert_currency($get_price->to, $request->get_currency_data) . " " . ($request->get_currency_data ? $request->get_currency_data['symbol'] : get_currency());

        } else {
            $shipping = convert_currency(get_shipping(), $request->get_currency_data);
        }


        /********************  get cash value *********************/
        if ($request->cash_value) {
            $get_cash_price = $shipping_company_city->shipping_company_cash_prices
                ->where('from', '<=', $sub_total_price_reverse)
                ->where('to', '>', $sub_total_price_reverse)
                ->first();

            if ($get_cash_price) {
                if ($get_cash_price->type == "fixed") {
                    $cash = convert_currency($get_cash_price->price, $request->get_currency_data);
                } else {
                    $cash = $sub_total_price * ($get_cash_price->price / 100);
                }

            } else {
                $cash = convert_currency(get_cash_value(), $request->get_currency_data);
            }
        } else {
            $cash = 0;
        }


        ////////////////////////
        $key_words = ['[from]', '[to]'];
        $replaces = [$shipping_from, $shipping_to];

        $get_new_text = str_replace($key_words, $replaces, $get_price ? $get_price->name : "");

        return [
            'type' => isset($get_price) ? $get_price->type : "",
            'amount' => isset($get_price) ? ($get_price->type == 'fixed' ? $shipping : $shipping) : 0,
            'amount_text' => isset($get_price) ? ($get_price->type == 'fixed' ? $shipping . "" : "%" . $shipping) : "",
            'to_price_text' => isset($get_price) ? "( $get_new_text )" : "",
            'original_price_text_ar' => isset($get_price) ? $get_price->name_ar : "",
            'original_price_text_en' => isset($get_price) ? $get_price->name_en : "",
            'price_from' => isset($get_price) ? convert_currency($get_price->from, $request->get_currency_data) : 0,
            'price_to' => isset($get_price) ? convert_currency($get_price->to, $request->get_currency_data) : 0,
            'shipping' => $shipping,
            'cash' => $cash,
        ];
    }


    public function get_first_order_discount($user, $session_id, $total_price)
    {


        if ($user) {
            $count_orders = Order::where('user_id', '=', $user->id)->count();
            $first_order_discount = $count_orders == 0 ? get_first_order_discount_rate() / 100 * $total_price : 0;
        } else {
            $count_orders = Order::where('session_id', '=', $session_id)->count();
            $first_order_discount = 0;
        }

        return number_format($first_order_discount, round_digit(), '.', '');
    }

    public function get_package_discount_data($request, $user, $shipping, $price_after, $total_price)
    {

        $package = null;
        $package_discount = 0;
        $package_price = 0;


        if (false) {
            $get_package_discount_type = get_package_discount_type();
            $coupon_type = CouponType::find($get_package_discount_type);

            if ($user && $user->is_guest == 0) {
                $package = $user->package;
                if ($package) {
                    $package_discount = $package->discount_rate;
                }

            }

            switch ($coupon_type->key) {

                case "percent_discount_for_shopping_cart" :
                    $package_price = ($package_discount / 100) * $total_price;
                    break;
                case "percent_discount_for_products" :
                    $package_price = ($package_discount / 100) * $price_after;
                    break;

                case "free_shipping" :
                    // $package_price = $shipping;
                    $shipping = 0;
                    break;

            }

            // discount from total price
            $total_price = $total_price > $package_price ? $total_price - $package_price : 0;
            if ($package && $package->free_shipping == 1) {

                $total_price = $total_price > $shipping ? $total_price - $shipping : $total_price;
                // $package_price = $package_price + $shipping;
                $shipping = 0;
            }

        }


        return [
            'package' => $package,
            'package_discount' => $package_discount,
            'package_price' => number_format($package_price, round_digit(), '.', ''),
            'shipping' => $shipping,
            'total_price' => $total_price
        ];


    }


    public function get_admin_discounts($request, $admin_discounts)
    {
        $discounts = [];
        foreach ($admin_discounts as $key => $value) {
            if ($key > 0) {
                $discounts[] = [
                    'name' => trans('api.admin_discount', ['discount_rate' => number_format($key, 1)]),
                    'discount_rate' => number_format($key, 1),
                    'price' => number_format($value, round_digit(), '.', ''),
                ];
            }


        }
        return $discounts;
    }
}
