<?php

namespace App\Models;

use App\Filters\CategoryFilter;
use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// models
use App\User;
use App\Models\CartProduct;
use App\Models\ProductVariation;
use App\Models\Cart;
use App\Models\AttributeValue;

class CartProductAttributeValues extends Model
{

    protected $table = 'cart_product_attribute_values';
    protected $fillable = ['cart_product_id' , 'attribute_value_id' ];

    public function cart_product() {
        return $this->belongsTo(CartProduct::class , 'cart_product_id');
    }
}
