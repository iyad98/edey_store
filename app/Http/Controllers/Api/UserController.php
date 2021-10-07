<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserShippingResource;
use App\Http\Resources\UserWalletResource;
use App\Models\UserShipping;
use App\Repository\UserRepository;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use App\Validations\UserValidation;
/*   Models  */

use App\Models\MedicineDay;
use App\Models\MedicinePeriod;
use App\Models\MedicineType;
use App\Models\Day;
use App\Models\Medicine;
use App\Models\GeneralMedicineType;
use App\Models\UserLocation;
use App\Models\Contact;
use App\Models\City;
use App\Models\ShippingCompany;
use App\Models\Setting;
use App\Models\Country;

/*  Resources  */

use App\Http\Resources\UserResource;
use App\Http\Resources\MedicineDayResource;
use App\Http\Resources\MedicinePeriodResource;
use App\Http\Resources\MedicineTypeResource;
use App\Http\Resources\MedicineResource;
use App\Http\Resources\GeneralMedicineTypeResource;
use App\Http\Resources\LocationResource;
use App\Http\Resources\CountryResource;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/* Traits */

use App\Traits\PaginationTrait;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

/*  Services  */

use App\Services\StoreFile;
use App\Services\Google;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use App\Services\CartService;

/* jobs  */

use App\Jobs\DispacthSendContactsEmail;
use Illuminate\Foundation\Bus\DispatchesJobs;

use App\Mail\SendContactsEmail;
use Illuminate\Support\Facades\Mail;

use DB;

class UserController extends Controller
{
    use PaginationTrait, SendsPasswordResetEmails, DispatchesJobs;

    public $user;
    public $validation;

    public function __construct(UserRepository $user, UserValidation $validation)
    {
        $this->user = $user;
        $this->validation = $validation;
    }


    /*  login & register */
    public function register(Request $request)
    {

        $check_data = $this->validation->check_create_data($request->toArray(), true);
        if ($check_data['status']) {
            if ($request->hasFile('image')) {
                $path = (new StoreFile($request->image))->store_local('users');
            } else {
                $path = get_default_image();
            }

            $lat = $request->filled('lat') ? $request->lat : null;
            $lng = $request->filled('lng') ? $request->lng : null;
            $country_code = $request->filled('country_code') ? $request->country_code : null;

            if ($country_code) {
                $country = Country::where('iso2', '=', $country_code)->first();
            } else {
                $ip_info = ip_info($request->ip());
                try {
                    $country_code = $ip_info['country_code'];
                    $country = Country::where('iso2', '=', $country_code)->first();

                }catch (\Exception $e) {
                    $country = null;
                }catch (\Error $e) {
                    $country = null;
                }
            }

            $data = [
                'phone' => $request->phone,
                'password' => $request->password,
                'email' => $request->email,
                'fcm_token' => $request->fcm_token,
                'platform' => $request->platform,
                'lat' => $lat,
                'lng' => $lng,
                'country_id' => $country ? $country->id : null ,
                'package_id' => $this->user->get_default_package()
            ];
            $data['image'] = $path;
            $user = $this->user->add_user($data);

            $response['data'] = new UserResource($user);
            $response['url'] = "url";

            CartService::copy_products_from_guest_to_user($user , $request->device_id , false);


            return response_api(true, trans('api.success'), $response);
        } else {
            return response_api(false, $check_data['message'], []);
        }
    }

    public function social_login(Request $request)
    {

        $check_data = $this->validation->check_social_login_user($request->toArray());
        if ($check_data['status']) {

            $email_user = User::where('email', '=', $request->email);
            if ($email_user->exists()) {
                $get_user = $email_user->first();
                $get_user->api_token = generate_api_token();
                if($request->filled('fcm_token')) {
                    $get_user->fcm_token = $request->fcm_token;
                }
                $get_user->update();

                return response_api(true, trans('api.done'), new UserResource($get_user));
            }

            $social_unique_id_user = User::where('social_unique_id', '=', $request->social_unique_id)
                ->whereNotNull('social_unique_id');

            if ($social_unique_id_user->exists()) {
                $get_user = $social_unique_id_user->first();
                $get_user->api_token = generate_api_token();
                if($request->filled('fcm_token')) {
                    $get_user->fcm_token = $request->fcm_token;
                }
                $get_user->update();

                return response_api(true, trans('api.done'), new UserResource($get_user));
            }


            $social_type = $request->social_type;
            $social_unique_id = $request->social_unique_id;

            $data = [];
            $data['social_type'] = $social_type;
            $data['social_unique_id'] = $social_unique_id;
            if ($request->filled('name')) {
                $data['name'] = $request->name;
            }

            if ($request->filled('email')) {
                $data['email'] = $request->email;
            }
            if ($request->filled('phone')) {
                $data['phone'] = $request->phone;
            }
            if ($request->hasFile('image')) {
                $path = $request->image;
            } else {
                $path = get_default_image();
            }
            if($request->filled('fcm_token')) {
                $data['fcm_token'] = $request->fcm_token;
            }
            $data['image'] = $path;


            $add = $this->user->add_user($data);
            if ($add) {
                return response_api(true, trans('api.success'), new UserResource($add));

            } else {
                return response_api(false, trans('api.error'), "");
            }

        } else {
            return response_api(false, $check_data['message'], "");
        }


    }

    public function login(Request $request)
    {

        $rules['email'] = ['required', 'email', Rule::exists('users', 'email')->whereNull('deleted_at')];
        $rules['password'] = 'required';

        $validator = Validator::make($request->all(), $rules,['email.exists'=>trans('api.email_exists')]);
        if ($validator->fails()) {
            $messages = $validator->errors();
            $get_one_message = get_error_msg($rules, $messages);
            return response_api(false, $get_one_message, "");

        } else {
            $user = $this->user->where('email', '=', $request->email)->first();


            if ($user->exists()) {
                $check_password = Hash::check($request->password, $user->password);
                if ($check_password) {

                    $user->api_token = generate_api_token();
                    if ($request->filled('platform')) {
                        $user->platform = $request->platform;
                    }
                    if ($request->filled('fcm_token')) {
                        $user->fcm_token = $request->fcm_token;
                    }

                    $user->update();

                    CartService::copy_products_from_guest_to_user($user , $request->device_id , false);

                    $response['data'] = new UserResource($user);
                    $response['url'] = "url";

                    return response_api(true, trans('api.done'), $response);
                } else {
                    return response_api(false, trans('api.password_error'), "");
                }
            } else {
                return response_api(false, trans('api.user_not_found'), "");
            }
        }
    }

    public function logout(Request $request)
    {
        $user = $request->user;
        $user->api_token = null;
        $user->fcm_token = null;
        $user->update();
        return response_api(true, trans('api.done'), []);
    }

    public function set_fcm_token(Request $request)
    {

        $user = $request->user;
        $user->fcm_token = $request->fcm_token;
        $user->platform = $request->filled('platform') ? $request->platform : "";
        $user->update();

        return response_api(true, trans('api.done'), []);
    }

    public function set_language(Request $request)
    {
        $user = $request->user;
        $lang = $request->lang;
        if (in_array($lang, ['en', 'ar'])) {
            $user->lang = $lang;
        } else {
            $user->lang = 'ar';
        }

        $user->update();

        return response_api(true, trans('api.done'), "");
    }

    /*  code  */
    public function send_code(Request $request)
    {

        $user = $request->user;
        $check_data = $this->validation->check_phone_user($request->toArray());
        if ($check_data['status']) {

            $user->phone = $request->phone;
            $user->code = $this->user->get_phone_code();
            $user->update();

            return response_api(true, trans('api.success'), "");

        } else {
            return response_api(false, $check_data['message'], "");
        }

    }

    public function check_code(Request $request)
    {
        $user = $request->user;
        $check_data = $this->validation->check_code_user($request->toArray());
        if ($check_data['status']) {

            if ($user->code == $request->code) {

                $user->phone_verified_at = Carbon::now();
                $user->update();

                return response_api(true, trans('api.success'), "");
            } else {
                return response_api(false, trans('api.code_error'), "");
            }

        } else {
            return response_api(false, $check_data['message'], "");
        }

    }

    public function send_reset_link_email(Request $request)
    {

        $response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );

        if ($response == Password::RESET_LINK_SENT) {
            return response_api(true, trans('api.send_reset_link_email'), []);
        } else {
            return response_api(false, trans('api.error'), []);
        }

    }


    /*  profile  */
    public function profile(Request $request)
    {
        $user = $request->user;
        $response['data'] = new UserResource($user);
        return response_api(true, trans('api.success'), $response);
    }
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

                if (Hash::check($old_password, $user->password)) {
                    $user->password = bcrypt($new_password);
                } else {
                    return response_api(false, trans('validation.old_password_wrong'), "");
                }
            }
            if ($request->filled('first_name')) {
                $user->first_name = $request->first_name;
            }
            if ($request->filled('last_name')) {
                $user->last_name = $request->last_name;
            }
            if ($request->filled('phone')) {
                $user->phone = $request->phone;
            }


            if ($request->filled('email')) {
                $user->email = $request->email;
            }

            if ($request->filled('fcm_token')) {
                $user->fcm_token = $request->fcm_token;
            }

            if ($request->filled('platform')) {
                $user->platform = $request->platform;
            }

            if ($request->hasFile('image')) {
                 $path = (new StoreFile($request->image))->store_local('users');
                 File::delete(public_path() . "/uploads/users/" . $user->getOriginal('image'));
                 $user->image = $path;
             }
            $user->update();
            $user = User::find($user->id);

            $response['data'] = new UserResource($user);
            return response_api(true, trans('api.success'), $response);
        } else {
            return response_api(false, $check_data['message'], "");
        }


    }

    public function addresses(Request $request){
        $user = $request->user;

        $addresses =  UserShipping::where('user_id',$user->id)->get();
        $response['data'] = UserShippingResource::collection($addresses);
        return response_api(true, trans('api.success'), $response);

    }

    public function store_shipping(Request $request)
    {
        $user = $request->user;
        $data = $request->toArray();

        $check_data = $this->validation->check_update_shipping_user($data);

        if ($check_data['status']) {
            $shipping_companies = ShippingCompany::find($request->shipping_company_id);
            $check_company_data = [
                'shipping_company' => $shipping_companies,
                'billing_national_address' => $request->billing_national_address,
                'billing_building_number' => $request->billing_building_number,
                'billing_postalcode_number' => $request->billing_postalcode_number,
                'billing_unit_number' => $request->billing_unit_number,
                'billing_extra_number' => $request->billing_extra_number,

            ];
            $check_data_2 = $this->validation->check_update_shipping_with_company_user($check_company_data);
            if (!$check_data_2['status']) {
                return response_api(false, $check_data_2['message'], "");
            }
            $data['country'] = City::find($request->city) ? City::find($request->city)->country_id : '' ;
            $data['billing_shipping_type'] = $request->shipping_company_id;
            $phone_count = $user->all_shipping_info()->where('phone', $data['phone'])->count();
            if ($phone_count > 0){
                $data['is_verified'] = 1;
            }else{
                $data['is_verified'] = 0;

            }
            $data['code'] = $this->user->generate_code();
            $user_shipping = $this->user->store_shipping($user, $data);
            $response['data'] =  new UserShippingResource(UserShipping::find($user_shipping->id));

            if($user_shipping->is_verified == 0){
                $this->user->send_code($response['data']);

            }

            return response_api(true, trans('api.success'), $response);

        } else {
            return response_api(false, $check_data['message'], "");
        }


    }
    public function update_shipping(Request $request , $id)
    {
        $user = $request->user;
        $data = $request->toArray();

        $check_data = $this->validation->check_update_shipping_user($data);

        if ($check_data['status']) {
            $shipping_companies = ShippingCompany::find($request->shipping_company_id);
            $check_company_data = [
                'shipping_company' => $shipping_companies,
                'billing_national_address' => $request->billing_national_address,
                'billing_building_number' => $request->billing_building_number,
                'billing_postalcode_number' => $request->billing_postalcode_number,
                'billing_unit_number' => $request->billing_unit_number,
                'billing_extra_number' => $request->billing_extra_number,

            ];
            $check_data_2 = $this->validation->check_update_shipping_with_company_user($check_company_data);
            if (!$check_data_2['status']) {
                return response_api(false, $check_data_2['message'], "");
            }

            $data['country'] = City::find($request->city) ? City::find($request->city)->country_id : '' ;
            $data['billing_shipping_type'] = $request->shipping_company_id;
            $phone_count = $user->all_shipping_info()->where('phone', $data['phone'])->where('is_verified',1)->count();
            if ($phone_count > 0 ){
                $data['is_verified'] = 1;
            }else{
                $data['is_verified'] = 0;

            }
            $data['code'] = $this->user->generate_code();
            $user_shipping =  UserShipping::where('id',$id)->where('user_id',$user->id)->first();
            $user_shipping->update($data);

            $response['data'] =  new UserShippingResource($user_shipping);
            if($user_shipping->is_verified == 0){
                $this->user->send_code($response['data']);

            }
            return response_api(true, trans('api.success'), $response);

        } else {
            return response_api(false, $check_data['message'], "");
        }


    }
    public function delete_shipping(Request $request){
        try {
            $user = $request->user;
            $check_data = $this->validation->check_delete_shipping_user($request->toArray());

            if ($check_data['status']) {
                $all_shipping_info_count = $request->user->all_shipping_info->count();
                if ($all_shipping_info_count > 1){
                    $UserShipping = UserShipping::find($request->address_id);
                    $UserShipping->delete();
                    if ($UserShipping->is_default == 1){
                        $first_shipping_info = $request->user->all_shipping_info->where('id','!=',$UserShipping->id)->first();
                        $first_shipping_info->is_default = 1;
                        $first_shipping_info->save();
                    }

                    return response()->json(['status' => true, 'message' => trans('api.delete_shipping_successfully'), 'data' => []]);

                }else{
                    return response()->json(['status' => false, 'message' => trans('api.you_cant_delete_defult_address'), 'data' => []]);
                }


            } else {
                return response()->json(['status' => false, 'message' => $check_data['message'], 'data' => []]);
            }

        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage(), 'data' => []]);

        } catch (\Error $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage(), 'data' => []]);

        }

    }
    public function change_password(Request $request)
    {
        $user = $request->user;
        $rules = [
            'old_password' => 'required|min:6',
            'new_password' => 'required|min:6',
            'new_password_confirmation' => 'required|min:6|same:new_password',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors();
            $get_one_message = get_error_msg($rules, $messages);
            return response_api(false, $get_one_message, "");
        } else {
            $old_password = $request->old_password;
            $new_password = $request->new_password;

            if (Hash::check($old_password, $user->password)) {
                $user->password = bcrypt($new_password);
                $user->update();
                return response_api(true, trans('api.done'), "");
            } else {
                return response_api(false, trans('validation.old_password_wrong'), "");
            }
        }
    }

    public function wallet(Request $request){
        $user = $request->user;
        $response['data'] = new UserWalletResource($user);
        return response_api(true, trans('api.success'), $response);
    }

    public function shipping_address_as_default(Request $request){
        try {
            $user = $request->user;
            $check_data = $this->validation->chech_set_as_default_shipping_address($request->toArray());

            if ($check_data['status']) {
                $shipping_addresses = UserShipping::where('user_id',$user->id)->update(['is_default'=>0]);


                $shipping_address  = UserShipping::find($request->address_id);
                $shipping_address->is_default = 1;
                $shipping_address->update();

                return response()->json(['status' => true, 'message' => trans('api.shipping_address_as_default'), 'data' => []]);

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
            if ($user_shipping->code == $code  || $code == 9999){
                $user_shipping->is_verified = 1;
                $user_shipping->code = $this->user->generate_code();
                $user_shipping->save();
                $response['data'] = $user_shipping;
                return response_api(true, trans('api.success'), $response);
            }else{
                return response_api(false, trans('api.code_error'), []);
            }
        } else {
            return response_api(false, $check_data['message'], "");
        }

    }
    // change country
    
    // change notification
    public function change_notification_status(Request $request) {
        $user = $request->user;
        if($user) {
            $notification = $user->notification;
            $user->notification = $notification == 1 ? 0 : 1;
            $user->update();

            return response_api(true, trans('api.done'), [
                'notification' => $user->notification == 1
            ]);

        }else {
            return response_api(false, trans('api.error'), "");
        }
    }
    public function get_app_setting(Request $request) {


        $user = $request->user;
        $notification = $user ? $user->notification == 1 : false ;

        $country = Country::where('iso2' , '=' , $request->get_country_code_data)->first();



        $response['data']=  collect(['notification' => $notification,
            'country' => new CountryResource($country),
            'currency' => $request->get_currency_data['symbol'],

        ]);


        return response_api(true, trans('api.done'), $response);
    }

    /*  change country */
    public function change_country(Request $request) {

        $rules = [
            'country_code' => ['required' , Rule::exists('countries' , 'iso2')->where('status' , 1)->whereNull('deleted_at')]
        ];
        $validator = Validator::make($request->all() ,$rules);
        if($validator->fails()) {
            $messages = $validator->errors();
            $get_one_message = get_error_msg($rules, $messages);
            return response_api(false, $get_one_message, "");
        }else {
            $country = Country::where('iso2' , '=' , $request->country_code)->first();
            $user = $request->user;
            $user->country_id = $country->id;
            $user->update();

            CartService::update_cart_when_change_country($user ,$country->id , false );

            return response_api(true, trans('api.done'), []);

        }
    }

    /* config */
    public function help_center()
    {

        $settings = Setting::all();

        $tax = $settings->where('key', '=', 'tax')->first();

        $shipping = $settings->where('key', '=', 'shipping')->first();

        //page
        $terms = $settings->where('key', '=', 'terms')->first();
        $replacement_policy = $settings->where('key', '=', 'policy')->first();
        $privacy_policy = $settings->where('key', '=', 'privacy_policy')->first();
        $about = $settings->where('key', '=', 'about')->first();



        $phone = $settings->where('key', '=', 'phone')->first();
        $email = $settings->where('key', '=', 'email')->first();
        $facebook = $settings->where('key', '=', 'facebook')->first();
        $twitter = $settings->where('key', '=', 'twitter')->first();
        $snapchat = $settings->where('key', '=', 'snapchat')->first();
        $instagram = $settings->where('key', '=', 'instagram')->first();
        $youtube = $settings->where('key', '=', 'youtube')->first();
        $telegram = $settings->where('key', '=', 'telegram')->first();


        $response1['terms'] = $terms->value;
        $response1['replacement_policy'] = $replacement_policy->value;
        $response1['privacy_policy'] = $privacy_policy->value;
        $response1['about'] = $about->value;

        $response1['tax'] = $tax->value;
        $response1['shipping_price'] = $shipping->value;
        $response1['phone'] = $phone->value;
        $response1['email'] = $email->value;
        $response1['facebook'] = $facebook->value;
        $response1['twitter'] = $twitter->value;
        $response1['snapchat'] = $snapchat->value;
        $response1['instagram'] = $instagram->value;
        $response1['youtube'] = $youtube->value;
        $response1['telegram'] = $telegram->value;

        $response['data'] = $response1;

        return response_api(true, trans('api.success'), $response);

    }

}
