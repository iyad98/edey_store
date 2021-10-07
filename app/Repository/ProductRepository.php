<?php
/**
 * Created by PhpStorm.
 * User: HP15
 * Date: 16/8/2019
 * Time: 7:12 م
 */

namespace App\Repository;

use App\Models\ProductCategory;
use Illuminate\Http\Request;

// models
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductAttributeValue;
use App\Models\ProductVariation;
use App\Models\ProductAttribute;
use App\Models\ProductVariationShipping;
use App\Models\Country;
use App\Models\Setting;

// services
use App\Services\SWWWTreeTraversal;
use Illuminate\Support\Facades\Cache;
use App\Services\StoreFile;
use App\Services\ResizeImageService;

use DB;

//Resources
use App\Http\Resources\CategoryResourceDFT;
use Carbon\Carbon;

use  App\Traits\FileTrait;
use App\Traits\ActionLogTrait;


use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductRepository
{
    use FileTrait, ActionLogTrait;

    public $Product;

    public function __construct(Product $Product)
    {
        $this->product = $Product;
    }

    public function __call($name, $arguments)
    {
        return $this->product->$name(...$arguments);
    }

    public function get_general_data_product($user_id = -1)
    {
        return $this->product->GetGeneralDataProduct($user_id);
    }


    // add product
    public function get_filter_product_data($data, $edit = false)
    {

        $selected_countries = [];
        $excluded_countries = [];

        if ($edit) {
            $response['id'] = $data['public']['id'];

        }
        $response['product_type'] = $data['public']['product_type'];
        $response['product_data'] = [
            'name_ar' => str_replace("أ", "ا", $data['public']['name_ar']),
            'name_en' => array_key_exists('name_en', $data['public']) && !empty($data['public']['name_en']) ? $data['public']['name_en'] : $data['public']['name_ar'],
            'description_ar' => $data['public']['description_ar'],
            'description_en' => $data['public']['description_en'],
            'brand_id' => $data['brand_id'],
            'merchant_id' => $data['merchant_id'],
            'is_variation' => $data['public']['product_type'] == 1 ? 0 : 1,
            'tax_status_id' => $data['public']['tax_status_id'],
            'image' => $data['image'],
            'in_day_deal' => $data['public']['in_day_deal'],
            'is_exclusive' => $data['public']['is_exclusive'],
            'in_offer' => $data['public']['in_offer'],
            'can_returned' => $data['public']['can_returned'],
            'can_gift' => $data['public']['can_gift'],
            'in_archive' => $data['public']['in_archive'],
            'regular_price' => $data['public']['regular_price'],
            'discount_price' => $data['public']['discount_price'],
            'sku' => $data['public']['sku'],

        ];
        /*if($data['image'] != -1) {
            $response['product_data']['image'] = $data['image'];
        }*/

        try {
            $start_at = Carbon::createFromFormat("Y-m-d h:i A", $data['public']['discount_start_at']);
            $end_at = Carbon::createFromFormat("Y-m-d h:i A", $data['public']['discount_end_at']);

        } catch (\Exception $e) {
            $start_at = null;
            $end_at = null;
        } catch (\Error $e) {
            $start_at = null;
            $end_at = null;
        }

        $response['product_variation'] = [
            'key' => '*',
            'cost_price' => $data['public']['cost_price'],
            'regular_price' => $data['public']['regular_price'],
            'discount_price' => $data['public']['discount_price'] ? $data['public']['discount_price'] : $data['public']['regular_price'],
            'stock_status_id' => $data['public']['stock_status_id'],
            'stock_quantity' => $data['public']['stock_quantity'],
            'sku' => $data['public']['sku'],
            'remain_product_count_in_low_stock' => $data['public']['remain_product_count_in_low_stock'],
            'min_quantity' => $data['public']['min_quantity'],
            'max_quantity' => $data['public']['max_quantity'],
            'is_default_select' => 1,
            'discount_start_at' => $start_at,
            'discount_end_at' => $end_at,

        ];
        $response['product_shipping'] = [
            'weight' => $data['public']['weight'] ? $data['public']['weight'] : 0,
            'length' => $data['public']['length'] ? $data['public']['length'] : 0,
            'width' => $data['public']['width'] ? $data['public']['width'] : 0,
            'height' => $data['public']['height'] ? $data['public']['height'] : 0,
        ];
        $response['recommended_products'] = $data['recommended_products'];
        $response['marketing_products'] = $data['marketing_products'];
        $response['sub_products'] = $data['sub_products'];

        $response['images'] = $data['images'];
        $response['categories'] = $data['categories'];
        $response['product_attributes'] = $data['product_attributes'];
        $response['attribute_value_variations'] = $data['attribute_value_variations'];
        $response['checked_variations'] = $data['checked_variations'];


        $countries = [];
        foreach ($data['countries'] as $select_country) {
            if (!empty($select_country)) {
                $countries[$select_country] = ['status' => 1];
            }
        }

        foreach ($data['excluded_countries'] as $excluded_country) {
            if (!empty($excluded_country)) {
                $countries[$excluded_country] = ['status' => 0];

            }
        }
        $response['countries'] = $countries;

        foreach ($data['attribute_value_variations'] as $attribute_value_variation) {

            $get_key = 'image_' . $attribute_value_variation->random_id;
            if (array_key_exists($get_key, $data['public'])) {
                $response[$get_key] = $data['public'][$get_key];
            }
        }


        return $response;

    }

    public function add_product($data)
    {
        DB::transaction(function () use ($data) {
            $is_variation = $data['product_type'] == 1 ? 0 : 1;
            $product = $this->product->create($data['product_data']);
            $product->recommended_products()->sync($data['recommended_products']);
            $product->marketing_products()->sync($data['marketing_products']);
            $product->sub_products()->sync($data['sub_products']);
            $product->categories()->sync($data['categories']);
            $product->images()->createMany($data['images']);

            $productCategory = ProductCategory::query()->where('product_id', $product->id)->get();

            foreach ($productCategory as $productr) {
                $productr->update([
                    'merchant_id' => $data['product_data']['merchant_id'],
                ]);
            }

            foreach ($data['product_attributes'] as $product_attribute) {
                $attribute = $product->attributes()->create(['attribute_id' => $product_attribute->id, 'is_variation' => in_array($product_attribute->id, $data['checked_variations']) ? 1 : 0]);
                $selected_arr = [];
                $index = 0;
                foreach ($product_attribute->selected as $selected) {
                    $selected_arr[] = ['product_attribute_id' => $attribute->id, 'attribute_value_id' => $selected, 'is_selected' => $index == 0 ? 1 : 0];
                    $index = $index + 1;
                }
                ProductAttributeValue::insert($selected_arr);

            }

            if ($data['product_type'] == 1) {
                $data['product_variation']['product_id'] = $product->id;
                $product_variation = ProductVariation::create($data['product_variation']);
                //  $product_variation->images()->createMany($data['images']);
                $product_variation->product_shipping()->create($data['product_shipping']);
            } else {


                foreach ($data['attribute_value_variations'] as $attribute_value_variation) {
                    try {
                        $start_at = Carbon::createFromFormat("Y-m-d h:i A", $attribute_value_variation->product_variation->discount_start_at);
                        $end_at = Carbon::createFromFormat("Y-m-d h:i A", $attribute_value_variation->product_variation->discount_end_at);

                    } catch (\Exception $e) {
                        $start_at = null;
                        $end_at = null;
                    } catch (\Error $e) {
                        $start_at = null;
                        $end_at = null;
                    }

                    $product_variation = ProductVariation::create([
                        'product_id' => $product->id,
                        'key' => $attribute_value_variation->key,
                        'description_ar' => $attribute_value_variation->product_variation->description_ar,
                        'description_en' => $attribute_value_variation->product_variation->description_en,
                        'cost_price' => $attribute_value_variation->product_variation->cost_price,
                        'regular_price' => $attribute_value_variation->product_variation->regular_price,
                        'discount_price' => $attribute_value_variation->product_variation->discount_price ? $attribute_value_variation->product_variation->discount_price : $attribute_value_variation->product_variation->regular_price,
                        'min_quantity' => $attribute_value_variation->product_variation->min_quantity,
                        'max_quantity' => $attribute_value_variation->product_variation->max_quantity,
                        'sku' => $attribute_value_variation->product_variation->sku,
                        'stock_management_status' => 1,
                        'stock_status_id' => $attribute_value_variation->product_variation->stock_status_id,
                        'stock_quantity' => $attribute_value_variation->product_variation->stock_quantity,
                        'remain_product_count_in_low_stock' => $attribute_value_variation->product_variation->remain_product_count_in_low_stock,
                        //  'is_default_select' => $attribute_value_variation->is_selected,
                        'is_default_select' => 0,
                        'discount_start_at' => $start_at,
                        'discount_end_at' => $end_at,


                    ]);

                    $attribute_values = collect($attribute_value_variation->values)->pluck('id')->toArray();
                    $product_variation->attribute_values()->sync($attribute_values);
                    $images = [];
                    foreach (json_decode(json_encode($attribute_value_variation->product_variation->images), true) as $image) {

                        if (array_key_exists('src', $image)) {
                            $path2 = $this->store_file_service($image['id'], 'products', null, null, true);
                            $images[] = ['image' => $path2];
                        }
                    }
                    $product_variation->images()->createMany($images);

                    // $product_variation->images()->createMany($data['images']);
                    ProductVariationShipping::updateOrCreate(
                        [
                            'product_variation_id' => $product_variation->id
                        ]
                        ,
                        [
                            'weight' => $attribute_value_variation->product_variation->weight ? $attribute_value_variation->product_variation->weight : 0,
                            'length' => $attribute_value_variation->product_variation->length ? $attribute_value_variation->product_variation->length : 0,
                            'width' => $attribute_value_variation->product_variation->width ? $attribute_value_variation->product_variation->width : 0,
                            'height' => $attribute_value_variation->product_variation->height ? $attribute_value_variation->product_variation->height : 0,

                        ]);

                }

            }

            $get_default_key = $this->get_key_default_product($product->id);
            ProductVariation::where('product_id', '=', $product->id)->where('key', '=', $get_default_key)
                ->update(['is_default_select' => 1]);

            if ($product->is_variation == 1) {
                $get_min_max_price = ProductVariation::where('product_id', '=', $product->id)
                    ->select(DB::raw('min(regular_price) as min_price'), DB::raw('max(regular_price) as max_price')
                        , DB::raw('min(regular_price - discount_price)'), DB::raw('max(regular_price - discount_price)'))
                    ->first();

                $product->min_price = $get_min_max_price->min_price;
                $product->max_price = $get_min_max_price->max_price;
                $product->update();
            }


            $product->countries()->sync($data['countries']);
            ResizeImageService::resize_product_image($product, 200, 200);

            $this->add_action("add_product", 'product', json_encode($product));
            return $product;
        });


    }

    public function update_product($data, $get_product_variations)
    {

        DB::transaction(function () use ($data, $get_product_variations) {

            $product = $this->product->find($data['id']);
            $is_variation = $data['product_type'] == 1 ? 0 : 1;

            $product->update($data['product_data']);
            $product->recommended_products()->sync($data['recommended_products']);
            $product->marketing_products()->sync($data['marketing_products']);
            $product->sub_products()->sync($data['sub_products']);

            $product->categories()->sync($data['categories']);
            $product->images()->createMany($data['images']);

            $get_product_attributes = ProductAttribute::where('product_id', '=', $data['id'])->get();


            foreach ($data['product_attributes'] as $product_attribute) {

                $attribute = $get_product_attributes->where('attribute_id', '=', $product_attribute->id)->first();

                if ($attribute) {
                    if (in_array($attribute->attribute_id, $data['checked_variations'])) {
                        $attribute->is_variation = 1;
                    } else {
                        $attribute->is_variation = 0;
                    }
                    $attribute->update();
                } else {
                    $attribute = $product->attributes()->create(['attribute_id' => $product_attribute->id, 'is_variation' => in_array($product_attribute->id, $data['checked_variations']) ? 1 : 0]);
                }

                $selected_arr = [];
                $index = 0;
                foreach ($product_attribute->selected as $selected) {
                    $selected_arr[] = ['product_attribute_id' => $attribute->id, 'attribute_value_id' => $selected, 'is_selected' => $index == 0 ? 1 : 0];
                    $index = $index + 1;
                }

                ProductAttributeValue::where('product_attribute_id', '=', $attribute->id)->delete();
                ProductAttributeValue::insert($selected_arr);


            }

            // removed attribute not used
            $get_attribute_used_ids = collect($data['product_attributes'])->pluck('id')->toArray();
            $get_product_attribute_removed_ids = ProductAttribute::where('product_id', '=', $product->id)
                ->whereNotIn('attribute_id', $get_attribute_used_ids)
                ->pluck('id')->toArray();


            ProductAttributeValue::whereIn('product_attribute_id', $get_product_attribute_removed_ids)->delete();
            ProductAttribute::whereIn('id', $get_product_attribute_removed_ids)->delete();


            if ($data['product_type'] == 1) {

                $product_variation = ProductVariation::where('product_id', '=', $data['id'])->where('key', '=', '*')->first();
                if (!$product_variation) {
                    $data['product_variation']['product_id'] = $product->id;
                    $product_variation = ProductVariation::create($data['product_variation']);
                } else {
                    $product_variation->update($data['product_variation']);
                }

                // $product_variation->images()->createMany($data['images']);

                ProductVariationShipping::updateOrCreate([
                    'product_variation_id' => $product_variation->id
                ], $data['product_shipping']);

                ProductAttribute::where('product_id', '=', $data['id'])->update([
                    'is_variation' => 0
                ]);
                /*
                $get_product_attributes = ProductAttribute::where('product_id', '=', $data['id'])->pluck('id')->toArray();
                ProductAttributeValue::whereIn('product_attribute_id', $get_product_attributes)->delete();
                ProductAttribute::where('product_id', '=', $data['id'])->delete();

                */
            } else {


                foreach ($data['attribute_value_variations'] as $attribute_value_variation) {

                    try {
                        $start_at = Carbon::createFromFormat("Y-m-d h:i A", $attribute_value_variation->product_variation->discount_start_at);
                        $end_at = Carbon::createFromFormat("Y-m-d h:i A", $attribute_value_variation->product_variation->discount_end_at);

                    } catch (\Exception $e) {
                        $start_at = null;
                        $end_at = null;
                    } catch (\Error $e) {
                        $start_at = null;
                        $end_at = null;
                    }

                    $check_product_variations_found = $get_product_variations->where('key', '=', $attribute_value_variation->key)->first();
                    if ($check_product_variations_found) {
                        $product_variation = $check_product_variations_found;

                        $product_variation->update([
                            'product_id' => $product->id,
                            'key' => $attribute_value_variation->key,
                            'description_ar' => $attribute_value_variation->product_variation->description_ar,
                            'description_en' => $attribute_value_variation->product_variation->description_en,
                            'cost_price' => $attribute_value_variation->product_variation->cost_price,
                            'regular_price' => $attribute_value_variation->product_variation->regular_price, //$data['product_data']['regular_price']
                            'discount_price' => $attribute_value_variation->product_variation->discount_price ? $attribute_value_variation->product_variation->discount_price : $attribute_value_variation->product_variation->regular_price, // $data['product_data']['discount_price'] ? $data['product_data']['discount_price'] : $data['product_data']['regular_price']
                            'min_quantity' => $attribute_value_variation->product_variation->min_quantity,
                            'max_quantity' => $attribute_value_variation->product_variation->max_quantity,
                            'sku' => $attribute_value_variation->product_variation->sku, //$data['product_data']['sku']
                            'stock_management_status' => 1,
                            'stock_status_id' => $attribute_value_variation->product_variation->stock_status_id,
                            'stock_quantity' => $attribute_value_variation->product_variation->stock_quantity,
                            'remain_product_count_in_low_stock' => $attribute_value_variation->product_variation->remain_product_count_in_low_stock,
                            //  'is_default_select' => $attribute_value_variation->is_selected,
                            'is_default_select' => 0,
                            'discount_start_at' => $start_at,
                            'discount_end_at' => $end_at,
                        ]);
                        $attribute_values = collect($attribute_value_variation->values)->pluck('id')->toArray();
                        $product_variation->attribute_values()->sync($attribute_values);
                        $images = [];
                        foreach (json_decode(json_encode($attribute_value_variation->product_variation->images), true) as $image) {

                            if (array_key_exists('src', $image)) {
                                $path2 = $this->store_file_service($image['id'], 'products', null, null, true);
                                $images[] = ['image' => $path2];
                            }
                        }

                        $product_variation->images()->createMany($images);


                        // $product_variation->images()->createMany($data['images']);

                        ProductVariationShipping::updateOrCreate([
                            'product_variation_id' => $product_variation->id
                        ], [
                            'weight' => $attribute_value_variation->product_variation->weight ? $attribute_value_variation->product_variation->weight : 0,
                            'length' => $attribute_value_variation->product_variation->length ? $attribute_value_variation->product_variation->length : 0,
                            'width' => $attribute_value_variation->product_variation->width ? $attribute_value_variation->product_variation->width : 0,
                            'height' => $attribute_value_variation->product_variation->height ? $attribute_value_variation->product_variation->height : 0,

                        ]);


                    } else {

                        try {
                            $start_at = Carbon::createFromFormat("Y-m-d h:i A", $attribute_value_variation->product_variation->discount_start_at);
                            $end_at = Carbon::createFromFormat("Y-m-d h:i A", $attribute_value_variation->product_variation->discount_end_at);

                        } catch (\Exception $e) {
                            $start_at = null;
                            $end_at = null;
                        } catch (\Error $e) {
                            $start_at = null;
                            $end_at = null;
                        }

                        $product_variation = ProductVariation::create([
                            'product_id' => $product->id,
                            'key' => $attribute_value_variation->key,
                            'description_ar' => $attribute_value_variation->product_variation->description_ar,
                            'description_en' => $attribute_value_variation->product_variation->description_en,
                            'cost_price' => $attribute_value_variation->product_variation->cost_price,
                            'regular_price' => $attribute_value_variation->product_variation->regular_price,
                            'discount_price' => $attribute_value_variation->product_variation->discount_price ? $attribute_value_variation->product_variation->discount_price : $attribute_value_variation->product_variation->regular_price,
                            'min_quantity' => $attribute_value_variation->product_variation->min_quantity,
                            'max_quantity' => $attribute_value_variation->product_variation->max_quantity,
                            'sku' => $attribute_value_variation->product_variation->sku,
                            'stock_management_status' => 1,
                            'stock_status_id' => $attribute_value_variation->product_variation->stock_status_id,
                            'stock_quantity' => $attribute_value_variation->product_variation->stock_quantity,
                            'remain_product_count_in_low_stock' => $attribute_value_variation->product_variation->remain_product_count_in_low_stock,
                            //  'is_default_select' => $attribute_value_variation->is_selected,
                            'is_default_select' => 0,
                            'discount_start_at' => $start_at,
                            'discount_end_at' => $end_at,

                        ]);

                        $attribute_values = collect($attribute_value_variation->values)->pluck('id')->toArray();
                        $product_variation->attribute_values()->sync($attribute_values);
                        $images = [];
                        foreach (json_decode(json_encode($attribute_value_variation->product_variation->images), true) as $image) {

                            if (array_key_exists('src', $image)) {
                                $path2 = $this->store_file_service($image['id'], 'products', null, null, true);
                                $images[] = ['image' => $path2];
                            }
                        }


                        $product_variation->images()->createMany($images);

                        // $product_variation->images()->createMany($data['images']);
                        ProductVariationShipping::updateOrCreate([
                            'product_variation_id' => $product_variation->id
                        ], [
                            'weight' => $attribute_value_variation->product_variation->weight ? $attribute_value_variation->product_variation->weight : 0,
                            'length' => $attribute_value_variation->product_variation->length ? $attribute_value_variation->product_variation->length : 0,
                            'width' => $attribute_value_variation->product_variation->width ? $attribute_value_variation->product_variation->width : 0,
                            'height' => $attribute_value_variation->product_variation->height ? $attribute_value_variation->product_variation->height : 0,

                        ]);
                    }


                }

            }

            $get_default_key = $this->get_key_default_product($product->id);
            ProductVariation::where('product_id', '=', $product->id)->where('key', '=', $get_default_key)
                ->update(['is_default_select' => 1]);

            if ($product->is_variation == 1) {
                $get_min_max_price = ProductVariation::where('product_id', '=', $product->id)
                    ->select(DB::raw('min(regular_price) as min_price'), DB::raw('max(regular_price) as max_price')
                        , DB::raw('min(regular_price - discount_price)'), DB::raw('max(regular_price - discount_price)'))
                    ->first();

                $product->min_price = $get_min_max_price->min_price;
                $product->max_price = $get_min_max_price->max_price;
                $product->update();
            }


            $product->countries()->sync($data['countries']);
            ResizeImageService::resize_product_image($product, 200, 200);
            return $product;

        });

    }

    // helper
    public function get_filter_data(Request $request)
    {

        $lat = $request->filled('lat') ? $request->lat : null;
        $lng = $request->filled('lng') ? $request->lng : null;

        $name = $request->filled('name') ? $request->name : -1;
        $brand_id = $request->filled('brand_id') ? $request->brand_id : -1;
        $category_id = $request->filled('category_id') && $request->category_id != -1 ? $request->category_id : -1;

        $country_code = $request->get_country_code_data;
        if ($country_code) {
            $country = Country::where('iso2', '=', $country_code)->first();
        } else {
            $country = null;
        }

        $category_ids = [];
        if ($category_id != -1) {

            $tree = get_categories_cache();
            $tree = json_decode(collect($tree)->where('id', '=', $category_id), true);

            $conf = array('tree' => $tree);
            $instance = new SWWWTreeTraversal($conf);
            $category_ids = $instance->get();
        }

        return [
            'name' => $name,
            'brand' => $brand_id,
            'category' => $category_ids,
            'country' => $country ? $country->id : null
        ];
    }

    public function set_order_by_product(Request $request, $products)
    {


        $keys = ['oldest', 'latest', 'price_asc', 'price_desc', 'most_sales'];
        $order_by = $request->filled('order_by') && in_array($request->order_by, $keys) ? $request->order_by : null;
        if (!is_null($order_by)) {
            $key_order_by = "created_at";
            $order_by_type = 'desc';
            switch ($order_by) {

                case "oldest" :
                    $key_order_by = "created_at";
                    $order_by_type = 'asc';
                    break;

                case "latest" :
                    $key_order_by = "created_at";
                    $order_by_type = 'desc';
                    break;

                case "most_sales" :
                    $key_order_by = "orders_count";
                    $order_by_type = 'desc';
                    break;


                case "price_asc" :
                    $subQuery1 = ProductVariation::select(DB::raw('discount_price'))
                        ->whereRaw('product_id = products.id')
                        ->whereRaw('is_default_select = 1');

                    $key_order_by = getSubQuerySql($subQuery1);
                    $order_by_type = 'asc';
                    break;

                case "price_desc" :
                    $subQuery1 = ProductVariation::select(DB::raw('discount_price'))
                        ->whereRaw('product_id = products.id')
                        ->whereRaw('is_default_select = 1');

                    $key_order_by = getSubQuerySql($subQuery1);
                    $order_by_type = 'desc';
                    break;
            }
            $products = $products->orderBy($key_order_by, $order_by_type);

        }
        return $products;
    }

    public function get_key_product($product_id, $attribute_values)
    {

        $get_attributes = ProductAttributeValue::whereHas('attribute_product', function ($query) use ($product_id) {
            $query->where('product_id', '=', $product_id)->where('is_variation', '=', 1);
        })->whereIn('attribute_value_id', $attribute_values)
            ->orderBy('attribute_value_id', 'asc')
            ->pluck('attribute_value_id')->toArray();

        $get_attributes = array_unique($get_attributes);
        $key = implode("-", $get_attributes);
        if (empty($key)) {
            $key = "*";
        }
        return $key;
    }

    public function get_key_default_product($product_id)
    {
        $attribute_values = ProductAttributeValue::whereHas('attribute_product', function ($query) use ($product_id) {
            $query->where('product_id', '=', $product_id)->where('is_variation', '=', 1);
        })->where('is_selected', '=', 1)
            ->pluck('attribute_value_id')
            ->toArray();

        sort($attribute_values);
        $key = implode("-", $attribute_values);
        if (empty($key)) {
            $key = "*";
        }
        return $key;
    }

    // get product details
    public function get_product_details($id, $user_id)
    {
        $product = $this->product
            ->GetGeneralDataProduct($user_id)
            ->with(['brand', 'tax_status', 'categories', 'variation.images', 'variation.cart_products',
                'variation' => function ($query) use ($user_id) {
                    $query->GetGeneralDataProduct($user_id);
                },
                'attributes.attribute.attribute_type', 'attributes.attribute_values.attribute_value.attribute.attribute_type'])
            ->find($id);

        return $product;
    }

    public function related_products($product, $user_id)
    {
        $related_products = $product->recommended_products();
        if ($related_products->count() <= 0) {
            $category_ids = $product->categories()->pluck('categories.id')->toArray();
            $related_products = $product->filter(['category' => $category_ids]);
        }
        $related_products = $related_products->limit(10)
            ->where('products.id', '<>', $product->id)
            ->GetGeneralDataProduct($user_id)->get();
        return $related_products;
    }

    public function marketing_products($product, $user_id)
    {
        $marketing_products = $product->marketing_products();
        if ($marketing_products->count() <= 0) {
            $category_ids = $product->categories()->pluck('categories.id')->toArray();
            $marketing_products = $product->filter(['category' => $category_ids]);
        }
        $marketing_products = $marketing_products->limit(10)
            ->where('products.id', '<>', $product->id)
            ->GetGeneralDataProduct($user_id)->get();
        return $marketing_products;
    }

    public function get_product_details_note($request)
    {
        $product_details_note = Setting::whereIn('key', ['product_details_note1', 'product_details_note2'])->get();
        $product_details_note1 = $product_details_note->where('key', 'product_details_note1')->first();
        $product_details_note2 = $product_details_note->where('key', 'product_details_note2')->first();

        $product_details_note1 = $product_details_note1 ? $product_details_note1->value : "";
        $product_details_note2 = $product_details_note2 ? $product_details_note2->value : "";


        $request->request->add(['product_details_note1' => $product_details_note1, 'product_details_note2' => $product_details_note2]);
    }

    /* validations */
    public function check_add_product_to_compare(Request $request)
    {
        $rules = [
            'product_id' => [
                'required', 'integer',
                Rule::exists('products', 'id')->whereNull('deleted_at'),
            ]
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors();
            $get_one_message = get_error_msg($rules, $messages);
            return ['status' => false, 'message' => $get_one_message];
        } else {
            return ['status' => true, 'message' => ""];
        }
    }


}
