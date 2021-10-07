<?php

namespace App\Http\Controllers\Website;

use App\Http\Resources\Product\ProductsCategoryResource;
use App\Http\Resources\Product\ProductsFavoritesResource;
use App\Models\Compare;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller\Website;
use phpDocumentor\Reflection\Types\Self_;

use App\Http\Controllers\Website\ShopController;

// Repository
use App\Repository\ProductRepository;

// models
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\CartProduct;
use App\Models\ProductAttributeValue;

use Illuminate\Support\Facades\Cache;

// Resources
use App\Http\Resources\Product\ProductSimpleResource;
use App\Http\Resources\Product\ProductDetailsResource;
use App\Http\Resources\Product\ProductVariationResource;


use Illuminate\Support\Facades\Input;

// services
use App\Services\SWWWTreeTraversal;
use Illuminate\Support\Facades\Auth;

use DB;

class ProductController extends Controller
{


    public $Product;
    public $shop_controller;

    public function __construct(ProductRepository $Product)
    {
        $this->product = $Product;
        $this->shop_controller = new ShopController($Product);
        parent::__construct();
    }

    public function product_details(Request $request, $id)
    {

        $user = Auth::guard('web')->user();

        $breadcrumb_arr = [];
        $breadcrumb_arr = array_slice($breadcrumb_arr, 0, count($breadcrumb_arr) - 1, true);
        array_unshift($breadcrumb_arr, ['name' => trans('website.store'), 'url' => "/shop"]);
        array_unshift($breadcrumb_arr, ['name' => trans('website.home'), 'url' => "/"]);

        $user_id = $user ? $user->id : -1;
        $cart_product_id = $request->filled('cart_product_id') ? $request->cart_product_id : -1;

        $product = $this->product
            ->GetGeneralDataProduct($user_id)
            ->with(['brand','merchant', 'tax_status','categories', 'variation.images', 'variation.cart_products',
                'variation' => function ($query) use ($user_id) {
                    $query->GetGeneralDataProduct($user_id);
                },
                'attributes.attribute.attribute_type', 'attributes.attribute_values.attribute_value.attribute.attribute_type'])
            ->find($id);

        if (!$product) {
            abort(404);
        }
        $product_categories = $product->categories;
        $cart_product = CartProduct::find($cart_product_id);
        $product_id = $product->id;

        $attribute_values = [];

        if ($cart_product) {
            $product_variation = ProductVariation::where('id', '=', $cart_product->product_variation_id)
                ->where('product_id', '=', $product_id)->first();

            $attribute_values = explode("-", $cart_product->key);

        } else if (!$cart_product || count($attribute_values) <= 0) {
            $attribute_values = ProductAttributeValue::whereHas('attribute_product', function ($query) use ($product_id) {
                $query->where('product_id', '=', $product_id);
            })->where('is_selected', '=', 1)
                ->pluck('attribute_value_id')
                ->toArray();
        }

        $this->product->get_product_details_note($request);
        $request->request->add(['attribute_values' => $attribute_values]);
        $product->attribute_values = $attribute_values;


        $product_details_note1 = Setting::where('key', 'product_details_note1')->first();
        $product_details_note2 = Setting::where('key', 'product_details_note2')->first();
        $product_details_note_image = Setting::where('key', 'product_details_note_image')->first();

        $get_product = new ProductDetailsResource($product);
        ////////////////// similar product /////////////////////////
        $similar_products = $this->product->related_products($product, $user_id);
        $similar_products = ProductSimpleResource::collection($similar_products);

        $marketing_products = $this->product->marketing_products($product, $user_id);
        $marketing_products = ProductSimpleResource::collection($marketing_products);

        $sub_products = ProductDetailsResource::collection($product->sub_products);
        ////////////////////////////////////////////
        parent::$data['product_categories'] = $product_categories;
        parent::$data['get_product'] = json_encode(json_decode(collect($get_product), true));
        parent::$data['similar_products'] = json_decode(collect($similar_products), true);
        parent::$data['marketing_products'] = json_decode(collect($marketing_products), true);
        parent::$data['sub_products'] = collect($sub_products);

        parent::$data['cart_product_id'] = $cart_product_id;
        parent::$data['guide_images'] = $product_categories->pluck('guide_image')->toArray();

        parent::$data['breadcrumb_title'] = $get_product->name;
        parent::$data['breadcrumb_arr'] = $breadcrumb_arr;
        parent::$data['breadcrumb_last_item'] = $get_product->name;

        parent::$data['product_details_note1'] = $product_details_note1->value;
        parent::$data['product_details_note2'] = $product_details_note2->value;
        parent::$data['product_details_note_image'] = add_full_path($product_details_note_image->value, 'ads');
//return parent::$data;
        parent::$data['title'] = parent::$data['breadcrumb_title'];


        return view('website_v3.shop.product_details', parent::$data);
    }

    public function get_product_variations(Request $request)
    {
        $user = Auth::guard('web')->user();
        $user_id = $user ? $user->id : -1;

        $product_id = $request->product_id;
        $attribute_values = $request->filled('attribute_values') ? $request->attribute_values : [];

        $key = $this->product->get_key_product($product_id, $attribute_values);

        if ($key == '*') {
            $product_variation = ProductVariation::GetGeneralDataProduct($user_id)
                ->where('product_id', '=', $product_id)
                ->with('stock_status', 'images')
                ->where('is_default_select', '=', 1)->first();
        } else {
            $product_variation = ProductVariation::GetGeneralDataProduct($user_id)
                ->where('product_id', '=', $product_id)
                ->with('stock_status', 'images')
                ->where('key', '=', $key)->first();
        }


        if (!$product_variation) {
            return response_api(false, trans('api.product_not_found'), []);
        }
        $response['data'] = new ProductVariationResource($product_variation);
        return response_api(true, trans('api.success'), $response);
    }

    // wishlist
    public function add_to_wishlist(Request $request)
    {
        $product_id = $request->product_id;
        $user = Auth::guard('web')->user();

        if ($user) {
            if (!$user->favorites()->where('product_id', '=', $product_id)->exists()) {
                $user->favorites()->syncWithoutDetaching($product_id);
            }
            return general_response(true, true, trans('api.added_to_favorite'), "", "", [
                'count_favorites' => $user->favorites()->count()
            ]);

        } else {
            return general_response(false, true, "", trans('website.must_login'), "", []);

        }

    }

    public function remove_from_wishlist(Request $request)
    {

        $product_id = $request->product_id;
        $user = Auth::guard('web')->user();

        if ($user) {
            if ($user->favorites()->where('product_id', '=', $product_id)->exists()) {
                $user->favorites()->where('product_id', '=', $product_id)->exists();
                $user->favorites()->detach($product_id);

                return general_response(true, true, trans('api.remove_from_favorite'), "", "", [
                    'count_favorites' => $user->favorites()->count()
                ]);
            }


        } else {
            return general_response(false, true, "", trans('website.must_login'), "", []);

        }

    }

    public function wishlist(Request $request)
    {

        $user = Auth::guard('web')->user();

        $breadcrumb_arr = [['name' => trans('website.home'), 'url' => "/"]];
        if (!$user) {
            $breadcrumb_arr = [['name' => trans('website.home'), 'url' => "/"]];

            parent::$data['breadcrumb_title'] = trans('website.my_account');
            parent::$data['breadcrumb_arr'] = $breadcrumb_arr;
            parent::$data['breadcrumb_last_item'] = trans('website.my_account');
            parent::$data['title'] = parent::$data['breadcrumb_title'];

            return view('website_v2.auth.login', parent::$data);
        }
        $user_id = $user->id;

        $products = $user->favorites()
            ->GetGeneralDataProduct($user_id)
            ->paginate(10);


        $get_products = ProductSimpleResource::collection($products);
        $excepts = except_data_from_product();
        $excepts[] = 'user';

        parent::$data['breadcrumb_title'] = trans('website.wishlist');
        parent::$data['breadcrumb_arr'] = $breadcrumb_arr;
        parent::$data['breadcrumb_last_item'] = trans('website.wishlist');


        parent::$data['products'] = json_decode(collect($get_products), true);
//        parent::$data['links'] = $products->appends(Input::except($excepts))->links();
        parent::$data['title'] = parent::$data['breadcrumb_title'];

        parent::$data['menu'] = 'wishlist';
        return view('website_v3.profile.favorite', parent::$data);

    }

    public function add_compare_products(Request $request)
    {
        $user = $request->user;
        $session_id = is_null($user) ? get_session_key() : null;
        if (is_null($user)) {
            $request->request->add(['session_id' => $session_id]);

        } else {
            $request->request->add(['user_id' => $user->id]);
        }

        $check_data = $this->product->check_add_product_to_compare($request);
        if ($check_data['status']) {
            Compare::create($request->all());

            return general_response(true, true, trans('api.added_to_compare'), "", "", [

            ]);
        }
        return general_response(false, true, trans('api.not_added_to_compare'), "", "", [

        ]);


    }

    public function compare_products(Request $request)
    {
        $user = $request->user;
        $user_id = $user ? $user->id : -1;
        $session_id = is_null($user) ? get_session_key() : null;

        if (is_null($user)) {
            $first_product = Compare::where('session_id', $session_id)->skip(1)->orderBy('created_at', 'desc')->first();
            $first_product_id = $first_product ? $first_product->product_id : 0;
            $second_product = Compare::where('session_id', $session_id)->orderBy('created_at', 'desc')->first();
            $second_product_id = $second_product ? $second_product->product_id : 0;

        } else {
            $first_product = Compare::where('user_id', $user->id)->skip(1)->orderBy('created_at', 'desc')->first();
            $first_product_id = $first_product ? $first_product->product_id : 0;
            $second_product = Compare::where('user_id', $user->id)->orderBy('created_at', 'desc')->first();
            $second_product_id = $second_product ? $second_product->product_id : 0;
        }


        $first_product = $this->product->get_product_details($first_product_id, $user_id);
        $second_product = $this->product->get_product_details($second_product_id, $user_id);

        if (!$first_product || !$second_product) {
            return view('website_v2.shop.compare_not_allow', parent::$data);
        }
        $attribute_values = [];
        $request->request->add(['attribute_values' => $attribute_values]);
        $first_product->attribute_values = $attribute_values;
        $first_product->share_url = url('products') . "/" . $first_product->id;

        $second_product->attribute_values = $attribute_values;
        $second_product->share_url = url('products') . "/" . $second_product->id;

        parent::$data['first_product'] = $first_product;
        parent::$data['second_product'] = $second_product;
        return view('website_v2.shop.compare', parent::$data);
    }


}
