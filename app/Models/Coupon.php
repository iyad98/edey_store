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
use App\Models\Order;
use App\Models\OrderCoupon;
use App\Models\CouponChecked;
use DB;
use App\User;

use Carbon\Carbon;

class Coupon extends Model
{
    use SoftDeletes, LanguageTrait;

    protected $table = 'coupons';
    protected $fillable = ['coupon', 'value', 'coupon_type_id','apply_for_discount_product', 'is_automatic', 'show_in_home', 'start_at',
        'end_at', 'min_price', 'max_used' , 'user_famous_id', 'user_famous_rate'];

    /*  scopes   */


    /* relations  */

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_coupon', 'coupon_id', 'order_id');
    }

    public function order_coupon()
    {
        return $this->hasMany(OrderCoupon::class, 'coupon_id');
    }

    public function user_famous()
    {
        return $this->belongsTo(User::class, 'user_famous_id');
    }

    public function type()
    {
        return $this->belongsTo(CouponType::class, 'coupon_type_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'coupon_products', 'coupon_id', 'product_id')
            ->select('products.id', 'coupon_products.type');
    }

    public function available_products()
    {
        return $this->belongsToMany(Product::class, 'coupon_products', 'coupon_id', 'product_id')
            ->where('coupon_products.type', '=', 1);
    }

    public function not_available_products()
    {
        return $this->belongsToMany(Product::class, 'coupon_products', 'coupon_id', 'product_id')
            ->where('coupon_products.type', '=', 0);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'coupon_categories', 'coupon_id', 'category_id')
            ->select('categories.id', 'coupon_categories.type');;
    }

    public function available_categories()
    {
        return $this->belongsToMany(Category::class, 'coupon_categories', 'coupon_id', 'category_id')
            ->where('coupon_categories.type', '=', 1);
    }

    public function not_available_categories()
    {
        return $this->belongsToMany(Category::class, 'coupon_categories', 'coupon_id', 'category_id')
            ->where('coupon_categories.type', '=', 0);
    }

    public function scopeActive($query)
    {
        $query->where('start_at', '<=', Carbon::now()->format('Y-m-d H:i:s'))
            ->where('end_at', '>=', Carbon::now()->format('Y-m-d H:i:s'));
    }

    public function scopeNotActive($query)
    {
        $query->where('start_at', '>=', Carbon::now()->format('Y-m-d H:i:s'))
            ->orWhere('end_at', '<=', Carbon::now()->format('Y-m-d H:i:s'));
    }

    public function scopeIsNotAutomatic($query)
    {
        $query->where('is_automatic', '<>', 1);
    }
    public function scopeIsActiveAndAutomatic($query)
    {
        $query->where('start_at', '<=', Carbon::now()->format('Y-m-d H:i:s'))
            ->where('end_at', '>=', Carbon::now()->format('Y-m-d H:i:s'))
            ->where('is_automatic', '=', 1);
    }

    public function checked() {
        return $this->hasMany(CouponChecked::class , 'coupon_id');
    }

    public function scopeCouponUsed($query, $get_date_filter) {
        $query->withCount(['orders' => function($query) use($get_date_filter) {
            $query->withTrashed()->DateRangeOrder($get_date_filter);
        }]);
    }
    public function scopeOrderCoupon($query, $get_date_filter)
    {
        $query->CouponUsed($get_date_filter)->withCount([
            'orders as order_price' => function($query) use($get_date_filter){
                $query->where('order_coupon.coupon_price' , '>' , 0)->withTrashed()->DateRangeOrder($get_date_filter)->select(DB::raw('round(sum(orders.total_price),3)'));
            },
            'orders as order_discount_price' => function($query) use($get_date_filter){
                $query->where('order_coupon.coupon_price' , '>' , 0)->withTrashed()->DateRangeOrder($get_date_filter)->select(DB::raw('round(sum(orders.coupon_price),3)'));
            },
            'orders as pending_orders' => function($query) use($get_date_filter){
                $query->where('order_coupon.coupon_price' , '>' , 0)->withTrashed()->DateRangeOrder($get_date_filter)->PendingOrder();
            },
            'orders as pending_orders_price' => function($query) use($get_date_filter){
                $query->where('order_coupon.coupon_price' , '>' , 0)->withTrashed()->DateRangeOrder($get_date_filter)->PendingOrder()
                    ->select(DB::raw('round(sum(orders.total_price) ,3)'));
            },
            'orders as confirm_orders' => function($query) use($get_date_filter){
                $query->where('order_coupon.coupon_price' , '>' , 0)->withTrashed()->DateRangeOrder($get_date_filter)->ConfirmOrder();
            },
            'orders as confirm_orders_price' => function($query) use($get_date_filter){
                $query->where('order_coupon.coupon_price' , '>' , 0)->withTrashed()->DateRangeOrder($get_date_filter)->ConfirmOrder()
                    ->select(DB::raw('round(sum(orders.total_price) , 3)'));
            },
            'order_coupon as user_famous_price' => function($query) use($get_date_filter){
                $query->where('order_coupon.coupon_price' , '>' , 0)->whereHas('order' , function($query1) use($get_date_filter){
                    $query1->withTrashed()->DateRangeOrder($get_date_filter)->ConfirmOrder();
                })->select(DB::raw('round(sum(user_famous_price) , 3)'));
            },
            'checked as checked_count' => function($query) use($get_date_filter){
                $query->DateRange($get_date_filter);
            },
        ]);
    }
    /*  filters */

}
