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

class ShippingCompanyValidation extends BaseValidation
{

    public $validator;

    public function __construct()
    {
        parent::__construct();
        $this->validator = new BaseValidation();
    }

    public function check_add_shipping_company($data)
    {
        $rules = [
            'name_ar' => [
                'required', 'max:250'
            ],
            'phone' => [
                'required', 'max:250'
            ],
            'tracking_url' => [
                'required', 'max:250'
            ],
           /* 'name_en' => [
                'required', 'max:255'
            ],*/
        ];
        $validator = $this->validator->check_data($data, $rules);
        return $validator;
    }
    public function check_shipping_prices($shipping_prices) {

        $get_shipping_price = [];
        foreach ($shipping_prices as $shipping_price) {

            if (!is_numeric($shipping_price['from']) || $shipping_price['from'] < 0) {
               return ['status' => false , 'message' =>trans('validation.shipping_price_from') , 'data' => [] ];
            }
            if (!is_numeric($shipping_price['to']) || $shipping_price['to'] < 0) {
                return ['status' => false , 'message' => trans('validation.shipping_price_to') , 'data' => [] ];
            }
            if (!is_numeric($shipping_price['price']) || $shipping_price['price'] < 0) {
                return ['status' => false , 'message' => trans('validation.shipping_price') , 'data' => [] ];
            }
            if ($shipping_price['from'] > $shipping_price['to']) {
                return ['status' => false , 'message' => trans('validation.shipping_price_to') , 'data' => [] ];
            }

            if (!in_array($shipping_price['type'] , ['fixed' , 'percent'])) {
                return ['status' => false , 'message' => trans('validation.shipping_price_type') , 'data' => [] ];
            }
            $get_shipping_price[] = [
                'name_ar' => $shipping_price['name_ar'] , 'name_en' => $shipping_price['name_en'] ,
                'from' =>$shipping_price['from'] , 'to' => $shipping_price['to'] ,
                'price' => $shipping_price['price'] , 'type' => $shipping_price['type']
            ];
        }
        return ['status' => true , 'message' => '' , 'data' => $get_shipping_price ];

    }

    public function check_shipping_piece($shipping_prices) {

        $get_shipping_price = [];
        $shipping_price = $shipping_prices[0];


            if (!is_numeric($shipping_price['price']) || $shipping_price['price'] < 0) {
                return ['status' => false , 'message' => trans('validation.shipping_price') , 'data' => [] ];
            }
            if ($shipping_price['from'] > $shipping_price['to']) {
                return ['status' => false , 'message' => trans('validation.shipping_price_to') , 'data' => [] ];
            }


            $get_shipping_price[] = [
                'name_ar' => $shipping_price['name_ar'] , 'name_en' => $shipping_price['name_en'] ,
                'from' =>1 , 'to' => 1 ,
                'price' => $shipping_price['price'] , 'type' => 'perpiece'
            ];

        return ['status' => true , 'message' => '' , 'data' => $get_shipping_price ];

    }

    public function check_shipping_cities($data) {
        $rules = [
            'cities' => [
                'required'
            ],
            'cities.*' => ['required' , 'integer']

        ];
        $validator = $this->validator->check_data_2($data, $rules);
        return $validator;

    }

    public function check_shipping_cash_value($shipping_prices) {
        $get_shipping_price = [];
        foreach ($shipping_prices as $shipping_price) {

            if (!is_numeric($shipping_price['from']) || $shipping_price['from'] < 0) {
                return ['status' => false , 'message' =>trans('validation.shipping_price_from') , 'data' => [] ];
            }
            if (!is_numeric($shipping_price['to']) || $shipping_price['to'] < 0) {
                return ['status' => false , 'message' => trans('validation.shipping_price_to') , 'data' => [] ];
            }
            if (!is_numeric($shipping_price['price']) || $shipping_price['price'] < 0) {
                return ['status' => false , 'message' => trans('validation.shipping_price') , 'data' => [] ];
            }
            if ($shipping_price['from'] > $shipping_price['to']) {
                return ['status' => false , 'message' => trans('validation.shipping_price_to') , 'data' => [] ];
            }

            if (!in_array($shipping_price['type'] , ['fixed' , 'percent'])) {
                return ['status' => false , 'message' => trans('validation.shipping_price_type') , 'data' => [] ];
            }
            $get_shipping_price[] = [
                'from' =>$shipping_price['from'] , 'to' => $shipping_price['to'] ,
                'price' => $shipping_price['price'] , 'type' => $shipping_price['type']
            ];
        }
        return ['status' => true , 'message' => '' , 'data' => $get_shipping_price ];

    }
}