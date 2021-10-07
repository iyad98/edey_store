<?php

namespace App\Models;

use App\Filters\CategoryFilter;
use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// models
use App\Models\ProductAttributeValue;
use App\Models\Attribute;


class ProductAttribute extends Model
{

    protected $table = 'product_attributes';
    protected $fillable = ['product_id','attribute_id' , 'is_variation' ];


    /*  scopes   */



    /* relations  */

    public function attribute_values() {
        return $this->hasMany(ProductAttributeValue::class , 'product_attribute_id');
    }
    public function attribute() {
        return $this->belongsTo(Attribute::class , 'attribute_id')->withTrashed();
    }

    /*  filters */

}
