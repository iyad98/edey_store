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

class CouponCategory extends Model
{
    use  LanguageTrait;

    protected $table = 'coupon_categories';
    protected $fillable = ['coupon_id' ,'category_id'];


    public function coupon() {
        return $this->belongsTo(Coupon::class , 'coupon_id');
    }
}
