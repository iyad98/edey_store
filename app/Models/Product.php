<?php

namespace App\Models;

use App\Filters\ProductFilter;
use App\Models\Category;
use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\User;
use App\Models\AttributeValue;
use App\Models\ProductImage;
use App\Models\ProductShipping;
use App\Models\ProductVariation;
use App\Models\ProductAttribute;
use App\Models\Brand;
use App\Models\TaxStatus;
use App\Models\CartProduct;
use App\Models\Coupon;
use App\Models\ProductCategory;
use App\Models\Order;
use App\Models\Country;
use App\Models\Comment;

use Carbon\Carbon;
use DB;

use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

use Illuminate\Support\Facades\File;

class Product extends Model implements Feedable
{
    /*
     *
     *
     */
    use SoftDeletes, LanguageTrait;

    protected $table = 'products';
    protected $fillable = ['id','merchant_id','image', 'name_en', 'name_ar', 'description_en', 'description_ar', 'is_variation'
        , 'brand_id', 'min_price', 'max_price', 'tax_status_id', 'coupon_automatic_id',
        'coupon_automatic_from_category_id', 'in_offer', 'in_day_deal', 'is_exclusive' , 'can_returned','can_gift','in_archive'];

    protected $appends = ['name', 'description' , 'thumb_image','order_count'];
    protected $filters = ['name', 'brand','merchant', 'category', 'stock_status', 'is_variation', 'country' , 'price_range'];


    /* rss */

    public function toFeedItem()
    {
        return FeedItem::create()
            ->id($this->id)
            ->title($this->name_ar)
            ->summary($this->description_ar)
            ->updated($this->updated_at)
            ->link($this->link)
            ->author('admin');
    }

    public static function getFeedItems()
    {
        return static::all();
    }
    public function getLinkAttribute()
    {
        return route('news_product.show', $this);
    }
    /*   */
    public function getNameAttribute()
    {
        return $this->getName($this);
    }

    public function getDescriptionAttribute()
    {
        return $this->getDescription($this);
    }

    public function getImageAttribute($value)
    {
        return getImage('' , true , $value);
    }

    public function getThumbImageAttribute()
    {
        return File::exists(getUploadsThumbPath($this->getOriginal('image'))) ? getImage('thumbs' , true , $this->getOriginal('image')) : $this->image;
    }

    /*  scopes   */

    public function scopeDoesntHaveDiscount($query)
    {
        $now_time = Carbon::now();
        $query->whereDoesntHave('variation', function ($query0) use ($now_time) {
            $query0->where('discount_price', '>', 0)
                ->where(function ($query1) use ($now_time) {
                    $query1->whereNull('discount_start_at')
                        ->orWhere(function ($query2) use ($now_time) {
                            $query2->where('discount_start_at', '<=', $now_time)
                                ->where('discount_end_at', '>=', $now_time);
                        });
                });
        });

    }

    public function scopeSalesCount($query)
    {
        $query->withCount(['orders as orders_count' => function ($query) {
            $query->where('orders.status', '=', order_status()['delivered']);
        }]);
    }

    public function scopeDateProduct($query, $start_at, $end_at)
    {

        $query->where(DB::raw('date(created_at)'), '>=', $start_at)
            ->where(DB::raw('date(created_at)'), '<=', $end_at);
    }

    public function scopeGetGeneralDataProduct($query, $user_id)
    {
        $query->with(['variation.stock_status', 'categories' , 'merchant','brand'])
            ->withCount(['favorites' => function ($query) use ($user_id) {
                $query->where('user_id', '=', $user_id);

            }])->withCount(['cart_products' => function ($query1) use ($user_id) {
                $query1->whereHas('cart', function ($query2) use ($user_id) {
                    $query2->where('carts.user_id', '=', $user_id)
                        ->orWhere(function ($query3) use($user_id) {
                            if($user_id == -1) {
                                $query3->whereNotNull('session_id')
                                    ->where('session_id', '=', get_session_key());
                            }

                    });
                });

            }])->ProductRate()->SalesCount();

    }


    public function scopeProductRate($query)
    {
        $query->withCount('rates')->WithCount(['rates as rate_sum' => function ($q) {
            $q->select(DB::raw('sum(rates.rate)'));
        }]);
    }


    /* relations  */

    public function comments()
    {
        return $this->hasMany(Comment::class, 'product_id');

    }

    public function countries()
    {
        return $this->belongsToMany(Country::class, 'product_countries', 'product_id', 'country_id')
            ->select('*', 'product_countries.status as product_country_status');
    }

    public function select_countries()
    {
        return $this->belongsToMany(Country::class, 'product_countries', 'product_id', 'country_id')
            ->where('product_countries.status', '=', 1);
    }

    public function excluded_countries()
    {
        return $this->belongsToMany(Country::class, 'product_countries', 'product_id', 'country_id')
            ->where('product_countries.status', '=', 0);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_products', 'product_id', 'order_id');
    }

    public function cart_products()
    {
        return $this->hasMany(CartProduct::class, 'product_id');
    }

    public function tax_status()
    {
        return $this->belongsTo(TaxStatus::class, 'tax_status_id');
    }

    public function automatic_coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_automatic_id');
    }

    public function automatic_active_coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_automatic_id')->IsActiveAndAutomatic();
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites', 'product_id', 'user_id')
            ->select('*', 'favorites.created_at as favorite_date');
    }

    public function recommended_products()
    {
        return $this->belongsToMany(Product::class, 'recommended_products', 'product_id', 'recomend_product_id');
    }

    public function marketing_products()
    {
        return $this->belongsToMany(Product::class, 'marketing_products', 'product_id', 'market_product_id');
    }

    public function sub_products()
    {
        return $this->belongsToMany(Product::class, 'sub_products', 'product_id', 'sub_product_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');

    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'merchant_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }


    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class, 'product_id');

    }

    public function attribute_values()
    {
        return $this->belongsToMany(AttributeValue::class, 'product_attribute_values', 'product_attribute_id', 'attribute_value_id');
    }

    public function attributes_size()
    {
        return $this->hasMany(ProductAttribute::class, 'product_id')->where('attribute_id',2);
    }

    public function attributes_color()
    {
        return $this->hasMany(ProductAttribute::class, 'product_id')->where('attribute_id',1);
    }





    public function attributes_intaglio()
    {
        return $this->hasMany(ProductAttribute::class, 'product_id')->where('attribute_id',3);
    }

    public function attribute_values_color()
    {
        return $this->belongsToMany(AttributeValue::class, 'product_attribute_values', 'product_attribute_id', 'attribute_value_id')->where('attribute_id',1);

    }

    public function attribute_values_size()
    {
        return $this->belongsToMany(AttributeValue::class, 'product_attribute_values', 'product_attribute_id', 'attribute_value_id')->where('attribute_id',2);
    }

    public function attribute_values_intaglio()
    {
        return $this->belongsToMany(AttributeValue::class, 'product_attribute_values', 'product_attribute_id', 'attribute_value_id')->where('attribute_id',3);
    }



    public function variation()
    {
        return $this->hasOne(ProductVariation::class, 'product_id')->where('is_default_select', '=', 1);
    }




    public function variations()
    {
        return $this->hasMany(ProductVariation::class, 'product_id')->where('is_default_select', '=', 0);
    }

    public function all_variations()
    {
        return $this->hasMany(ProductVariation::class, 'product_id')->where('deleted_at',null);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories', 'product_id', 'category_id');
    }




    public function category()
    {
        return $this->hasOne(ProductCategory::class, 'product_id');

    }


    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'coupon_products', 'product_id', 'coupon_id');
    }

    public function rates()
    {
        return $this->belongsToMany(User::class, 'rates', 'product_id', 'user_id');
    }

    public function getOrderCountAttribute()
    {
        return $this->hasMany(OrderProduct::class,'product_id', 'id')->count();
    }
    /*  filters */

    public function scopeFilter($builder, $filters)
    {
        return $this->apply_filters($builder, $filters);
    }

    public function apply_filters($builder, $get_filters)
    {
        $filters = [];
        $user_filter = new ProductFilter($builder);

        foreach ($get_filters as $key => $value) {
            if (in_array($key, $this->filters)) {
                $get_method = $user_filter->get_filters()[$key];
                $filters[$key] = $user_filter->$get_method($value);
            }
        }
    }
}
