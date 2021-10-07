<?php

namespace App\Http\Controllers\Admin;


use App\Exports\OrderExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryDataResourceDFT;
use App\Http\Resources\Order\OrderDetailsResource;
use App\Http\Resources\Order\OrderResource;
use App\Http\Resources\OrderExportResource;
use App\Jobs\CheckOrderBankTransfer;
use App\Jobs\DispatchSendEmail;
use App\Jobs\SendNotificationJob;
use App\Jobs\TestJob;
use App\Models\Cart;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Package;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\Setting;
use App\Models\ShippingCompany;
use App\Repository\OrderRepository;
use App\Services\CartService;
use App\Services\CurrencyService\CurrencyExchange;
use App\Services\Firebase;
use App\Services\Firestore;
use App\Services\MobilyService\MobilySMS;
use App\Services\MobilyService\SendMessage;
use App\Services\NotificationService\ChangeOrderStatusNotification;
use App\Services\NotificationService\MakeOrderNotification;
use App\Services\NotificationService\NotificationAdminService;
use App\Services\Payment\PayTabs;
use App\Services\PointService;
use App\Services\PublicOrderDataService;
use App\Services\ShippingService\SAMSAShipping\SAMSALibrary;
use App\Services\StoreFile;
use App\Services\SWWWTreeTraversal;
use App\Services\TwilioService;
use App\User;
use App\Validations\ProductValidation;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use Excel;
/*  Models */

/* service */

// validations
// Repository

// jobs


// Resources
use Illuminate\Support\Facades\Hash;

class OrderController extends HomeController
{


    public $order;
    public $tiwlio;

    public function __construct(OrderRepository $order)
    {
        $this->middleware('check_role:view_orders');

        parent::__construct();
        parent::$data['active_menu'] = 'orders';
        parent::$data['route_name'] = trans('admin.orders');
        parent::$data['route_uri'] = route('admin.orders.index');
        $this->order = $order;
        $this->tiwlio = new TwilioService();


    }


    public function index(Request $request)
    {
        $deleted = $request->filled('deleted') ? $request->deleted : 0;
        $is_return = $request->filled('is_return') ? $request->is_return : 0;

        $order_status = $this->order->get_order_status_data();
        $payment_methods = PaymentMethod::Active()->get();
        $shipping_companies = ShippingCompany::Active()->get();

        parent::$data['shipping_companies'] = $shipping_companies;
        parent::$data['payment_methods'] = $payment_methods;

        parent::$data['countries'] = Country::Active()->get();
        parent::$data['order_status'] = $order_status;
        parent::$data['deleted'] = $deleted;
        parent::$data['is_return'] = $is_return;

        if ($deleted) {
            parent::$data['active_menu'] = 'trash';
            parent::$data['sub_menu'] = 'deleted_orders';
        }
        if($is_return) {
            parent::$data['route_name'] = trans('admin.orders_return');
            parent::$data['route_uri'] = route('admin.orders.index' ,['is_return' => 1]);
            parent::$data['active_menu'] = 'order_return';
            parent::$data['sub_menu'] = 'order_return';
        }
        return view('admin.orders.index', parent::$data);
    }

    public function order_details(Request $request, $id)
    {

        $order = $this->get_order_details($id);
        

        $countries = Country::Active()->get();
        (new NotificationAdminService())->mark_as_read_notification($order->id);

        $cities = City::Active()->where('country_id', '=', $order->country_id_selected)->get();
        $shipping_companies = PublicOrderDataService::get_shipping_companies($order->city_id_selected);
        $payment_methods = PublicOrderDataService::get_payment_methods($order->company_shipping->shipping_company, $order->city_id_selected);

        parent::$data['order'] = $order;

        parent::$data['countries'] = $countries;
        parent::$data['cities'] = count($cities) > 0 ? $cities : json_encode([]);
        parent::$data['shipping_companies'] = count($shipping_companies) > 0 ? $shipping_companies : json_encode([]);
        parent::$data['payment_methods'] = count($payment_methods) > 0 ? $payment_methods : json_encode([]);

        return view('admin.orders.order_details', parent::$data);
    }

    public function print_order(Request $request)
    {
        $setting = Setting::whereIn('key', ['email', 'phone', 'place'])->get();
        $email = $setting->where('key', 'email')->first();
        $phone = $setting->where('key', 'phone')->first();
        $place = $setting->where('key', 'place')->first();

        $id = $request->id;
        $order = $this->get_order_details($id);
        $order->bill_name = $order->user && !empty($order->user->first_name) ? $order->user->first_name . " " . $order->user->last_name : ($order->order_user_shipping->first_name . " " . $order->order_user_shipping->last_name);
        $order->bill_email = $order->user && !empty($order->user->email) ? $order->user->email : $order->order_user_shipping->email;
        $order->bill_phone = $order->user && !empty($order->user->phone) ? $order->user->phone : $order->order_user_shipping->phone;

        $this->add_action("print_order", 'order', json_encode($order));

        parent::$data['order'] = $order;
        parent::$data['email'] = $email ? $email->value : "";
        parent::$data['phone'] = $phone ? $phone->value : "";
        parent::$data['place'] = $place ? $place->value : "";

        return view('admin.orders.bill', parent::$data);
    }

    public function print_multi_order(Request $request){
        $setting = Setting::whereIn('key', ['email', 'phone', 'place'])->get();
        $email = $setting->where('key', 'email')->first();
        $phone = $setting->where('key', 'phone')->first();
        $place = $setting->where('key', 'place')->first();

        $ids =   explode(',',$request->order_ids);

        $orders =  collect();
        foreach ($ids as $id){
            $order = $this->get_order_details($id);
            $order->bill_name = $order->user && !empty($order->user->first_name) ? $order->user->first_name . " " . $order->user->last_name : ($order->order_user_shipping->first_name . " " . $order->order_user_shipping->last_name);
            $order->bill_email = $order->user && !empty($order->user->email) ? $order->user->email : $order->order_user_shipping->email;
            $order->bill_phone = $order->user && !empty($order->user->phone) ? $order->user->phone : $order->order_user_shipping->phone;

            $orders->push($order);
            $this->add_action("print_order", 'order', json_encode($order));

        }

        parent::$data['orders'] = $orders;
        parent::$data['email'] = $email ? $email->value : "";
        parent::$data['phone'] = $phone ? $phone->value : "";
        parent::$data['place'] = $place ? $place->value : "";

        return view('admin.orders.bills', parent::$data);
    }

    public function download_excel_order(Request $request){
           $orders = $this->order->get_ajax_data($request)->get();

        $orders = OrderExportResource::collection($orders);

                return Excel::download(new OrderExport($orders), "orders.xlsx");


    }

    public function get_orders_ajax(Request $request)
    {

        $deleted = $request->deleted;
        $is_return = $request->is_return;
        $orders = $this->order->get_ajax_data($request);
        if ($deleted == 1) {
            $orders = $orders->withTrashed()->onlyTrashed();
        }
        if ($is_return == 1) {
            $orders = $orders->whereIn('orders.status', [6,9,10]);
        }

        return DataTables::of($orders)
            ->editColumn('linkable_name', function ($model) {
                return view('admin.orders.parts.linkable_name', ['model' => $model])->render();
            })->editColumn('linkable_order_id', function ($model) {
                return view('admin.orders.parts.linkable_order_id', ['model' => $model])->render();
            })
            ->editColumn('order_status', function ($model) {
                return view('admin.orders.parts.order_status', ['status' => $model->order_status])->render();
            })
            ->editColumn('payment_name', function ($model) {
                return view('admin.orders.parts.payment_name', ['payment_name' => $model->payment_name])->render();
            })
            ->addColumn('options', function ($model) {
                return view('admin.orders.parts.options', ['id' => $model->id])->render();
            })
//            ->addColumn('actions', function ($model) {
//                return view('admin.orders.parts.actions', ['id' => $model->id])->render();
//            })
            ->escapeColumns(['*'])->make(true);
    }

    public function change_status(Request $request)
    {
        $order_id = $request->order_id;
        $status = $request->order_status;
        $order = $this->order->find($order_id);
        $order_status_point_to_failed = [order_status()['canceled'], order_status()['returned'], order_status()['failed'], order_status()['replaced']];


        if (!$order) {
            return general_response(false, true, "", trans('admin.order_not_found'), "", [
                'order' => $order
            ]);
        }
        $previous_status = $order->status;

        if ($previous_status == $status) {
            return general_response(false, true, "", trans('admin.order_is_same_status'), "", [
                'order' => $order
            ]);
        }

        if (!in_array($order->status, $order_status_point_to_failed) && in_array($previous_status, $order_status_point_to_failed) && $order->payment_method->key == "wallet") {
            $user = $order->user;
            $get_user_points = $user && $user->is_guest == 0 ? $user->points : 0;
            $wallet_price = get_wallet_price(null, $get_user_points);
            if ($wallet_price < $order->total_price) {
                return general_response(false, true, "", trans('admin.cant_pay_by_wallet_2', ['wallet' => $wallet_price]), "", [
                    'order' => $order
                ]);
            }
        }

        if ($status == order_status()['shipment'] && is_null($order->shipping_policy)) {

            $order->can_edit = $this->order->can_edit_order($order->status);
            $order->status_text = trans_order_status()[$order->status];
            $order->status_class = order_status_class()[$order->status];

            return general_response(false, true, "", trans('admin.you_must_add_shipping_policy'), "", [
                'order' => $order
            ]);
        }

        if ($status == order_status()['replaced']) {
            $order_package = $order->order_package;
            $now_time = Carbon::now();

            if ($order->status != order_status()['finished']) {
                return general_response(false, true, "", trans('admin.you_must_finish_order'), "", [
                    'order' => $order
                ]);
            }
            $time_can_replace_order = Carbon::parse($order->finished_at)->addHours($order_package ? $order_package->replace_hours : 0);
            if ($now_time < $time_can_replace_order) {
                return general_response(false, true, "", trans('admin.cant_replace_order'), "", ['order' => $order]);
            }
        }

        try {
            $get_date_order_status = get_date_order_status()[$status];
        } catch (\Exception $e) {
            $get_date_order_status = 0;
        } catch (\Error $e) {
            $get_date_order_status = 0;
        }

        $order->status = $status;
        //   $order->shipping_policy = $request->filled('shipping_policy') && !is_null($request->shipping_policy) ? $request->shipping_policy : $order->shipping_policy;
        if ($status != 0) {
            $order->$get_date_order_status = Carbon::now();
        }

        $order->update();

        if (in_array($order->status, $order_status_point_to_failed) && !in_array($previous_status, $order_status_point_to_failed)) {
            CartService::update_order_product_quantity($order, "+");
        } else if (!in_array($order->status, $order_status_point_to_failed) && in_array($previous_status, $order_status_point_to_failed)) {
            CartService::update_order_product_quantity($order, "-");
        }


        $order->can_edit = $this->order->can_edit_order($order->status);
        $order->status_text = trans_order_status()[$order->status];
        $order->status_class = order_status_class()[$order->status];

        /************* send sms and email ***********************************/

        ChangeOrderStatusNotification::send_notification($order, $order->shipping_policy, $status);
        // $this->send_order_status_msg($order, $request->shipping_policy, $status);

        return general_response(true, true, trans('admin.change_order_status_success'), "", "", [
            'order' => $order
        ]);

    }


    // helper
    public function get_order_details($id, $currency_type = 2)
    {
        $order = $this->order->withTrashed()->with(['user', 'currency', 'order_payment', 'admin_discounts', 'payment_method', 'company_shipping', 'coupon',
            'order_user_shipping.shipping_city', 'order_products.product:id,name_ar,name_en,image', 'package.package',
            'order_products.product_attribute_values__.attribute.attribute_type', 'order_products.product_variation:id,product_id,sku,order_status'])
            ->find($id);

        foreach ($order->order_products as  $order_products ){
            $order_products->product_variation->order_status_text = trans_order_status()[$order_products->product_variation->order_status] ;
        }
        $get_remain_replace_time = get_remain_replace_time($order);

        $order->status_text = trans_orignal_order_status()[$order->status];
        $order->status_class = order_status_class()[$order->status];
        $order->can_edit = $this->order->can_edit_order($order->status);
        $order->remain_replace_time = $get_remain_replace_time['remain_replace_time'];
        $order->can_replace = $get_remain_replace_time['can_replace'];

        $order->currency_text = $currency_type == 2 ? "KWD" : $order->currency->code;
        $order->currency_symbol = $currency_type == 2 ? trans('api.currency') : $order->currency->symbol;
        $order->currency_type = $currency_type;
        $exchange_rate = $currency_type == 2 ? 1 : $order->exchange_rate;

        $country_id = $order->order_user_shipping && $order->order_user_shipping->shipping_city && $order->order_user_shipping->shipping_city->country ? $order->order_user_shipping->shipping_city->country->id : -1;
        $city_id = $order->order_user_shipping && $order->order_user_shipping->shipping_city ? $order->order_user_shipping->shipping_city->id : -1;
        $shipping_company_id = $order->company_shipping && $order->company_shipping->shipping_company ? $order->company_shipping->shipping_company->id : -1;


        $order->country_id_selected = $country_id;
        $order->city_id_selected = $city_id;
        $order->shipping_company_id_selected = $shipping_company_id;


        return $this->order->update_order_as_selected_currency($order, $exchange_rate);
    }

    public function update_order_as_currency_type(Request $request)
    {
        $order_id = $request->order_id;
        $currency_type = $request->currency_type;
        return response()->json($this->get_order_details($order_id, $currency_type));
    }

}
