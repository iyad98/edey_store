<?php

namespace App\Models;

use App\Filters\CategoryFilter;
use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// models
use App\User;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\Order;
use App\Models\OrderProductAttributeValues;
use App\Models\AttributeValue;

class OrderProduct extends Model
{

    protected $table = 'order_products';
    protected $fillable = ['order_id' ,'product_id' ,'product_variation_id','key','price' , 'discount_price' ,'quantity' ,
        'tax' ,'is_returned' , 'is_gift'];
    public $appends = ['total_discount_price','total_price' ,'total_price_after' , 'price_after'];

    public function getPriceAttribute($value)
    {

        return number_format($value, round_digit(), '.', '');
    }
    public function getTaxAttribute($value) {
        return number_format($value ,round_digit(), '.', '');
    }
    public function getPriceAfterAttribute() {
        return number_format($this->price - $this->discount_price  , round_digit(), '.', '');

        return $this->price - $this->discount_price;
    }
    public function getTotalPriceAttribute() {
        return number_format($this->price * $this->quantity  , round_digit(), '.', '');
    }
    public function getTotalDiscountPriceAttribute() {
        return number_format($this->discount_price  * $this->quantity   , round_digit(), '.', '');

    }
    public function getTotalPriceAfterAttribute() {
        return number_format(($this->price - $this->discount_price) * $this->quantity   , round_digit(), '.', '');

        return ($this->price - $this->discount_price) * $this->quantity;
    }


    /*  scopes   */

    public function scopeOrderDate($query  ,$date_from , $date_to) {
        $query->whereHas('order' , function ($query2) use($date_from , $date_to){
            $query2->DateOrder($date_from , $date_to);
        });
    }
    public function scopeOrderStatus($query  ,$status) {
        $query->whereHas('order' , function ($query2) use($status ){
            $query2->where('status' , '=' , $status);
        });
    }
    public function scopeOrderPaymentMethod($query  ,$payment_method) {
        $query->whereHas('order' , function ($query2) use($payment_method ){
            $query2->where('payment_method_id' , '=' , $payment_method);
        });
    }

    /* relations  */
    public function order() {
        return $this->belongsTo(Order::class , 'order_id');
    }
    public function product() {
        return $this->belongsTo(Product::class , 'product_id')->withTrashed();
    }
    public function exist_product() {
        return $this->belongsTo(Product::class , 'product_id');
    }
    public function product_variation() {
        return $this->belongsTo(ProductVariation::class , 'product_variation_id')->withTrashed();
    }

    public function product_attribute_values() {
        return $this->hasMany(OrderProductAttributeValues::class , 'order_product_id');
    }
    public function product_attribute_values__() {
        return $this->belongsToMany(AttributeValue::class ,'order_product_attribute_values' ,'order_product_id' , 'attribute_value_id')->withTrashed();
    }

    /*  filters */

}
