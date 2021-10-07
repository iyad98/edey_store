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

class OrderCompanyShipping extends Model
{
    use LanguageTrait;

    protected $table = 'order_company_shipping';

    protected $fillable = ['order_id', 'shipping_company_id', 'shipping_company_name', 'shipping_company_type',
        'shipping_company_amount' , 'from' , 'to' , 'shipping_company_price_text_en' ,
        'shipping_company_price_text_ar' , 'shipping_company_city_id' ,
        'shipping_company_cash_prices' , 'shipping_company_prices'];

    protected $appends = ['shipping_company_price_text'];

    public function getShippingCompanyPriceTextAttribute() {
        return $this->getShippingCompanyPriceText($this);
    }
    /*  scopes   */


    /* relations  */

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
    public function prices()
    {
        return $this->hasMany(ShippingCompanyPrice::class, 'shipping_company_id' , 'shipping_company_id');
    }

    public function shipping_company()
    {
        return $this->belongsTo(ShippingCompany::class, 'shipping_company_id' );
    }

    /*  filters */

}
