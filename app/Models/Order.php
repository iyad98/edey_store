<?php

namespace App\Models;

use App\Filters\OrderFilter;

use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// models
use App\Models\OrderCompanyShipping;
use App\Models\OrderCoupon;
use App\Models\OrderUserShipping;
use App\Models\OrderProduct;
use App\Models\PaymentMethod;
use App\Models\OrderBank;
use App\Models\OrderPayment;
use App\Models\OrderPackage;
use App\Models\OrderAdminDiscount;
use App\Models\Currency;

use App\User;
use DB;

use Carbon\Carbon;

class Order extends Model
{
    use SoftDeletes, LanguageTrait;

    protected $table = 'orders';
    protected $fillable = ['id','order_number','user_id' , 'session_id', 'is_guest', 'status','returned_status', 'payment_method_id', 'price', 'price_after', 'tax', 'shipping', 'is_coupon',
        'coupon_price', 'is_coupon_automatic', 'coupon_automatic_code', 'coupon_automatic_price', 'cash_fees', 'platform','invoice_number',
        'tax_percentage' ,'first_order_discount', 'package_discount_price' ,'admin_discount','total_price' , 'confirm_cod', 'confirm_cod_at', 'processing_at', 'shipment_at', 'pending_at',
        'currency_id','is_discount_product_quantity' , 'is_add_to_user_points', 'exchange_rate', 'order_points' ,'lat' , 'lng',
        'pay_points','paid_points','shipping_policy','shipping_policy_return' ,'lang', 'finished_at',
        'canceled_at', 'returned_at', 'failed_at' , 'replaced_at' , 'check_return_order_token',
        'return_order_note_text','return_order_note_file','sms_code','cancel_reasons',
        'app_version'
    ];

    public $appends = ['discount_price' , 'total_coupon_price', 'price_after_discount_coupon', 'price_before_tax'];
    protected $filters = ['id','phone','total_price','status', 'payment_method' ,'shipping_company', 'type_product' , 'place','platform'];

    /*  attributes   */
    public function getCreatedAtAttribute($value)
    {
        if (!is_null($value)) {
            return Carbon::parse($value)->format('Y-m-d h:i:s a');
        } else {
            return "";
        }
    }


    public function getShippingAttribute($value)
    {
        return number_format($value, round_digit() , '.', '');
    }
   
    public function getPriceAfterDiscountCouponAttribute()
    {
        return number_format($this->price - $this->admin_discount - $this->coupon_price - $this->coupon_automatic_price - $this->first_order_discount - $this->package_discount_price, round_digit(), '.', '');
    }

    public function getPriceBeforeTaxAttribute()
    {
        return number_format($this->price - $this->admin_discount - $this->coupon_price - $this->first_order_discount - $this->package_discount_price - $this->coupon_automatic_price + $this->cash_fees + $this->shipping, round_digit(), '.', '');
    }

    public function getProcessingAtAttribute($value)
    {
        if (!is_null($value)) {
            return Carbon::parse($value)->format('Y-m-d h:i:s a');
        } else {
            return "";
        }
    }

    public function getShipmentAtAttribute($value)
    {
        if (!is_null($value)) {
            return Carbon::parse($value)->format('Y-m-d h:i:s a');
        } else {
            return "";
        }
    }

    public function getPendingAtAttribute($value)
    {
        if (!is_null($value)) {
            return Carbon::parse($value)->format('Y-m-d h:i:s a');
        } else {
            return "";
        }
    }

    public function getFinishedAtAttribute($value)
    {
        if (!is_null($value)) {
            return Carbon::parse($value)->format('Y-m-d h:i:s a');
        } else {
            return "";
        }
    }

    public function getCanceledAtAttribute($value)
    {
        if (!is_null($value)) {
            return Carbon::parse($value)->format('Y-m-d h:i:s a');
        } else {
            return "";
        }
    }

    public function getReturnedAtAttribute($value)
    {
        if (!is_null($value)) {
            return Carbon::parse($value)->format('Y-m-d h:i:s a');
        } else {
            return "";
        }
    }

    public function getFailedAtAttribute($value)
    {
        if (!is_null($value)) {
            return Carbon::parse($value)->format('Y-m-d h:i:s a');
        } else {
            return "";
        }
    }

    public function getPriceAttribute($value)
    {

        return number_format($value, round_digit(), '.', '');
    }
    public function getTaxAttribute($value)
    {

        return number_format($value, round_digit(), '.', '');
    }

    public function getPriceAfterAttribute($value)
    {

        return number_format($value, round_digit(), '.', '');
    }

    public function getDiscountPriceAttribute()
    {

        return number_format($this->price - $this->price_after, round_digit(), '.', '');
    }

    public function getTotalCouponPriceAttribute($value)
    {

        return number_format($this->coupon_price + $this->coupon_automatic_price +$this->first_order_discount + $this->package_discount_price + ( $this->price - $this->price_after), round_digit(), '.', '');
    }

    public function getTotalPriceAttribute($value)
    {

        return number_format($value, round_digit(), '.', '');

    }

    /* relations  */

    public function currency(){
        return $this->belongsTo(Currency::class , 'currency_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public function company_shipping()
    {
        return $this->hasOne(OrderCompanyShipping::class, 'order_id');
    }
    public function wallet_logs()
    {
        return $this->hasOne(WalletLog::class, 'order_id');
    }

    public function bank()
    {
        return $this->hasOne(OrderBank::class, 'order_id');
    }

    public function admin_discounts()
    {
        return $this->hasMany(OrderAdminDiscount::class, 'order_id');
    }

    public function package()
    {
        return $this->hasOne(OrderPackage::class, 'order_id')->withDefault([
            'id' => -1,
            'name' => "",
            'discount' => 0 ,
            'price' => 0 ,
            'free_shipping' => false ,
        ]);
    }


    public function order_payment()
    {
        return $this->hasOne(OrderPayment::class, 'order_id');
    }

    public function coupon()
    {
        return $this->hasMany(OrderCoupon::class, 'order_id');
    }

    public function order_user_shipping()
    {
        return $this->hasOne(OrderUserShipping::class, 'order_id');
    }

    public function order_products()
    {
        return $this->hasMany(OrderProduct::class, 'order_id');
    }


    public function scopePendingOrder($query) {
        $query->whereIn('orders.status' , [orignal_order_status()['new'] , orignal_order_status()['processing']
         ,orignal_order_status()['finished']]);
    }

    public function scopeConfirmOrder($query) {
        $query->whereIn('orders.status' , [order_status()['delivered']]);
    }

    /*  filters */
    public function scopeNewOrder($query)
    {
        $query->where('orders.status' ,'=' , orignal_order_status()['new']);
    }

    public function scopeProcessingOrder($query)
    {
        $query->where('orders.status' ,'=' , orignal_order_status()['processing']);
    }

    public function scopeFailedOrder($query)
    {
        $query->where('orders.status' ,'=' , orignal_order_status()['failed']);
    }

    public function scopeCanceledOrder($query)
    {
        $query->where('orders.status' ,'=' , orignal_order_status()['canceled']);
    }


    public function scopeFinishedOrder($query)
    {
        $query->where('orders.status' ,'=' , orignal_order_status()['finished']);
    }

    public function scopeFinancialStatisticOrder($query)
    {
        $query->where('orders.status' ,'=' , orignal_order_status()['finished'])->orWhere('orders.status' ,'=' , orignal_order_status()['new'])
            ->orWhere('orders.status' ,'=' , orignal_order_status()['processing']);
    }

    public function scopeDateRawOrder($query, $start_at, $end_at)
    {

        $query->whereRaw("date(orders.created_at) >= '$start_at' ")
            ->whereRaw("date(orders.created_at) <= '$end_at' ");
    }
    
    public function scopeDateOrder($query, $start_at, $end_at)
    {

        $query->where(DB::raw('date(created_at)'), '>=', $start_at)
            ->where(DB::raw('date(created_at)'), '<=', $end_at);
    }

    public function scopeDateRangeOrder($query, $get_date_filter)
    {

        if ($get_date_filter['date_from'] != -1 && $get_date_filter['date_to'] != -1) {
            $query->where(DB::raw('date(orders.created_at)'), '>=', $get_date_filter['date_from'])
                ->where(DB::raw('date(orders.created_at)'), '<=', $get_date_filter['date_to']);
        }
    }
    public function scopeOrderProduct($query, $product_id)
    {
        $query->whereHas('order_products' , function ($query2)use($product_id){
            $query2->where('product_id' , '=' ,$product_id );
        });
    }
    public function scopeOrderProductVariation($query, $product_variation_id)
    {
        $query->whereHas('order_products' , function ($query2)use($product_variation_id){
            $query2->where('product_variation_id' , '=' ,$product_variation_id );
        });
    }
    public function scopeOrderCity($query, $city_id)
    {
        $query->whereHas('order_user_shipping' , function ($query2)use($city_id){
            $query2->where('city' , '=' ,$city_id );
        });
    }
    public function scopeOrderCountry($query, $country_id)
    {
        $query->whereHas('order_user_shipping' , function ($query2)use($country_id){
            $query2->whereHas('shipping_city' , function ($query3) use($country_id){
                $query3->where('country_id' , '=' , $country_id);
            });
        });
    }

    public function scopeFilter($builder, $filters)
    {
        return $this->apply_filters($builder, $filters);
    }

    public function apply_filters($builder, $get_filters)
    {
        $filters = [];
        $user_filter = new OrderFilter($builder);

        foreach ($get_filters as $key => $value) {
            if (in_array($key, $this->filters)) {
                $get_method = $user_filter->get_filters()[$key];
                $filters[$key] = $user_filter->$get_method($value);
            }
        }
    }
}
