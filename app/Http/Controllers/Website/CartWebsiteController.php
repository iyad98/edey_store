<?php

namespace App\Http\Controllers\Website;

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
use App\Models\ShippingCompanyCity;

use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Api\CartController;
// Resources
use App\Http\Resources\Product\ProductSimpleResource;
use Illuminate\Support\Facades\Input;

// services
use App\Services\SWWWTreeTraversal;
use Illuminate\Support\Facades\Auth;
use App\Services\CouponService;

use DB;
/*  validations */

use App\Validations\OrderValidation;
use App\Validations\UserValidation;

use Carbon\Carbon;
use Illuminate\Support\Str;

class CartWebsiteController extends Controller
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

        parent::__construct();
    }

    public function index(Request $request)
    {
        $breadcrumb_arr = [['name' => trans('website.home'), 'url' => "/"] , ['name' => trans('website.cart'), 'url' => url('cart')]];

        parent::$data['breadcrumb_title'] = trans('website.cart');
        parent::$data['breadcrumb_arr'] = $breadcrumb_arr;
        parent::$data['breadcrumb_last_item'] = trans('website.cart');
        parent::$data['title'] = parent::$data['breadcrumb_title'];

        parent::$data['menu'] = 'cart';

        $get_cart_ = $this->get_cart_($request);
        $cart = $get_cart_['cart'];

        $coupon_code = "";
        if ($cart && $cart->coupon_code) {
            $coupon_code = $cart ? $cart->coupon_code : "";
        }

        parent::$data['coupon_code'] = $coupon_code;

        return view('website_v3.profile.cart', parent::$data);
    }

    public function add_or_update_product_to_cart(Request $request)
    {
        /*
        $check_user = $this->check_auth();
        if (!$check_user['status']) {
            return response()->json($check_user);
        }
        */

        $user = $request->user;
        $session_id = is_null($user) ?  get_session_key() : null;

        $request->request->add(['user' => $user , 'session_id' => $session_id]);
        $response =  $this->cart_controller->add_or_update_product_to_cart($request);
        return json_decode(collect($response) , true);

    }

    public function update_cart_quantity(Request $request)
    {

        $cart_products = json_decode($request->get_data);

        $get_cart_products = CartProduct::with('product_variation')->whereIn('id', collect($cart_products)->pluck('cart_product_id'))->get();


        $get_cart_ = $this->get_cart_($request);
        $cart = $get_cart_['cart'];
        $session_id = $get_cart_['session_id'];
        $user = $get_cart_['user'];

        $coupon_code = $cart && $cart->coupon_code ? $cart->coupon_code : "";


        foreach ($cart_products as $cart_product) {

            $cart_product_ = $get_cart_products->where('id', $cart_product->cart_product_id)->first();
            if ($cart_product_->product_variation->stock_quantity < $cart_product->quantity) {
                $quantity = $cart_product_->product_variation->stock_quantity;
            } else {
                $quantity = $cart_product->quantity > 0 ? $cart_product->quantity : 1;
                $quantity = $cart_product->quantity > 0  && $cart_product_->product_variation && $cart_product_->product_variation->min_quantity <= $quantity ? $quantity : ($cart_product_->product_variation ? $cart_product_->product_variation->min_quantity : 1);
            }
            $cart_product_->quantity = $quantity;
            $cart_product_->update();
        }
        $request->request->add(['coupon_code' => $coupon_code , 'session_id' =>$session_id ]);
        return $this->get_all_cart_data($request);
    }

    public function remove_product_from_cart(Request $request, $cart_product_id)
    {
        $get_cart_ = $this->get_cart_($request);
        $cart = $get_cart_['cart'];
        $session_id = $get_cart_['session_id'];
        $user = $get_cart_['user'];

        $coupon_code = $cart && $cart->coupon_code ? $cart->coupon_code : "";

        CartProduct::where('id', '=', $cart_product_id)->delete();
        $response['message'] = trans('api.removed_product_from_cart');

        $request->request->add(['coupon_code' => $coupon_code , 'session_id' =>$session_id ]);
        $response['cart_data'] = $this->get_all_cart_data($request);
        return $response;
    }

    public function get_cart_data(Request $request)
    {
        $get_cart_ = $this->get_cart_($request);
        $cart = $get_cart_['cart'];
        $session_id = $get_cart_['session_id'];
        $user = $get_cart_['user'];


        $coupon_code = "";
        if ($cart && $cart->coupon_code) {
            $coupon_code = $cart ? $cart->coupon_code : "";
        }
        $request->request->add(['coupon_code' => $coupon_code , 'session_id' => $session_id]);
        $cart_data = $this->cart->get_user_cart_products($request);
        $response['total_price'] = $cart_data['total_price'];
        $response['count_products'] = $cart_data['count_products'];
        $response['count_quantity'] = $cart_data['count_quantity'];
        $response['count_favorites'] = $user && $user->favorites() ? $user->favorites()->count() : 0;
        $response['currency'] = $cart_data['currency'];
        $response['cart_data'] = $cart_data;

        return response()->json($response);

    }
    public function get_cart_data_count(Request $request){
        $get_cart_ = $this->get_cart_($request);
        $cart = $get_cart_['cart'];
        $session_id = $get_cart_['session_id'];
        $user = $get_cart_['user'];



        $request->request->add([ 'session_id' => $session_id]);
        $cart_data = $this->cart->get_user_cart_products($request);
        $response['total_price'] = $cart_data['total_price'];
        $response['count_products'] = $cart_data['count_products'];
        $response['count_quantity'] = $cart_data['count_quantity'];
        $response['count_favorites'] = $user && $user->favorites() ? $user->favorites()->count() : 0;
        $response['currency'] = $cart_data['currency'];
    }

    public function apply_coupon(Request $request)
    {

        $user = $request->user;
        $coupon_code = $request->coupon_code;
        $session_id = get_session_key();
        if($user) {
            $cart = $user->cart;
        }else {
            $cart = Cart::where('session_id' , '=' , $session_id)->first();
        }

        $request->request->add([ 'session_id' => $session_id]);
        $cart_data = $this->cart->get_user_cart_products($request);
        $check_coupon = CouponService::check_coupon($user , $coupon_code ,$cart_data );

        if(!$check_coupon['status']) {
            $cart->coupon_code = null;
            $cart->update();

            return response()->json([
                'status' => $check_coupon['status'],
                'message' => $check_coupon['message'],
                'data' => $cart_data
            ]);

        }else{
            $cart->coupon_code = $coupon_code;
            $cart->update();
        }


        $shipping_company = ShippingCompany::find($request->company_id);
        $city = City::find($request->city_id);
        $payment_method = $request->payment_method;

        if($shipping_company && $payment_method && $city) {

            $shipping_company_city = ShippingCompanyCity::InCompanyAndCity($shipping_company , $city)->first();

            $request->request->add([
                'is_bill' => true,
                'shipping_company' => $shipping_company,
                'shipping_company_city' => $shipping_company_city ,
                'cash_value' => $payment_method == "cash" && $shipping_company_city->cash == 1 ? true : false
            ]);
        }
        $cart_data = $this->cart->get_user_cart_products($request);
        if($cart_data['coupon']['id'] == -1) {
            return response()->json([
                'status' => false,
                'message' => trans('api.coupon_not_condition'),
                'data' => $cart_data
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => trans('api.coupon_used_success'),
            'data' => $cart_data
        ]);


    }

    public function get_all_cart_data(Request $request)
    {

        $get_cart_ = $this->get_cart_($request);
        $session_id = $get_cart_['session_id'];

        $request->request->add([ 'session_id' => $session_id]);
        $cart_data = $this->cart->get_user_cart_products($request);
        return $cart_data;

    }


}
