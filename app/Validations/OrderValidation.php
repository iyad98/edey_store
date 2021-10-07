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

use App\Models\ProductVariation;

use App\Rules\CheckFileRule;

class OrderValidation extends BaseValidation
{

    public $validator;

    public function __construct()
    {
        parent::__construct();
        $this->validator = new BaseValidation();
    }


    public function check_make_order_data($data)
    {

        $rules = [
            'payment_method' => ['required', Rule::exists('payment_methods', 'id')->where('status', 1)],
        ];
//        if($data['payment_method'] == 2) {
//
//            $rules['card_name'] = ['required'];
//            $rules['card_number'] = ['required','digits:16'];
//            $rules['card_month'] = ['required'];
//            $rules['card_year'] = ['required'];
//            $rules['card_cvv'] = ['required'];
//
//        }
        if ($data['company_id'] != 1){
            $rules['user_shipping_id'] = ['required'];

        }
     
        $validator = $this->validator->check_data($data, $rules);
        return $validator;
    }

    public function check_make_order_data_api($data)
    {

        $rules = [
            'payment_method' => ['required', Rule::exists('payment_methods', 'id')->where('status', 1)],
            'user_shipping_id' => ['required',  Rule::exists('user_shipping', 'id')->where('user_id',$data['user']->id)],

        ];


        $validator = $this->validator->check_data($data, $rules);
        return $validator;
    }

    public function check_bank_transfer_data($data)
    {
        $rules = [
            'name' => ['required'],
            'account_number' => ['required'],
            'price' => ['required', 'numeric', 'gt:0'],
            'order_id' => ['required', Rule::exists('orders', 'id')->whereNull('deleted_at')],
            'bank_id' => ['required', Rule::exists('banks', 'id')->whereNull('deleted_at')->where('status', 1)],
            'file' => [new CheckFileRule(false)] ,

        ];
        $validator = $this->validator->check_data($data, $rules);
        return $validator;
    }

    public function check_product_quantity($data)
    {


        $product_variation_ids = collect($data)->pluck('product_variation_id')->toArray();
        $product_variations = ProductVariation::with('stock_status')->whereIn('id', $product_variation_ids);

        foreach ($data as $p) {
            $quantity = $p['quantity'];
            $product_variation = $product_variations->where('id' , '=' ,$p['product_variation_id'] )->first();
            if(!$product_variation) {
                return [
                    'status' => false,
                    'message' => trans('api.product_not_available_' , ['product_name' => $p['name']]),
                    'data' =>[
                        'id' => $p['id']
                    ]
                ];
            }
            if ($product_variation->stock_status->key != "available") {

                return [
                    'status' => false,
                    'message' => trans('api.product_not_available_' , ['product_name' => $p['name']]),
                    'data' =>[
                        'id' => $p['id']
                    ]
                ];
            }

            if ($product_variation->stock_quantity < $quantity) {

                return [
                    'status' => false,
                    'message' =>trans('api.must_less_max_quantity_', ['product_name' => $p['name'] ,'quantity' => $product_variation->stock_quantity]) ,
                    'data' =>[
                        'id' => $p['id']
                    ]
                ];
            }

            return [
                'status' => true ,
                'message' => '',
                'data' => []
            ];


        }

    }

    public function check_update_order_data($data) {
        $rules = [
            'id' => ['required' , Rule::exists('orders' , 'id')],
            'first_name' => ['required' ],
            'last_name' => ['required'],
            'email' => [
                'required','email'
            ],
            'phone' => [
                'required' ,'digits_between:5,13',
            ],
        ];
        if($data['extra_data'] == 1) {
            $rules['country_id'] = ['required' , Rule::exists('countries' , 'id')->whereNull('deleted_at')];
            $rules['city_id'] = ['required' , Rule::exists('cities' , 'id')->whereNull('deleted_at')];
            $rules['shipping_company_id'] = ['required' , Rule::exists('shipping_companies' , 'id')->whereNull('deleted_at')];
            $rules['payment_method_id'] = ['required' , Rule::exists('payment_methods' , 'id') ];

        }
        $validator = $this->validator->check_data($data, $rules);
        return $validator;
    }

}