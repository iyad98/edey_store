<?php
/**
 * Created by PhpStorm.
 * User: Al
 * Date: 11/9/2019
 * Time: 03:39 م
 */

namespace App\Validations;

use App\Models\Filter;
use App\Validations\BaseValidation;
use Illuminate\Validation\Rule;

class ProductValidation extends BaseValidation
{

    public $validator;

    public function __construct()
    {
        parent::__construct();
        $this->validator = new BaseValidation();
    }

    //product
    public function check_add_product_public($data)
    {
        $rules = [
            'name_ar' => [
                'required',
                Rule::unique('products', 'name_ar')->whereNull('deleted_at'),
            ],
           /* 'name_en' => [
                'required',
                Rule::unique('products', 'name_en')->whereNull('deleted_at'),
            ],*/
            'regular_price' => ['required', 'numeric'],
            'discount_price' => ['sometimes', 'nullable', 'numeric', 'lte:' . $data['regular_price']],
            'tax_status_id' => [
                'required',
                Rule::exists('tax_status', 'id'),
            ],
            'min_quantity' => [
                'required', 'integer', 'lt:' . $data['max_quantity']
            ],
            'max_quantity' => [
                'required', 'integer'
            ],
            'description_ar' => ['required'],
            'description_en' => ['required']

        ];
        $validator = $this->validator->check_data($data, $rules);
        return $validator;
    }

    public function check_add_product_sku($data)
    {
        $rules = [
            'sku' => [
                'required',
                Rule::unique('product_variations', 'sku')->whereNull('deleted_at'),
            ],
            'stock_status_id' => [
                'required',
                Rule::exists('stock_status', 'id'),
            ],
            'stock_quantity' => ['required', 'integer'],
            'remain_product_count_in_low_stock' => ['required', 'integer']

        ];
        $validator = $this->validator->check_data($data, $rules);
        return $validator;
    }

    public function check_add_product_shipping($data)
    {
        $rules = [
            /* 'weight' => ['required', 'numeric'],
             'length' => ['required', 'numeric'],
             'width' => ['required', 'numeric'],
             'height' => ['required', 'numeric'],*/

        ];
        $validator = $this->validator->check_data($data, $rules);
        return $validator;
    }

    public function check_add_product_categories_and_brands($data)
    {
        $rules = [
            'categories' => [
                'required',
                Rule::exists('categories', 'id')->whereNull('deleted_at'),
            ],
            /* 'brand_id' => [
                 'required',
                 Rule::exists('brands', 'id')->whereNull('deleted_at'),
             ],
            */

        ];
        $validator = $this->validator->check_data($data, $rules);
        return $validator;
    }

    public function check_add_product_attributes($product_attributes)
    {
        foreach ($product_attributes as $product_attribute) {
            if (!count($product_attribute->selected) > 0) {
                return ['status' => false, 'message' => trans('validation.validate_attributes')];
            }
        }

        return ['status' => true, 'message' => ''];
    }

    public function check_add_attribute_value_variations($attribute_value_variations)
    {

        foreach ($attribute_value_variations as $attribute_value_variation) {
            $check = $this->check_product_variations(collect($attribute_value_variation->product_variation)->toArray());
            if (!$check['status']) {
                return ['status' => false, 'message' => $check['message'], 'data' => ['random_id' => $attribute_value_variation->random_id]];
            }
        }


        return ['status' => true, 'message' => ""];
    }

    public function check_product_variations($data)
    {
        $rules = [

            'regular_price' => ['required', 'numeric'],
            'discount_price' => ['sometimes', 'nullable', 'numeric', 'lte:' . $data['regular_price']],
            'min_quantity' => [
                'required', 'integer', 'lt:' . $data['max_quantity']
            ],
            'max_quantity' => [
                'required', 'integer'
            ],

            'sku' => [
                'required',
                Rule::unique('product_variations', 'sku')->whereNull('deleted_at'),
            ],
            'stock_status_id' => [
                'required',
                Rule::exists('stock_status', 'id'),
            ],
            'stock_quantity' => ['required', 'integer'],
            /*  'weight' => ['required', 'numeric'],
              'length' => ['required', 'numeric'],
              'width' => ['required', 'numeric'],
              'height' => ['required', 'numeric'],*/

        ];
        $validator = $this->validator->check_data($data, $rules);
        return $validator;
    }


    public function check_edit_product_public($data)
    {
        $rules = [
            'name_ar' => [
                'required',
                Rule::unique('products', 'name_ar')->ignore($data['id'])->whereNull('deleted_at'),
            ],
           /* 'name_en' => [
                'required',
                Rule::unique('products', 'name_en')->ignore($data['id'])->whereNull('deleted_at'),
            ],*/
            'regular_price' => ['required', 'numeric'],
            'discount_price' => ['sometimes', 'nullable', 'numeric', 'lte:' . $data['regular_price']],
            'tax_status_id' => [
                'required',
                Rule::exists('tax_status', 'id'),
            ],
            'min_quantity' => [
                'required', 'integer', 'lt:' . $data['max_quantity']
            ],
            'max_quantity' => [
                'required', 'integer'
            ],
            'description_ar' => ['required'],
            'description_en' => ['required']

        ];
        $validator = $this->validator->check_data($data, $rules);
        return $validator;
    }

    public function check_edit_product_sku($data)
    {
        $rules = [
            'sku' => [
                'required',
                /* Rule::unique('product_variations', 'sku')
                     ->ignore($data['id'] , 'product_id')
                     ->whereNull('deleted_at'),
                */
            ],
            'stock_status_id' => [
                'required',
                Rule::exists('stock_status', 'id'),
            ],
            'stock_quantity' => ['required', 'integer'],
            'remain_product_count_in_low_stock' => ['required', 'integer']

        ];
        $validator = $this->validator->check_data($data, $rules);
        return $validator;
    }

    public function check_edit_attribute_value_variations($product_id, $attribute_value_variations, $get_product_variations)
    {

        foreach ($attribute_value_variations as $attribute_value_variation) {
            /* $product_variation__ = $get_product_variations->where('key' , '=' ,$attribute_value_variation->key)->first();
             if($product_variation__) {
                 $check = $this->check_edit_product_variations(collect($attribute_value_variation->product_variation)->toArray() , $product_variation__->product_id);
             }else {
                 $check = $this->check_product_variations(collect($attribute_value_variation->product_variation)->toArray());
             }
            */
            $attribute_value_variation_arr = collect($attribute_value_variation->product_variation)->toArray();
         //   $attribute_value_variation_arr = $this->trim_array($attribute_value_variation_arr);
           // $attribute_value_variation_arr = array_map('trim', $attribute_value_variation_arr);
            $check = $this->check_edit_product_variations($attribute_value_variation_arr, $product_id);
            if (!$check['status']) {
                return ['status' => false, 'message' => $check['message'], 'data' => ['random_id' => $attribute_value_variation->random_id]];
            }
        }


        return ['status' => true, 'message' => ""];
    }

    public function check_edit_product_variations($data, $id)
    {

        $rules = [

            'regular_price' => ['required', 'numeric'],
            'discount_price' => ['sometimes', 'nullable', 'numeric', 'lte:' . $data['regular_price']],
            'min_quantity' => [
                'required', 'integer', 'lt:' . $data['max_quantity']
            ],
            'max_quantity' => [
                'required', 'integer',
            ],

            'sku' => [
                'required',
                Rule::unique('product_variations', 'sku')->ignore($id, 'product_id')->whereNull('deleted_at'),
            ],
            'stock_status_id' => [
                'required',
                Rule::exists('stock_status', 'id'),
            ],
            'stock_quantity' => ['required', 'integer'],
            'remain_product_count_in_low_stock' => ['required', 'integer'],
            'weight' => ['required', 'numeric'],
            'length' => ['required', 'numeric'],
            'width' => ['required', 'numeric'],
            'height' => ['required', 'numeric'],


        ];
        $validator = $this->validator->check_data($data, $rules);
        return $validator;
    }

    // favorites
    public function check_add_to_favorite($data)
    {
        $rules = [
            'product_id' => [
                'required',
                Rule::exists('products', 'id')->whereNull('deleted_at'),
            ],
        ];
        $validator = $this->validator->check_data($data, $rules);
        return $validator;
    }


    public function trim_array($attribute_value_variation_arr) {
        $result = [];
        foreach ($attribute_value_variation_arr as $key => $value) {
            if(!is_array($value)) {
                $result[$key] = trim($value);
            }else {
                $result[$key] = $value;
            }

        }
        return $result;
    }

    public function check_countries($data) {
        $rules = [
            'countries' => [
                'required'
            ],
            'countries.*' => ['required' , 'integer']

        ];
        $validator = $this->validator->check_data_2($data, $rules);
        return $validator;

    }

}