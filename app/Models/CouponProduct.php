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

class CouponProduct extends Model
{
    use  LanguageTrait;

    protected $table = 'coupon_products';
    protected $fillable = ['coupon_id' ,'product_id'];


    public function coupon() {
        return $this->belongsTo(Coupon::class , 'coupon_id');
    }
    public function product() {
        return $this->belongsTo(Product::class , 'product_id');
    }
}
