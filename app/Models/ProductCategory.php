<?php

namespace App\Models;

use App\Filters\CategoryFilter;
use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// models
use App\Models\Product;
use App\Models\Category;
use App\Models\CouponType;
use App\Models\Coupon;
use Carbon\Carbon;

class ProductCategory extends Model
{
    use  LanguageTrait;

    protected $table = 'product_categories';
    protected $fillable = ['id','product_id' ,'category_id','merchant_id'];


    public function product() {
        return $this->belongsTo(Product::class , 'product_id');
    }
}
