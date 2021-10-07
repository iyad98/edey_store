<?php

namespace App\Http\Controllers\Admin\Order;


use App\Http\Controllers\Admin\HomeController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use DB;
/*  Models */
use App\Models\Order;
use App\Models\ProductVariation;
use App\Models\OrderProduct;
use App\Models\Product;
/* service */


// Repository
use App\Repository\OrderRepository;

// Services
use App\Services\CartService;
use App\Services\PointService;
use Carbon\Carbon;

// traits
use App\Traits\Order\OrderDetailsTrait;

class UpdateOrderProductController extends HomeController
{
    use OrderDetailsTrait;
    public $order;
    public function __construct(OrderRepository $order)
    {
        $this->middleware('check_role:edit_orders');

        parent::__construct();
        parent::$data['active_menu'] = 'store';
        parent::$data['sub_menu'] = 'orders';

        parent::$data['route_name'] = trans('admin.orders');
        parent::$data['route_uri'] = route('admin.orders.index');
        $this->order = $order;
    }


    public function add_product_to_order(Request $request)
    {

        DB::beginTransaction();

        try {
            $products = json_decode($request->products);
            $get_data = [];

            $order = $this->order->find($request->order_id);
            $get_tax = $order->tax_percentage;
            $can_edit = $this->order->can_edit_order($order->status);
            if ($can_edit == 0) {
                return general_response(false, true, "", trans('admin.cant_edit'), "", []);
            }

            if (collect($products)->count() <= 0) {
                return general_response(false, true, "", trans('admin.no_products_order'), "", []);
            }


            foreach ($products as $product) {
                $selected = [];
                foreach ($product->attributes as $attribute) {
                    $selected[] = $attribute->selected;
                }
                if (count($selected) <= 0) {
                    $get_data[] = ['id' => $product->id, 'key' => '*', 'quantity' => $product->quantity, 'random_id' => $product->random_id];
                } else {
                    sort($selected);
                    $get_data[] = ['id' => $product->id, 'key' => implode('-', $selected), 'quantity' => $product->quantity, 'random_id' => $product->random_id];
                }
            }

            $products_ids = collect($get_data)->pluck('id')->toArray();
            $keys = collect($get_data)->pluck('key')->toArray();

            $product_variations = ProductVariation::with('product.tax_status')->whereIn('product_id', $products_ids)
                ->whereIn('key', $keys)
                ->get();


            $order_products = OrderProduct::where('order_id', '=', $request->order_id)->get();
            foreach ($get_data as $data) {
                $get_product_variation = $product_variations->where('key', '=', $data['key'])
                    ->where('product_id', '=', $data['id']);


                if (collect($get_data)->where('id' , $data['id'])->where('key', '=', $data['key'])->count() > 1) {
                    return general_response(false, true, "", trans('admin.duplicate_order_product'), "", [
                        'random_id' => $data['random_id']
                    ]);
                }
                $get_product_variation = $get_product_variation->first();

                if ($order_products->where('key', '=', $data['key'])->where('product_id', '=', $data['id'])->first()) {
                    return general_response(false, true, "", trans('admin.order_product_is_already_found'), "", [
                        'random_id' => $data['random_id']
                    ]);
                }
                if (!$get_product_variation || $get_product_variation->stock_status->key != "available") {
                    return general_response(false, true, "", trans('api.product_not_available'), "", [
                        'random_id' => $data['random_id']
                    ]);
                }

                if ($data['quantity'] <= 0 || $get_product_variation->stock_quantity < $data['quantity']) {
                    return general_response(false, true, "", trans('api.must_less_max_quantity', ['quantity' => $get_product_variation->stock_quantity]), "", [
                        'random_id' => $data['random_id']
                    ]);
                }
                if ($get_product_variation->min_quantity > $data['quantity']) {
                    return general_response(false,true, "", trans('api.must_greater_than_min_quantity', ['quantity' => $get_product_variation->min_quantity]), "", [
                        'random_id' => $data['random_id']
                    ]);
                }

                if ($get_product_variation->max_quantity < $data['quantity']) {
                    return general_response(false,true, "", trans('api.must_less_than_max_quantity', ['quantity' => $get_product_variation->max_quantity]), "", [
                        'random_id' => $data['random_id']
                    ]);
                }

                if ( $order->payment_method->key == "wallet") {
                    $get_product_price_data = get_helper_product_variation_price($get_product_variation, false);
                    $user = $order->user;
                    $get_user_points = $user && $user->is_guest == 0 ? $user->points : 0;
                    $wallet_price = get_wallet_price(null, $get_user_points);
                    if ($wallet_price < ($data['quantity']*$get_product_price_data['price_after'])) {
                        return general_response(false, true, "", trans('admin.cant_pay_by_wallet_2' , ['wallet' => $wallet_price]), "", [
                            'order' => $order
                        ]);
                    }
                }
            }


            foreach ($get_data as $data) {

                $get_product_variation = $product_variations->where('key', '=', $data['key'])
                    ->where('product_id', '=', $data['id'])
                    ->first();
                $get_product_price_data = get_helper_product_variation_price($get_product_variation , false);

                $attribute_values = [];
                if ($data['key'] != '*') {
                    $attribute_values = explode('-', $data['key']);
                }

                $get_currency_data = get_currency_data(-1, $order->currency_id);


                DB::transaction(function () use ($request,$get_product_price_data,$order, $get_product_variation, $data, $attribute_values, $get_tax, $get_currency_data) {

                    $get_previous_order_product = OrderProduct::where('order_id' , '=' ,$request->order_id )
                        ->where('product_id' , '=' ,$data['id'] )
                        ->where('product_variation_id' , '=' , $get_product_variation->id)
                        ->first();

                    $quantity_before = $get_previous_order_product ? $get_previous_order_product->quantity : 0;

                    $tax_ = round($get_product_variation->product->tax_status->key == "taxable" ? ($get_tax / 100 * ($data['quantity'] * ($get_product_price_data['price_after']))) : 0, 2);
                    $order_product = OrderProduct::updateOrCreate(
                        [
                            'order_id' => $request->order_id,
                            'product_id' => $data['id'],
                            'product_variation_id' => $get_product_variation->id,

                        ],
                        [
                            'key' => $data['key'],
                            'quantity' => $data['quantity'],
                            'price' => $get_product_price_data['price'],
                            'discount_price' => $get_product_price_data['price'] - $get_product_price_data['price_after'],
                            'tax' => $tax_,
                        ]
                    );
                    $order_product->product_attribute_values__()->sync($attribute_values);

                    CartService::update_product_variation($get_product_variation ,$quantity_before , $data['quantity'] );
                });


            }

            $order = Order::find($request->order_id);

            $this->order->update_order($order);

            $this->add_action("add_products_to_order" ,'order_product', json_encode([
                'order' => $order ,
                'products' => implode(' , ' , Product::whereIn('id' , collect($products)->pluck('id')->toArray())->pluck('name_ar')->toArray())
            ]));
        }catch (\Exception $e) {
            DB::rollback();
            return general_response(false, true, "", $e->getMessage(), "", []);
        }catch (\Error $e2) {
            DB::rollback();
            return general_response(false, true, "", $e2->getMessage(), "", []);
        }

        DB::commit();
        $order = $this->get_order_details($order->id, $request->currency_type);

        return general_response(true, true, trans('api.done'), "", "", [
            'order' => $order
        ]);


    }

    public function update_order_product(Request $request)
    {
        DB::beginTransaction();
        try {
            $order_product_id = $request->order_product_id;
            $quantity = floor($request->quantity);



            $order_product = OrderProduct::where('id', '=', $order_product_id)->first();

            $order = $this->order->find($order_product->order_id);
            $get_tax = $order->tax_percentage;
            $can_edit = $this->order->can_edit_order($order->status);
            if ($can_edit == 0) {
                return general_response(false, true, "", trans('admin.cant_edit'), "", []);
            }

            if ($order_product) {
                $quantity_before = $order_product->quantity;

                $product_variation = $order_product->product_variation;
                if (!$product_variation || $product_variation->stock_status->key != "available") {
                    return general_response(false, true, "", trans('api.product_not_available'), "", []);
                }

                if ($quantity <= 0 || $product_variation->stock_quantity < $quantity) {
                    return general_response(false, true, "", trans('api.must_less_max_quantity', ['quantity' => $product_variation->stock_quantity]), "", []);
                }

                if ($product_variation->min_quantity > $quantity) {
                    return general_response(false,true, "", trans('api.must_greater_than_min_quantity', ['quantity' => $product_variation->min_quantity]), "", []);
                }

                if ($product_variation->max_quantity < $quantity) {
                    return general_response(false,true, "", trans('api.must_less_than_max_quantity', ['quantity' => $product_variation->max_quantity]), "", []);
                }
                if ( $order->payment_method->key == "wallet") {
                    $user = $order->user;
                    $get_user_points = $user && $user->is_guest == 0 ? $user->points : 0;
                    $wallet_price = get_wallet_price(null, $get_user_points);
                    if ($wallet_price < ($quantity * ($order_product->price - $order_product->discount_price))) {
                        return general_response(false, true, "", trans('admin.cant_pay_by_wallet_2' , ['wallet' => $wallet_price]), "", [
                            'order' => $order
                        ]);
                    }
                }


                $order_product->quantity = $quantity;
                $order_product->tax = round($order_product->product->tax_status->key == "taxable" ? ($get_tax / 100 * ($quantity * ($order_product->price - $order_product->discount_price))) : 0, 2);
                $order_product->update();

                $order = Order::with('coupon')->find($order_product->order_id);
                $this->order->update_order($order);


                $order = $this->get_order_details($order->id, $request->currency_type);

                CartService::update_product_variation($product_variation ,$quantity_before , $quantity );
                DB::commit();

                $this->add_action("update_product_in_order" ,'order_product', json_encode([
                    'order' => $order ,
                    'product' => $order_product->product->name_ar
                ]));

                return general_response(true, true, "", "", "", [
                    'order' => $order
                ]);
            }
            return general_response(false, true, "", "", "", [
                'order' => ""
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return general_response(false, true, "", $e->getMessage(), "", [
                'order' => ""
            ]);
        } catch (\Error $e) {
            DB::rollback();
            return general_response(false, true, "", $e->getMessage(), "", [
                'order' => ""
            ]);
        }


    }


    public function delete_order_product(Request $request)
    {

        DB::beginTransaction();

        try {
            $order_product_id = $request->order_product_id;

            $order_product = OrderProduct::where('id', '=', $order_product_id)->first();
            $order = $this->order->find($order_product->order_id);
            $can_edit = $this->order->can_edit_order($order->status);
            if ($can_edit == 0) {
                return general_response(false, true, "", trans('admin.cant_edit'), "", []);
            }
            if ($order_product) {

                $get_product_variation = $order_product->product_variation;
                $order = Order::with('coupon')->find($order_product->order_id);
                if ($order->order_products()->count() == 1) {
                    return general_response(false, true, "", trans('admin.cant_remove_last_product_in_order'), "", [
                        'order' => ""
                    ]);
                }
                $order_product->delete();

                $this->order->update_order($order);
                $order = $this->get_order_details($order->id, $request->currency_type);
                CartService::update_product_variation($get_product_variation, $order_product->quantity, 0);

                DB::commit();

                $this->add_action("delete_product_to_order" ,'order_product', json_encode([
                    'order' => $order ,
                    'product' => $order_product->product->name_ar
                ]));

                return general_response(true, true, "", "", "", [
                    'order' => $order
                ]);
            }
        }catch (\Exception $e) {
            DB::rollback();
            return general_response(false, true, "", $e->getMessage(), "", []);
        }catch (\Error $e2) {
            DB::rollback();
            return general_response(false, true, "", $e2->getMessage(), "", []);
        }

        return general_response(false, true, "", "", "", [
            'order' => ""
        ]);


    }

}
