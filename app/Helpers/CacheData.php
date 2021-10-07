<?php

use App\Models\Setting;
use App\Models\PaymentMethod;
use App\Models\Bank;
use App\Models\AppHome;
use App\Models\Product;
use App\Models\Category;
use App\Models\Currency;
use App\Models\WebsiteHome;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\SWWWTreeTraversal;

use App\Http\Resources\CategoryResourceDFT;
use App\Http\Resources\CategoryDataResourceDFT;

// Resources
use App\Http\Resources\BannerResource;
use App\Http\Resources\Product\ProductSimpleResource;
use App\Http\Resources\Product\ProductsCategoryResource;


/*********************** categories_cache *******************/


/*
function get_categories_with_data_cache()
{
    Cache::rememberForever('categories_data_tree', function () {
        $categories = Category::with('children')->get();
        $tree = CategoryDataResourceDFT::collection($categories);
        return $tree;
    });
    return Cache::get('categories_data_tree');
}
function update_categories__with_data_in_cache()
{
    Cache::forget('categories_data_tree');
    get_categories_with_data_cache();
}

function get_all_category_cache()
{
    Cache::rememberForever('get_all_category_cache', function () {
        $categories = Category::all();
        return $categories;
    });
    return Cache::get('get_all_category_cache');
}
function update_all_category_cache()
{
    Cache::forget('get_all_category_cache');
    get_all_category_cache();
}
*/

function get_categories_cache()
{
    Cache::rememberForever('categories_tree', function () {
        $categories = Category::with('children')
            ->select('id')
            ->get();
        $tree = CategoryResourceDFT::collection($categories);
        return $tree;
    });
    return Cache::get('categories_tree');
}

function update_categories_in_cache()
{
    Cache::forget('categories_tree');
    get_categories_cache();
}


function get_all_category_with_parents()
{
//    Cache::forget('get_all_category_with_parents');
    Cache::rememberForever('get_all_category_with_parents', function () {
        $categories = Category::with('children')->get();
        $categories = $categories->map(function ($value) {
            $parents = [];
            foreach ($value->parents as $parent) {
                if ($parent['id'] == $value->id) continue;
                $parents[] = ['id' => $parent['id'], 'name_ar' => $parent['name_ar'], 'name_en' => $parent['name_en'], 'name' => $parent['name'], 'slug_ar' => $parent['slug_ar'], 'slug_en' => $parent['slug_en']];
            }
            $category_parents = $parents;
            array_unshift($category_parents , ['id' => $value->id, 'name_ar' => $value->name_ar, 'name_en' => $value->name_en, 'name' => $value->name, 'slug_ar' => $value->slug_ar, 'slug_en' => $value->slug_en]);
            $value->get_parents = array_reverse($category_parents);
            $value->parents_text = implode(" / ", array_reverse(collect($parents)->pluck('name')->toArray()));
            $value->category_with_parents_text = $value->name . " " . (count($parents) > 0 ? " ( " . $value->parents_text . " ) " : "");
            $value->slug_ar_data = implode('/', collect($category_parents)->pluck('slug_ar')->toArray());
            $value->slug_en_data = implode('/', collect($category_parents)->pluck('slug_en')->toArray());
//            $value->product_count = \App\Models\ProductCategory::where('category_id',$value->id)->count();

            return $value;
        });
        $tree = CategoryDataResourceDFT::collection($categories);
        $obj = json_decode(json_encode($tree), FALSE);
        return collect($obj);
    });
    return Cache::get('get_all_category_with_parents');
}

function update_all_category_with_parents()
{
    Cache::forget('get_all_category_with_parents');
    get_all_category_with_parents();
}

/*************************************************************/

/********** cache setting messages **********************/
function get_setting_messages()
{
    Cache::rememberForever('setting_messages', function () {

        $setting_keys = ['shipping_order', 'cancel_order','finished_order', 'failed_order', 'phone','order_in_the_warehouse'];
        $sms_keys = ['sms_user_account', 'sms_user_pass', 'sms_sender'];


        $payment_methods = PaymentMethod::all();
        $settings = Setting::whereIn('key', array_merge($setting_keys, $sms_keys))
            ->select('id', 'key', 'value_ar', 'value_en')
            ->get();

        $banks = Bank::all();
        $data['payment_methods'] = $payment_methods;
        $data['settings'] = $settings->whereIn('key', $setting_keys)->values();
        $data['banks'] = $banks;
        $data['sms'] = $settings->whereIn('key', $sms_keys)->values();
        return $data;
    });
    return Cache::get('setting_messages');
}

function update_setting_messages()
{
    Cache::forget('setting_messages');
    get_categories_cache();
}

/********************************************************/


/*********  cache app banners and categories in app *****/
function get_categories_banners_app()
{

    Cache::rememberForever('get_categories_banners_app', function () {


        $app_home_data = [];
        $app_home = AppHome::with(['banner' => function ($q0) {
            $q0->Active();
        }, 'banner.children' => function ($q1) {
            $q1->Active();
        }, 'category'])->get();

        $product_ids = [];

        $categories = category::with('children')->whereIn('id', function ($query) {
            $query->from('app_home')->where('type', '=', 1)->select('type_id');
        })->get();
        $tree = CategoryResourceDFT::collection($categories);

        foreach ($app_home as $p) {

            try {
                $id = $p->type_id;

                $type = $p->type;
                $order = $p->order;

                if ($type == 1) {
                    $display_type = 1;
                    if (!$p->category) {
                        continue;
                    }
                    $tree_ = json_decode(collect($tree)->where('id', '=', $p->type_id), true);
                    $conf = array('tree' => $tree_);
                    $instance = new SWWWTreeTraversal($conf);
                    $category_ids = $instance->get();

                    $products = Product::with(['variation', 'tax_status'])->ProductRate()
                        ->filter(['category' => $category_ids])
                        ->limit($p->product_counts)
                        ->get();

                    if ($products->count() <= 0) {
                        continue;
                    }
                    $product_ids = array_values(array_unique(array_merge($product_ids, $products->pluck('id')->toArray())));

                    $name = $p->category->name;
                    $name_ar = $p->category->name_ar;
                    $name_en = $p->category->name_en;
                    $image = $p->category->image;
                    $data = [
                        'id' => $id,
                        'name' => $name,
                        'name_ar' => $name_ar,
                        'name_en' => $name_en,
                        'image' => $image,
                        'banner_type' => 0,
                        // 'products' => ProductSimpleResource::collection($products),
                        'products' => $products,
                    ];

                } else {

                    if (!$p->banner) {
                        continue;
                    }
                    $name = $p->banner->name;
                    $name_ar = $p->banner->name_ar;
                    $name_en = $p->banner->name_en;

                    $image = "";
                    $children_count = $p->banner->children->count();
                    $display_type = $children_count >= 3 ? 4 : $children_count + 1;
                    $data = [
                        'id' => $id,
                        'name' => $name,
                        'name_ar' => $name_ar,
                        'name_en' => $name_en,
                        'image' => $image,
                        'banner_type' => $children_count >= 3 ? 3 : $children_count,
                        'products' => BannerResource::collection($p->banner->children)
                    ];
                }

                $app_home_data[] = [
                    'type' => $display_type,
                    'order' => $order,
                    'data' => $data

                ];
            } catch (\Exception $e) {
                continue;
            } catch (\Error $e) {
                continue;
            }


        }

        return [
            'app_home_data' => collect($app_home_data)->sortBy('order')->values(),
            'product_ids' => $product_ids
        ];
    });
    return Cache::get('get_categories_banners_app');


}

function update_categories_banners_app()
{
    Cache::forget('get_categories_banners_app');
    get_categories_banners_app();
}

function set_favorite_in_cart_in_app_home_data($request, $user)
{
    // update_categories_banners_app();

    $get_categories_banners_app = get_categories_banners_app();
    $app_home_data = $get_categories_banners_app['app_home_data'];

    $favorite_product_ids = $user ? $user->favorites()
        ->whereIn('product_id', $get_categories_banners_app['product_ids'])
        ->pluck('product_id')->toArray() : [];


    $cart_product_ids = $user && $user->cart ? $user->cart->products()
        ->whereIn('product_id', $get_categories_banners_app['product_ids'])
        ->pluck('product_id')->toArray() : [];

    $app_home_data_after_favorite_cart = [];
    foreach ($app_home_data as $get_data) {

        $get_data['data']['name'] = app()->getLocale() == 'en' ? $get_data['data']['name_en'] : $get_data['data']['name_ar'];
        if ($get_data['type'] == 1) {
            $get_products = $get_data['data']['products'];
            $get_new_product_all = [];
            foreach ($get_products as $get_product) {
                $get_product__ = new ProductsCategoryResource($get_product);
                $get_new_product = json_decode(collect($get_product__), true);
                $get_new_product['in_favorite'] = in_array($get_new_product['id'], $favorite_product_ids);
                $get_new_product['in_cart'] = in_array($get_new_product['id'], $cart_product_ids);

                $get_new_product_all[] = $get_new_product;
            }

            $get_data['data']['products'] = $get_new_product_all;
            $app_home_data_after_favorite_cart[] = $get_data;
        } else {
            $app_home_data_after_favorite_cart[] = $get_data;
        }

    }
    return $app_home_data_after_favorite_cart;
}


function get_website_home_data_without_cache($request, $user, $country_id)
{

    $user_id = $user ? $user->id : -1;
    $general_tree = get_categories_cache();

    $app_home = WebsiteHome::with(['banner' => function ($q0) {
        $q0->Active()->InWebsiteHome();
    }, 'banner.children' => function ($q1) {
        $q1->Active();
    }, 'category' => function ($q2) {
        $q2->InWebsiteHome();
    },'widget'])->get();

    $app_home_categories = $app_home->where('type', '=', 1)->values();
    $app_home_categories = $app_home_categories->transform(function ($category) use ($general_tree, $country_id, $user_id ) {

        $tree_ = json_decode(collect($general_tree)->where('id', '=', $category->type_id), true);
        $conf = array('tree' => $tree_);
        $instance = new SWWWTreeTraversal($conf);
        $category_ids = $instance->get();

        $products = Product::latest('products.created_at')->with(['variation', 'tax_status'])
            ->GetGeneralDataProduct($user_id)
            ->ProductRate()
            ->filter(['category' => $category_ids, 'country' => $country_id])
            ->limit($category->product_counts)
            ->get();


        $products = ProductsCategoryResource::collection($products);

        $get_category = $category->category;

        $name = $category->name;

        $name_ar = $category->name_ar;
        $name_en = $category->name_en;
        $image = $get_category->image;

        $data = [
            'id' => $get_category->id,
            'name' => $name,
            'name_ar' => $name_ar,
            'name_en' => $name_en,
            'image' => $image,
            'banner_type' => 0,
            'products' => json_decode(json_encode($products), true),
            'categories_type' => [],
        ];
        $app_home_data = [
            'type' => $category->type,
            'order' => $category->order,
            'widget_type'=> $category->widget->widget_type,
            'widget_image_ads'=> $category->widget->{'image_'.app()->getLocale()},
            'widget_image_ads_mobile'=> $category->widget->{'image_mobile_ar'},
            'data' => $data,
        ];

        return $app_home_data;

    });

    $app_home_data = [];
    foreach ($app_home as $p) {

        try {
            $name = $p->name;
            $name_ar = $p->name_ar;
            $name_en = $p->name_en;
            $id = $p->type_id;
            $type = $p->type;
            $order = $p->order;

            if ($type == 1) {
                continue;
            } else {
                if (!$p->banner) {
                    continue;
                }
                $image = "";
                $children_count = $p->banner->children->count();
                $display_type = $children_count >= 3 ? 4 : $children_count + 1;
                $data = [
                    'id' => $id,
                    'name' => $name,
                    'name_ar' => $name_ar,
                    'name_en' => $name_en,
                    'image' => $image,
                    'banner_type' => $children_count >= 3 ? 3 : $children_count,
                    'products' => json_decode(json_encode(BannerResource::collection($p->banner->children)), true),
                ];
            }
            $app_home_data[] = [
                'type' => $display_type,
                'order' => $order,
                'data' => $data

            ];
        } catch (\Exception $e) {
            continue;
        } catch (\Error $e) {
            continue;
        }

    }
    foreach ($app_home_categories as $app_home_category) {
        $app_home_data[] = $app_home_category;
    }
    $app_home_data = collect($app_home_data)->sortBy('order')->values();
    return $app_home_data;
}

function get_app_home_data_without_cache($request, $user, $country_id)
{

    $user_id = $user ? $user->id : -1;
    $general_tree = get_categories_cache();

    $app_home = AppHome::with(['banner' => function ($q0) {
        $q0->Active();
    }, 'banner.children' => function ($q1) {
        $q1->Active();
    }, 'category'])->get();


    $app_home_categories = $app_home->where('type', '=', 1)->values();
    $app_home_categories = $app_home_categories->transform(function ($category) use ($general_tree, $country_id, $user_id) {

        $tree_ = json_decode(collect($general_tree)->where('id', '=', $category->type_id), true);
        $conf = array('tree' => $tree_);
        $instance = new SWWWTreeTraversal($conf);
        $category_ids = $instance->get();

        $products = Product::latest('products.created_at')->with(['variation', 'tax_status'])
            ->GetGeneralDataProduct($user_id)
            ->ProductRate()
            ->filter(['category' => $category_ids, 'country' => $country_id])
            ->limit($category->product_counts)
            ->get();

        $products = ProductsCategoryResource::collection($products);

        $get_category = $category->category;
        $name = $category->name;
        $name_ar = $category->name_ar;
        $name_en = $category->name_en;
        $image = $get_category->image;

        $data = [
            'id' => $get_category->id,
            'name' => $name,
            'name_ar' => $name_ar,
            'name_en' => $name_en,
            'image' => $image,
            'banner_type' => 0,
            'products' => json_decode(json_encode($products), true),
            'categories_type' => [],
        ];
        $app_home_data = [
            'type' => $category->type,
            'order' => $category->order,
            'data' => $data

        ];

        return $app_home_data;
    });

    $app_home_data = [];
    foreach ($app_home as $p) {

        try {
            $name = $p->name;
            $name_ar = $p->name_ar;
            $name_en = $p->name_en;

            $id = $p->type_id;
            $type = $p->type;
            $order = $p->order;

            if ($type == 1) {
                continue;
            } else {
                if (!$p->banner) {
                    continue;
                }

                $image = "";
                $children_count = $p->banner->children->count();
                $display_type = $children_count >= 3 ? 4 : $children_count + 1;
                $data = [
                    'id' => $id,
                    'name' => $name,
                    'name_ar' => $name_ar,
                    'name_en' => $name_en,
                    'image' => $image,
                    'banner_type' => $children_count >= 3 ? 3 : $children_count,
                    'products' => BannerResource::collection($p->banner->children)
                ];
            }
            $app_home_data[] = [
                'type' => $display_type,
                'order' => $order,
                'data' => $data

            ];
        } catch (\Exception $e) {
            continue;
        } catch (\Error $e) {
            continue;
        }

    }
    foreach ($app_home_categories as $app_home_category) {
        $app_home_data[] = $app_home_category;
    }
    $app_home_data = collect($app_home_data)->sortBy('order')->values();
    return $app_home_data;
}

/********************************************************/


/********* cache shipping , tax , first order discount  ***********************************/

function get_cart_data_cache()
{
    Cache::rememberForever('cart_data_cache', function () {
        $setting = Setting::whereIn('key', ['tax', 'shipping', 'cash', 'first_order_discount', 'package_discount_type',
            'price_tax_in_products', 'price_tax_in_cart' , 'checkout_label'])->get();

        $cash = $setting->where('key', '=', 'cash')->first()->value;
        $tax = $setting->where('key', '=', 'tax')->first()->value;
        $shipping = $setting->where('key', '=', 'shipping')->first()->value;

        $first_order_discount = $setting->where('key', '=', 'first_order_discount')->first()->value;
        $package_discount_type = $setting->where('key', '=', 'package_discount_type')->first()->value;

        $price_tax_in_products = $setting->where('key', '=', 'price_tax_in_products')->first()->value;
        $price_tax_in_cart = $setting->where('key', '=', 'price_tax_in_cart')->first()->value;

        $checkout_label = $setting->where('key', '=', 'checkout_label')->first();

        return [
            'tax' => $tax,
            'cash' => $cash,
            'shipping' => $shipping,
            'first_order_discount' => $first_order_discount,
            'package_discount_type' => $package_discount_type,
            'price_tax_in_products' => $price_tax_in_products,
            'price_tax_in_cart' => $price_tax_in_cart,
            'checkout_label' => $checkout_label,
        ];
    });
    return Cache::get('cart_data_cache');
}

function update_cart_data_cache_in_cache()
{
    Cache::forget('cart_data_cache');
    get_cart_data_cache();
}

/********* currencies with exchange rate  *************************************************/

function get_currencies_cache()
{
    Cache::rememberForever('currencies_cache', function () {
        return Currency::all();
    });
    return Cache::get('currencies_cache');
}

function update_currencies_cache()
{
    Cache::forget('currencies_cache');
    get_currencies_cache();
}


/****************** maintenance  mode ******************************************/
function get_maintenance_cache_data()
{

    Cache::rememberForever('maintenance_cache_data', function () {
        $settings = Setting::whereIn('key', ['close_app', 'close_website'])->get();

        $close_app = $settings->where('key', 'close_app')->first();
        $close_website = $settings->where('key', 'close_website')->first();

        return [
            'close_app' => $close_app ? $close_app->status == 1 : false,
            'close_app_text' => trans('api.app_in_maintenance_mode'),

            'close_website' => $close_website ? $close_website->status == 1 : false,
            'close_website_text' => $close_website ? $close_website->value : false,
        ];
    });
    return Cache::get('maintenance_cache_data');
}

function update_maintenance_cache_data()
{
    Cache::forget('maintenance_cache_data');
    get_maintenance_cache_data();
}
