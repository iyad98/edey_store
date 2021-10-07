<?php

namespace App\Models;

use App\Filters\CategoryFilter;
use App\Filters\ProductFilter;
use App\Filters\ProductVariationFilter;
use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\AttributeValue;
use App\Models\ProductVariationImage;
use App\Models\ProductVariationShipping;
use App\Models\StockStatus;
use App\Models\Product;
use App\Models\CartProduct;

use Carbon\Carbon;

class ProductVariation extends Model
{

    use SoftDeletes, LanguageTrait;

    protected $table = 'product_variations';

    protected $fillable = ['id','key', 'product_id', 'description_en', 'description_ar', 'regular_price','cost_price',
        'discount_price', 'discount_start_at', 'discount_end_at', 'on_sale', 'min_quantity', 'max_quantity', 'sku', 'stock_management_status', 'stock_status_id'
        , 'stock_quantity', 'remain_product_count_in_low_stock','order_status', 'is_default_select',
        'note_in_manufacturing',
        'note_charged_up',
        'note_charged_at_sea',
        'note_at_the_harbour',
        'note_in_the_warehouse',
        'note_delivered'
        ];

    protected $appends = ['description','order_count'];
    protected $filters = ['name', 'brand', 'category', 'stock_status', 'is_variation', 'country' , 'price_range','status'];


    public function setCostPriceAttribute($value) {
        $this->attributes['cost_price'] = is_null($value) || empty($value) ? 0 : $value;
    }

    public function getDiscountStartAtAttribute($value)
    {
        if (!is_null($value)) {
            return Carbon::parse($value)->format('Y-m-d h:i A');
        } else {
            return $value;
        }
    }

    public function getDiscountEndAtAttribute($value)
    {
        if (!is_null($value)) {
            return Carbon::parse($value)->format('Y-m-d h:i A');
        } else {
            return $value;
        }
    }

    public function getDiscountPriceAttribute($value)
    {
        return $value;
        $current_date = Carbon::now();
        $check_discount = (is_null($this->discount_start_at) && is_null($this->discount_end_at)) || ($current_date >= $this->discount_start_at && $current_date <= $this->discount_end_at);
        if ($check_discount) {
            return round($value, 2);
        } else {
            return 0;
        }
    }

    public function getDescriptionAttribute()
    {
        return $this->getDescription($this);
    }

    /*  scopes   */

    public function scopeGetGeneralDataProduct($query, $user_id)
    {
        $query->withCount(['cart_products' => function ($query1) use ($user_id) {
            $query1->whereHas('cart', function ($query2) use ($user_id) {
                $query2->where('carts.user_id', '=', $user_id)
                    ->orWhere(function ($query3) use($user_id) {
                        if($user_id == -1) {
                            $query3->whereNotNull('session_id')
                                ->where('session_id', '=', get_session_key());
                        }

                    });
            });
        }])->with(['cart_products' => function ($query1) use ($user_id) {
            $query1->whereHas('cart', function ($query2) use ($user_id) {
                $query2->where('carts.user_id', '=', $user_id)
                    ->orWhere(function ($query3) use($user_id) {
                        if($user_id == -1) {
                            $query3->whereNotNull('session_id')
                                ->where('session_id', '=', get_session_key());
                        }
                    });
            });
        }]);
    }

    /* relations  */

    public function cart_products()
    {
        return $this->hasMany(CartProduct::class, 'product_variation_id');
    }


    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id')->withTrashed();
    }

    public function stock_status()
    {
        return $this->belongsTo(StockStatus::class, 'stock_status_id')->select('id', 'name_ar', 'name_en', 'key');
    }

    public function attribute_values()
    {
        return $this->belongsToMany(AttributeValue::class, 'product_variation_attribute_values', 'product_variation_id', 'attribute_value_id');
    }

    public function images()
    {
        return $this->hasMany(ProductVariationImage::class, 'product_variation_id');
    }

    public function product_shipping()
    {
        return $this->hasOne(ProductVariationShipping::class, 'product_variation_id');
    }



    public function getOrderCountAttribute()
    {
        return $this->hasMany(OrderProduct::class,'product_variation_id', 'id')
            ->whereHas('order',function ($q){
                $q->whereIn('status',[0,1,2]);
            })->sum('quantity');
    }


    public function scopeFilter($builder, $filters)
    {
        return $this->apply_filters($builder, $filters);
    }

    public function apply_filters($builder, $get_filters)
    {
        $filters = [];
        $user_filter = new ProductVariationFilter($builder);

        foreach ($get_filters as $key => $value) {
            if (in_array($key, $this->filters)) {
                $get_method = $user_filter->get_filters()[$key];
                $filters[$key] = $user_filter->$get_method($value);
            }
        }
    }

}
