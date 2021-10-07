<?php

namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller\Website;
use phpDocumentor\Reflection\Types\Self_;

use App\Http\Controllers\Website\ShopController;

// Repository
use App\Repository\ProductRepository;
use App\Repository\UserRepository;

// Validations
use App\Validations\UserValidation;

// models
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\CartProduct;
use App\Models\ProductAttributeValue;
use App\Models\City;
use App\Models\Order;
use App\User;
use App\Models\Coupon;
use App\Models\Country;


use Illuminate\Support\Facades\Cache;

// Resources
use App\Http\Resources\Product\ProductSimpleResource;
use App\Http\Resources\Product\ProductDetailsResource;
use App\Http\Resources\Product\ProductVariationResource;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

// services
use App\Services\SWWWTreeTraversal;
use App\Services\CartService;

use App\Jobs\DispatchSendEmail;
use DB;
use Illuminate\Support\Facades\Auth;

use LaravelLocalization;

class AuthController extends Controller
{

    public $user;
    public $validation;

    public function __construct(UserRepository $user, UserValidation $validation)
    {
        $this->user = $user;
        $this->validation = $validation;
        parent::__construct();
    }

    public function my_account(Request $request)
    {


        $breadcrumb_arr = [['name' => trans('website.home'), 'url' => "/"]];

        parent::$data['breadcrumb_title'] = trans('website.my_account');
        parent::$data['breadcrumb_arr'] = $breadcrumb_arr;
        parent::$data['breadcrumb_last_item'] = trans('website.my_account');

        parent::$data['menu'] = "myaccount";
        parent::$data['title'] = parent::$data['breadcrumb_title'];


        if (Auth::guard('web')->check()) {
            parent::$data['user'] = $request->user;
            return view('website.my_account.my_account', parent::$data);
        } else {
            return redirect('/sign-in');

        }
    }


    public function login(Request $request)
    {
        $check_data = $this->validation->check_login_data_website($request->toArray());
        if ($check_data['status']) {
            $email = $request->email;
            $password = $request->password;
            if (Auth::attempt(['email' => $email, 'password' => $password])) {
                $user = Auth::guard('web')->user();
                $user->country_id = $request->get_country_data['id'];
                $user->update();
                CartService::copy_products_from_guest_to_user($user, 0, true);
                return general_response(true, true, trans('website.success_login'), "", "", []);
            } else {
                return general_response(false, true, "", trans('website.error_login'), "", []);
            }
        } else {
            return general_response(false, true, "", $check_data['message'], "", []);
        }

    }

    public function register(Request $request)
    {
        $check_data = $this->validation->check_create_data_website($request->toArray());
        if ($check_data['status']) {
            $first_name = $request->first_name;
            $last_name = $request->last_name;

            $email = $request->email;
            $password = $request->password;

            $user = User::create([
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'password' => bcrypt($password),
                'platform' => 'web',
                'package_id' => $this->user->get_default_package(),
//                'country_id' => $request->get_country_data['id']
                'country_id' => 120
            ]);
            $user->shipping_info()->create([
                'user_id' => $user->id,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'code' => $this->user->generate_code(),
                'is_default' => 1,
//                'country' => $request->get_country_data['id'],
                'country' => 120
            ]);
            Auth::guard('web')->login($user);
            CartService::copy_products_from_guest_to_user($user, 0, true);
            return general_response(true, true, trans('website.success_register'), "", "", []);
        } else {
            return general_response(false, true, "", $check_data['message'], "", []);
        }
    }

    public
    function logout()
    {
        Auth::guard('web')->logout();
        return redirect(LaravelLocalization::localizeUrl('my-account'));
    }


    public
    function get_country($request, $country_code)
    {
        if ($country_code) {
            $country = Country::where('iso2', '=', $country_code)->first();

        } else if (!is_null(session()->get('country_code'))) {
            $country = Country::where('iso2', '=', session()->get('country_code'))->first();
        } else {
            $ip_info = ip_info($request->ip());
            try {
                $country_code = $ip_info['country_code'];
                $country = Country::where('iso2', '=', $country_code)->first();

            } catch (\Exception $e) {
                $country = null;
            } catch (\Error $e) {
                $country = null;
            }
        }
        return $country;
    }

    public function sign_in(Request $request)
    {
        $breadcrumb_arr = [['name' => trans('website.home'), 'url' => "/"]];

        parent::$data['breadcrumb_title'] = trans('website.my_account');
        parent::$data['breadcrumb_arr'] = $breadcrumb_arr;
        parent::$data['breadcrumb_last_item'] = trans('website.my_account');

        parent::$data['menu'] = "myaccount";
        parent::$data['title'] = parent::$data['breadcrumb_title'];


        if (Auth::guard('web')->check()) {
            parent::$data['user'] = $request->user;
            return redirect('my-account');
        } else {

            return view('website_v3.auth.login', parent::$data);

        }
    }

    public function sign_up(Request $request)
    {
        $breadcrumb_arr = [['name' => trans('website.home'), 'url' => "/"]];

        parent::$data['breadcrumb_title'] = trans('website.my_account');
        parent::$data['breadcrumb_arr'] = $breadcrumb_arr;
        parent::$data['breadcrumb_last_item'] = trans('website.my_account');

        parent::$data['menu'] = "myaccount";
        parent::$data['title'] = parent::$data['breadcrumb_title'];

        if (Auth::guard('web')->check()) {
            parent::$data['user'] = $request->user;
            return redirect('my-account');
        } else {
            return view('website_v3.auth.register', parent::$data);

        }
    }

}
