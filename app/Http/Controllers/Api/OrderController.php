<?php

namespace App\Http\Controllers\Api;


use App\Mail\TicketEmail;
use App\Models\Setting;
use App\Notifications\SendChangeOrderStatusNotification;
use App\Services\Payment\Myfatoorah;
use App\Validations\UserValidation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\StoreFile;
use DB;
use Carbon\Carbon;
/*  Repository */

use App\Repository\OrderRepository;
use App\Repository\CartRepository;
use App\Repository\BankTransferRepository;
/* Traits */

use App\Traits\PaginationTrait;

/* Models */

use App\Models\Order;
use App\Models\UserLocation;
use App\Models\AdminFcm;
use App\Models\Pharmacy;
use App\Models\Coupon;
use App\Models\OrderProduct;
use App\Models\NotificationAppUser;
use App\Models\OrderUserShipping;
use App\Models\PaymentMethod;
use App\Models\ProductVariation;
use App\Models\Product;
use App\Models\Bank;
use App\Models\UserShipping;
use App\Models\City;
use App\Models\ShippingCompanyCity;
/*  Resources  */

use App\Http\Resources\OrderRescourse;
use App\Http\Resources\OrderDetailsRescourse;
use App\Http\Resources\OrderProductRescourse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

use App\Http\Resources\Order\OrderResource;
use App\Http\Resources\Order\OrderDetailsResource;
use App\Http\Resources\Order\BankResource;
/*  jobs */

use  App\Jobs\SendNotificationJob;
use  App\Jobs\SendNotificationAdminJob;
use App\Jobs\DispatchSendEmail;

/*  validations */

use App\Validations\OrderValidation;

use Illuminate\Support\Str;

/*  services */

use App\Services\CartService;
use App\Services\NotificationService\MakeOrderNotification;

// notifications
use Illuminate\Support\Facades\Notification;
use App\Notifications\SendMakeOrderNotification;

class OrderController extends Controller
{
    use PaginationTrait;

    public $order;
    public $cart;
    public $validation;
    public $validation_user;

    public function __construct(OrderRepository $order, CartRepository $cart, OrderValidation $validation ,  UserValidation $validation_user)
    {
        $this->order = $order;
        $this->cart = $cart;
        $this->validation = $validation;
        $this->validation_user = $validation_user;
        $this->my_fatoorah = new Myfatoorah();

    }

    public function make_order(Request $request)
    {

        $user_shipping = new UserShipping();
        $user = $request->user;
        $cart = $user->cart;
        $is_guest = $user->is_guest;
//          $user->shipping_info;

        if (!$cart) {
            return response_api(false, trans('api.no_cart'), "");
        }
        if ($cart->products()->count() <= 0) {
            return response_api(false, trans('api.empty_cart'), "");
        }


        $check_data = $this->validation->check_make_order_data_api($request->toArray());

        if ($check_data['status']) {
            $user->shipping_info = UserShipping::where('user_id',$user->id)->where('id',$request->user_shipping_id)->first();

            $coupon_code = $request->coupon_code;
            $payment_method = $request->payment_method;
            $address_id = $request->address_id;
            $app_version = $request->app_version;

            $get_payment_method = PaymentMethod::find($payment_method);

            if ($user->shipping_info->billing_shipping_type_) {

                $shipping_company = $user->shipping_info->billing_shipping_type_;
                $shipping_city_id = $user->shipping_info->city;

                $city = City::find($shipping_city_id);
                $shipping_company_city = ShippingCompanyCity::InCompanyAndCity($shipping_company, $city)->first();

                $get_phone_with_phone_code = $city->country->phone_code . "-" . ($user->shipping_info->phone * 1);
                if ($user) {
//                    if ($get_phone_with_phone_code != $user->phone || is_null($user->phone_verified_at)) {
//                        return response_api(false, trans('api.phone_is_not_verified'), []);
//                    }
                } else {
                    if ($get_phone_with_phone_code != $cart->phone || is_null($cart->verified_at)) {
                        return response_api(false, trans('api.phone_is_not_verified'), []);
                    }
                }


                if ($get_payment_method && $get_payment_method->key == "cash" && $shipping_company_city->cash == 0) {
                    return response_api(false, trans('api.shipping_company_not_cash'), []);
                }

                $get_cart_product_ids = $cart->products()->pluck('product_id')->toArray();
                $check_gift_products = Product::whereIn('id', $get_cart_product_ids)->where('can_gift', '=', 1);
                if (array_key_exists('is_gift', $request->toArray()) && $request->is_gift == 1 && $check_gift_products->count() <= 0) {
                    return response()->json(['status' => false, 'message' => trans('api.no_product_in_cart_can_gift'), 'data']);
                }


                $request->request->add([
                    'is_bill' => true,
                    'shipping_company' => $shipping_company,
                    'coupon_code' => $coupon_code,
                    'shipping_company_city' => $shipping_company_city,
                    'cash_value' => $get_payment_method->key == "cash" && $shipping_company_city->cash == 1 ? true : false,
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

                    return response_api(false, trans('api.product_in_cart_has_trashed', ['name' => $check_if_product_is_trashed['name']]), ['cart_product_id' => $check_if_product_is_trashed['cart_product_id']]);
                }
                $check_product_quantity = $this->validation->check_product_quantity($collect_cart_products);
                if (!$check_product_quantity['status']) {
                    return response_api(false, $check_product_quantity['message'], $check_product_quantity['data']);

                }
                $get_all_data['user_id'] = $user->id;
                $get_all_data['payment_method'] = $payment_method;
                $get_all_data['user_shipping'] = $user->shipping_info->toArray();
                $get_all_data['is_guest'] = $user->is_guest;
                $get_all_data['confirm_cod'] = $get_payment_method->key == "cash" ? get_confirm_cod() : null;
                $get_all_data['confirm_cod_at'] = null;
                $get_all_data['is_guest'] = $user->is_guest;
                $get_all_data['platform'] = $request->filled('platform') ? $request->platform : "";
                $get_all_data['origin_exchange_rate'] = $origin_exchange_rate;
                $get_all_data['currency_id'] = $origin_currency_id;
                $get_all_data['lat'] = $request->filled('lat') ? $request->lat : 0;
                $get_all_data['lng'] = $request->filled('lng') ? $request->lng : 0;
                $get_all_data['is_gift'] = $request->is_gift;
                $get_all_data['app_version'] = $app_version;


                $get_filtered_data = $this->order->filter_order_data(json_decode(json_encode($get_all_data), true));

//                if ($get_filtered_data['order']['payment_method_id'] == 2 or $get_filtered_data['order']['payment_method_id'] == 1) {
//
//                    $get_filtered_data['payment_result'] = $this->my_fatoorah->create_myfatoorah_page($get_filtered_data['payment_data'],$get_all_data['payment_method']);
//
//                    $get_filtered_data['order_payment']['payment_reference'] = $get_filtered_data['payment_result'];
//                } else {
//                    $get_filtered_data['payment_result'] = null;
//                }
//
//                if (!is_null($get_filtered_data['payment_result'])) {
//                    if ($get_filtered_data['payment_result']['status']) {
//                        $request->request->add(['payment_url' => $get_filtered_data['payment_result']['payment_url']]);
//                    } else {
//                        return response_api(false, $get_filtered_data['payment_result']['message'], []);
//                    }
//                }

                $get_order = $this->order->add_order($get_filtered_data);

                /*  if($get_order == -1) {
                      return response_api(false, trans('api.error'), []);

                  }*/
                $order = $this->order->with(['payment_method', 'user', 'company_shipping',
                    'coupon', 'order_user_shipping', 'order_products.product',
                    'order_products.product_attribute_values.attribute_value.attribute.attribute_type'])
                    ->find($get_order->id);
//                $order = $this->order->update_order_as_selected_currency($order, $order->exchange_rate);
                $response['data'] = new OrderDetailsResource($order);
//                $response['payment_result'] = $get_filtered_data['payment_result'];

                if ($is_guest) {
                    //  $user->shipping_info->update($user_shipping->empty_shipping());
                }



//                if ($get_order->payment_method_id != 1 ) {
//
//                    CartService::delete_cart($cart, $order);
//                    Notification::route('test', 'test')->notify(new SendMakeOrderNotification($get_order));
//
//                }


                return response_api(true, trans('api.order_done'), $response);

            } else {
                return response_api(false, trans('api.select_shipping_company'), []);
            }

        } else {
            return response_api(false, $check_data['message'], "");
        }
    }

    public function chack_payment(Request $request){
        $order_id = $request->order_id;
        $payment_id = $request->payment_id;
        $invoice_id = $request->invoice_id;

        $user = $request->user;
         $cart = $user->cart;
        $get_order =  Order::find($order_id);

        if ($get_order){
            $my_fatoorah = new Myfatoorah();
            if ($payment_id == null){
                $verify_payment = $my_fatoorah->verify_payment($invoice_id,'InvoiceId');
            }else{
                $verify_payment = $my_fatoorah->verify_payment($payment_id,'PaymentId');
            }
            $TransactionStatus = 'Failed';
            $InvoiceTransactionsCount = count($verify_payment['Data']['InvoiceTransactions']) -1;
            if ($InvoiceTransactionsCount >= 0){
                $TransactionStatus = $verify_payment['Data']['InvoiceTransactions'][$InvoiceTransactionsCount]['TransactionStatus'];
                $TransactionError = $verify_payment['Data']['InvoiceTransactions'][$InvoiceTransactionsCount]['Error'];
            }

            if ($TransactionStatus == 'Succss') {
                $get_order->status = 0;
                $get_order->save();
                $get_order->order_payment()->create([
                    'payment_reference' =>$invoice_id,
                    'payment_reference_at' => Carbon::now(),
                    'transaction_id' => $verify_payment['Data']['InvoiceTransactions'][$InvoiceTransactionsCount] ? $verify_payment['Data']['InvoiceTransactions'][$InvoiceTransactionsCount]['TransactionId'] : '',
                    'reference_no' => $verify_payment['Data']['InvoiceReference'],
                ]);
                $order = $this->order->with(['payment_method', 'user', 'company_shipping',
                    'coupon', 'order_user_shipping', 'order_products.product',
                    'order_products.product_attribute_values.attribute_value.attribute.attribute_type'])
                    ->find($order_id);
                $order = $this->order->update_order_as_selected_currency($order, $order->exchange_rate);
                CartService::update_order_product_quantity($get_order, "-");

                CartService::delete_cart($cart,$order);
                Notification::route('test', 'test')->notify(new SendMakeOrderNotification($get_order));
                $response['data'] = new OrderDetailsResource($get_order);
                return response_api(true, trans('api.order_done'), $response);
            }else{

                $get_order->status = 3;
                $get_order->save();
                $get_order->order_payment()->create([
                    'payment_reference' =>$invoice_id,
                    'payment_reference_at' => Carbon::now(),
                    'reference_no' => $verify_payment['Data']['InvoiceReference'],
                ]);
            }
            $message = trans('website.order_error', [] , 'ar');
            return response_api(false, $message, "");

        }
        return response_api(false, 'error', "");

    }
    public function my_orders(Request $request)
    {
        $user = $request->user;
        $orders = $user->orders()
            ->latest('orders.created_at')
            ->with(['payment_method', 'currency'])
            ->withCount('order_products')
            ->paginate(10);

        $return_order_time = Setting::where('key', '=', 'return_order_time')->first()->value;

        $filters = $request->except(['user']);
        $filter_option = "&" . http_build_query($filters);

    $response['data'] = OrderResource::collection($orders);
        $pagination_options = $this->get_options_v2($orders, $filter_option);
        $response = $response + $pagination_options;

        $response['return_order_time'] = $return_order_time;

        return response_api(true, trans('api.done'), $response);
    }

//    public function my_return_orders(Request $request)
//    {
//        $user = $request->user;
//        $orders = $user->orders_api_return()
//            ->latest('orders.created_at')
//            ->with(['payment_method', 'currency'])
//            ->withCount('order_products')
//            ->paginate(10);
//
//        $filters = $request->except(['user']);
//        $filter_option = "&" . http_build_query($filters);
//        $response['orders'] = OrderResource::collection($orders);
//        $pagination_options = $this->get_options_v2($orders, $filter_option);
//        $response = $response + $pagination_options;
//        return response_api(true, trans('api.done'), $response);
//    }

    public function orders_search(Request $request)
    {

        $massage = "";
        $user = $request->user;

        $orders = $user->orders()
            ->latest('orders.created_at')
            ->with(['payment_method', 'currency'])
            ->withCount('order_products')
            ->filter([
                'id' => $request->order_id,

            ])
            ->paginate(10);
        if ($orders->count() <= 0){
            $exist_order = Order::find($request->order_id);
            if (!$exist_order) {
                $massage = "الرجاء التاكد من رقم الطلب المدخل";
            } else {

                if (!$request->sms_code) {
                    if (!in_array($request->order_id, $orders->pluck('id')->toArray())) {

                        if ($exist_order) {
                            $massage = "تم ارسال رسالة الي رقم الجوال المربوط بهدا الطلب ";
                            $exist_order->sms_code = '1234';
                            $exist_order->save();
                        }
                    }
                } else {
                    if ($exist_order->sms_code ==  $request->sms_code) {
                        $orders = Order::latest('orders.created_at')
                            ->with(['payment_method', 'currency'])
                            ->withCount('order_products')
                            ->filter([
                                'id' => $request->order_id,

                            ])
                            ->paginate(10);


                    }else{
                        $massage = "خطا في الكود المدخل";

                    }

                }
            }
        }




        $filters = $request->except(['user']);
        $filter_option = "&" . http_build_query($filters);
        $response['orders'] = OrderResource::collection($orders);
        $response['massage'] = $massage;
        $pagination_options = $this->get_options_v2($orders, $filter_option);
        $response = $response + $pagination_options;
        return response_api(true, trans('api.done'), $response);
    }

    public function order_details(Request $request, $id)
    {

        $order = $this->order->with(['payment_method', 'admin_discounts', 'company_shipping', 'package.package',
            'coupon', 'order_user_shipping', 'order_products.product','order_products.product',
            'order_products.product_attribute_values.attribute_value.attribute.attribute_type'])
            ->find($id);
        $order->return_order_note_file = add_full_path($order->return_order_note_file , 'ads');;

        if (!$order) {
            return response_api(false, trans('api.order_not_found'), []);

        }

//        $order = $this->order->update_order_as_selected_currency($order, $order->exchange_rate);
        $response['data'] = new OrderDetailsResource($order);
        return response_api(true, trans('api.done'), $response);

    }

    public function order_cancel(Request $request){
        $order_id = $request->order_id;
        $cancel_reasons = $request->cancel_reasons;
        $order = Order::find($order_id);
        if (!$order){
            return ['status' => false, 'message' => trans('api.error'), 'data'=> [

            ]];
        }

        if ($cancel_reasons == null){
            return ['status' => false, 'message' => trans('api.select_cancel_reason'), 'data'=> [
                'order' => $order
            ]];
        }
        $cancel_order_time = Setting::where('key', '=', 'cancel_order_time')->first()->value;
        $order_day_can_cancel =  Carbon::parse($order->created_at)->addDay($cancel_order_time);
        $day_naw =  Carbon::now();


        if ($day_naw > $order_day_can_cancel ){
            return ['status' => false, 'message' => trans('api.you_exceeded_the_limit'), 'data'=> [
                'order' => $order
            ]];
        }

        if ($order->status == 4){
            return ['status' => false, 'message' => trans('api.you_cancel_order'), 'data'=> [
                'order' => $order
            ]];
        }

        if ($order->status == 4){
            return ['status' => false, 'message' => trans('api.you_cancel_order'), 'data'=> [
                'order' => $order
            ]];
        }
        if ($order && in_array($order->status , [0,1]) ){
            $order->load('order_payment');

            $myFatoorah = new Myfatoorah();
            $myFatoorah->refund('invoiceid',$order->order_payment->payment_reference,$order->total_price);
            $order->status = 4 ;
            $order->canceled_at = Carbon::now();
            $order->cancel_reasons = $cancel_reasons;
            $order->save();
            Notification::route('test', 'test')->notify(new SendChangeOrderStatusNotification($order, $order->shipping_policy,  $order->status ) );

            return ['status' => true, 'message' => trans('api.cancel_order_success'), 'data'=> [
                'order' => $order
            ]];

        }

        return ['status' => false, 'message' => trans('api.you_cant_cancel_this_order'), 'data'=> [
            'order' => $order
        ]];

    }

    public function ticket(Request $request){

        $data = $request->toArray();

        $check_data = $this->validation_user->check_ticket_data($data);

        if ($check_data['status']) {

            $order_id =  $request->ticket_order_id;
            $title =  $request->ticket_title;
            $email =  $request->ticket_email;
            $description =  $request->ticket_description;
            $files = $request->ticket_files;


            $myEmail = 'info@q8store.co';

            Mail::to($myEmail)->send(new TicketEmail($order_id,$title,$email,$description,$files));
            return response()->json(['status' => true, 'message' => trans('api.ticket_send_successfully'), 'data' => '']);
        } else {
            return response()->json(['status' => false, 'message' => $check_data['message'], 'data' => '']);
        }

    }


}
