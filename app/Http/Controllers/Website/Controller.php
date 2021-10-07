<?php

namespace App\Http\Controllers\Website;

use App\Models\Merchant;
use App\Models\Service;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// models
use App\User;
use App\Models\Category;
use App\Models\UserShipping;
use App\Models\Cart;
use App\Models\Brand;
use App\Models\City;
use App\Models\Setting;
use App\Models\Country;
use App\Models\WebsiteTopBanner;
use App\Models\Order;
use App\Models\Coupon;

// service
use App\Services\CartService;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static $data = [];
    public $cart;

    public function __construct()
    {
        $all_categories = get_all_category_with_parents();

        $brands = Brand::all();
        $merchants = Merchant::all();
        $footer_data = get_social_medial_urls();

        $top_banner = WebsiteTopBanner::first();
        $top_banner = $top_banner && $top_banner->status == 1 ? $top_banner: null;
        $pointer_header_image = $top_banner ? get_pointer_top_banner_url($top_banner) : "";



        $header_note_text_first = WebsiteTopBanner::find(2);
        $header_note_text_first = $header_note_text_first && $header_note_text_first->status == 1 ? $header_note_text_first: null;

        $header_note_text_second = WebsiteTopBanner::find(3);
        $header_note_text_second = $header_note_text_second && $header_note_text_second->status == 1 ? $header_note_text_second: null;


        $countries = Country::Active()->GeneralData()->get();


        self::$data['all_categories'] = $all_categories;
        self::$data['main_categories_shop'] = $all_categories->where('parent', '=', null)->values();
        self::$data['main_categories'] = $all_categories->where('in_website_sidebar' , '=' ,1)
            ->where('parent_website', '=', null)
            ->sortBy('in_website_sidebar_order')
            ->values();

        self::$data['brands'] = $brands;
        self::$data['merchants'] = $merchants;
        self::$data['category_name'] = get_category_lang();
        self::$data['nick_name'] = get_category_nick_lang();


//        self::$data['services'] =json_decode( Service::all(), true);
        self::$data['footer_data'] = $footer_data;

        self::$data['header_image']  = $top_banner ? $top_banner->image : "";
        self::$data['pointer_header_image']  =$pointer_header_image;

        self::$data['header_note_text_first']  = $header_note_text_first;
        self::$data['header_note_text_second'] = $header_note_text_second;


        self::$data['countries'] = $countries;

    }

    public function check_auth() {
        if(!Auth::guard('web')->check()) {
            return [
                'status' => false,
                'message' => trans('website.must_login') ,
                'data' => []
            ];
        }else {
            return [
                'status' => true,
                'message' => trans('website.done') ,
                'data' => []
            ];
        }
    }

    public function get_cart_($request) {

        $user = $request->user;
        $session_id = false;
        $shipping_info = collect((new UserShipping())->empty_shipping());
        if($user) {
            $cart = $user->cart;
        }else {
            $session_id = get_session_key();
            $get_order = Order::where('session_id' , '=' ,$session_id )->latest('created_at')->limit(1)->first();
            if($get_order) {
                $shipping_info = $get_order->order_user_shipping;
            }
            $cart = Cart::CheckSessionId($session_id)->first();
        }
        return [
            'user' => $user ,
            'cart' => $cart ,
            'session_id' => $session_id ,
            'shipping_info' => $user ? $user->shipping_info :$shipping_info ,
            'all_shipping_info' => $user ? $user->all_shipping_info :$shipping_info ,
        ];
    }

    public function get_user_my_account_data($request) {

        $countries = Country::Active()->GeneralData()->get();
        $user = $request->user;
    //    $user = User::find(28);
        $country = $user->country;

        self::$data['user'] = $user;
        self::$data['country_code'] = json_encode($country ? $country->iso2 : "");
        self::$data['country_flag'] = $country ? $country->flag : "";
        self::$data['user_shipping'] = $request->user->shipping_info;
        self::$data['all_user_shipping'] = $request->user->all_shipping_info;
        self::$data['countries'] = $countries;
    }

    public function change_language(Request $request, $lang)
    {
        $langs = get_langs();
        if (in_array($lang, $langs)) {
            $user = Auth::guard('web')->user();
            if ($user) {
                $user->lang = $lang;
                $user->update();
            }

            session()->put('website_lang', $lang);
            app()->setLocale($lang);
        }
        return redirect()->back();

    }

    public function change_country(Request $request, $country_code)
    {

        $user = Auth::guard('web')->user();
        $country = Country::where('iso2', '=', $country_code)->active()->first();

        if ($country) {
            $country_id = $country->id;
            $country_code = $country->iso2;
        } else {
            $country_id = 194;
            $country_code = "SA";
        }


        session()->put('country_code', $country_code);
        if ($user) {
            $user->country_id = $country_id;
            $user->update();
        }
        CartService::update_cart_when_change_country($user ,$country_id , true );
        return redirect()->back();

    }
}
