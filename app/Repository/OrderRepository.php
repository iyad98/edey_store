<?php
/**
 * Created by PhpStorm.
 * User: HP15
 * Date: 16/8/2019
 * Time: 7:12 م
 */

namespace App\Repository;


use App\Models\Country;
use App\Models\Order;
use App\Services\Payment\Myfatoorah;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repository\CartRepository;

use App\Models\OrderPharmacy;
use App\Models\OrderProduct;
use App\Models\Pharmacy;
use App\Models\Admin;
use App\Models\AdminFcm;
use App\Models\Coupon;
use App\Models\NotificationAppUser;
use App\Models\Product;
use App\Models\OrderUserShipping;
use App\Models\OrderCoupon;
use App\Models\City;
use App\Models\Package;
use App\Models\Setting;
use App\Models\ShippingCompanyCity;

use App\Services\MobilyService\SendMessage;
use App\Services\CartService;

use Carbon\Carbon;
use DB;
// Repository
use App\Repository\NotificationAdminRepository;

// jobs
use  App\Jobs\SendNotificationJob;
use  App\Jobs\SendToNextPharmacy;

use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Jobs\DispatchSendEmail;
use App\Jobs\CheckOrderBankTransfer;

// service
use App\Services\Firestore;
use App\Services\Payment\PayTabs;
use App\Services\NotificationService\NotificationAdminService;

class OrderRepository
{
    use DispatchesJobs;

    public $order;
    public $cart;
    public $paytabs;

    public function __construct(Order $order, CartRepository $cart)
    {
        $this->order = $order;
        $this->cart = $cart;
        $this->my_fatoorah = new Myfatoorah();
    }


    public function __call($name, $arguments)
    {
        return $this->order->$name(...$arguments);
    }


    public function add_order($data)
    {


        $failed_order_bank_time = Setting::where('key', '=', 'failed_order_bank_time')->first();
        $failed_order_bank_time = $failed_order_bank_time ? $failed_order_bank_time->value : 24;
        $order_product_object = new OrderProduct();
        $order_user_shipping = new OrderUserShipping();

        $order = $this->order->create($data['order']);
        $shipping_company_city = ShippingCompanyCity::find($data['order_company_shipping']['shipping_company_city_id']);

        DB::transaction(function () use ($data, $order,$shipping_company_city, $order_product_object, $order_user_shipping) {
            // order_company_shipping
            $data['order_company_shipping']['shipping_company_cash_prices'] = json_encode($shipping_company_city->shipping_company_cash_prices);
            $data['order_company_shipping']['shipping_company_prices'] = json_encode($shipping_company_city->shipping_company_prices);
            $order->company_shipping()->create($data['order_company_shipping']);
            //

            $order->coupon()->createMany($data['order_coupon']);
            if (!is_null($data['order_package'])) {
                $order->package()->create($data['order_package']);

            }
            $order->admin_discounts()->createMany($data['admin_discounts']);
            /*Coupon::select('*')->whereIn('id' , collect($data['order_coupon'])->pluck('coupon_id')->toArray())
                               ->increment("used_count");*/


            if ($data['order_payment']['payment_reference']) {
                $order->order_payment()->create([
                    'payment_reference'=>$data['order_payment']['payment_reference']['invoice_id'],
                    'order_id'=>$data['order_payment']['payment_reference']['user_defined_field'],
                ]);
            }


            $get_fillable_user_shipping_data = array_only(collect($data['order_user_shipping'])->toArray(), $order_user_shipping->getFillable());
            $order_user_shipping = $order->order_user_shipping()->create($get_fillable_user_shipping_data);
            $user = $order->user ? $order->user : null;



            $order->user_name = $order_user_shipping->first_name . " " . $order_user_shipping->last_name;
            $order->user_phone = $order_user_shipping->phone_code .''. $order_user_shipping->phone;
            $order->user_email = $order_user_shipping->email;
            $order->update();

            foreach ($data['order_products'] as $order_product) {
                $get_fillable_data = array_only($order_product, $order_product_object->getFillable());
                $add_order_product = $order->order_products()->create($get_fillable_data);
                $add_order_product->product_attribute_values__()->sync(collect($order_product['attribute_values'])->toArray());

            }

        });
        // send make order message

        $user = $order->user;
        if ($user) {
            $sum_price_orders = $user->orders()->sum('total_price');
            $package = Package::where('price_from', '<=', $sum_price_orders)
                ->where('price_to', '>=', $sum_price_orders)
                ->first();

            if ($package) {
                $user->package_id = $package->id;
                $user->update();
            }

        }
//        if ($order->payment_method_id == 3) {
//            $check_order_bank_transfer = (new CheckOrderBankTransfer($order))->delay(Carbon::now()->addHours($failed_order_bank_time));
//            dispatch($check_order_bank_transfer);
//        }
//        if ($order->payment_method_id != 1) {
//            CartService::update_order_product_quantity($order, "-");
//        }
        (new NotificationAdminService())->send_notification($order , 1);


        return $order;


    }

    public function filter_order_data($data)
    {

        $response['order'] = [
            'order_number' => get_order_number(),
            'session_id' => array_key_exists('session_id', $data) ? $data['session_id'] : null,
            'user_id' => $data['user_id'],
            'is_guest' => $data['is_guest'],
            'app_version'=>$data['app_version'],
            'confirm_cod' => $data['confirm_cod'],
            'confirm_cod_at' => $data['confirm_cod_at'],
            'status' =>  3,
            'payment_method_id' => $data['payment_method'],
            'price' => $data['price'],
            'price_after' => $data['price_after'],
            'tax' => $data['tax'],
            'tax_percentage' => $data['tax_percentage'],
            'shipping' => $data['shipping'],
            'is_coupon' => $data['coupon']['id'] != -1 ? 1 : 0,
            'coupon_price' => $data['coupon_price'],
            'is_coupon_automatic' => 0,
            'coupon_automatic_code' => "",
            'coupon_automatic_price' => $data['coupon_automatic_price'],
            'cash_fees' => $data['cash_value'],
            'first_order_discount' => $data['first_order_discount'],
            'package_discount_price' => $data['package']['price'],
            'admin_discount' => count($data['admin_discounts']) > 0 ? collect($data['admin_discounts'])->sum('price') : 0,
            'platform' => $data['platform'],
            'total_price' => $data['total_price'],
            'currency_id' => $data['currency_id'],
            'exchange_rate' => $data['origin_exchange_rate'],
            'lat' => $data['lat'],
            'lng' => $data['lng'],
            'lang' => app()->getLocale()
        ];


        $response['order_company_shipping'] = [
            'shipping_company_id' => $data['shipping_company']['id'],
            'shipping_company_name' => $data['shipping_company']['name'],
            'shipping_company_type' => $data['shipping_company']['type'],
            'shipping_company_amount' => $data['shipping_company']['amount'],
            'shipping_company_price_text_en' => $data['shipping_company']['original_price_text_en'],
            'shipping_company_price_text_ar' => $data['shipping_company']['original_price_text_ar'],
            'from' => $data['shipping_company']['shipping_price_from'],
            'to' => $data['shipping_company']['shipping_price_to'],
            'shipping_company_city_id' => $data['shipping_company']['shipping_company_city_id'],

        ];

        $response['order_coupon'] = [];
        foreach ($data['coupons_automatic'] as $coupon) {
            $response['order_coupon'][] = [
                'coupon_id' => $coupon['id'],
                'coupon_code' => $coupon['coupon'],
                'coupon_type' => $coupon['type'],
                'coupon_price' => $coupon['price'],
                'is_automatic' => 1,


            ];
        }
        if ($data['coupon']['id'] != -1) {
            $response['order_coupon'][] = [
                'coupon_id' => $data['coupon']['id'],
                'coupon_code' => $data['coupon']['coupon'],
                'coupon_type' => $data['coupon']['type'],
                'coupon_price' => $data['coupon']['price'],
                'is_automatic' => 0,
                'user_famous_id' => $data['coupon']['user_famous_id'],
                'user_famous_rate' => $data['coupon']['user_famous_rate'],
                'user_famous_price' => $data['coupon']['user_famous_price'],
            ];
        }

        if ($data['package']['id'] != -1) {
            $response['order_package'] = [
                'package_id' => $data['package']['id'],
                'package_discount' => $data['package']['discount'],
                'package_price' => $data['package']['price'],
                'free_shipping' => $data['package']['free_shipping'],
                'replace_hours' => $data['package']['replace_hours'],
            ];
        } else {
            $response['order_package'] = null;
        }


        $response['order_user_shipping'] = $data['user_shipping'];
        $response['admin_discounts'] = $data['admin_discounts'];

        $order_products = [];

        foreach (collect($data['products'])->toArray() as $order_product) {
            $order_products[] = [
                'product_id' => $order_product['id'],
                'product_variation_id' => $order_product['product_variation_id'],
                'key' => $order_product['key'],
                'quantity' => $order_product['quantity'],
                'price' => $order_product['price_without_tax'],
                'discount_price' => $order_product['discount_price'],
                'tax' => $order_product['tax'],
                'attribute_values' => collect($order_product['attribute_values'])->pluck('id')->toArray() ,
                'is_gift' => 0,
            ];
        }
        $response['order_products'] = $order_products;

        $city = City::find($data['user_shipping']['city']);
        $response['payment_data'] = [
            'order' => $response['order'],
            'order_user_shipping' => $data['user_shipping'],
            'city' => $city ? $city->name : "No",
            'products' => implode(" || ", collect($data['products'])->pluck('name')->toArray()),
            'unit_price' => implode(" || ", collect($data['products'])->pluck('price_without_tax')->toArray()),
            'quantity' => implode(" || ", collect($data['products'])->pluck('quantity')->toArray()),
            'other_charges' => $data['total_price'] - $data['price'],
        ];
        $response['order_payment'] = [
            'payment_reference' => null,
            'payment_reference_at' => null,
            'transaction_id' => null,
        ];


        return $response;
    }


    public function update_order($order)
    {


        DB::transaction(function () use ($order) {

            $coupon_tax = 0;
            $coupon_automatic_tax = 0;

            $run_coupons_automatic = false;

            $user = $order->user;
            $session_id = $order->session_id;

            $admin_discounts = [];

            $order_products = $order->order_products()->get();
            $get_cart_product_ids = $order_products->pluck('product_id')->toArray();
            $cart_products = $order->order_products()->with(['product.automatic_active_coupon.type'])
                ->select('*','product_id as id')->get();
            $cart_products = $cart_products->map(function ($value) {
                $value->discount_rate = round(($value->discount_price / $value->price) * 100 , round_digit()) . "";
                return $value;
            });
            $price = $order_products->sum('total_price');
            $price_after = $order_products->sum('total_price_after');
            $tax = $order_products->sum('tax');


            $price_tax_in_cart = get_cart_data_cache()['price_tax_in_cart'];
            // $get_currency_data = get_currency_data(-1 , $order->currency_id);
            $get_currency_data = get_default_currency_data();

            // get shipping company city
            $city = City::find($order->order_user_shipping->city);
            $shipping_company = $order->company_shipping->shipping_company;

            $check_company_shipping_cash_and_shipping = is_null($order->company_shipping->shipping_company_cash_prices) || is_null($order->company_shipping->shipping_company_prices);
              //  || collect(json_decode($order->company_shipping->shipping_company_cash_prices ))->count() <= 0 || collect(json_decode($order->company_shipping->shipping_company_prices ))->count() <= 0;

            if($check_company_shipping_cash_and_shipping) {
                $shipping_company_city = ShippingCompanyCity::InCompanyAndCity($shipping_company, $city)->first();
                $shipping_company_city_previous = ShippingCompanyCity::find($order->company_shipping->shipping_company_city_id);
                $get_shipping_company_city = $shipping_company_city_previous ? $shipping_company_city_previous : $shipping_company_city;
            }else {
                $get_shipping_company_city = new \stdClass();
                $get_shipping_company_city->id = $order->company_shipping->shipping_company_city_id;
                $get_shipping_company_city->shipping_company_cash_prices = collect(json_decode($order->company_shipping->shipping_company_cash_prices ));
                $get_shipping_company_city->shipping_company_prices = collect(json_decode($order->company_shipping->shipping_company_prices ));
            }

            $request = new \stdClass();
            $request->shipping_company = $order->company_shipping->shipping_company;

            $request->shipping_company_city = $get_shipping_company_city;
            $request->cash_value = $order->payment_method_id == 1;
            $request->price_tax_in_cart = $price_tax_in_cart == 1;
            $request->get_currency_data = $get_currency_data;


//            $get_shipping_and_cash = $this->cart->get_shipping_and_cash($request, $price);
//            $shipping = $get_shipping_and_cash['shipping'];
//            $cash_fees = $get_shipping_and_cash['cash'];
//
//            $type = $get_shipping_and_cash['type'];
//            $amount = $get_shipping_and_cash['amount'];
//            $original_price_text_ar = $get_shipping_and_cash['original_price_text_ar'];
//            $original_price_text_en = $get_shipping_and_cash['original_price_text_en'];
//            $shipping_price_from = $get_shipping_and_cash['price_from'];
//            $shipping_price_to = $get_shipping_and_cash['price_to'];
            $type = "";
            $cash_fees = 0;
            $shipping = 0;
            $amount =0;
            $original_price_text_ar =0;
            $original_price_text_en =0;
            $shipping_price_from = 0;
            $shipping_price_to = 0;

//            $total_price = $price + $shipping  + $cash_fees;
            $total_price = $price ;

            // package discount
            $get_package_discount = $this->cart->get_package_discount_data($request, $user, $shipping, $price, $total_price);
            $shipping = $get_package_discount['shipping'];
            $total_price = $get_package_discount['total_price'];

            // coupon
            $get_order_coupon = $order->coupon()->with('coupon')->where('is_automatic', '=', 0)->first();
            $coupon = $get_order_coupon ? $get_order_coupon->coupon : null;

            $coupon_price_data = $this->cart->get_coupon_price_data($request ,$order->tax_percentage ,$user, $coupon, $get_cart_product_ids, $cart_products, $price, $shipping, $total_price , true);
            $coupon_price = $coupon_price_data['coupon_price'];
            $coupon_type = $coupon_price_data['coupon_type'];
            $coupon_famous_price = $coupon_price_data['coupon_famous_price'];
            $shipping = $coupon_price_data['shipping'];
            $total_price = $coupon_price_data['total_price'];
            $is_discount_by_coupon = $coupon_price_data['is_discount_by_coupon'];
            $coupon_price = $is_discount_by_coupon ? $coupon_price : 0;
            $coupon_tax = $coupon_price_data['coupon_tax'];


            if ($coupon_price <= 0) {
                $run_coupons_automatic = true;
            }
            $get_coupons_automatic_with_shipping_data = $this->cart->get_coupons_automatic_data($request ,$order->tax_percentage ,$run_coupons_automatic, $user, $cart_products, $price, $shipping, $total_price);
            $get_coupons_automatic_data = $get_coupons_automatic_with_shipping_data['coupons_automatic'];
            $shipping = $get_coupons_automatic_with_shipping_data['shipping'];
            $coupon_automatic_price = $get_coupons_automatic_with_shipping_data['coupon_automatic_price'];
            $total_price = $get_coupons_automatic_with_shipping_data['total_price'];
            $coupon_automatic_tax = $get_coupons_automatic_with_shipping_data['coupon_tax'];


            // if ($run_coupons_automatic && $coupon_automatic_price <= 0) {
            $admin_discounts = $this->cart->get_admin_discounts($request, $cart_products->groupBy('discount_rate')->map(function ($value) {
                return $value->sum('total_discount_price');
            }));

            $total_admin_discounts = collect($admin_discounts)->sum('price');
            $total_price = $total_price > $total_admin_discounts ? $total_price - $total_admin_discounts : $total_price;

            //}

            $first_order_discount = $this->cart->get_first_order_discount($user, $session_id, $price);
            if ($total_price >= $first_order_discount) {
                $total_price = $total_price - $first_order_discount;
            } else {
                $first_order_discount = 0;
            }

            /*********************************************************/
            $order->coupon()->where('is_automatic', '=', 1)->delete();
            $order->admin_discounts()->delete();
            $order->package()->delete();


            $order_coupon = [];

            foreach ($get_coupons_automatic_data as $coupon) {
                $order_coupon[] = [
                    'coupon_id' => $coupon['id'],
                    'coupon_code' => $coupon['coupon'],
                    'coupon_type' => $coupon['type'],
                    'coupon_price' => $coupon['price'],
                    'is_automatic' => 1,
                ];
            }

            $order_package = null;
            if (!is_null($get_package_discount['package'])) {
                $order_package = [
                    'package_id' => $get_package_discount['package']['id'],
                    'package_discount' => $get_package_discount['package_price'],
                    'package_price' => $get_package_discount['package_discount'],
                    'free_shipping' => $get_package_discount['package']['free_shipping'],
                    'replace_hours' => $get_package_discount['package']['replace_hours'],
                ];
            }

            $coupon_price = round($coupon_price, round_digit());
            $coupon_automatic_price = round($coupon_automatic_price, round_digit());

            $order->coupon()->createMany($order_coupon);
            if (count($admin_discounts) > 0) {
                $order->admin_discounts()->createMany($admin_discounts);
            }

            if (!is_null($order_package)) {
                $order->package()->create($order_package);
            }

            // update if coupon exists
            if ($get_order_coupon) {
                $get_order_coupon->coupon_price = $coupon_price;
                $get_order_coupon->user_famous_price = $coupon_famous_price;
                $get_order_coupon->update();
            }
            // update order company shipping
            $order_company_shipping = $order->company_shipping;
            $order_company_shipping->shipping_company_city_id = $request->shipping_company_city->id ;
            $order_company_shipping->shipping_company_type = $type;
            $order_company_shipping->shipping_company_amount = $amount;
            $order_company_shipping->shipping_company_price_text_en = $original_price_text_en;
            $order_company_shipping->shipping_company_price_text_ar = $original_price_text_ar;
            $order_company_shipping->from = $shipping_price_from;
            $order_company_shipping->to = $shipping_price_to;
            $order_company_shipping->shipping_company_cash_prices = json_encode($get_shipping_company_city->shipping_company_cash_prices);
            $order_company_shipping->shipping_company_prices = json_encode($get_shipping_company_city->shipping_company_prices);
            $order_company_shipping->update();


            //////////////////////////
            $shipping_tax =  ($order->tax_percentage / 100 * $shipping);
            $cash_tax = ($order->tax_percentage / 100 * $cash_fees);
            $product_coupon_tax = ($coupon_tax + $coupon_automatic_tax);
            $tax = $tax + $shipping_tax + $cash_tax - $product_coupon_tax;

            $total_price = $total_price + $tax;

            $get_total_file = round($total_price, round_digit());

            $order->price = round($price, round_digit());
            $order->price_after = round($price_after, round_digit());
            $order->first_order_discount = round($first_order_discount, round_digit());
            $order->admin_discount = collect($admin_discounts)->sum('price');
            $order->tax = round($tax, round_digit());
            $order->shipping = round($shipping, round_digit());
            $order->package_discount_price = round($get_package_discount['package_price'], round_digit());
            $order->cash_fees = round($cash_fees, round_digit());
            $order->coupon_price = round($coupon_price, round_digit());
            $order->coupon_automatic_price = round($coupon_automatic_price, round_digit());
            $order->total_price = $get_total_file;
            $order->update();

        });
        // return general_response(false, true, "", "Hellooo", "", []);
        return $order;
    }


    public function get_general_ajax_data(Request $request)
    {
        $orders = $this->order;

        $status = $request->filled('status') ? $request->status : -1;
        $payment_method = $request->filled('payment_method') ? $request->payment_method : -1;
        $shipping_company = $request->filled('shipping_company') ? $request->shipping_company : -1;

        $date_from = $request->filled('date_from') ? $request->date_from : -1;
        $date_to = $request->filled('date_to') ? $request->date_to : -1;

        $search_type = $request->filled('search_type') ? $request->search_type : 1;
        $search = $request->search_value;
        
        $type_product_id = $request->filled('type_product_id') ? $request->type_product_id : -1;
        $type_product    = $request->filled('type_product') ? $request->type_product : -1;

        $country_id = $request->filled('country_id') ? $request->country_id : -1;
        $city_id    = $request->filled('city_id') ? $request->city_id : -1;
        $platform    = $request->filled('platform') ? $request->platform : -1;


        $get_date_filter = $this->get_date_filter($date_from, $date_to);
        $filters = [
            'status'           => $status,
            'payment_method'   => $payment_method,
            'shipping_company' => $shipping_company,
            'type_product'     => ['id' =>$type_product_id , 'type' =>$type_product ] ,
            'place'            => ['country_id' => $country_id , 'city_id' => $city_id],
            'platform'         => $platform,

        ];
        switch ($search_type) {
            case 2 :
                $filters['id'] = $search;
                break;
            case 3 :
                $filters['phone'] = $search;
                break;
            case 4 :
                $filters['total_price'] = $search;
                break;

        }

        if ($get_date_filter['date_from'] != -1 && $get_date_filter['date_to'] != -1) {
            $orders = $orders->where(DB::raw('date(orders.created_at)'), '>=', $get_date_filter['date_from'])
                ->where(DB::raw('date(orders.created_at)'), '<=', $get_date_filter['date_to']);
        }
        $orders = $orders->filter($filters);
        return $orders;
    }

    public function get_general_order_product_ajax_data(Request $request)
    {
        $order_products = OrderProduct::query();

        $status = $request->filled('status') ? $request->status : -1;
        $payment_method = $request->filled('payment_method') ? $request->payment_method : -1;
        $date_from = $request->filled('date_from') ? $request->date_from : -1;
        $date_to = $request->filled('date_to') ? $request->date_to : -1;

        $get_date_filter = $this->get_date_filter($date_from, $date_to);
        $filters = [
            'status' => $status,
            'payment_method' => $payment_method
        ];

        $order_products = $order_products->whereHas('order', function ($query) use ($filters, $get_date_filter) {
            if ($get_date_filter['date_from'] != -1 && $get_date_filter['date_to'] != -1) {
                $query = $query->where(DB::raw('date(orders.created_at)'), '>=', $get_date_filter['date_from'])
                    ->where(DB::raw('date(orders.created_at)'), '<=', $get_date_filter['date_to']);
            }
            $query->withTrashed()->filter($filters)->whereIn('orders.status', [order_status()["finished"], order_status()["returned"]]);
        });

        return $order_products;
    }

    public function get_ajax_data(Request $request)
    {


        $orders = $this->get_general_ajax_data($request);
        $orders = $orders->leftJoin('users', 'users.id', '=', 'orders.user_id')
            ->leftJoin('payment_methods', 'payment_methods.id', '=', 'orders.payment_method_id')
            ->leftJoin('order_company_shipping', 'order_company_shipping.order_id', '=', 'orders.id')
            ->leftJoin('shipping_companies', 'shipping_companies.id', '=', 'order_company_shipping.shipping_company_id')
            ->select('orders.*', 'orders.id as id', 'orders.status as order_status',
                'orders.user_phone as phone', 'orders.user_email as email', 'payment_methods.name_ar as payment_name',
                'shipping_companies.name_ar as shipping_company_name');

//        $orders = $orders->leftJoin('users', 'users.id', '=', 'orders.user_id')
//            ->leftJoin('payment_methods', 'payment_methods.id', '=', 'orders.payment_method_id')
//            ->leftJoin('order_company_shipping', 'order_company_shipping.order_id', '=', 'orders.id')
//            ->select('orders.*', 'orders.id as id', 'orders.status as order_status',
//                'orders.user_phone as phone', 'orders.user_email as email', 'payment_methods.name_ar as payment_name',
//                'order_company_shipping.shipping_company_name as shipping_company_name');


        return $orders;
    }

    public function get_store_statistics_ajax_data(Request $request)
    {

        $products_count = OrderProduct::select(DB::raw('count(*)'))->whereRaw('order_id = orders.id');
        $orders = $this->get_general_ajax_data($request)->withTrashed();
//        $orders = $orders->whereIn('orders.status', [trans_orignal_order_status()[0],trans_orignal_order_status()[1],trans_orignal_order_status()[2],trans_orignal_order_status()[3],trans_orignal_order_status()[4]]);
        $orders = $orders->leftJoin('users', 'users.id', '=', 'orders.user_id')
            ->leftJoin('payment_methods', 'payment_methods.id', '=', 'orders.payment_method_id')
            ->leftJoin('order_company_shipping', 'order_company_shipping.order_id', '=', 'orders.id')
            ->select('orders.*', 'orders.id as id', 'orders.status as order_status',
                'payment_methods.name_ar as payment_name',
                'order_company_shipping.shipping_company_name as shipping_company_name',
                getSubQuerySql($products_count, 'products_count'));

        return $orders;
    }

    public function get_store_bill_ajax_data(Request $request)
    {

        $products_count = OrderProduct::select(DB::raw('count(*)'))->whereRaw('order_id = orders.id');
        $products_quantity_count = OrderProduct::select(DB::raw('sum(quantity)'))->whereRaw('order_id = orders.id');

        $orders = $this->get_general_ajax_data($request)->withTrashed();;
//        $orders = $orders->whereIn('orders.status', [trans_orignal_order_status()[2]]);
        $orders = $orders->leftJoin('users', 'users.id', '=', 'orders.user_id')
            ->leftJoin('payment_methods', 'payment_methods.id', '=', 'orders.payment_method_id')
            ->leftJoin('order_company_shipping', 'order_company_shipping.order_id', '=', 'orders.id')
            ->select('orders.*', 'orders.id as id', 'orders.status as order_status',
                'payment_methods.name_ar as payment_name',
                'order_company_shipping.shipping_company_name as shipping_company_name',
                getSubQuerySql($products_count, 'products_count'),
                getSubQuerySql($products_quantity_count, 'products_quantity_count'));

        $orders = $orders->with(['order_products.product_variation.product', 'order_user_shipping.shipping_city']);
        return $orders;
    }

    public function get_invoice_ajax_data(Request $request)
    {
        $order_products = $this->get_general_order_product_ajax_data($request);
        return $order_products;

    }

    public function get_invoice2_ajax_data(Request $request)
    {
        $start = $request->filled('start') ? $request->start : 0;
        $rownum = 199000000 + $start;
        DB::statement(DB::raw("set @rownum=$rownum"));
        $orders = $this->get_general_ajax_data($request)->withTrashed();;
        $orders = $orders->whereIn('orders.status', [order_status()["finished"], order_status()["returned"]]);
        $orders = $orders->select('*', DB::raw('@rownum  := @rownum  + 1 AS rownum'));
        return $orders;

    }

    public function get_coupon_ajax_data(Request $request)
    {

        $date_from = $request->filled('date_from') ? $request->date_from : -1;
        $date_to = $request->filled('date_to') ? $request->date_to : -1;

        $get_date_filter = $this->get_date_filter($date_from, $date_to);

        $coupon = Coupon::OrderCoupon($get_date_filter);
        return $coupon;
    }

    public function get_date_filter($date_from, $date_to)
    {


        if (!empty($date_from) && !empty($date_to) && $date_from != -1 && $date_to != -1) {
            try {
                $date_from = Carbon::parse($date_from)->format('Y-m-d');
                $date_to = Carbon::parse($date_to)->format('Y-m-d');
            } catch (\Exception $e) {
                $date_from = -1;
                $date_to = -1;
            }
        } else {
            $date_from = -1;
            $date_to = -1;
        }
        $data = [
            'date_from' => $date_from,
            'date_to' => $date_to
        ];
        return $data;
    }

    public function can_edit_order($status)
    {
//        $can_edit = [order_status()['payment_waiting'], order_status()['processing']];
//        return in_array($status, $can_edit) ? 1 : 0;
return 1;
    }

    public function get_order_status_data($deleted = 0)
    {
        $all = Order::select(DB::raw('count(*)'));

        $new = Order::select(DB::raw('count(*)'))->whereRaw('status = 0');
        $processing = Order::select(DB::raw('count(*)'))->whereRaw('status = 1');
        $finished = Order::select(DB::raw('count(*)'))->whereRaw('status = 2');

        $failed = Order::select(DB::raw('count(*)'))->whereRaw('status = 3');
        $canceled = Order::select(DB::raw('count(*)'))->whereRaw('status = 4');




        $return_order = Order::select(DB::raw('count(*)'))->whereRaw('status = 9');
        $pending_return_order = Order::select(DB::raw('count(*)'))->whereRaw('status = 10');

        $order_status = $this->order->select(
            getSubQuerySql($all, 'all_count'),
            getSubQuerySql($new, 'new_count'),
            getSubQuerySql($processing, 'processing_count'),
            getSubQuerySql($finished, 'finished_count'),
            getSubQuerySql($failed, 'failed_count'),
            getSubQuerySql($canceled, 'canceled_count')
        )
            ->limit(1)->first();

        return $order_status;
    }

    // update order as currency
    public function update_order_as_selected_currency($order, $exchange_rate = 1)
    {

        $currency_data['exchange_rate'] = $exchange_rate;

        $order->price = reverse_convert_currency($order->price, $currency_data) ;
        $order->price_after = reverse_convert_currency($order->price_after, $currency_data);

        $order->tax =  reverse_convert_currency($order->tax, $currency_data);
        $order->shipping = reverse_convert_currency($order->shipping, $currency_data);
        $order->coupon_price =  reverse_convert_currency($order->coupon_price, $currency_data);

        $order->coupon_automatic_price =  reverse_convert_currency($order->coupon_automatic_price, $currency_data);
        $order->admin_discount =  reverse_convert_currency($order->admin_discount, $currency_data);
        $order->cash_fees =  reverse_convert_currency($order->cash_fees, $currency_data);
        $order->first_order_discount =  reverse_convert_currency($order->first_order_discount, $currency_data);
        $order->package_discount_price =  reverse_convert_currency($order->package_discount_price, $currency_data);
        $order->total_price = reverse_convert_currency($order->total_price, $currency_data);
        $order->discount_price =  reverse_convert_currency($order->discount_price, $currency_data);
        $order->total_coupon_price =  reverse_convert_currency($order->total_coupon_price, $currency_data);
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
        $order->order_products[0]->tax ;

        $order->order_products->map(function ($value) use ($currency_data) {

            $value->price = reverse_convert_currency($value->price, $currency_data);
            $value->discount_price = reverse_convert_currency($value->discount_price, $currency_data);
            $value->tax =reverse_convert_currency($value->tax, $currency_data);
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
        $currency_code = isset($order->currency_symbol) ? $order->currency_symbol : ($currency ? $currency->symbol : "");
        $order_shipping = $order->company_shipping;
        $key_words = ['[from]', '[to]'];
        $replaces = [reverse_convert_currency($order_shipping->from, $currency_data) . " " . $currency_code, reverse_convert_currency($order_shipping->to, $currency_data) . " " . $currency_code];

        $get_new_text = str_replace($key_words, $replaces, $order_shipping ? $order_shipping->shipping_company_price_text : "");

        $order->shipping_text = $get_new_text;

        return $order;

    }
}