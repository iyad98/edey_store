<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

/*  Models */

use App\Models\Setting;
use App\Models\PaymentMethod;
use App\Models\CouponType;
use App\Models\Order;
/* service */

use App\Services\JawalService\JawalSMS;
use App\Services\NotificationService\ChangeOrderStatusNotification;

use Illuminate\Validation\Rule;
use App\Services\StoreFile;
use DB;


class SettingController extends HomeController
{


    public function __construct()
    {
        $this->middleware('check_role:view_settings');

        parent::__construct();
        parent::$data['route_name'] = trans('admin.settings');
        parent::$data['route_uri'] = route('admin.settings.index');
        parent::$data['active_menu'] = 'settings';

    }


    public function index()
    {

        $settings = Setting::all();
        $coupon_types = CouponType::all();

        $tax = $settings->where('key', '=', 'tax')->first();
        $shipping = $settings->where('key', '=', 'shipping')->first();
        $first_order_discount = $settings->where('key', '=', 'first_order_discount')->first();
        $cancel_order_time = $settings->where('key', '=', 'cancel_order_time')->first();

        $place = $settings->where('key', '=', 'place')->first();
        $policy = $settings->where('key', '=', 'policy')->first();
        $about = $settings->where('key', '=', 'about')->first();
        $privacy_policy = $settings->where('key', '=', 'privacy_policy')->first();
        $terms = $settings->where('key', '=', 'terms')->first();
        $shipping_and_delivery = $settings->where('key', '=', 'shipping_and_delivery')->first();

        $phone = $settings->where('key', '=', 'phone')->first();
        $email = $settings->where('key', '=', 'email')->first();
        $facebook = $settings->where('key', '=', 'facebook')->first();
        $twitter = $settings->where('key', '=', 'twitter')->first();
        $snapchat = $settings->where('key', '=', 'snapchat')->first();
        $instagram = $settings->where('key', '=', 'instagram')->first();
        $youtube = $settings->where('key', '=', 'youtube')->first();
        $telegram = $settings->where('key', '=', 'telegram')->first();


//        $cash_note = $settings->where('key', '=', 'cash_note')->first();
//        $bank_note = $settings->where('key', '=', 'bank_note')->first();
//        $visa_note = $settings->where('key', '=', 'visa_note')->first();

        $point_price = $settings->where('key', '=', 'point_price')->first();
        $package_discount_type = $settings->where('key', '=', 'package_discount_type')->first();

        $failed_order_bank_time = $settings->where('key', '=', 'failed_order_bank_time')->first();

        $price_tax_in_products = $settings->where('key', '=', 'price_tax_in_products')->first();
        $price_tax_in_cart = $settings->where('key', '=', 'price_tax_in_cart')->first();

        $product_details_note1 = $settings->where('key', '=', 'product_details_note1')->first();
        $product_details_note2 = $settings->where('key', '=', 'product_details_note2')->first();
        $product_details_note_image = $settings->where('key', '=', 'product_details_note_image')->first();


        $checkout_label = $settings->where('key', '=', 'checkout_label')->first();

        $close_app = $settings->where('key', '=', 'close_app')->first();
        $close_website = $settings->where('key', '=', 'close_website')->first();

        $return_order_time = $settings->where('key', '=', 'return_order_time')->first();
        $note_discount_product_details = $settings->where('key', '=', 'note_discount_product_details')->first();



        parent::$data['tax'] = $tax;
        parent::$data['shipping'] = $shipping;
        parent::$data['first_order_discount'] = $first_order_discount;
        parent::$data['cancel_order_time'] = $cancel_order_time;



        parent::$data['place'] = $place;
        parent::$data['policy'] = $policy;
        parent::$data['about'] = $about;
        parent::$data['privacy_policy'] = $privacy_policy;
        parent::$data['terms'] = $terms;
        parent::$data['shipping_and_delivery'] = $shipping_and_delivery;

        parent::$data['phone'] = $phone;
        parent::$data['email'] = $email;
        parent::$data['facebook'] = $facebook;
        parent::$data['twitter'] = $twitter;
        parent::$data['snapchat'] = $snapchat;
        parent::$data['instagram'] = $instagram;
        parent::$data['youtube'] = $youtube;
        parent::$data['telegram'] = $telegram;




//        parent::$data['cash_note'] = $cash_note;
//        parent::$data['bank_note'] = $bank_note;
//        parent::$data['visa_note'] = $visa_note;

        parent::$data['point_price'] = $point_price;
        parent::$data['package_discount_type'] = $package_discount_type;

        parent::$data['failed_order_bank_time'] = $failed_order_bank_time;

        parent::$data['price_tax_in_products'] = $price_tax_in_products;
        parent::$data['price_tax_in_cart'] = $price_tax_in_cart;

        parent::$data['product_details_note1'] = $product_details_note1;
        parent::$data['product_details_note2'] = $product_details_note2;
        parent::$data['product_details_note_image'] = $product_details_note_image;




        parent::$data['close_app'] = $close_app;
        parent::$data['close_website'] = $close_website;

        parent::$data['return_order_time'] = $return_order_time;

        parent::$data['coupon_types'] = $coupon_types;
        parent::$data['note_discount_product_details'] = $note_discount_product_details;

        parent::$data['checkout_label'] = $checkout_label;

        parent::$data['sub_menu'] = 'settings';
        return view('admin.settings.index', parent::$data);
    }
    public function messages()
    {

        $mobily_sms = new JawalSMS();
     //   return $mobily_sms->send_sms("970598149450" , "Hello");
        $balance = $mobily_sms->get_balance();

        $keys = ['shipping_order', 'cancel_order', 'failed_order','finished_order' ,'sms_user_account' , 'sms_user_pass' , 'sms_sender','order_in_the_warehouse'];
        $payment_methods = PaymentMethod::all();
        $settings = Setting::whereIn('key', $keys)->get();

        $cash = $payment_methods->where('key', '=', 'knet')->first();
        $visa = $payment_methods->where('key', '=', 'visa')->first();
        $bank_transfer = $payment_methods->where('key', '=', 'bank_transfer')->first();

        $shipping_order = $settings->where('key', '=', 'shipping_order')->first();
        $cancel_order = $settings->where('key', '=', 'cancel_order')->first();
        $failed_order = $settings->where('key', '=', 'failed_order')->first();
        $finished_order = $settings->where('key', '=', 'finished_order')->first();

        $order_in_the_warehouse = $settings->where('key', '=', 'order_in_the_warehouse')->first();

        $sms_user_account = $settings->where('key', '=', 'sms_user_account')->first();
        $sms_user_pass = $settings->where('key', '=', 'sms_user_pass')->first();
        $sms_sender = $settings->where('key', '=', 'sms_sender')->first();

        parent::$data['active_menu'] = 'setting_messages';
        parent::$data['cash'] = $cash;
        parent::$data['visa'] = $visa;
        parent::$data['bank_transfer'] = $bank_transfer;

        parent::$data['shipping_order'] = $shipping_order;
        parent::$data['finished_order'] = $finished_order;
        parent::$data['cancel_order'] = $cancel_order;
        parent::$data['failed_order'] = $failed_order;
        parent::$data['order_in_the_warehouse'] = $order_in_the_warehouse;


        parent::$data['sms_user_account'] = $sms_user_account;
        parent::$data['sms_user_pass'] = $sms_user_pass;
        parent::$data['sms_sender'] = $sms_sender;

        parent::$data['balance'] = $balance;

        parent::$data['sub_menu'] = 'setting_messages';
        return view('admin.settings.messages', parent::$data);

    }

    public function update_messages(Request $request)
    {

        $rules = [
            'cash_text_ar' => 'required',
            'visa_text_ar' => 'required',
            'bank_transfer_text_ar' => 'required',

            'cash_text_en' => 'required',
            'visa_text_en' => 'required',
            'bank_transfer_text_en' => 'required',

            'shipping_order_ar' => 'required',
            'cancel_order_ar' => 'required',
            'failed_order_ar' => 'required',
            'finished_order_ar' => 'required',
            'order_in_the_warehouse_ar'=>'required',

            'shipping_order_en' => 'required',
            'cancel_order_en' => 'required',
            'failed_order_en' => 'required',
            'finished_order_en' => 'required',
            'order_in_the_warehouse_en'=>'required',

        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors();
            $get_one_message = get_error_msg($rules, $messages);
            return general_response(false, true, "", $get_one_message, "", []);
        } else {
//            , '[cod_url]'
            $cash_key_words = [ '[name]'];
            $key_words = [ '[name]'];
            $bank_key_words = ['[order_id]', '[name]', '[price]', '[currency]', '[banks]'];
            $order_shipping_key_words = ['[order_id]', '[phone]'];
            $order_key_words = ['[order_id]'];
            $order_in_the_warehouse_key_words = ['[name]','[order_id]','[order_date]'];

            ////////////////////////////////////////////////////////////////////////////
            $check_cash_keys_ar = $this->contains($request->cash_text_ar, $cash_key_words);
            $check_cash_keys_en = $this->contains($request->cash_text_en, $cash_key_words);

            $cash_keys = implode(" , ", $cash_key_words);
            if (!$check_cash_keys_ar || !$check_cash_keys_en) {
                return general_response(false, true, "", trans('admin.cash_must_contains_keys', ['keys' => $cash_keys]), "", []);
            }
            $check_visa_keys_ar = $this->contains($request->visa_text_ar, $key_words);
            $check_visa_keys_en = $this->contains($request->visa_text_en, $key_words);

            if (!$check_visa_keys_ar || !$check_visa_keys_en) {
                return general_response(false, true, "", trans('admin.visa_must_contains_keys', ['keys' => $cash_keys]), "", []);
            }

            $check_bank_keys_ar = $this->contains($request->bank_transfer_text_ar, $bank_key_words);
            $check_bank_keys_en = $this->contains($request->bank_transfer_text_en, $bank_key_words);

            $bank_keys = implode(" , ", $bank_key_words);
            if (!$check_bank_keys_ar || !$check_bank_keys_en) {
                return general_response(false, true, "", trans('admin.bank_transfer_must_contains_keys', ['keys' => $bank_keys]), "", []);
            }
            ///////////////////////////////////////////////////////////////////////////////////////////////////


            ////////////////////////////////////////////////////////////////////////////
            $check_shipping_order_keys_ar = $this->contains($request->shipping_order_ar, $order_shipping_key_words);
            $check_shipping_order_keys_en = $this->contains($request->shipping_order_en, $order_shipping_key_words);

            $order_keys = implode(" , ", $order_key_words);
            $order_shipping_key_words = implode(" , ", $order_shipping_key_words);

            if (!$check_shipping_order_keys_ar || !$check_shipping_order_keys_en)  {
                return general_response(false, true, "", trans('admin.shipping_order_must_contains_keys', ['keys' => $order_shipping_key_words]), "", []);
            }
            $check_cancel_order_keys_ar = $this->contains($request->cancel_order_ar, $order_key_words);
            $check_cancel_order_keys_en = $this->contains($request->cancel_order_en, $order_key_words);

            if (!$check_cancel_order_keys_ar || !$check_cancel_order_keys_en) {
                return general_response(false, true, "", trans('admin.cancel_order_must_contains_keys', ['keys' => $order_keys]), "", []);
            }

//            $check_failed_order_keys_ar = $this->contains($request->failed_order_ar, $order_key_words);
//            $check_failed_order_keys_en = $this->contains($request->failed_order_en, $order_key_words);
//
//            if (!$check_failed_order_keys_ar || !$check_failed_order_keys_en) {
//                return general_response(false, true, "", trans('admin.failed_order_must_contains_keys', ['keys' => $order_keys]), "", []);
//            }

            $order_in_the_warehouse_key_words_keys = implode(" , ", $order_in_the_warehouse_key_words);
            $check_order_in_the_warehouse_key_ar = $this->contains($request->order_in_the_warehouse_ar, $order_in_the_warehouse_key_words);
            $check_order_in_the_warehouse_key_en = $this->contains($request->order_in_the_warehouse_en, $order_in_the_warehouse_key_words);

            if (!$check_order_in_the_warehouse_key_ar || !$check_order_in_the_warehouse_key_en) {
                return general_response(false, true, "", trans('admin.order_in_the_warehouse_must_contains_keys', ['keys' => $order_in_the_warehouse_key_words_keys]), "", []);
            }
            ///////////////////////////////////////////////////////////////////////////////////////////////////
            ///
            PaymentMethod::where('key', '=', 'knet')->update([
                'text_ar' => $request->cash_text_ar,
                'text_en' => $request->cash_text_en,
            ]);
            PaymentMethod::where('key', '=', 'visa')->update([
                'text_ar' => $request->visa_text_ar,
                'text_en' => $request->visa_text_en,
            ]);
            PaymentMethod::where('key', '=', 'bank_transfer')->update([
                'text_ar' => $request->bank_transfer_text_ar,
                'text_en' => $request->bank_transfer_text_en,
            ]);

            $keys = ['shipping_order', 'cancel_order','finished_order', 'failed_order', 'sms_user_account', 'sms_user_pass', 'sms_sender','order_in_the_warehouse'];
            $multi_lang_keys = ['shipping_order', 'finished_order','cancel_order', 'failed_order','order_in_the_warehouse'];
            foreach ($keys as $key) {
                if(in_array($key ,$multi_lang_keys )) {
                    $key_ar = $key."_ar";
                    $key_en = $key."_en";

                    $value_ar = $request->$key_ar;
                    $value_en = $request->$key_en;
                }else {
                    $value_ar = $request->$key;
                    $value_en = $request->$key;
                }

                Setting::where('key', '=', $key)->update([
                    'value_en' => $value_en,
                    'value_ar' => $value_ar
                ]);
            }
            $this->add_action("update_message_setting" ,'message_setting', json_encode([]));
            update_setting_messages();
            return general_response(true, true, trans('admin.success'), "", "", []);
        }
    }
    public function update(Request $request)
    {

        try {
            $rules = [
                'tax' => 'required|numeric|min:0',
                'shipping' => 'required|numeric|min:0',
                'first_order_discount' => 'required|numeric|min:0',
                'cancel_order_time'=>'required|numeric|min:0',

                'phone' => 'required',
                'email' => 'required',

                'facebook' => 'required',
                'twitter' => 'required',
                'snapchat' => 'required',
                'instagram' => 'required',
                'youtube' => 'required',
                'telegram' => 'required',


                'point_price' => 'required|numeric',
                'package_discount_type' => 'required|numeric',

                'failed_order_bank_time' => 'required|numeric',

                'price_tax_in_products' => 'required|in:0,1',
                'price_tax_in_cart' => 'required|in:0,1',

                'return_order_time' => 'required|integer|gte:0',


            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $messages = $validator->errors();
                $get_one_message = get_error_msg($rules, $messages);
                return general_response(false, true, "", $get_one_message, "", []);
            } else {
                $multi_lang_keys = ['checkout_label','place' ,'policy' , 'about' ,'privacy_policy' , 'terms' , 'shipping_and_delivery'];
                
                $keys = ['tax' , 'shipping' , 'first_order_discount','cancel_order_time' , 'phone' , 'email' ,'facebook' ,'twitter' , 'snapchat' ,'instagram' ,
                    'youtube','telegram','place','policy' , 'about' ,'privacy_policy' , 'terms' ,'shipping_and_delivery', 'cash_note' , 'bank_note' , 'visa_note' , 'point_price' ,
                    'package_discount_type' , 'failed_order_bank_time' , 'price_tax_in_products' , 'price_tax_in_cart' ,
                    'product_details_note1' , 'product_details_note2' ,'product_details_note_image', 'return_order_time' , 'checkout_label','note_discount_product_details'];


                foreach ($keys as $key) {
                    if(in_array($key ,$multi_lang_keys )) {

                        $key_ar = $key."_ar";
                        $key_en = $key."_en";

                        $value_ar = $request->$key_ar;
                        $value_en = $request->$key_en;
                    }else {

                        $value_ar = $request->$key;
                        $value_en = $request->$key;

                        if ($key === 'product_details_note_image'){

                            if ($request->hasFile('product_details_note_image')) {

                                $value_ar = (new StoreFile($request->product_details_note_image))->store_local('ads');
                                $value_en = (new StoreFile($request->product_details_note_image))->store_local('ads');
                            } else {


                                $value_ar = $request->product_details_note_image;
                                $value_en = $request->product_details_note_image;
                            }

                        }
                    }

                    Setting::where('key', '=', $key)->update([
                        'value_en' => $value_en,
                        'value_ar' => $value_ar
                    ]);
                }
                ////////////////////////////////////////
                Setting::where('key', '=', 'close_app')->update([
                    'status' => $request->close_app,
                ]);
                Setting::where('key', '=', 'close_website')->update([
                    'status' => $request->close_website,
                    'value_en' => $request->close_website_text,
                    'value_ar' => $request->close_website_text
                ]);
                $this->add_action("update_setting" ,'setting', json_encode([]));
                ////////////////////////////////////////
                update_maintenance_cache_data();
                update_cart_data_cache_in_cache();
                update_setting_messages();
                
                return general_response(true, true, trans('admin.success'), "", "", []);
            }

        } catch (\Exception $e) {
            return general_response(false, true, trans('admin.success'), $e->getMessage(), "", []);

        } catch (\Error $e) {
            return general_response(false, true, trans('admin.success'),$e->getMessage(), "", []);

        }
    }

    /////////////////////
    function contains($str, array $arr)
    {
        foreach ($arr as $a) {
            if (stripos($str, $a)) {
                continue;
            } else {
                return false;
            }
        }
        return true;
    }

}
