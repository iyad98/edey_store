<?php

namespace App\Models;

use App\Filters\CategoryFilter;
use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// models
use App\User;
use App\Models\City;
use App\Models\ShippingCompany;
use App\Models\Order;
use App\Models\Coupon;

class OrderCoupon extends Model
{

    protected $table = 'order_coupon';

    protected $fillable = ['order_id', 'coupon_id', 'coupon_code', 'coupon_type' , 'coupon_price' , 'is_automatic'
    ,'user_famous_id' , 'user_famous_rate' , 'user_famous_price'];

    /*  scopes   */


    /* relations  */

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }

    /*  filters */

}
