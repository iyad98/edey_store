<?php
/**
 * Created by PhpStorm.
 * User: HP15
 * Date: 18/8/2019
 * Time: 11:04 ص
 */

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class OrderFilter extends BaseFilter
{
    public function __construct(Builder $builder)
    {
        parent::__construct($builder);

    }

    public function get_filters()
    {
        return [

            'id'              => 'filter_by_id',
            'phone'           => 'filter_by_phone',
            'total_price'     => 'filter_by_total_price',
            'status'          => 'filter_by_status',
            'payment_method'  => 'filter_by_payment_method',
            'shipping_company'=> 'filter_by_shipping_company',
            'type_product_id' => 'filter_type_product_id',
            'type_product'    => 'filter_type_product',
            'place'           => 'filter_by_place',
            'platform'        => 'filter_by_platform',


        ];
    }


    public function filter_by_status($value) {
        if(in_array( $value,array_values(order_status()))) {

            $this->builder->where('orders.status' , '=' , $value);
        }
    }

    public function filter_by_payment_method($value) {
        if(!is_null($value) && $value != -1) {

            $this->builder->where('orders.payment_method_id' , '=' , $value);
        }
    }

    public function filter_by_shipping_company($value) {
        if(!is_null($value) && $value != -1) {

            if ($value != -1) {
                $this->builder->where(function ($query) use ($value) {

                    $query->whereHas('company_shipping' , function ($query2) use($value){
                            $query2->where('shipping_company_id',$value);
                        });
                });
            }
        }
    }

    public function filter_by_id($value) {
        if(!is_null($value) && $value != -1) {
            $this->builder->where('orders.id' , '=' , $value);
        }
    }
    public function filter_by_phone($value) {
        if(!is_null($value) && $value != -1) {
            $this->builder->where('orders.user_phone' , '=' , $value);
        }
    }
    public function filter_by_total_price($value) {
        if(!is_null($value) && $value != -1) {
            $this->builder->where('orders.total_price' , '=' , $value);
        }
    }


    public function filter_type_product($value) {
        if(!is_null($value['id']) && $value['id'] != -1) {
            switch ($value['type']) {
                case 1 :
                    $this->builder->OrderProduct($value['id']);
                    break;
                default :
                    $this->builder->OrderProductVariation($value['id']);
                    break;
            }
        }
    }
    public function filter_by_place($value) {
        if(!is_null($value['city_id']) && $value['city_id'] != -1) {
            $this->builder->OrderCity($value['city_id']);
        }else if(!is_null($value['country_id']) && $value['country_id'] != -1) {
            $this->builder->OrderCountry($value['country_id']);
        }
    }

    public function filter_by_platform($value){
        if(!is_null($value) && $value != -1) {
            $this->builder->where('orders.platform' , '=' , $value);
        }
    }

}