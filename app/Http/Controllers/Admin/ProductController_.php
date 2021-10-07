<?php

namespace App\Http\Controllers\Admin;


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
use Illuminate\Support\Facades\File;

use DB;

use Illuminate\Validation\Rule;

// validations
use App\Validations\ProductValidation;
// Repository
use App\Repository\ProductRepository;

class ProductController_ extends HomeController
{


    public function __construct(ProductRepository $Product, ProductValidation $validation)
    {
        // $this->middleware('check_admin');
        parent::__construct();
        $this->product = $Product;
        $this->validation = $validation;
        parent::$data['active_menu'] = 'products';

    }


    public function index(Request $request)
    {

        $sort_by = $request->filled('sort_by') ? $request->sort_by : 1;
        //   return $this->product->get_key_default_product(64);

        $stock_status = StockStatus::Active()->get();
        $categories = Category::all();
        $brands = Brand::all();

        parent::$data['stock_status'] = $stock_status;
        parent::$data['categories'] = $categories;
        parent::$data['brands'] = $brands;
        parent::$data['sort_by'] = $sort_by;

        return view('admin.products.index', parent::$data);
    }

    public function create(Request $request)
    {


        $cache_categories = get_categories_cache();
        $tax_status = TaxStatus::Active()->get();
        $stock_status = StockStatus::Active()->get();
        $attributes = Attribute::with('attribute_values:id,attribute_id,name_ar,name_en')->get();
        $categories = Category::all();
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

        $brands = Brand::all();

        parent::$data['tax_status'] = $tax_status;
        parent::$data['stock_status'] = $stock_status;
        parent::$data['attributes'] = $attributes;
        parent::$data['categories'] = $categories;
        parent::$data['main_categories'] = $main_categories;
        parent::$data['get_categories_with_children'] = json_encode($get_categories_with_children);
        parent::$data['brands'] = $brands;
        parent::$data['countries'] = $countries;


        return view('admin.products.add_product', parent::$data);
    }

    public function store(Request $request)
    {


        /*
        return response()->json($request->all());
        return response()->json($request->images[0]->getClientOriginalName());
        return response()->json($request->image_R71Ae59B1sQn2gS7zbCsl2FE6[0]->getClientOriginalName());

        */

        try {

            $categories = $request->categories != "" ? explode(",", $request->categories) : [];
            $brand_id = $request->brand_id;
            $recommended_products = $request->recommended_products != "" ? explode(",", $request->recommended_products) : [];
            $marketing_products = $request->marketing_products != "" ? explode(",", $request->marketing_products) : [];
            $product_attributes = json_decode($request->product_attributes);
            $attribute_value_variations = json_decode($request->attribute_value_variations);
            $checked_variations = json_decode($request->checked_variations);

            $select_country = $request->select_country;
            $countries = explode(",", $request->countries);

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

            // check countries
            if ($select_country == 2) {
                $check_countries = $this->validation->check_countries(['countries' => $countries]);
                if (!$check_countries['status']) {
                    return general_response(false, true, "", $check_countries['message'], "", []);
                }
            }
            // handle image
            if ($request->hasFile('image')) {
                $path = (new StoreFile($request->image))->store_local('products');
            } else {
                $path = get_default_image();
            }

            $images = [];
            if ($request->has('images')) {
                foreach ($request->images as $image) {
                    $path2 = (new StoreFile($image))->store_local('products');
                    $images[] = ['image' => $path2];
                }
            }


            ////////////////////////////////////////////////////
            $data['public'] = $request->all();
            $data['select_country'] = $select_country;
            $data['countries'] = $countries;
            $data['image'] = $path;
            $data['images'] = $images;
            $data['categories'] = $categories;
            $data['brand_id'] = $brand_id;
            $data['product_attributes'] = $product_attributes;
            $data['attribute_value_variations'] = $attribute_value_variations;
            $data['recommended_products'] = $recommended_products;
            $data['marketing_products'] = $marketing_products;
            $data['checked_variations'] = $checked_variations;


            $product_data = $this->product->get_filter_product_data($data);
            // return response()->json($product_data);

            $product = $this->product->add_product($product_data);
            // return response()->json($product);


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
            'marketing_products:products.id,name_ar,name_en', 'categories', 'attributes.attribute_values' ,'countries'])
            ->find($id);

        $cache_categories = get_categories_cache();
        $tax_status = TaxStatus::Active()->get();
        $stock_status = StockStatus::Active()->get();
        $attributes = Attribute::with('attribute_values:id,attribute_id,name_ar,name_en')->get();
        $categories = Category::all();
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

        //return parent::$data['product'];
        return view('admin.products.edit_product', parent::$data);
    }

    public function update(Request $request)
    {


        try {

            $categories = $request->categories != "" ? explode(",", $request->categories) : [];
            $brand_id = $request->brand_id;
            $recommended_products = $request->recommended_products != "" ? explode(",", $request->recommended_products) : [];
            $marketing_products = $request->marketing_products != "" ? explode(",", $request->marketing_products) : [];
            $product_attributes = json_decode($request->product_attributes);
            $attribute_value_variations = json_decode($request->attribute_value_variations);
            $edit_images_removed = json_decode($request->edit_images_removed);
            $edit_product_images_removed = json_decode($request->edit_product_images_removed);
            $checked_variations = json_decode($request->checked_variations);
            $get_key_product_variations = collect($attribute_value_variations)->pluck('key')->toArray();

            $select_country = $request->select_country;
            $countries = explode(",", $request->countries);

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
            if ($request->hasFile('image')) {
                $path = (new StoreFile($request->image))->store_local('products');
            } else {
                $path = $get_product->getOriginal('image');
            }


            $images = [];
            if ($request->has('images')) {
                foreach ($request->images as $image) {
                    $path2 = (new StoreFile($image))->store_local('products');
                    $images[] = ['image' => $path2];
                }
            }


            foreach ($edit_product_images_removed as $remove_product_image) {
                File::delete(public_path('') . "/uploads/products/" . $remove_product_image);
            }
            ProductImage::where('product_id', '=', $request->id)
                ->whereIn('image', $edit_product_images_removed)
                ->delete();


            foreach ($edit_images_removed as $remove_image) {
                File::delete(public_path('') . "/uploads/products/" . $remove_image);

                ProductVariationImage::whereIn('product_variation_id', $get_product_variation_ids)
                    ->whereIn('image', $edit_images_removed)
                    ->delete();
            }


            ////////////////////////////////////////////////////

            $data['public'] = $request->all();
            $data['select_country'] = $select_country;
            $data['countries'] = $countries;
            $data['checked_variations'] = $checked_variations;
            $data['image'] = $path;
            $data['images'] = $images;
            $data['categories'] = $categories;
            $data['brand_id'] = $brand_id;
            $data['product_attributes'] = $product_attributes;
            $data['attribute_value_variations'] = $attribute_value_variations;
            $data['recommended_products'] = $recommended_products;
            $data['marketing_products'] = $marketing_products;
            $product_data = $this->product->get_filter_product_data($data, true);
            $product = $this->product->update_product($product_data, $get_product_variations);

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


        } catch (\Exception $e1) {
            return general_response(false, true, "", $e1->getMessage(), "", [
                'error_tab_id' => '_product_tab_1'
            ]);
        } catch (\Error $e2) {
            return general_response(false, true, "", $e2->getMessage(), "", [
                'error_tab_id' => '_product_tab_1'
            ]);
        }

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
                ProductAttributeValue::whereIn('product_attribute_id', $product_attributes)->delete();
                ProductVariationImage::whereIn('product_variation_id', $product_variations)->delete();
                ProductVariationShipping::whereIn('product_variation_id', $product_variations)->delete();
                $product->categories()->detach();
                $product->recommended_products()->detach();
                $product->marketing_products()->detach();

                ProductAttribute::where('product_id', '=', $product->id)->delete();
                ProductVariation::where('product_id', '=', $product->id)->delete();
                $product->delete();
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
                return get_helper_product_price($model)['price'];
            })->addColumn('price_after', function ($model) {
                return get_helper_product_price($model)['price_after'];
            })->addColumn('discount_rate', function ($model) {
                return get_helper_product_price($model)['discount_rate'];
            })->addColumn('categories', function ($model) {
                return implode(" , ", $model->categories->pluck('name')->toArray());
            })->addColumn('stock_status', function ($model) {
                return view('admin.products.parts.stock_status', ['status' => $model->all_variations_count > 0 ? 1 : 0])->render();
            })
            ->addColumn('automatic_coupon', function ($model) {
                return $model->automatic_coupon ? $model->automatic_coupon->coupon : "";
            })
            ->editColumn('show_image', function ($model) {
                return view('admin.products.parts.image', ['image' => $model->image])->render();
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

    public function get_product_variations(Request $request, $id)
    {
        $product_variations = $this->product->with(['all_variations.images', 'all_variations.product_shipping'])->find($id);
        return response()->json($product_variations);
    }
}
