<?php

namespace App\Models;

use App\Filters\CategoryFilter;
use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// models
use App\Models\ProductVariation;

class ProductVariationShipping extends Model
{
    use SoftDeletes ;

    protected $table = 'product_variation_shipping';
    protected $fillable = ['product_variation_id','weight' , 'length' , 'width' , 'height' , 'shipping_company_id' ];


    /*  scopes   */



    /* relations  */
    public function product_variation() {
        return $this->belongsTo(ProductVariation::class , 'product_variation_id');
    }
    public function shipping_company() {
        return $this->belongsTo(ShippingCompany::class , 'shipping_company_id');
    }


    /*  filters */

}
