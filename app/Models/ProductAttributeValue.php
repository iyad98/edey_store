<?php

namespace App\Models;

use App\Filters\CategoryFilter;
use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

//models
use App\Models\AttributeValue;
use App\Models\ProductAttribute;


class ProductAttributeValue extends Model
{

    protected $table = 'product_attribute_values';
    protected $fillable = ['id','product_attribute_id','attribute_value_id' ];


    /*  scopes   */



    /* relations  */

    public function attribute_product() {
        return $this->belongsTo(ProductAttribute::class , 'product_attribute_id');

    }

    public function attribute_value() {
        return $this->belongsTo(AttributeValue::class , 'attribute_value_id')->withTrashed();
    }
    /*  filters */

}
