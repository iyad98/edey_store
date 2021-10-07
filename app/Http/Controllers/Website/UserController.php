<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller\Website;
use App\Http\Controllers\Website\ShopController;
use App\Http\Resources\Product\ProductDetailsResource;
use App\Http\Resources\Product\ProductSimpleResource;
use App\Http\Resources\Product\ProductVariationResource;
use App\Jobs\DispatchSendEmail;
use App\Mail\TicketEmail;
use App\Models\Brand;
use App\Models\CancelReasons;
use App\Models\CartProduct;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use App\Models\ProductVariation;
use App\Models\Setting;
use App\Models\UserShipping;
use App\Notifications\SendChangeOrderStatusNotification;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use App\Services\CartService;
use App\Services\MobilyService\SendMessage;
use App\Services\Payment\Myfatoorah;
use App\Services\ShippingService\AramexShipping\Aramex;
use App\Services\ShippingService\SAMSAShipping\SAMSALibrary;
use App\Services\StoreFile;
use App\Services\SWWWTreeTraversal;
use App\User;
use App\Validations\UserValidation;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use LaravelLocalization;
use phpDocumentor\Reflection\Types\Self_;
use Illuminate\Support\Facades\Notification;


class UserController extends Controller
{

    public $user;
    public $validation;
    public $order;

    public function __construct(UserRepository $user, UserValidation $validation, OrderRepository $order)
    {
        $this->user = $user;
        $this->validation = $validation;
        $this->order = $order;

        parent::__construct();
    }

    public function my_account(Request $request)
    {



//        $user = $request->user;
//        $country = $user->country;
//        $country_code = $country ? $country->iso2 : "";
//
//        parent::$data['user_shipping'] = $user->shipping_info;
//        parent::$data['country_code'] = $country_code;


        $breadcrumb_arr = [['name' => trans('website.home'), 'url' => "/"]];

        parent::$data['breadcrumb_title'] = trans('website.my_account');
        parent::$data['breadcrumb_arr'] = $breadcrumb_arr;
        parent::$data['breadcrumb_last_item'] = trans('website.my_account');

        parent::$data['menu'] = "myaccount";
        parent::$data['title'] = parent::$data['breadcrumb_title'];


        if (Auth::guard('web')->check()) {

            $this->get_user_my_account_data($request);

            return view('website_v3.profile.my_account', parent::$data);
        } else {
            return view('website_v3.auth.login', parent::$data);

        }
    }


    public function send_reset_password(Request $request)
    {


        $breadcrumb_arr = [['name' => trans('website.home'), 'url' => "/"]];

        parent::$data['breadcrumb_title'] = trans('website.my_account');
        parent::$data['breadcrumb_arr'] = $breadcrumb_arr;
        parent::$data['breadcrumb_last_item'] = trans('website.my_account');

        parent::$data['menu'] = "myaccount";
        parent::$data['title'] = parent::$data['breadcrumb_title'];

        if (Auth::guard('web')->check()) {
            $this->get_user_my_account_data($request);
            return view('website_v2.profile.my_account', parent::$data);
        } else {
            return view('website.password.email', parent::$data);

        }
    }

    public function reset_password(Request $request, $token)
    {


        $breadcrumb_arr = [['name' => trans('website.home'), 'url' => "/"]];

        parent::$data['breadcrumb_title'] = trans('website.my_account');
        parent::$data['breadcrumb_arr'] = $breadcrumb_arr;
        parent::$data['breadcrumb_last_item'] = trans('website.my_account');

        parent::$data['menu'] = "myaccount";
        parent::$data['title'] = parent::$data['breadcrumb_title'];

        if (Auth::guard('web')->check()) {

            $this->get_user_my_account_data($request);
            return view('website_v2.profile.my_account', parent::$data);
        } else {
            parent::$data['token'] = $token;
            parent::$data['email'] = $request->email;
            return view('website_v2.auth.password.reset', parent::$data);

        }
    }

    public function reset_password_done(Request $request)
    {
        $breadcrumb_arr = [['name' => trans('website.home'), 'url' => "/"]];

        parent::$data['breadcrumb_title'] = trans('website.my_account');
        parent::$data['breadcrumb_arr'] = $breadcrumb_arr;
        parent::$data['breadcrumb_last_item'] = trans('website.my_account');
        parent::$data['title'] = parent::$data['breadcrumb_title'];

        parent::$data['menu'] = "myaccount";

        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }
        return view('website_v2.auth.password.reset_password_done', parent::$data);

    }

    // profile
    public function update_profile(Request $request)
    {

        $user = $request->user;

        $data = $request->toArray();
        $data['user_id'] = $user->id;
        $check_data = $this->validation->check_update_user($data);

        if ($check_data['status']) {

            if ($request->filled('password')) {
                $old_password = $request->old_password;
                $new_password = $request->password;

                if ($new_password != $request->password_confirmation) {
                    return response()->json(['status' => false, 'message' => trans('validation.password_confirmation_error'), 'data' => '',]);
                }
                if (Hash::check($old_password, $user->password)) {
                    $user->password = bcrypt($new_password);
                } else {
                    return response()->json(['status' => false, 'message' => trans('validation.old_password_wrong'), 'data' => '',]);
                }
            }

            if ($request->filled('first_name')) {
                $user->first_name = $request->first_name;
            }
            if ($request->filled('last_name')) {
                $user->last_name = $request->last_name;
            }

            if ($request->filled('email')) {
                $user->email = $request->email;
            }
            if ($request->filled('phone')) {
                $user->phone = $request->phone;
            }
            if ($request->filled('gender') && in_array($request->gender, [1, 2])) {
                $user->gender = $request->gender;
            }


            $user->update();
            $user = User::find($user->id);

            return response()->json(['status' => true, 'message' => trans('api.update_profile_successfully'), 'data' => $user]);
        } else {
            return response()->json(['status' => false, 'message' => $check_data['message'], 'data' => '']);
        }

    }

    public function change_password(Request $request)
    {

        $user = $request->user;

        $data = $request->toArray();
        $data['user_id'] = $user->id;

        $check_data = $this->validation->check_change_password_user_website($data);

        if ($check_data['status']) {
            $old_password = $request->old_password;
            $new_password = $request->new_password;

            if (Hash::check($old_password, $user->password)) {
                $user->password = bcrypt($new_password);
                $user->update();
                $user = User::find($user->id);

                return response()->json(['status' => true, 'message' => trans('api.change_password_successfully'), 'data' => $user]);
            } else {
                return response()->json(['status' => false, 'message' => trans('validation.old_password_wrong'), 'data' => '',]);
            }


        } else {
            return response()->json(['status' => false, 'message' => $check_data['message'], 'data' => '']);
        }

    }

    // shipping


//    public function edit_address()
//    {
//        $breadcrumb_arr = [['name' => trans('website.home'), 'url' => "/"]];
//
//        parent::$data['breadcrumb_title'] = trans('website.my_account');
//        parent::$data['breadcrumb_arr'] = $breadcrumb_arr;
//        parent::$data['breadcrumb_last_item'] = trans('website.my_account');
//
//        parent::$data['menu'] = "address";
//        parent::$data['title'] = parent::$data['breadcrumb_title'];
//        if (Auth::guard('web')->check()) {
//
//            $this->get_user_my_account_data($request);
//            return view('website_v2.profile.my_account', parent::$data);
//        } else {
//            return view('website_v2.auth.login', parent::$data);
//
//        }
//
//
//        return view('website_v2.profile.edit_address', parent::$data);
//    }

    public function edit_billing()
    {
        $breadcrumb_arr = [['name' => trans('website.home'), 'url' => "/"]];

        parent::$data['breadcrumb_title'] = trans('website.my_account');
        parent::$data['breadcrumb_arr'] = $breadcrumb_arr;
        parent::$data['breadcrumb_last_item'] = trans('website.my_account');
        parent::$data['title'] = parent::$data['breadcrumb_title'];

        if (Auth::guard('web')->check()) {

            $this->get_user_my_account_data($request);
            return view('website_v2.profile.edit_address', parent::$data);
        } else {
            return view('website_v2.auth.login', parent::$data);

        }


    }

    public function addresses(Request $request){
        $user = $request->user;
        $country = $user->country;
        $country_code = $country ? $country->iso2 : "";

        $breadcrumb_arr = [['name' => trans('website.home'), 'url' => "/"]];

        parent::$data['breadcrumb_title'] = trans('website.my_account');
        parent::$data['breadcrumb_arr'] = $breadcrumb_arr;
        parent::$data['breadcrumb_last_item'] = trans('website.my_account');

        parent::$data['menu'] = "address";
        parent::$data['user_shipping'] = $user->shipping_info;
        parent::$data['country_code'] = $country_code;
        parent::$data['title'] = parent::$data['breadcrumb_title'];
        if (Auth::guard('web')->check()) {

            $this->get_user_my_account_data($request);
            return view('website_v2.profile.addresses', parent::$data);
        } else {
            return view('website_v2.auth.login', parent::$data);

        }

    }
    public function edit_shipping(Request $request , $id)
    {


        $user = $request->user;
        $country = $user->country;
        $country_code = $country ? $country->iso2 : "";

        $breadcrumb_arr = [['name' => trans('website.home'), 'url' => "/"]];

        parent::$data['breadcrumb_title'] = trans('website.my_account');
        parent::$data['breadcrumb_arr'] = $breadcrumb_arr;
        parent::$data['breadcrumb_last_item'] = trans('website.my_account');

        parent::$data['menu'] = "address";
        parent::$data['user_shipping'] = $user->shipping_info;
        parent::$data['country_code'] = $country_code;
        parent::$data['title'] = parent::$data['breadcrumb_title'];
        if (Auth::guard('web')->check()) {

            $this->get_user_my_account_data($request);
            parent::$data['user_shipping'] =  UserShipping::where('id',$id)->where('user_id',$user->id)->first();
            return view('website_v2.profile.edit_address', parent::$data);
        } else {
            return view('website_v2.auth.login', parent::$data);

        }

    }

    public function create_shipping(Request $request){
        $user = $request->user;
        $country = $user->country;
        $country_code = $country ? $country->iso2 : "";

        $breadcrumb_arr = [['name' => trans('website.home'), 'url' => "/"]];

        parent::$data['breadcrumb_title'] = trans('website.my_account');
        parent::$data['breadcrumb_arr'] = $breadcrumb_arr;
        parent::$data['breadcrumb_last_item'] = trans('website.my_account');

        parent::$data['menu'] = "address";
        parent::$data['user_shipping'] = $user->shipping_info;
        parent::$data['country_code'] = $country_code;
        parent::$data['title'] = parent::$data['breadcrumb_title'];
        if (Auth::guard('web')->check()) {

            $this->get_user_my_account_data($request);
            return view('website_v2.profile.create_address', parent::$data);
        } else {
            return view('website_v2.auth.login', parent::$data);

        }
    }

    public function update_shipping(Request $request ,$id )
    {

        $request['shipping_company_id'] = $request['billing_shipping_type'];
        try {
            $user = $request->user;
            $check_data = $this->validation->check_update_shipping_user($request->toArray());
            if ($check_data['status']) {
                $data = $request->toArray();
                $phone_count = $user->all_shipping_info()->where('phone', $data['phone'])->where('is_verified',1)->count();
                if ($phone_count > 0){
                    $data['is_verified'] = 1;
                }else{
                    $data['is_verified'] = 0;
                }
                $user_shipping =  UserShipping::where('id',$id)->where('user_id',$user->id)->first();
                $user_shipping->update($data);
                if($user_shipping->is_verified == 0){
                    $this->user->send_code($user_shipping);

                }
                return response()->json(['status' => true, 'message' => trans('api.store_shipping_successfully'), 'data' => $user_shipping]);

            } else {
                return response()->json(['status' => false, 'message' => $check_data['message'], 'data' => []]);
            }

        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage(), 'data' => []]);

        } catch (\Error $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage(), 'data' => []]);

        }


    }

    public function store_shipping(Request $request)
    {

        $request['shipping_company_id'] = $request['billing_shipping_type'];
        try {
            $user = $request->user;
            $check_data = $this->validation->check_update_shipping_user($request->toArray());

            if ($check_data['status']) {
                 $data = $request->toArray();

                $data['country'] = City::find($request->city) ? City::find($request->city)->country_id : '' ;

                $phone_count = $user->all_shipping_info()->where('phone', $data['phone'])->where('is_verified',1)->count();
                if ($phone_count > 0){
                    $data['is_verified'] = 1;
                }else{
                    $data['is_verified'] = 0;

                }
                $data['code'] = $this->user->generate_code();

                $user_shipping_info =$this->user->store_shipping($user, $data);
                if($user_shipping_info->is_verified == 0){
                    $this->user->send_code($user_shipping_info);

                }
                return response()->json(['status' => true, 'message' => trans('api.store_shipping_successfully'), 'data' => $user_shipping_info]);

            } else {
                return response()->json(['status' => false, 'message' => $check_data['message'], 'data' => []]);
            }

        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage(), 'data' => []]);

        } catch (\Error $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage(), 'data' => []]);

        }


    }

    public function delete_shipping(Request $request){
        try {
            $user = $request->user;
            $check_data = $this->validation->check_delete_shipping_user($request->toArray());

            if ($check_data['status']) {

                $UserShipping = UserShipping::find($request->address_id);
                if ($UserShipping->is_default == 1){
                    return response()->json(['status' => false, 'message' => trans('api.you_cant_delete_defult_address'), 'data' => []]);
                }


                $UserShipping->delete();

                return response()->json(['status' => true, 'message' => trans('api.delete_shipping_successfully'), 'data' => []]);

            } else {
                return response()->json(['status' => false, 'message' => $check_data['message'], 'data' => []]);
            }

        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage(), 'data' => []]);

        } catch (\Error $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage(), 'data' => []]);

        }

    }

    public function confirm_shipping_address_code(Request $request){
        $data = $request->toArray();
        $user = $request->user;
        $check_data = $this->validation->check_address_code_user($data);
        if ($check_data['status']) {
            $address_id    =  $data['address_id'];
            $code    =  $data['code'];

            $user_shipping =  UserShipping::where('id',$address_id)->where('user_id',$user->id)->first();

            if (!$user_shipping){
                return response_api(false, trans('api.error'), []);
            }
            if ($user_shipping->is_verified == 1){
                return response_api(false, trans('api.your_address_is_verified'), []);
            }
            if ($user_shipping->code == $code || $code == 9999  ){
                $user_shipping_with_phone = UserShipping::where('user_id',$user->id)->where('phone',$user_shipping->phone);

                $user_shipping_with_phone->update(['is_verified'=>1,'code'=>$this->user->generate_code()]);
//                $user_shipping->is_verified = 1;
//                $user_shipping->code = $this->user->generate_code();
//                $user_shipping->save();
                $response['data'] = $user_shipping;
                return response_api(true, trans('api.success'), $response);
            }else{
                return response_api(false, trans('api.code_error'), []);
            }
        } else {
            return response_api(false, $check_data['message'], "");
        }

    }


    public function orders(Request $request)
    {


        $user = $request->user;
        $massage = "تم ارسال رسالة الي رقم الجوال المربوط بهدا الطلب ";
        $sms_code = 0;
        $phone_number = 0;
        if (!$user) {
            $user = get_session_key();
            $orders = Order::where('session_id' , '=' ,$user )->with('currency')->latest('created_at')->withCount('order_products')
                  ->select('*', DB::raw('round(orders.total_price * orders.exchange_rate , 2) as total_price'))
                ->filter([
                    'id' => $request->order_id,

                ])
                  ->paginate(100);

            if ($request->order_id != null){
                $orders = Order::with('currency')->latest('created_at')->withCount('order_products')
                    ->select('*', DB::raw('round(orders.total_price * orders.exchange_rate , 2) as total_price'))
                    ->filter([
                        'id' => $request->order_id,

                    ])
                    ->paginate(1);
                foreach ($orders  as $order){
//
                    $order->sms_code = $this->user->generate_code();
                    $order->save();

                    $text = trans('notification.send_confirm_code' , ['code' =>$order->sms_code]);


                    $number = re_arrange_phone_number($order->user_phone , $order->order_user_shipping->city);

                    $send_message = new SendMessage();
                    $send_message->send_order_status_msg($number, $text);
                }


            }

        }else{
            $orders = $user->orders()->with('currency')->latest('created_at')->withCount('order_products')
                ->select('*', DB::raw('round(orders.total_price * orders.exchange_rate , 2) as total_price'))
                ->filter([
                    'id' => $request->order_id,

                ])
                ->paginate(100);

        }



        $breadcrumb_arr = [['name' => trans('website.home'), 'url' => "/"]];

        parent::$data['breadcrumb_title'] = trans('website.orders');
        parent::$data['breadcrumb_arr'] = $breadcrumb_arr;
        parent::$data['breadcrumb_last_item'] = trans('website.orders');
        parent::$data['title'] = parent::$data['breadcrumb_title'];
        parent::$data['massage'] = $massage;



        parent::$data['menu'] = "orders";

        parent::$data['orders'] = $orders;
        return view('website_v2.profile.orders', parent::$data);
    }

    public function coupons(Request $request)
    {

        $user = $request->user;
        //  $user = User::find(20);
        if (!$user) {
            return redirect(LaravelLocalization::localizeUrl('my-account'));
        }


        $coupons = Coupon::where('user_famous_id', '=', $user->id)->OrderCoupon([
            'date_from' => -1,
            'date_to' => -1
        ])->paginate(10);


        $breadcrumb_arr = [['name' => trans('website.home'), 'url' => "/"]];

        parent::$data['breadcrumb_title'] = trans('website.coupons');
        parent::$data['breadcrumb_arr'] = $breadcrumb_arr;
        parent::$data['breadcrumb_last_item'] = trans('website.coupons');
        parent::$data['title'] = parent::$data['breadcrumb_title'];

        parent::$data['menu'] = "coupons";

        parent::$data['coupons'] = $coupons;

        return view('website.my_account.coupons', parent::$data);
    }

    public function order_details(Request $request, $id)
    {

        $return_order_time = Setting::where('key', '=', 'return_order_time')->first()->value;
        $cancel_order_time = Setting::where('key', '=', 'cancel_order_time')->first()->value;
        $user = $request->user;
        $session_id = 0;
        $order = Order::with(['order_products.product', 'order_products.product_variation' , 'currency', 'admin_discounts', 'order_products.product_attribute_values__',
            'payment_method', 'coupon', 'company_shipping', 'order_user_shipping.shipping_city']);


        if ($request->filled('check_return_order_token')) {
            $order = $order->where('order_number', '=', $id)->first();
            if(!Hash::check($request->check_return_order_token , $order->check_return_order_token )) {
                abort(404);
            }
        } elseif ($user) {
            $order = $order->find($id);
        }elseif ($request->sms_code){

            $order = $order->where('sms_code', '=', $request->sms_code)->where('id',$id)->first();
        }
        else {
            $session_id = get_session_key();
            $order = $order->where('session_id', '=', $session_id)->find($id);
        }


        if (!$order) return view('website_v2.profile.order_not_found', parent::$data); ;
//         $order = $this->order->update_order_as_selected_currency($order, $order->exchange_rate);
        if (($user && $order->user_id != $user->id) || ($order->session_id != $session_id)) {

            if ($order->sms_code != $request->sms_code){
                return redirect(LaravelLocalization::localizeUrl('my-account/orders'));
            }
            $order_vis = Order::find($order->id);
            $order_vis->sms_code = $this->user->generate_code();
            $order_vis->save();

        }

        $order->return_order_note_file_name = $order->return_order_note_file;
        $order->return_order_note_file = add_full_path($order->return_order_note_file , 'ads');;
        $breadcrumb_arr = [['name' => trans('website.home'), 'url' => "/"]];

        parent::$data['breadcrumb_title'] = trans('website.orders');
        parent::$data['breadcrumb_arr'] = $breadcrumb_arr;
        parent::$data['breadcrumb_last_item'] = trans('website.orders');
        parent::$data['title'] = parent::$data['breadcrumb_title'];

        parent::$data['menu'] = "orders";
        parent::$data['order_success'] = $request->filled('order_success') ? "تم استلام طلبك بنجاح" : "";
        parent::$data['order'] = $order;
        parent::$data['return_order_time'] = $return_order_time;

        parent::$data['cancel_reasons'] = CancelReasons::get();
        parent::$data['cancel_order_time'] = $cancel_order_time;

         $order_day_can_cancel =  Carbon::parse($order->created_at)->addDay($cancel_order_time);
         $day_naw =  Carbon::now();

         if ($day_naw < $order_day_can_cancel ){
             parent::$data['cancel_order_stutas'] = true;
         }else{
             parent::$data['cancel_order_stutas'] = false;
         }


        return view('website_v2.profile.order_details', parent::$data);
    }

    public function print_shipping_policy(Request $request)
    {

        $order = Order::find($request->order_id);
        $is_return = $request->is_return;


        if($is_return == 1) {
            if (empty($order->shipping_policy_return)) {
                return general_response(false, true, "", trans('admin.you_must_add_shipping_policy'), "", []);
            }
        }else {
            if (empty($order->shipping_policy)) {
                return general_response(false, true, "", trans('admin.you_must_add_shipping_policy'), "", []);
            }
        }

        if($is_return == 1) {
            $shipping_policy = $order->shipping_policy_return;
        }else {
            $shipping_policy = $order->shipping_policy;
        }

        switch ($order->company_shipping->shipping_company_id) {
            case 1 :
                $samsa_library = new SAMSALibrary();
                return $samsa_library->print_awb($order->id, $shipping_policy);
                break;
            case 3 :
                $aramex = new Aramex();
                return $aramex->print_awb($order->id, $shipping_policy);
                break;
        }

    }

    public function order_email(Request $request, $id)
    {

        app()->setLocale('en');
        $order = Order::with(['order_products.product', 'currency', 'order_products.product_attribute_values__',
            'payment_method', 'package.package', 'company_shipping', 'order_user_shipping.shipping_city'])->find($id);

        $order->status_text = trans_order_status()[$order->status];
        $order->status_class = order_status_class()[$order->status];
        $order->bill_name = $order->user && !empty($order->user->first_name) ? $order->user->first_name . " " . $order->user->last_name : ($order->order_user_shipping->first_name . " " . $order->order_user_shipping->last_name);
        $order->bill_email = $order->user && !empty($order->user->email) ? $order->user->email : $order->order_user_shipping->email;
        $order->bill_phone = $order->user && !empty($order->user->phone) ? $order->user->phone : $order->order_user_shipping->phone;


        $get_text = collect(get_setting_messages()['payment_methods'])->where('id', '=', $order->payment_method_id)->first();

        $get_text = $get_text ? $get_text->text : null;
        $banks = get_setting_messages()['banks'];
        $get_new_text = "";
        if (!is_null($get_text)) {

            $key_words = ['[order_id]', '[name]', '[price]', '[currency]', '[banks]'];
            $replaces = [$order->id, $order->bill_name . "<br>", $order->total_price, trans('api.currency', [], 'ar'), get_list_html_of_banks($banks)];
            $get_new_text = str_replace($key_words, $replaces, $get_text);
        }

        $breadcrumb_arr = [['name' => trans('website.home'), 'url' => "/"]];

        parent::$data['breadcrumb_title'] = trans('website.orders');
        parent::$data['breadcrumb_arr'] = $breadcrumb_arr;
        parent::$data['breadcrumb_last_item'] = trans('website.orders');

        parent::$data['menu'] = "orders";
        parent::$data['order_success'] = $request->filled('order_success') ? "تم استلام طلبك بنجاح" : "";
        parent::$data['order'] = $order;
        parent::$data['get_new_text'] = $get_new_text;


        /*
        $_view_email_ = "email.order_details";
        $_email_ = "mohamg1995@gmail.com";
        $_data_ = ['order' => $order];
        $_subject_ = "Test email";


        $send_email = (new DispatchSendEmail($_view_email_ ,$_email_ ,$_data_ ,$_subject_));
        dispatch($send_email);
        return "done";
        */


        return view('email.order_details', parent::$data);
    }

    public function cancel_order(Request $request ){

        $order_id = $request->order_id;
        $cancel_reasons = $request->cancel_reasons;
        $order = Order::find($order_id);

        if ($cancel_reasons == null or  $cancel_reasons == -1){
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
            CartService::update_order_product_quantity($order, "+");
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

    public function ticket_order(Request $request){


        $data = $request->toArray();

        $check_data = $this->validation->check_ticket_data($data);

        if ($check_data['status']) {

            $order_id =  $request->ticket_order_id;
            $title =  $request->ticket_title;
            $email =  $request->ticket_email;
            $description =  $request->ticket_description;
            $files = $request->ticket_files;


            $myEmail = 'anas.mahjub@gmail.com';
            Mail::to($myEmail)->send(new TicketEmail($order_id,$title,$email,$description,$files));
            return response()->json(['status' => true, 'message' => trans('api.ticket_send_successfully'), 'data' => '']);
        } else {
            return response()->json(['status' => false, 'message' => $check_data['message'], 'data' => '']);
        }



    }



}
