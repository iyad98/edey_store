<?php

namespace App\Http\Controllers\Website;

use App\Models\MailingList;
use App\Validations\UserValidation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller\Website;
use Illuminate\Support\Facades\Response;
use phpDocumentor\Reflection\Types\Self_;

// Repository
use App\Repository\HomeRepository;

use Carbon\Carbon;

// models
use App\Models\Brand;
use App\Models\Category;
use App\Models\Cart;
use App\Models\Setting;
use App\Models\AppHome;
use App\Models\Product;
use App\Models\WebsiteHome;

use Illuminate\Support\Facades\Cache;


use App\Http\Resources\BannerResource;
use App\Http\Resources\Product\ProductSimpleResource;
use App\Services\SWWWTreeTraversal;

class HomeController extends Controller
{

    public $validation;

    public function __construct(HomeRepository $home_repository, UserValidation $validation)
    {
        parent::__construct();
        $this->home_repository = $home_repository;
        $this->validation = $validation;

    }

    public function index(Request $request)
    {
        $response = $this->home_repository->get_website_home_data($request);
        parent::$data['home_data'] = $response;

        return view('website_v3.home', parent::$data);
    }


    /*********************************************************************/
    public function index_2(Request $request)
    {

        $response = $this->home_repository->get_main_slider_of_home_data($request);
        parent::$data['home_data'] = json_decode(json_encode($response), true);
        return view('website.index_2', parent::$data);
    }

    public function get_home_data_as_parts(Request $request)
    {
        $page = $request->filled('page') ? $request->page : 1;

        $app_home_data = [];
        $user = $request->user;
        $user_id = $user ? $user->id : -1;
        if ($request->get_country_data) {
            $country = $request->get_country_data;
        } else {
            $country = null;
        }
        $country_id = $country ? $country->id : null;


        $general_tree = get_categories_cache();

        $app_home = AppHome::with(['banner' => function ($q0) {
            $q0->Active();
        }, 'banner.children' => function ($q1) {
            $q1->Active();
        }, 'category'])
            ->skip(($page - 1) * 5)
            ->take(5)
            ->get();

        $app_home_latest = $app_home->where('type', '=', 5)->first();
        $app_home_most_sales = $app_home->where('type', '=', 6)->first();
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
                    'products' => ProductSimpleResource::collection($latest_products)
                ]
            ];
            $app_home_data[] = $latest_products_data;
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
                    'products' => ProductSimpleResource::collection($most_sales_products)
                ]
            ];
            $app_home_data[] = $most_sales_products_data;

        }

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

            $products = ProductSimpleResource::collection($products);

            $get_category = $category->category;
            $name = $get_category->name;
            $name_ar = $get_category->name_ar;
            $name_en = $get_category->name_en;
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


        foreach ($app_home as $p) {


            $id = $p->type_id;
            $type = $p->type;
            $order = $p->order;

            if ($type == 1) {
                continue;
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


        }
        foreach ($app_home_categories as $app_home_category) {
            $app_home_data[] = $app_home_category;
        }

        $app_home_data = collect($app_home_data)->sortBy('order')->values();
        return $app_home_data;

    }

//
    public function about_us(Request $request)
    {

        $about_us = Setting::where('key', '=', 'about')->first();
        $about_us = $about_us ? $about_us->value : "";
        $breadcrumb_arr = [['name' => trans('website.home'), 'url' => "/"], ['name' => trans('website.about_us'), 'url' => url('about-us')]];

        parent::$data['breadcrumb_title'] = trans('website.about_us');
        parent::$data['breadcrumb_arr'] = $breadcrumb_arr;
        parent::$data['breadcrumb_last_item'] = trans('website.about_us');
        parent::$data['title'] = parent::$data['breadcrumb_title'];

        parent::$data['about_us'] = $about_us;

        return view('website_v3.pages.about_us', parent::$data);
    }

    public function branches()
    {

        $breadcrumb_arr = [['name' => trans('website.home'), 'url' => "/"]];

        parent::$data['breadcrumb_title'] = trans('website.branches');
        parent::$data['breadcrumb_arr'] = $breadcrumb_arr;
        parent::$data['breadcrumb_last_item'] = trans('website.branches');


        return view('website.branches', parent::$data);
    }

    public function terms()
    {
        $terms = Setting::where('key', '=', 'terms')->first();
        $terms = $terms ? $terms->value : "";

        $breadcrumb_arr = [['name' => trans('website.home'), 'url' => "/"], ['name' => trans('website.terms'), 'url' => url('terms')]];

        parent::$data['breadcrumb_title'] = trans('website.terms');
        parent::$data['breadcrumb_arr'] = $breadcrumb_arr;
        parent::$data['breadcrumb_last_item'] = trans('website.terms');
        parent::$data['title'] = parent::$data['breadcrumb_title'];

        parent::$data['terms'] = $terms;

        return view('website_v3.pages.terms', parent::$data);
    }

    public function contact_us()
    {

        $keys = ['facebook', 'twitter', 'snapchat', 'instagram', 'youtube', 'contact_us'];
        $social_media = Setting::whereIn('key', $keys)->get();

        $facebook = $social_media->where('key', 'facebook')->first();
        $twitter = $social_media->where('key', 'twitter')->first();
        $instagram = $social_media->where('key', 'instagram')->first();
        $snapchat = $social_media->where('key', 'snapchat')->first();
        $youtube = $social_media->where('key', 'youtube')->first();

        $contact_us = $social_media->where('key', 'contact_us')->first();

        $breadcrumb_arr = [['name' => trans('website.home'), 'url' => "/"], ['name' => trans('website.contact_us'), 'url' => url('contact-us')]];

        parent::$data['facebook'] = $facebook ? $facebook->value : "";
        parent::$data['twitter'] = $twitter ? $twitter->value : "";
        parent::$data['instagram'] = $instagram ? $instagram->value : "";
        parent::$data['snapchat'] = $snapchat ? $snapchat->value : "";
        parent::$data['youtube'] = $youtube ? $youtube->value : "";
        parent::$data['contact_us'] = $contact_us ? $contact_us->value : "";


        parent::$data['breadcrumb_title'] = trans('website.contact_us');
        parent::$data['breadcrumb_arr'] = $breadcrumb_arr;
        parent::$data['breadcrumb_last_item'] = trans('website.contact_us');
        parent::$data['title'] = parent::$data['breadcrumb_title'];

        parent::$data['menu'] = "contact_us";

        return view('website_v2.pages.contact_us', parent::$data);
    }

    public function return_policy()
    {

        $return_policy = Setting::where('key', '=', 'policy')->first();
        $return_policy = $return_policy ? $return_policy->value : "";

        $breadcrumb_arr = [['name' => trans('website.home'), 'url' => "/"], ['name' => trans('website.return_policy'), 'url' => url('return-policy')]];

        parent::$data['breadcrumb_title'] = trans('website.return_policy');
        parent::$data['breadcrumb_arr'] = $breadcrumb_arr;
        parent::$data['breadcrumb_last_item'] = trans('website.return_policy');
        parent::$data['title'] = parent::$data['breadcrumb_title'];

        parent::$data['return_policy'] = $return_policy;
        return view('website_v3.pages.return_policy', parent::$data);
    }

    public function shipping_and_delivery()
    {
        $shipping_and_delivery = Setting::where('key', '=', 'shipping_and_delivery')->first();
        $shipping_and_delivery = $shipping_and_delivery ? $shipping_and_delivery->value : "";

        $breadcrumb_arr = [['name' => trans('website.home'), 'url' => "/"]];

        parent::$data['breadcrumb_title'] = trans('website.shipping_and_delivery');
        parent::$data['breadcrumb_arr'] = $breadcrumb_arr;
        parent::$data['breadcrumb_last_item'] = trans('website.shipping_and_delivery');
        parent::$data['title'] = parent::$data['breadcrumb_title'];

        parent::$data['shipping_and_delivery'] = $shipping_and_delivery;
        return view('website_v3.pages.shipping_and_delivery', parent::$data);
    }

    public function faqs()
    {

        $breadcrumb_arr = [['name' => trans('website.home'), 'url' => "/"]];

        parent::$data['breadcrumb_title'] = trans('website.faqs');
        parent::$data['breadcrumb_arr'] = $breadcrumb_arr;
        parent::$data['breadcrumb_last_item'] = trans('website.faqs');
        parent::$data['title'] = parent::$data['breadcrumb_title'];


        return view('website_v2.faqs', parent::$data);
    }

    public function privacy_policy()
    {

        $privacy_policy = Setting::where('key', '=', 'privacy_policy')->first();
        $privacy_policy = $privacy_policy ? $privacy_policy->value : "";


        $breadcrumb_arr = [['name' => trans('website.home'), 'url' => "/"], ['name' => trans('website.privacy_policy'), 'url' => url('privacy-policy')]];

        parent::$data['breadcrumb_title'] = trans('website.privacy_policy');
        parent::$data['breadcrumb_arr'] = $breadcrumb_arr;
        parent::$data['breadcrumb_last_item'] = trans('website.privacy_policy');
        parent::$data['title'] = parent::$data['breadcrumb_title'];

        parent::$data['privacy_policy'] = $privacy_policy;


        return view('website_v3.pages.privacy_policy', parent::$data);
    }


    public function mailing_list(Request $request)
    {
        $data = $request->toArray();
        $check_data = $this->validation->check_mailing_list($data);

        if ($check_data['status']) {

            MailingList::create($data);


            return response()->json(['status' => true, 'message' => trans('api.email_send_successfully'), 'data' => '']);
        } else {
            return response()->json(['status' => false, 'message' => $check_data['message'], 'data' => '']);
        }
    }


    public function category_search(Request $request)
    {
        $query = Product::query();
        if ($request->filled('category_name')) {
            $query->where('name_en', 'like', '%' . $request->get('category_name') . '%');
            $query->where('name_ar', 'like', '%' . $request->get('category_name') . '%');
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', "=", $request->get('category_id'));
        }
        $data['product'] = $query->get();


//        return response()->json(['status' => true, 'data_compact' => $data]);

        $html = view('welcome', compact('data'))->render();
        return $html;

//        return view('frontend.category_restaurant', $data);

    }


}
