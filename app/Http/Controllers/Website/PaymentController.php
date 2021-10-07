<?php

namespace App\Http\Controllers\Website;

use App\Notifications\SendMakeOrderNotification;
use App\Repository\HomeRepository;
use App\Services\Payment\Myfatoorah;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller\Website;
use Illuminate\Support\Facades\Notification;
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
use App\Models\Order;

use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Api\CartController;
// Resources
use App\Http\Resources\Product\ProductSimpleResource;
use Illuminate\Support\Facades\Input;

// services
use App\Services\SWWWTreeTraversal;
use App\Services\Payment\PayTabs;
use App\Services\CartService;
use App\Services\NotificationService\MakeOrderNotification;

use Illuminate\Support\Facades\Auth;

use DB;
/*  validations */

use App\Validations\OrderValidation;

use Carbon\Carbon;

class PaymentController extends Controller
{

    public $paytabs;
    public $myfatoorah;
    public $order;

    public function __construct(OrderRepository $order ,HomeRepository $home_repository)
    {
        $this->order = $order;
        $this->paytabs = new PayTabs();
        $this->myfatoorah = new Myfatoorah();

        parent::__construct();
        $this->home_repository = $home_repository;
    }



    public function confirmcod(Request $request , $code)
    {

        $order = Order::where('confirm_cod', '=', $code)->first();
        $lang = $order ? $order->lang : 'ar';
        app()->setLocale($lang);
        if (!$order) {
            $message = trans('website.error');

        } else {
            if ($order && is_null($order->confirm_cod_at) && in_array($order->status , [0 , 1])) {
                $order->confirm_cod_at = Carbon::now();
                $order->status = order_status()['processing'];
                $order->update();
                $message = trans('website.confirmcod_done');
            } else {
                $message = trans('website.confirmcod_already_done');
            }
        }

        return view('website.notifications.confirmcod', ['_message_' => $message , '_lang_' => $lang ]);

    }

    public function complete_payment(Request $request)
    {

        $payment_reference = $request->payment_reference;
        $verify_payment = $this->paytabs->verify_payment($payment_reference);

        $order = Order::whereHas('order_payment', function ($query) use ($payment_reference) {
            $query->where('payment_reference', '=', $payment_reference);
        })->first();
        $lang = $order ? $order->lang : 'ar';

        $payment_status = false;
        $platform = $order ? $order->platform : "";
        $pointer = ['name' => trans('website.raq_shop' , [] , $lang), 'url' => \LaravelLocalization::localizeUrl("/")];
        if ($verify_payment['response_code'] == "100") {

            if ($order) {
                $order->order_payment()->update([
                    'payment_reference_at' => Carbon::now(),
                    'transaction_id' => $verify_payment['transaction_id'],
                    'reference_no' => $verify_payment['reference_no'],
                ]);
                $payment_status = true;
                $order->status = order_status()['processing'];
                $order->update();

                CartService::update_order_product_quantity($order, "-");
                CartService::delete_cart(null , $order);

                $get_order =  $this->order->update_order_as_selected_currency($order , $order->exchange_rate);
                MakeOrderNotification::send_notification($get_order);
                
                $message = trans('website.complete_payment_success' , [] , $lang);
            } else {
                $message = trans('website.complete_payment_already_confirm', [] , $lang);
            }

        } else {
            if ($order) {
                $order->status = order_status()['failed'];
                $order->update();
            }
            $pointer = ['name' => trans('website.go_back_checkout' , [] , $lang), 'url' => \LaravelLocalization::localizeUrl("/$lang/checkout")];
            $message = trans('website.complete_payment_failed', [] , $lang);
        }
        return view('website.notifications.payment', [
            'payment_status' => $payment_status, 'platform' =>$platform ,
            'pointer'=> $pointer , 'payment_message' => $message , '_lang_' => $lang
        ]);
    }


    public function complete_my_fatoorah(Request $request){


        $payment_reference = $request->paymentId;

        $verify_payment = $this->myfatoorah->verify_payment($payment_reference , 'PaymentId');

        $InvoiceTransactionsCount = count($verify_payment['Data']['InvoiceTransactions']) -1;

        $TransactionStatus = $verify_payment['Data']['InvoiceTransactions'][$InvoiceTransactionsCount]['TransactionStatus'];
        $TransactionError = $verify_payment['Data']['InvoiceTransactions'][$InvoiceTransactionsCount]['Error'];

        $payment_reference =   $verify_payment['Data']['InvoiceId'];

        $order = Order::whereHas('order_payment', function ($query) use ($payment_reference) {
            $query->where('payment_reference', $payment_reference);
        })->first();
        $lang = $order ? $order->lang : 'ar';

        $payment_status = false;
        $platform = $order ? $order->platform : "";
        $pointer = ['name' => trans('website.raq_shop' , [] , $lang), 'url' => \LaravelLocalization::localizeUrl("/")];
        if ($TransactionStatus == 'Succss') {

            if ($order) {
                $order->order_payment()->update([
                    'payment_reference_at' => Carbon::now(),

                    'transaction_id' => $verify_payment['Data']['InvoiceTransactions'][0]?$verify_payment['Data']['InvoiceTransactions'][0]['TransactionId'] :'',
                    'reference_no' =>  $verify_payment['Data']['InvoiceReference'],
                ]);
                $payment_status = true;
                $order->status = orignal_order_status()['new'];
                $order->update();

                CartService::update_order_product_quantity($order, "-");
                CartService::delete_cart(null , $order);

//                $get_order =  $this->order->update_order_as_selected_currency($order , $order->exchange_rate);
                Notification::route('test', 'test')->notify(new SendMakeOrderNotification($order) );

//                MakeOrderNotification::send_notification($get_order);

                $message = trans('website.complete_payment_success' , [] , $lang);
            } else {
                $message = trans('website.complete_payment_already_confirm', [] , $lang);
            }

        } else {
            if ($order) {
                $order->status = orignal_order_status()['failed'];
                $order->update();
            }
            $pointer = ['name' => trans('website.go_back_checkout' , [] , $lang), 'url' => \LaravelLocalization::localizeUrl("/$lang/checkout")];
            $message = trans('website.'.$TransactionError, [] , $lang);
//            $message = $TransactionError;
        }
        return view('website_v2.payment.complete', [
            'payment_status' => $payment_status, 'platform' =>$platform ,
            'pointer'=> $pointer , 'payment_message' => $message , '_lang_' => $lang,'order'=>$order
        ], parent::$data);


    }

    public function visa_compleate_payment(Request $request){
        $order = Order::find($request->order_id);
        parent::$data['order'] = $order;
        $lang = $order ? $order->lang : 'ar';
        $platform = $order ? $order->platform : "";
        $payment_status = true;
        $pointer = ['name' => trans('website.raq_shop' , [] , $lang), 'url' => \LaravelLocalization::localizeUrl("/")];

        $message = trans('website.complete_payment_success' , [] , $lang);

        return view('website_v2.payment.complete', [
            'payment_status' => $payment_status, 'platform' =>$platform ,
            'pointer'=> $pointer , 'payment_message' => $message , '_lang_' => $lang
        ], parent::$data);
    }

}
