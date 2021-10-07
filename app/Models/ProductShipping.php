<?php

namespace App\Models;

use App\Filters\CategoryFilter;
use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// models
use App\Models\Product;

class ProductShipping extends Model
{
    use SoftDeletes ;

    protected $table = 'product_shipping';
    protected $fillable = ['product_id','weight' , 'length' , 'width' , 'height' , 'shipping_company_id' ];


    /*  scopes   */



    /* relations  */
    public function product() {
        return $this->belongsTo(Product::class , 'product_id');
    }
    public function shipping_company() {
        return $this->belongsTo(ShippingCompany::class , 'shipping_company_id');
    }


    /*  filters */

}
