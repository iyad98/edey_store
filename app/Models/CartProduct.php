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
use App\Models\Cart;
use App\Models\AttributeValue;

class CartProduct extends Model
{

    protected $table = 'cart_products';
    protected $fillable = ['key','cart_id','product_id' ,'product_variation_id','price' , 'discount_price' ,'quantity' ];
    public $appends = ['price_after' ,'total_price' , 'total_price_after'];

    public function getTotalPriceAttribute() {
        return $this->price * $this->quantity;
    }
    public function getTotalPriceAfterAttribute() {
        return ($this->price - $this->discount_price) * $this->quantity;
    }
    public function getPriceAfterAttribute() {
        return $this->price - $this->discount_price;
    }
    /*  scopes   */



    /* relations  */
    public function cart() {
        return $this->belongsTo(Cart::class , 'cart_id');
    }
    public function product() {
        return $this->belongsTo(Product::class , 'product_id')->withTrashed();
    }
    public function product_variation() {
        return $this->belongsTo(ProductVariation::class , 'product_variation_id')->withTrashed();
    }

    public function attribute_values() {
        return $this->belongsToMany(AttributeValue::class , 'cart_product_attribute_values' , 'cart_product_id' , 'attribute_value_id');
    }
    /*  filters */

    /*  scope */
    public function scopeProductCountry($query , $country_id) {
        $query->whereDoesntHave('product' , function ($q) use($country_id){
            $q->filter(['country' => $country_id]);
        });
    }
    public function scopeGetDeletedCartProduct($query) {
        $query->whereHas('product' , function ($query){
            $query->whereNotNull('deleted_at');
        })->orWhereHas('product_variation' , function ($query2){
            $query2->whereNotNull('deleted_at');
        });
    }
}
