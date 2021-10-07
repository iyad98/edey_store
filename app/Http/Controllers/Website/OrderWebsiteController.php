<?php

namespace App\Http\Controllers\Website;

use App\Models\Order;
use App\Services\Payment\Myfatoorah;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller\Website;
use phpDocumentor\Reflection\Types\Self_;

// Repository
use App\Repository\ProductRepository;
use App\Repository\CartRepository;
use App\Repository\OrderRepository;

// models
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\CartProduct;
use App\Models\Coupon;
use App\Models\City;
use App\Models\UserShipping;
use App\Models\PaymentMethod;
use App\Models\Cart;
use App\Models\ShippingCompany;
use App\Models\Country;
use App\Models\ShippingCompanyCity;

use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Api\CartController;

// Resources
use App\Http\Resources\Product\ProductSimpleResource;
use Illuminate\Support\Facades\Input;

// services
use App\Services\SWWWTreeTraversal;
use Illuminate\Support\Facades\Auth;
use App\Services\CartService;
use App\Services\NotificationService\MakeOrderNotification;
use App\Services\PublicOrderDataService;

use DB;

/*  validations */

use App\Validations\OrderValidation;
use App\Validations\UserValidation;

use Carbon\Carbon;
use Illuminate\Support\Str;

// notifications
use Illuminate\Support\Facades\Notification;
use App\Notifications\SendMakeOrderNotification;

class OrderWebsiteController extends Controller
{


    public $cart_controller;
    public $cart;
    public $order;
    public $validation;

    public function __construct(CartRepository $cart, CartController $cart_controller, OrderRepository $order, OrderValidation $validation)
    {
        $this->cart_controller = $cart_controller;
        $this->cart = $cart;
        $this->order = $order;
        $this->validation = $validation;

        $this->my_fatoorah = new Myfatoorah();
        parent::__construct();
    }


    // check out
    public function checkout(Request $request)
    {
        $cache_data = get_cart_data_cache();
        $payment_methods = PaymentMethod::all();
        $countries = Country::Active()->GeneralData()->get();
        $country_code = $request->get_country_data ? $request->get_country_data->iso2 : null;

        $banks = get_setting_messages()['banks'];

        $get_cart_ = $this->get_cart_($request);
        $cart = $get_cart_['cart'];
        $shipping_info = $get_cart_['shipping_info'];
        $all_shipping_info = $get_cart_['all_shipping_info'];

//        dd($all_shipping_info);
        $confirm_phone_data = $this->get_confirm_phone_data($request);
        $shipping_info['phone'] = $confirm_phone_data['phone'];

        $coupon_code = "";
        if ($cart && $cart->coupon_code) {
            $coupon_code = $cart ? $cart->coupon_code : "";
        }
        $breadcrumb_arr = [['name' => trans('website.home'), 'url' => "/"]];
        $payment_note = gte_payment_note();


        $billing_shipping_type = !empty($shipping_info->billing_shipping_type) ? $shipping_info->billing_shipping_type : 1;
        $shipping_company = ShippingCompany::find($billing_shipping_type);
        $shipping_info->accept_user_shipping_address = $shipping_company ? $shipping_company->accept_user_shipping_address : 0;
        parent::$data['breadcrumb_title'] = trans('website.checkout');
        parent::$data['breadcrumb_arr'] = $breadcrumb_arr;
        parent::$data['breadcrumb_last_item'] = trans('website.checkout');

        parent::$data['coupon_code'] = $coupon_code;

        parent::$data['shipping_info'] = $shipping_info;
        parent::$data['all_shipping_info'] = $all_shipping_info;


        parent::$data['countries'] = $countries;
        parent::$data['country_code'] = json_encode($country_code);

        $bank_note = $payment_note->where('key', '=', 'bank_transfer')->first()->note;
        $key_words = ['[banks]'];
        $replaces = [get_list_html_of_banks($banks)];
        $get_new_bank_note = str_replace($key_words, $replaces, $bank_note);


        parent::$data['cash_note'] = $payment_note->where('key', '=', 'knet')->first()->note;
        parent::$data['bank_note'] = $get_new_bank_note;
        parent::$data['visa_note'] = $payment_note->where('key', '=', 'visa')->first()->note;

        parent::$data['payment_methods'] = $payment_methods;
        parent::$data['title'] = parent::$data['breadcrumb_title'];
        parent::$data['confirm_phone_data'] = json_encode($confirm_phone_data);
        parent::$data['checkout_label'] = array_key_exists('checkout_label', $cache_data) ? $cache_data['checkout_label']->value : "";;
        if (Auth::guard('web')->check()) {

            return view('website_v3.order.checkout', parent::$data);

        } else {
            return redirect('/sign-in');
//            return view('website_v2.auth.login', parent::$data);

        }

    }

    public function update_billing(Request $request)
    {


        $city_id = $request->city_id;
        $city = City::find($city_id);
        $shipping_company_city = null;

        $user_shipping_id = $request->user_shipping_id;


        $company_id = $request->filled('company_id') && $request->company_id != -1 ? $request->company_id : -1;
        $payment_method = $request->payment_method;
        $payment_ids = [];

        $get_cart_ = $this->get_cart_($request);
        $user = $get_cart_['user'];
        $cart = $get_cart_['cart'];
        $session_id = $get_cart_['session_id'];
        // $get_payment_ids = [];

        $coupon_code = "";
        if ($cart && $cart->coupon_code) {
            $coupon_code = $cart ? $cart->coupon_code : "";
        }
        if ($user && $company_id == 1) {


            $shipping_info = $user->shipping_info()->first();
            $shipping_info->update(
                [
                    'billing_shipping_type' => $request['user_shipping']['billing_shipping_type'],
                ]
            );

            $city_id = $shipping_info->city;
            $city = City::find($city_id);


        } else if ($user && $company_id != 1 && $company_id != -1) {


            $shipping_info = $user->all_shipping_info()->where('id', $user_shipping_id)->first();

            $shipping_info->billing_shipping_type = $request['user_shipping']['billing_shipping_type'];
            $shipping_info->save();

            $city_id = $shipping_info->city;
            $city = City::find($city_id);


        }

        $shipping_company = ShippingCompany::find($company_id);

        if ($shipping_company && $city) {
            $shipping_company_city = ShippingCompanyCity::InCompanyAndCity($shipping_company, $city)->first();

            $payment_ids = PublicOrderDataService::get_filtered_payment_methods($city, $shipping_company_city)->pluck('id')->toArray();
        }

        if ($payment_method && !$shipping_company) {
            return response()->json([
                'status' => false,
                'message' => trans('api.shipping_company_not_found'),
                'data' => []
            ]);
        }

        if ($shipping_company) {

            $city = City::find($city_id);

            $shipping_company_city = ShippingCompanyCity::InCompanyAndCity($shipping_company, $city)->first();

            if ($payment_method == "cash" && $shipping_company_city->cash == 0) {
                return response()->json([
                    'status' => false,
                    'message' => trans('api.shipping_company_not_cash'),
                    'data' => []
                ]);
            }

            $request->request->add([
                'is_bill' => true,
                'shipping_company' => $shipping_company,
                'shipping_company_city' => $shipping_company_city,
                'cash_value' => $payment_method == "cash" && $shipping_company_city->cash == 1 ? true : false
            ]);

        }


        $request->request->add([
            'session_id' => $session_id,
            'coupon_code' => $coupon_code,
        ]);

        $cart_data = $this->cart->get_user_cart_products($request);

        return response()->json([
            'status' => true,
            'message' => trans('api.done'),
            'data' => $cart_data,
            'shipping_company_city' => $shipping_company_city,
//            'payment_ids' => $payment_ids,
        ]);

    }

    public function add_order(Request $request)
    {

        try {
            $get_cart_ = $this->get_cart_($request);

            $user = $get_cart_['user'];
            $cart = $get_cart_['cart'];
            $session_id = $get_cart_['session_id'];
            $user_validation = new UserValidation();

            $payment_url = null;
            if (!$cart) {
                return response()->json(['status' => false, 'message' => trans('api.no_cart'), 'data']);
            }
            if ($cart->products()->count() <= 0) {
                return response()->json(['status' => false, 'message' => trans('api.empty_cart'), 'data']);
            }

            $get_cart_product_ids = $cart->products()->pluck('product_id')->toArray();
            $check_gift_products = Product::whereIn('id', $get_cart_product_ids)->where('can_gift', '=', 1);
            if (array_key_exists('is_gift', $request->toArray()) && $request->is_gift == 1 && $check_gift_products->count() <= 0) {
                return response()->json(['status' => false, 'message' => trans('api.no_product_in_cart_can_gift'), 'data']);
            }

            $check_data = $this->validation->check_make_order_data($request->toArray());

            if ($check_data['status']) {

                $coupon_code = $cart ? $cart->coupon_code : "";
                $payment_method = $request->payment_method;
                $company_id = $request->company_id;
                $user_shipping_id = $request->user_shipping_id;
                $shipping_company = ShippingCompany::find($company_id);

                if (!$shipping_company) {
                    return response()->json([
                        'status' => false,
                        'message' => trans('api.shipping_company_not_found'),
                        'data' => []
                    ]);
                }
                if ($shipping_company) {

                    $user_shipping = new UserShipping();

                    if ($shipping_company->accept_user_shipping_address == 1) {
                        $get_fillable_shipping_data = $user->all_shipping_info()->where('id', $user_shipping_id)->first();
                    } else {
                        $get_fillable_shipping_data = $user->shipping_info()->first();
                    }


                    $check_shipping_data = $user_validation->check_empty_shipping_user($get_fillable_shipping_data);

                    if (!$check_shipping_data) {

                        return response()->json(['status' => false, 'message' => trans('website.you_mast_complet_shipping_address', ['link' => '/ar/my-account/edit-address/' . $get_fillable_shipping_data['id']]), []]);

                    }

                    $countrycode = Country::where('iso2', $request->phone_code)->first();
                    $get_phone_with_phone_code = $countrycode->phone_code . "-" . ($request->phone * 1);
                    $get_fillable_shipping_data['is_gift'] = $request->is_gift;
                    $get_fillable_shipping_data['shipping_company_id'] = $request->company_id;


                    // $get_fillable_shipping_data['phone'] = re_arrange_phone_number($get_fillable_shipping_data['phone'] , $get_fillable_shipping_data['city']);
                    $update_shipping_with_company = $get_fillable_shipping_data;

                    $update_shipping_with_company['shipping_company'] = $shipping_company;
//                    $check_update_shipping_with_company_user_data = $user_validation->check_update_shipping_with_company_user($update_shipping_with_company);


                    $city = City::find($get_fillable_shipping_data['city']);

                    $shipping_company_city = ShippingCompanyCity::InCompanyAndCity($shipping_company, $city)->first();
                    $get_payment_method = PaymentMethod::InCountry($city ? $city->country_id : -1)->Active()->find($payment_method);

                    if (!$get_payment_method) {
                        return response()->json(['status' => false, 'message' => trans('api.payment_method_not_supported'), 'data']);
                    }

//                    if(!$check_shipping_data['status']) {
//                        return response()->json(['status' => false, 'message' => $check_shipping_data['message'], 'data']);
//
//                    }
//                    if(!$check_update_shipping_with_company_user_data['status']) {
//                        return response()->json(['status' => false, 'message' => $check_update_shipping_with_company_user_data['message'], 'data']);
//
//                    }

                    if ($get_payment_method->key == "cash" && $shipping_company_city->cash == 0) {
                        return response()->json(['status' => false, 'message' => trans('api.shipping_company_not_cash'), 'data']);
                    }
                    unset($get_fillable_shipping_data['shipping_company_id']);


                    $request->request->add([
                        'session_id' => $session_id,
                        'is_bill' => true,
                        'shipping_company' => $shipping_company,
                        'shipping_company_city' => $shipping_company_city,
                        'coupon_code' => $coupon_code,
                        'cash_value' => $get_payment_method && $get_payment_method->key == "cash" && $shipping_company_city->cash == 1 ? true : false
                    ]);

                    $origin_exchange_rate = $request->get_currency_data['exchange_rate'];
                    $origin_currency_id = $request->get_currency_data['id'];;
                    $request->request->add([
                        'get_currency_data' => get_default_currency_data()
                    ]);

                    $get_all_data = $this->cart->get_user_cart_products($request);


                    $collect_cart_products = collect($get_all_data['products']);
                    $check_if_product_is_trashed = $collect_cart_products->where('is_trashed', '=', true)->first();
                    if ($check_if_product_is_trashed) {

                        return response()->json(['status' => false, 'message' => trans('api.product_in_cart_has_trashed', ['name' => $check_if_product_is_trashed['name']]), ['cart_product_id' => $check_if_product_is_trashed['cart_product_id']]]);
                    }


                    $get_all_data['session_id'] = $user ? null : $session_id;
                    $get_all_data['user_id'] = $user ? $user->id : null;
                    $get_all_data['payment_method'] = $payment_method;
                    $get_all_data['user_shipping'] = $get_fillable_shipping_data;
                    $get_all_data['confirm_cod'] = $get_payment_method && $get_payment_method->key == "cash" ? get_confirm_cod() : null;
                    $get_all_data['confirm_cod_at'] = null;
                    $get_all_data['is_guest'] = $user ? 0 : 1;
                    $get_all_data['platform'] = "web";
                    $get_all_data['origin_exchange_rate'] = $origin_exchange_rate;
                    $get_all_data['currency_id'] = $origin_currency_id;
                    $get_all_data['lat'] = $request->filled('lat') ? $request->lat : 0;
                    $get_all_data['lng'] = $request->filled('lng') ? $request->lng : 0;
                    $get_all_data['is_gift'] = $request->is_gift;
                    $get_all_data['app_version'] = 1;


                    $get_filtered_data = $this->order->filter_order_data(json_decode(json_encode($get_all_data), true));


                    if ($get_filtered_data['order']['payment_method_id'] == 2 or $get_filtered_data['order']['payment_method_id'] == 1) {

                        $get_filtered_data['payment_result'] = $this->my_fatoorah->create_myfatoorah_page($get_filtered_data['payment_data'], $get_all_data['payment_method']);

                        $get_filtered_data['order_payment']['payment_reference'] = $get_filtered_data['payment_result'];
                    } else {
                        $get_filtered_data['payment_result'] = null;
                    }


                    if (!is_null($get_filtered_data['payment_result'])) {
                        if ($get_filtered_data['payment_result']['status']) {
                            if ($get_filtered_data['payment_result']['is_direct_payment']) {
                                $payment_url = $get_filtered_data['payment_result']['payment_url'];
                                $my_fatoorah = new Myfatoorah();
                                $payment = $my_fatoorah->create_myfatoorah_direct_payment_url($payment_url, $request);
                                $verify_payment = $my_fatoorah->verify_payment($payment['payment_id'], 'PaymentId');
                                $TransactionStatus = $verify_payment['Data']['InvoiceTransactions'][0]['TransactionStatus'];
                                $TransactionError = $verify_payment['Data']['InvoiceTransactions'][0]['Error'];

                                if ($TransactionStatus == 'Succss') {
                                    $get_filtered_data['order']['status'] = 0;
                                    $get_order = $this->order->add_order($get_filtered_data);
                                    $order = Order::where('order_number', $get_order->order_number)->first();
                                    $order->order_payment()->update([
                                        'payment_reference_at' => Carbon::now(),
                                        'transaction_id' => $verify_payment['Data']['InvoiceTransactions'][0] ? $verify_payment['Data']['InvoiceTransactions'][0]['TransactionId'] : '',
                                        'reference_no' => $verify_payment['Data']['InvoiceReference'],
                                    ]);
                                } else {
                                    return response()->json([
                                        'status' => false,
                                        'message' => $TransactionError,
                                        'data' => []
                                    ]);
                                }
                                $payment_url = '';
                            } else {
                                $get_filtered_data['order']['status'] = 3;
                                $get_order = $this->order->add_order($get_filtered_data);

                                $payment_url = $get_filtered_data['payment_result']['payment_url'];
                            }
                        } else {
                            return response()->json([
                                'status' => false,
                                'message' => $get_filtered_data['payment_result']['message'],
                                'data' => []
                            ]);
                        }
                    }

//                    $get_order =  $this->order->update_order_as_selected_currency($get_order , $get_order->exchange_rate);


//                    if($get_order->payment_method_id != 1 || $get_order->payment_method_id != 2) {
//
//                        Notification::route('test', 'test')->notify(new SendMakeOrderNotification($get_order) );
//
//                        CartService::delete_cart($cart , $get_order);
//                    }
                    ////////////////////////////////////////////////////////


                    return response()->json(['status' => true, 'message' => trans('website.add_order_done'),
                        'order_id' => $get_order->id,
                        'payment_url' => $payment_url
                    ]);

                } else {
                    return response()->json(['status' => false, 'message' => trans('api.select_shipping_company'), '']);
                }

            } else {
                return response()->json(['status' => false, 'message' => $check_data['message'], '']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage(), '']);

        } catch (\Error $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage(), '']);

        }


    }

    // help function
    public function get_confirm_phone_data($request)
    {
        $user = $request->user;
        $session_id = get_session_key();
        $phone_code = "";
        $phone = '';
        $steps = '';
        if ($user) {
            $phone_code = substr($user->phone, 0, strpos($user->phone, '-'));
            $phone = substr($user->phone, strpos($user->phone, '-') + 1);
            $steps = $user->confirm_setps;

        } else {

            $cart = Cart::CheckSessionId($session_id)->first();
            if ($cart) {
                $phone_code = substr($cart->phone, 0, strpos($cart->phone, '-'));
                $phone = substr($cart->phone, strpos($cart->phone, '-') + 1);

                $steps = $cart->confirm_setps;
            }

        }
        return [
            'phone_code' => $phone_code !== "" ? $phone_code : "",
            'phone' => $phone !== false ? $phone : "",
            'steps' => $steps,
        ];
    }
}
