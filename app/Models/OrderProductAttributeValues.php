<?php

namespace App\Models;

use App\Filters\CategoryFilter;
use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

//models
use App\Models\AttributeValue;
use App\Models\ProductAttribute;
use App\Models\OrderProduct;


class OrderProductAttributeValues extends Model
{

    protected $table = 'order_product_attribute_values';
    protected $fillable = ['order_product_id','attribute_value_id' ];


    /*  scopes   */



    /* relations  */

    public function order_product() {
        return $this->belongsTo(OrderProduct::class , 'order_product_id');

    }

    public function attribute_value() {
        return $this->belongsTo(AttributeValue::class , 'attribute_value_id')->withTrashed();
    }
    /*  filters */

}
