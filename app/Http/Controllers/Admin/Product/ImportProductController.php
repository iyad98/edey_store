<?php

namespace App\Http\Controllers\Admin\Product;

use App\Exports\ProductsExport;
use App\Http\Controllers\Controller;
use App\Imports\ProductImport;
use App\Imports\UsersImport;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Company;
use App\Models\EffectiveMaterial;
use App\Models\Gallery;
use App\Models\MedicineType;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use App\Models\ProductImage;
use App\Models\ProductVariation;
use App\Models\ProductVariationImage;
use Carbon\Carbon;
use Excel;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ImportProductController extends Controller
{
    public function __construct()
    {

    }
    public function import_product()
    {
        $products = Excel::toArray(new ProductImport, public_path('') . '/imports/��اصناف المتجر2020 (1)�.xlsx');
        $all_products = collect($products[0]);
        $get_products = $all_products->where('product_id', '=', '-')->values();
        $get_attributes = Attribute::all();
        $get_attribute_values = AttributeValue::all();
        $get_brands = Brand::all();

        foreach ($get_products as $product) {
            $store_images = [];
            $categories = Category::whereIn('name_ar', explode(',', $product['categories']))->pluck('id')->toArray();
            $product_images = explode(',', $product['image']);
            $get_image = "defullt.png";

            foreach ($product_images as $index => $image) {
                if($index == 0) {
                    $get_image = $image;
                }else {
                    $store_images[] = ['image' => $image];
                }
            }

            $attributes = $product['attributes'];
            $attrs = explode('(^&*)', $attributes);

            $product_data = [
                'code' => $product['id'],
                'image' => !$get_image || empty($get_image) ? "defullt.png" :$get_image ,
                'name_en' => $product['name_ar'],
                'name_ar' => $product['name_en'],
                'description_en' => $product['description_ar'],
                'description_ar' => $product['description_en'],
                'brand_id' => optional($get_brands->where('name_ar', '=', $product['brand'])->first())->id,
                'is_variation' => $all_products->where('product_id', '=', $product['id'])->count() > 0 ? 1 : 0,
                'tax_status_id' => $product['tax_status_id'] == "taxable" ? 1 : 0,
            ];
            $new_product = Product::create($product_data);
            $new_product->categories()->sync($categories);
            $new_product->images()->createMany($store_images);

            $attribute___ids__ = [];
            foreach ($attrs as $attr) {
                $attr_ = explode(":", $attr);
                $attribute___ = $get_attributes->where('name_ar' ,'=',$attr_[0])->first();
                if($attribute___) {
                    $attribute___ids__[] =$attribute___->id;
                    $new_attribute = $new_product->attributes()->create([
                        'attribute_id' => $attribute___->id ,
                        'is_variation' => 1
                    ]);
                    $index = 0;
                    $add_attribute__values__ = [];


                    $get_attribute_values_as_array = $get_attribute_values
                        ->whereIn('attribute_id',$attribute___ids__)
                        ->whereIn('name_ar' ,explode('(#$%)',$attr_[1]))
                        ->pluck('id')->toArray();

                    /*****************************************/
                    foreach ($get_attribute_values_as_array as $add_attribute_1_value) {

                        $add_attribute__values__[] = [
                            'product_attribute_id' => $new_attribute->id,
                            'attribute_value_id' => $add_attribute_1_value,
                            'is_selected' => $index == 0 ? 1 : 0,
                        ];
                        $index++;
                    }
                    ProductAttributeValue::insert($add_attribute__values__);
                }

            }
            $product_variation_index = 0;
            foreach ($all_products->where('product_id' ,'=' , $product['id'])->values() as $sub_product){
                $store_images_2 = [];
                $images_variation = explode(',', $sub_product['image']);
                $attribute_value_ids = $get_attribute_values
                    ->whereIn('attribute_id',$attribute___ids__)
                    ->whereIn('name_ar' ,explode('(#$%)',$sub_product['attribute_values']))
                    ->pluck('id')->toArray();

                sort($attribute_value_ids);
                $key = implode("-", $attribute_value_ids);

                $product_variation_data = [
                    'product_id' => $new_product->id,
                    'key' => $key,
                    'regular_price' => $sub_product['regular_price'],
                    'discount_price' => $sub_product['discount_price'] ? $sub_product['discount_price'] : $sub_product['regular_price'],
                    'discount_start_at' => null,
                    'discount_end_at' => null,
                    'on_sale' => 1,
                    'min_quantity' => $sub_product['min_quantity'],
                    'max_quantity' => $sub_product['max_quantity'],
                    'sku' => $sub_product['sku'],
                    'stock_management_status' => 1,
                    'stock_status_id' => $sub_product['stock_status_id'] == 'in_stock' ? 1 : 2,
                    'stock_quantity' => $sub_product['stock_quantity'] ? $sub_product['stock_quantity'] : 1000,
                    'remain_product_count_in_low_stock' =>  $sub_product['remain_product_count_in_low_stock'],
                    'is_default_select' => $product_variation_index == 0 ? 1 : 0,
                ];
                $product_variation_index++;
                $new_product_variation = ProductVariation::create($product_variation_data);
                $new_product_variation->attribute_values()->sync($attribute_value_ids);

                foreach ($images_variation as $index => $image) {
                    $image = str_replace('http://178.128.205.248/uploads/' , '' , $image);
                    $image = str_replace('optimize/' , '' , $image);
                    $store_images_2[] = ['image' => $image];
                }
                $new_product_variation->images()->createMany($store_images_2);
            }

        }
        return "done";

    }
}

