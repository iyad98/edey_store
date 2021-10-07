<?php
/**
 * Created by PhpStorm.
 * User: HP15
 * Date: 18/8/2019
 * Time: 11:04 ص
 */

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class ProductVariationFilter extends BaseFilter
{
    public function __construct(Builder $builder)
    {
        parent::__construct($builder);

    }

    public function get_filters()
    {
        return [
            'name' => 'filter_by_name',
            'brand' => 'filter_by_brand',
            'category' => 'filter_by_category',
            'country' => 'filter_by_country',
            'stock_status' => 'filter_by_stock_status',
            'is_variation' => 'filter_by_is_variation',
            'price_range' => 'filter_by_price_range',
            'status'=>'filter_by_status'
        ];
    }

    public function filter_by_name($value)
    {
        if ($value != -1) {
            $this->builder->where(function ($query) use ($value) {

                $query->whereHas('product',function($q)use($value){
                    $q->where('name_ar', 'LIKE', "%$value%")->orWhere('name_ar', 'LIKE', "%$value%");
                } );


            });
        }
    }


    public function filter_by_brand($value)
    {
        if ($value != -1 && !empty($value) && !is_null($value)) {

            $this->builder->where(function ($query) use ($value) {

                $query->where('product_id' , function ($query2) use($value){
                        $query2->from('products')->select('id')->where('brand_id' ,$value)->limit(1);
                    });
            });


        }

    }

    public function filter_by_price_range($value)
    {

        $this->builder->whereIn('products.id' , function ($query) use($value) {
            $query->from('product_variations')
                ->where('is_default_select', '=', 1)
                ->where('discount_price', '>=', $value['min_price'])
                ->where('discount_price', '<=', $value['max_price'])
                ->select('product_id');
        });
    }
    public function filter_by_is_variation($value)
    {
        if ($value != -1 && !empty($value) && !is_null($value)) {
            if ($value == 1) {

                $this->builder->where('key', '=', '*');
            } else {
                $this->builder->where('key', '!=', '*');
            }
        }

    }

    public function filter_by_category($value)
    {
        if ($value != -1 && !is_null($value) && is_array($value) && count($value) > 0) {

            $this->builder->whereIn('product_variations.product_id' , function ($query) use($value){
                $query
                    ->from('product_categories')
                    ->select('product_categories.product_id')
                    ->whereIn('category_id' ,$value );
            });
        }

    }

    public function filter_by_country($value)
    {


        if ($value != -1 && !empty($value) && !is_null($value)) {


            $this->builder->where(function ($query) use($value){


                $query->where(function ($query1) use($value) {
                    $query1->whereDoesntHave('select_countries')
                        ->orWhereHas('select_countries', function ($query2) use ($value) {
                            $query2->whereIn('product_countries.country_id', [$value]);
                        });

                })->where(function ($query3) use($value) {
                    $query3->whereDoesntHave('excluded_countries', function ($query4) use ($value) {
                        $query4->whereIn('country_id', [$value]);
                    });
                });
            });
        }

    }

    public function filter_by_stock_status($value)
    {
        if ($value != -1 && !empty($value) && !is_null($value)) {

            if ($value == 1) {
                $this->builder->where('stock_quantity', '>', 0);

            } else {
                $this->builder->where('stock_quantity', '<', 0);

            }

        }

    }
    public function filter_by_status($value){

        if ($value != -1 ) {


                $this->builder->where('order_status', $value);


        }
    }


}