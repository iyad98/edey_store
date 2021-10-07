<?php
/**
 * Created by PhpStorm.
 * User: HP15
 * Date: 9/8/2019
 * Time: 11:29 م
 */

namespace App\Repository;

use App\Models\Day;
use App\Models\WebsiteTopBanner;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/*  Repository */

use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use App\Repository\StatisticRepository;
/* Resource */

use App\Http\Resources\CategoryResource;
use App\Http\Resources\BrandResource;
use App\Http\Resources\CategoryResourceDFT;
use App\Http\Resources\SliderResource;

use App\Http\Resources\Product\ProductsCategoryResource;
// services
use App\Services\SWWWTreeTraversal;

// models
use App\Models\Brand;
use App\Models\Slider;
use App\Models\Category;
use App\Models\Advertisement;
use App\Models\Order;
use App\Models\Product;
use App\Models\AppHome;
use App\Models\WebsiteHome;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class HomeRepository
{

    public function get_website_home_data($request) {


        $StatisticRepository = new StatisticRepository(new Order());
        $app_home_latest_most_sales = WebsiteHome::whereIn('type', [5, 6])->get();

        $user = $request->user;
        $user_id = $user ? $user->id : -1;

        if ($request->get_country_data) {
            $country = $request->get_country_data;
        } else {
            $country = null;
        }
        $country_id = $country ? $country->id : null;


        $ads_category = Slider::Active()->whereNotNull('parent_id')->whereHas('parent', function ($q) {
            $q->Active();
        })->with(['category', 'product'])->get();

        $brands = BrandResource::collection(Brand::all());
        $coupons = $StatisticRepository->show_coupon_in_home();

         $cat_slider = get_website_home_data_without_cache($request ,$user , $country_id);
        $cat_slider = $this->contact_latest_most_sales_products($app_home_latest_most_sales , $user_id , $cat_slider);

        $sliders['main_slider'] = json_decode(json_encode(SliderResource::collection($ads_category)) , true);
        $sliders['category_slider'] = collect($cat_slider)->sortBy('order')->values();
        $sliders['brands_slider'] = $brands;
        $sliders['coupons'] = json_decode($coupons, true);
        $response['data'] = $sliders;
        return $response;
    }


    public function get_app_home_data($request) {

        $StatisticRepository = new StatisticRepository(new Order());
        $app_home_latest_most_sales = AppHome::whereIn('type', [5, 6])->get();

        $user = $request->user;
        $user_id = $user ? $user->id : -1;

        if ($request->get_country_data) {
            $country = $request->get_country_data;
        } else {
            $country = null;
        }
        $country_id = $country ? $country->id : null;





        $ads_category = Slider::Active()->whereNotNull('parent_id')->whereHas('parent', function ($q) {
            $q->Active();
        })->with(['category', 'product'])->get();

        $brands = BrandResource::collection(Brand::all());
        $coupons = $StatisticRepository->show_coupon_in_home();

        $cat_slider = get_app_home_data_without_cache($request ,$user , $country_id);
        $cat_slider = $this->contact_latest_most_sales_products($app_home_latest_most_sales , $user_id , $cat_slider);


        $sliders['main_slider'] = SliderResource::collection($ads_category);
        $sliders['category_slider'] = collect($cat_slider)->sortBy('order')->values();
        $sliders['brands_slider'] = $brands;
        $sliders['coupons'] = json_decode($coupons, true);


        $response['data'] = $sliders;




        return $response;
    }

    public function get_home_data(Request $request)
    {

        $StatisticRepository = new StatisticRepository(new Order());
        $app_home_latest_most_sales = AppHome::whereIn('type', [5, 6])->get();

        $user = $request->user;
        $user_id = $user ? $user->id : -1;

        $ads_category = Slider::Active()->whereNotNull('parent_id')->whereHas('parent', function ($q) {
            $q->Active();
        })->with(['category', 'product'])->get();

        $brands = BrandResource::collection(Brand::all());
        $coupons = $StatisticRepository->show_coupon_in_home();


        $app_home_latest = $app_home_latest_most_sales->where('type', '=', 5)->first();
        $app_home_most_sales = $app_home_latest_most_sales->where('type', '=', 6)->first();

        $cat_slider = set_favorite_in_cart_in_app_home_data($request, $user);

        if ($app_home_latest) {
            $latest_products = Product::GetGeneralDataProduct($user_id)->where('created_at', '>=', Carbon::now()->subDays(10))
                ->limit($app_home_latest->product_counts)->get();
            $latest_products_data = [
                'type' => 5,
                'order' => $app_home_latest->order,
                'data' => [
                    'id' => 1,
                    'name' => trans('api.latest_product'),
                    'name_ar' => trans('api.latest_product'),
                    'name_en' => trans('api.latest_product'),
                    'image' => '',
                    'banner_type' => 0,
                    'products' => ProductsCategoryResource::collection($latest_products)
                ]
            ];
            array_unshift($cat_slider, $latest_products_data);
        }
        if ($app_home_most_sales) {
            $most_sales_products = Product::GetGeneralDataProduct($user_id)->orderBy('orders_count', 'desc')
                ->limit($app_home_most_sales->product_counts)->get();
            $most_sales_products_data = [
                'type' => 6,
                'order' => $app_home_most_sales->order,
                'data' => [
                    'id' => 1,
                    'name' => trans('api.most_sales_products'),
                    'name_ar' => trans('api.most_sales_products'),
                    'name_en' => trans('api.most_sales_products'),
                    'image' => '',
                    'banner_type' => 0,
                    'products' => ProductsCategoryResource::collection($most_sales_products)
                ]
            ];
            array_unshift($cat_slider, $most_sales_products_data);

        }
        $sliders['main_slider'] = SliderResource::collection($ads_category);
        $sliders['cat_slider'] = collect($cat_slider)->sortBy('order')->values();
     //   $sliders['cat_slider'] = $cat_slider;
        $sliders['brands_slider'] = $brands;
        $sliders['coupons'] = json_decode($coupons, true);
        $response['data'] = $sliders;
        return $response;
    }



    public function contact_latest_most_sales_products($app_home_latest_most_sales , $user_id , $cat_slider) {
        //return $cat_slider;
        $app_home_latest = $app_home_latest_most_sales->where('type', '=', 5)->first();
        $app_home_most_sales = $app_home_latest_most_sales->where('type', '=', 6)->first();

        if ($app_home_latest) {
            $latest_products = Product::GetGeneralDataProduct($user_id)
                ->latest('products.created_at')
                ->limit($app_home_latest->product_counts)
                ->get();
            $latest_products_data = [
                'type' => 5,
                'order' => $app_home_latest->order,
                'data' => [
                    'id' => 1,
                    'name' => $app_home_latest->name,
                    'name_ar' => $app_home_latest->name_ar,
                    'name_en' => $app_home_latest->name_en,
                    'image' => '',
                    'banner_type' => 0,
                    'products' => json_decode(json_encode(ProductsCategoryResource::collection($latest_products) ) , true)
                ]
            ];
            $cat_slider[] = $latest_products_data;
        }
        if ($app_home_most_sales) {
            $most_sales_products = Product::GetGeneralDataProduct($user_id)
                ->orderBy('orders_count', 'desc')
                ->limit($app_home_most_sales->product_counts)->get();
            $most_sales_products_data = [
                'type' => 6,
                'order' => $app_home_most_sales->order,
                'data' => [
                    'id' => 1,
                    'name' => $app_home_most_sales->name,
                    'name_ar' => $app_home_most_sales->name_ar,
                    'name_en' => $app_home_most_sales->name_en,
                    'image' => '',
                    'banner_type' => 0,
                    'products' => json_decode(json_encode(ProductsCategoryResource::collection($most_sales_products) ) , true)
                ]
            ];
            $cat_slider[] = $most_sales_products_data;
        }
        return $cat_slider;
    }

    ///////////////////////////////////////////////////
    public function get_main_slider_of_home_data() {

        $ads_category = Slider::Active()->whereNotNull('parent_id')->whereHas('parent', function ($q) {
            $q->Active();

        })->with(['category', 'product'])->get();
        $sliders['main_slider'] = SliderResource::collection($ads_category);
        $sliders['main_slider'] = SliderResource::collection($ads_category);

        $response['data'] = $sliders;
        return $response;

    }

}
