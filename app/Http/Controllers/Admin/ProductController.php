<?php

namespace App\Http\Controllers\Admin;


use App\Models\Merchant;
use App\Models\Order;
use App\Notifications\SendChangeOrderStatusNotification;
use App\Notifications\SendChangeProductStatusNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

/*  Models */

use App\Models\FilterData;
use App\Models\TaxStatus;
use App\Models\StockStatus;
use App\Models\City;
use App\Models\Attribute;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductVariation;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use App\Models\ProductVariationImage;
use App\Models\ProductVariationShipping;
use App\Models\ProductImage;
use App\Models\Country;

/* service */

use App\Services\StoreFile;
use App\Services\Firestore;
use App\Services\SWWWTreeTraversal;
use App\Services\CartService;


use Illuminate\Support\Facades\File;

use DB;

use Illuminate\Validation\Rule;

// validations
use App\Validations\ProductValidation;
// Repository
use App\Repository\ProductRepository;
use Illuminate\Support\Facades\Notification;
// jobs
use App\Jobs\UpdateCategoriesBannersAppJob;

class ProductController extends HomeController
{


    public function __construct(ProductRepository $Product, ProductValidation $validation)
    {
        $this->middleware('check_role:view_products|add_products|edit_products|delete_products', ['only' => ['index']]);
        $this->middleware('check_role:add_products', ['only' => ['create' ,'store' ]]);
        $this->middleware('check_role:edit_products', ['only' => ['edit','update' ]]);
        $this->middleware('check_role:delete_products', ['only' => ['delete' ]]);

        parent::__construct();
        parent::$data['route_name'] = trans('admin.products');
        parent::$data['route_uri'] = route('admin.products.index');
        $this->product = $Product;
        $this->validation = $validation;


        parent::$data['active_menu'] = 'products';

    }


    public function index(Request $request)
    {

        $sort_by = $request->filled('sort_by') ? $request->sort_by : 1;
        //   return $this->product->get_key_default_product(64);

        $stock_status = StockStatus::Active()->get();
        $categories =get_all_category_with_parents();
        $brands = Brand::all();
        $merchants = Merchant::all();

        parent::$data['stock_status'] = $stock_status;
        parent::$data['categories'] = $categories;
        parent::$data['brands'] = $brands;
        parent::$data['merchants'] = $merchants;
        parent::$data['sort_by'] = $sort_by;

        return view('admin.products.index', parent::$data);
    }

    public function create(Request $request)
    {

        $cache_categories = get_all_category_with_parents();
        $tax_status = TaxStatus::Active()->get();
        $stock_status = StockStatus::Active()->get();
        $attributes = Attribute::with('attribute_values:id,attribute_id,name_ar,name_en')->get();
        $categories = $cache_categories;
        $countries = Country::select('id' , 'name_en' , 'name_ar')->get();

        $main_categories = $categories->filter(function ($value){
            return is_null($value->parent);
        })->values();

        $get_categories = $categories->filter(function ($value) {
            return is_null($value->parent);
        })->values();

        $get_categories_with_children = [];
        foreach ($get_categories as $get_category) {

            $tree = json_decode(collect($cache_categories)->where('id', '=', $get_category->id), true);
            $conf = array('tree' => $tree);
            $instance = new SWWWTreeTraversal($conf);
            $category_ids = $instance->get();

            $get_category_ = [];

            $get_category_['id'] = $get_category->id;
            $get_category_['name'] = $get_category->name;
            $get_category_['children'] = $category_ids;

            $get_categories_with_children[] = $get_category_;
        }

        $brands = Brand::all();
        $merchants = Merchant::all();

        parent::$data['tax_status'] = $tax_status;
        parent::$data['stock_status'] = $stock_status;
        parent::$data['attributes'] = $attributes;
        parent::$data['categories'] = $categories;
        parent::$data['main_categories'] = $main_categories;
        parent::$data['get_categories_with_children'] = json_encode($get_categories_with_children);
        parent::$data['brands'] = $brands;
        parent::$data['merchants'] = $merchants;
        parent::$data['countries'] = $countries;

        return view('admin.products.add_product', parent::$data);
    }
    public function store(Request $request)
    {


        try {

            $categories = $request->categories != "" ? explode(",", $request->categories) : [];
            $brand_id = $request->brand_id;
            $merchant_id = $request->merchant_id;
            $recommended_products = $request->recommended_products != "" ? explode(",", $request->recommended_products) : [];
            $marketing_products = $request->marketing_products != "" ? explode(",", $request->marketing_products) : [];
            $sub_products = $request->sub_products != "" ? explode(",", $request->sub_products) : [];

            $product_attributes = json_decode($request->product_attributes);
            $attribute_value_variations = json_decode($request->attribute_value_variations);
            $checked_variations = json_decode($request->checked_variations);

            $select_country = $request->select_country;
            $countries = explode(",", $request->countries);
            $excluded_countries = explode(",", $request->excluded_countries);

            /*return general_response(false, true, "", array_only($request->all() ,$this->product->getFillable() ), "", [
                'error_tab_id' => '_product_tab_4'
            ]);*/

            $check_public_data = $this->validation->check_add_product_public($request->all());
            if (!$check_public_data['status']) {
                return general_response(false, true, "", $check_public_data['message'], "", [
                    'error_tab_id' => '_product_tab_1'
                ]);

            }

            $check_sku_data = $this->validation->check_add_product_sku($request->all());
            if (!$check_sku_data['status']) {
                return general_response(false, true, "", $check_sku_data['message'], "", [
                    'error_tab_id' => '_product_tab_2'
                ]);
            }

            $check_shipping_data = $this->validation->check_add_product_shipping($request->all());
            if (!$check_shipping_data['status']) {
                return general_response(false, true, "", $check_shipping_data['message'], "", [
                    'error_tab_id' => '_product_tab_3'
                ]);
            }

            $check_categories_and_brands_data = $this->validation->check_add_product_categories_and_brands(['categories' => $categories, 'brand_id' => $brand_id]);
            if (!$check_categories_and_brands_data['status']) {
                return general_response(false, true, "", $check_categories_and_brands_data['message'], "", [
                    'error_tab_id' => '_product_tab_4'
                ]);
            }

            $check_attributes_data = $this->validation->check_add_product_attributes($product_attributes);
            if (!$check_attributes_data['status']) {
                return general_response(false, true, "", $check_attributes_data['message'], "", [
                    'error_tab_id' => '_product_tab_6'
                ]);
            }

            $check_attribute_variations_data = $this->validation->check_add_attribute_value_variations($attribute_value_variations);
            if (!$check_attribute_variations_data['status']) {
                return general_response(false, true, "", $check_attribute_variations_data['message'], "", [
                    'error_tab_id' => '_product_tab_8',
                    'random_id' => $check_attribute_variations_data['data']['random_id']
                ]);
            }

            if ($request->product_type == 2 && count($attribute_value_variations) <= 0) {
                return general_response(false, true, "", trans('validation.must_have_variation'), "", [
                    'error_tab_id' => '_product_tab_8'
                ]);
            }

            if ($request->product_type == 2 && count(array_diff(collect($checked_variations)->toArray(), collect($product_attributes)->pluck('id')->toArray())) > 0) {
                return general_response(false, true, "", trans('validation.variations_must_have_in_attributes'), "", [
                    'error_tab_id' => '_product_tab_8'
                ]);
            }


            // handle image
            $path = $this->store_file_service($request->image , 'products' , null , null ,true);

            $images = [];
            if ($request->has('images')) {
                foreach (json_decode($request->images , true) as $image) {
                    if(array_key_exists('src' , $image)) {
                        $path2 = $this->store_file_service($image['id'] , 'products' , null , null ,true);
                        $images[] = ['image' => $path2];
                    }
                }
            }


            ////////////////////////////////////////////////////
            $data['public'] = $request->all();
            $data['select_country'] = $select_country;
            $data['countries'] = $countries;
            $data['excluded_countries'] = $excluded_countries;
            $data['image'] = $path;
            $data['images'] = $images;
            $data['categories'] = $categories;
            $data['brand_id'] = $brand_id;
            $data['merchant_id'] = $merchant_id;
            $data['product_attributes'] = $product_attributes;
            $data['attribute_value_variations'] = $attribute_value_variations;
            $data['recommended_products'] = $recommended_products;
            $data['marketing_products'] = $marketing_products;
            $data['sub_products'] = $sub_products;
            $data['checked_variations'] = $checked_variations;


            $product_data = $this->product->get_filter_product_data($data);
            $product = $this->product->add_product($product_data);



        } catch (\Exception $e1) {
            return general_response(false, true, "", $e1->getMessage(), "", [
                'error_tab_id' => '_product_tab_1'
            ]);
        } catch (\Error $e2) {
            return general_response(false, true, "", $e2->getMessage(), "", [
                'error_tab_id' => '_product_tab_1'
            ]);
        }


        return general_response(true, true, trans('admin.success'), "", "", []);
    }
    public function edit(Request $request, $id)
    {

        $product = $this->product->with(['images', 'variation.product_shipping', 'variation.images', 'recommended_products:products.id,name_ar,name_en',
            'marketing_products:products.id,name_ar,name_en' ,'sub_products:products.id,name_ar,name_en', 'categories', 'attributes.attribute_values' ,'countries'])
            ->find($id);

        $cache_categories = get_all_category_with_parents();
        $tax_status = TaxStatus::Active()->get();
        $stock_status = StockStatus::Active()->get();
        $attributes = Attribute::with('attribute_values:id,attribute_id,name_ar,name_en')->get();
        $categories = $cache_categories;
        $brands = Brand::all();
        $countries = Country::select('id' , 'name_en' , 'name_ar')->get();


        $main_categories = $categories->filter(function ($value){
            return is_null($value->parent);
        });
        $get_categories = $categories->filter(function ($value) {
            return is_null($value->parent);
        })->values();

        $get_categories_with_children = [];
        foreach ($get_categories as $get_category) {

            $tree = json_decode(collect($cache_categories)->where('id', '=', $get_category->id), true);
            $conf = array('tree' => $tree);
            $instance = new SWWWTreeTraversal($conf);
            $category_ids = $instance->get();

            $get_category_ = [];

            $get_category_['id'] = $get_category->id;
            $get_category_['name'] = $get_category->name;
            $get_category_['children'] = $category_ids;

            $get_categories_with_children[] = $get_category_;
        }

        parent::$data['product'] = $product;
        parent::$data['tax_status'] = $tax_status;
        parent::$data['stock_status'] = $stock_status;
        parent::$data['attributes'] = $attributes;
        parent::$data['categories'] = $categories;
        parent::$data['main_categories'] = $main_categories;
        parent::$data['get_categories_with_children'] = json_encode($get_categories_with_children);
        parent::$data['brands'] = $brands;
        parent::$data['countries'] = $countries;

        return view('admin.products.edit_product', parent::$data);
    }

    public function update(Request $request)
    {

        try {

            $categories = $request->categories != "" ? explode(",", $request->categories) : [];
            $brand_id = $request->brand_id;
            $recommended_products = $request->recommended_products != "" ? explode(",", $request->recommended_products) : [];
            $marketing_products = $request->marketing_products != "" ? explode(",", $request->marketing_products) : [];
            $sub_products = $request->sub_products != "" ? explode(",", $request->sub_products) : [];

            $product_attributes = json_decode($request->product_attributes);
            $attribute_value_variations = json_decode($request->attribute_value_variations);
            $edit_images_removed = json_decode($request->edit_images_removed);
            $edit_product_images_removed = json_decode($request->edit_product_images_removed);
            $checked_variations = json_decode($request->checked_variations);
            $get_key_product_variations = collect($attribute_value_variations)->pluck('key')->toArray();

            $select_country = $request->select_country;
            $countries = explode(",", $request->countries);
            $excluded_countries = explode(",", $request->excluded_countries);

            $get_keys = collect($attribute_value_variations)->pluck('key')->toArray();
            $get_product_variations = ProductVariation::where('product_id', '=', $request->id)
                ->whereIn('key', $get_keys)
                ->get();

            $get_product_variation_ids = ProductVariation::where('product_id', '=', $request->id)->pluck('id')->toArray();


            try {
                $get_product = $this->product->find($request->id);

                $check_public_data = $this->validation->check_edit_product_public($request->all());

                if (!$check_public_data['status']) {
                    return general_response(false, true, "", $check_public_data['message'], "", [
                        'error_tab_id' => '_product_tab_1'
                    ]);
                }

                $check_sku_data = $this->validation->check_edit_product_sku($request->all());
                if (!$check_sku_data['status']) {
                    return general_response(false, true, "", $check_sku_data['message'], "", [
                        'error_tab_id' => '_product_tab_2'
                    ]);
                }

                $check_shipping_data = $this->validation->check_add_product_shipping($request->all());
                if (!$check_shipping_data['status']) {
                    return general_response(false, true, "", $check_shipping_data['message'], "", [
                        'error_tab_id' => '_product_tab_3'
                    ]);
                }

                $check_categories_and_brands_data = $this->validation->check_add_product_categories_and_brands(['categories' => $categories, 'brand_id' => $brand_id]);
                if (!$check_categories_and_brands_data['status']) {
                    return general_response(false, true, "", $check_categories_and_brands_data['message'], "", [
                        'error_tab_id' => '_product_tab_4'
                    ]);
                }

                $check_attributes_data = $this->validation->check_add_product_attributes($product_attributes);
                if (!$check_attributes_data['status']) {
                    return general_response(false, true, "", $check_attributes_data['message'], "", [
                        'error_tab_id' => '_product_tab_6'
                    ]);
                }

                $check_attribute_variations_data = $this->validation->check_edit_attribute_value_variations($request->id, $attribute_value_variations, $get_product_variations);
                if (!$check_attribute_variations_data['status']) {
                    return general_response(false, true, "", $check_attribute_variations_data['message'], "", [
                        'error_tab_id' => '_product_tab_8',
                        'random_id' => $check_attribute_variations_data['data']['random_id']
                    ]);
                }

                // check countries
                if ($select_country == 2) {
                    $check_countries = $this->validation->check_countries(['countries' => $countries]);
                    if (!$check_countries['status']) {
                        return general_response(false, true, "", $check_countries['message'], "", []);
                    }
                }

            } catch (\Exception $e) {
                return general_response(false, true, "", $e->getMessage(), "", [
                    'error_tab_id' => '_product_tab_8'
                ]);
            } catch (\Error $e2) {
                return general_response(false, true, "", $e2->getMessage(), "", [
                    'error_tab_id' => '_product_tab_8'
                ]);
            }

            if ($request->product_type == 2 && count($attribute_value_variations) <= 0) {
                return general_response(false, true, "", trans('validation.must_have_variation'), "", [
                    'error_tab_id' => '_product_tab_1'
                ]);
            }

            if ($request->product_type == 2 && count(array_diff(collect($checked_variations)->toArray(), collect($product_attributes)->pluck('id')->toArray())) > 0) {
                return general_response(false, true, "", trans('validation.variations_must_have_in_attributes'), "", [
                    'error_tab_id' => '_product_tab_8'
                ]);
            }
            // handle image
            $path = $this->store_file_service($request->image, 'products', $get_product, 'image', false);

            $images = [];
            if ($request->has('images')) {
                foreach (json_decode($request->images , true) as $image) {
                    if(array_key_exists('src' , $image)) {
                        $path2 = $this->store_file_service($image['id'] , 'products' , null , null ,true);
                        $images[] = ['image' => $path2];
                    }
                }
            }

            ProductImage::where('product_id', '=', $request->id)
                ->whereIn('image', $edit_product_images_removed)
                ->delete();

            ProductVariationImage::whereIn('product_variation_id', $get_product_variation_ids)
                ->whereIn('id', $edit_images_removed)
                ->delete();



            ////////////////////////////////////////////////////

            $data['public'] = $request->all();
            $data['select_country'] = $select_country;
            $data['countries'] = $countries;
            $data['excluded_countries'] = $excluded_countries;
            $data['checked_variations'] = $checked_variations;
            $data['image'] = $path;
            $data['images'] = $images;
            $data['categories'] = $categories;
            $data['brand_id'] = $brand_id;
            $data['product_attributes'] = $product_attributes;
            $data['attribute_value_variations'] = $attribute_value_variations;
            $data['recommended_products'] = $recommended_products;
            $data['marketing_products'] = $marketing_products;
            $data['sub_products'] = $sub_products;

            $product_data = $this->product->get_filter_product_data($data, true);


            $product = $this->product->update_product($product_data, $get_product_variations);

            // update update categories banners app
//            $update_categories_banners_app = (new UpdateCategoriesBannersAppJob());
//            dispatch($update_categories_banners_app);

            // delete product variations not used
            if ($request->product_type == 2) {
                $remove_product_variations_not_used = ProductVariation::where('product_id', '=', $request->id)
                    ->whereNotIn('key', $get_key_product_variations)->pluck('id')->toArray();

                ProductVariationImage::whereIn('product_variation_id', $remove_product_variations_not_used)->delete();
                ProductVariationShipping::whereIn('product_variation_id', $remove_product_variations_not_used)->delete();
                ProductVariation::whereIn('id', $remove_product_variations_not_used)->delete();
            } else {
                $remove_product_variations_not_used = ProductVariation::where('product_id', '=', $request->id)
                    ->where('key', '<>', '*')->pluck('id')->toArray();

                ProductVariationImage::whereIn('product_variation_id', $remove_product_variations_not_used)->delete();
                ProductVariationShipping::whereIn('product_variation_id', $remove_product_variations_not_used)->delete();
                ProductVariation::whereIn('id', $remove_product_variations_not_used)->delete();
            }
            $this->add_action("update_product" ,'product', json_encode(Product::find($request->id)));

        } catch (\Exception $e1) {
            return general_response(false, true, "", $e1->getMessage(), "", [
                'error_tab_id' => '_product_tab_1'
            ]);
        } catch (\Error $e2) {
            return general_response(false, true, "", $e2->getMessage(), "", [
                'error_tab_id' => '_product_tab_1'
            ]);
        }
        CartService::update_cart_when_update_product();

        // return response()->json($request->images[0]->getClientOriginalName());


        // return response()->json($product);

        return general_response(true, true, trans('admin.success'), "", "", []);
    }

    public function delete(Request $request)
    {
        $product = Product::find($request->id);
        $product_variations = ProductVariation::where('product_id', '=', $product->id)->pluck('id')->toArray();
        $product_attributes = ProductAttribute::where('product_id', '=', $product->id)->pluck('id')->toArray();

        try {
            DB::transaction(function () use ($product, $product_variations, $product_attributes) {

                (new StoreFile(null))->delete_product_images($product);

                ProductAttributeValue::whereIn('product_attribute_id', $product_attributes)->delete();
                ProductVariationImage::whereIn('product_variation_id', $product_variations)->delete();
                ProductVariationShipping::whereIn('product_variation_id', $product_variations)->delete();
                $product->categories()->detach();
                $product->recommended_products()->detach();
                $product->marketing_products()->detach();

                ProductAttribute::where('product_id', '=', $product->id)->delete();
                ProductVariation::where('product_id', '=', $product->id)->delete();
                $product->delete();

                $this->add_action("delete_product" ,'product', json_encode($product));
                CartService::update_cart_when_update_product();

               // update_categories_banners_app();
            });

            return general_response(true, true, "", "", "", []);
        } catch (\Exception $e) {
            return general_response(false, true, "", trans('admin.error'), "", []);

        }


    }


    public function get_products_ajax(Request $request)
    {

        $products_data = Product::with(['variation', 'categories' , 'automatic_coupon']);

        $category_id = $request->filled('category_id') ? $request->category_id : -1;
        $stock_status_id = $request->filled('stock_status_id') ? $request->stock_status_id : -1;
        $brand_id = $request->filled('brand_id') ? $request->brand_id : -1;
        $is_variation = $request->filled('is_variation') ? $request->is_variation : -1;

        $category_ids = [];
        if ($category_id != -1) {

            $tree = get_categories_cache();
            $tree = json_decode(collect($tree)->where('id', '=', $category_id), true);

            $conf = array('tree' => $tree);
            $instance = new SWWWTreeTraversal($conf);
            $category_ids = $instance->get();
        }

        $filters = [
            'category' => $category_ids,
            'stock_status' => $stock_status_id,
            'brand' => $brand_id,
            'is_variation' => $is_variation
        ];

        $products_data = $products_data->filter($filters);
        $products_data = $products_data->withCount(['all_variations' => function ($query) {
            $query->where('stock_status_id', '=', 1);
        }])->SalesCount();

        return DataTables::of($products_data)
            ->addColumn('price', function ($model) {
                return get_helper_product_price($model, false)['price'];
            })->addColumn('price_after', function ($model) {
                return get_helper_product_price($model , false)['price_after'];
            })->addColumn('discount_rate', function ($model) {
                return get_helper_product_price($model , false)['discount_rate'];
            })->addColumn('categories', function ($model) {
                return implode(" , ", $model->categories->pluck('name')->toArray());
            })->addColumn('stock_status', function ($model) {
                return view('admin.products.parts.stock_status', ['status' => $model->all_variations_count > 0 ? 1 : 0])->render();
            })
            ->addColumn('automatic_coupon', function ($model) {
                return $model->automatic_coupon ? $model->automatic_coupon->coupon : "";
            })
            ->addColumn('in_archive', function ($model) {
                return $model->in_archive == 1  ? trans('admin.yes') : trans('admin.no');
            })
            ->editColumn('show_image', function ($model) {
                return view('admin.products.parts.image', ['image' => $model->thumb_image])->render();
            })
            ->addColumn('actions', function ($model) {
                return view('admin.products.parts.actions', ['id' => $model->id])->render();
            })->escapeColumns(['*'])->make(true);
    }


    public function get_remote_ajax_products(Request $request)
    {
        $search = $request->get('q');
        $data = Product::select(['id', 'name_ar', 'name_en'])
            ->where('name_ar', 'like', '%' . $search . '%')
            ->orWhere('name_en', 'like', '%' . $search . '%')
            ->paginate(10);
        return response()->json(['items' => $data->toArray()['data'], 'incomplete_results' => $data->nextPageUrl() ? true : false, 'total_count' => $data->total()]);
    }
    public function get_remote_ajax_details_products(Request $request)
    {
        $search = $request->get('q');
        $data = Product::with(['attributes.attribute.attribute_type', 'attributes.attribute_values.attribute_value.attribute.attribute_type'])
            ->select(['id', 'name_ar', 'name_en' , 'image'])
            ->where('name_ar', 'like', '%' . $search . '%')
            ->orWhere('name_en', 'like', '%' . $search . '%')
            ->paginate(10);
        return response()->json(['items' => $data->toArray()['data'], 'incomplete_results' => $data->nextPageUrl() ? true : false, 'total_count' => $data->total()]);
    }
    public function get_remote_ajax_sku_products(Request $request)
    {
        $search = $request->get('q');
        $data = ProductVariation::with(['product'])->where('sku', 'like', '%' . $search . '%')->paginate(10);
        return response()->json(['items' => $data->toArray()['data'], 'incomplete_results' => $data->nextPageUrl() ? true : false, 'total_count' => $data->total()]);
    }
    public function get_product_variations(Request $request, $id)
    {
        $product_variations = $this->product->with(['all_variations.images', 'all_variations.product_shipping'])->find($id);
        return response()->json($product_variations);
    }
    public function order_status(Request $request){
        $sort_by = $request->filled('sort_by') ? $request->sort_by : 1;

        $stock_status = StockStatus::Active()->get();
        $categories =get_all_category_with_parents();
        $brands = Brand::all();

        parent::$data['stock_status'] = $stock_status;
        parent::$data['categories'] = $categories;
        parent::$data['brands'] = $brands;
        parent::$data['sort_by'] = $sort_by;
        parent::$data['active_menu'] = 'order_status';


        return view('admin.products.order_status.index', parent::$data);
    }
    public function get_product_variations_ajax(Request $request)
    {
        $products_data = ProductVariation::with(['product','attribute_values']);


        $category_id = $request->filled('category_id') ? $request->category_id : -1;
        $stock_status_id = $request->filled('stock_status_id') ? $request->stock_status_id : -1;
        $brand_id = $request->filled('brand_id') ? $request->brand_id : -1;
        $is_variation = $request->filled('is_variation') ? $request->is_variation : -1;
        $status = $request->filled('status') ? $request->status : -1;
        $name = $request->filled('name') ? $request->name : -1;



        $category_ids = [];
        if ($category_id != -1) {

            $tree = get_categories_cache();
            $tree = json_decode(collect($tree)->where('id', '=', $category_id), true);

            $conf = array('tree' => $tree);
            $instance = new SWWWTreeTraversal($conf);
            $category_ids = $instance->get();
        }

        $filters = [
            'category' => $category_ids,
            'stock_status' => $stock_status_id,
            'brand' => $brand_id,
            'is_variation' => $is_variation,
            'status' => $status,
            'name' => $name,

        ];


        $products_data = $products_data->filter($filters);


        return DataTables::of($products_data)
            ->editColumn('show_image', function ($model) {
                return view('admin.products.parts.image', ['image' => $model->product->thumb_image])->render();
            })

            ->addColumn('name', function ($model) {
                $attr_value = ' ';
                foreach ($model->attribute_values as $attr){
                    $attr_value .=' '. $attr->name;
                }
                return $model->product->name .'<br><br>'.$attr_value;
            })
            ->addColumn('actions', function ($model) {
                return view('admin.products.parts.order_status', ['id' => $model->id , 'order_status'=>$model->order_status])->render();
            })
            ->escapeColumns(['*'])->make(true);
    }

    public function change_order_status(Request $request){

        $product_id = $request->product_id;
        $status = $request->status ;


        $product = ProductVariation::find($product_id);
        $previous_status = $product->order_status;
        $product->order_status = $status;
        $product->save();



        if ($status > 0){
            $orders =   Order::whereIn('status',[0,1])->whereHas('order_products',function ($q)use ($product_id){
                $q->where('product_variation_id',$product_id);
            })->update(['status'=>1]);
        }

        $orders =  Order::whereIn('status',[0,1])->whereHas('order_products',function ($q)use($product_id){
           $q->where('product_variation_id',$product_id);
       })->whereHas('order_user_shipping',function($q){
           $q->whereHas('billing_shipping_type_',function ($q){
               $q->where('accept_user_shipping_address',0);
           });
        })->get();

        foreach ($orders as $order){
            Notification::route('test', 'test')->notify(new SendChangeProductStatusNotification($order,$product, $status) );
        }


        $this->add_action("change_order_status" ,'order', json_encode([
            'order'       => $product,
            'from_status' =>  trans_order_status()[$previous_status],
            'to_status'   =>  trans_order_status()[$status],
        ]));

        return general_response(true, true, trans('admin.change_order_status_success'), "", "", [
            'order' => $product
        ]);

    }

    public function add_note(Request $request){
        $product_id = $request->product_id;
        $note_at_the_harbour = $request->note_at_the_harbour ;
        $note_charged_at_sea = $request->note_charged_at_sea ;
        $note_charged_up = $request->note_charged_up ;
        $note_delivered = $request->note_delivered ;
        $note_in_manufacturing = $request->note_in_manufacturing ;
        $note_in_the_warehouse = $request->note_in_the_warehouse ;


        $product = ProductVariation::find($product_id);
        $product->note_at_the_harbour = $note_at_the_harbour;
        $product->note_charged_at_sea = $note_charged_at_sea;
        $product->note_charged_up = $note_charged_up;
        $product->note_delivered = $note_delivered;
        $product->note_in_manufacturing = $note_in_manufacturing;
        $product->note_in_the_warehouse = $note_in_the_warehouse;
        $product->save();






        return general_response(true, true, trans('admin.note_add_success'), "", "", [
            'order' => $product
        ]);
    }
}

