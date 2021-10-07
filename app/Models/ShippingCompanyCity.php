<?php

namespace App\Models;

use App\Filters\CategoryFilter;
use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// models
use App\Models\City;
use App\Models\ShippingCompanyPrice;
use App\Models\Country;
use App\Models\ShippingCompany;
use App\Models\ShippingCompanyCountry;

class ShippingCompanyCity extends Model
{
    use  LanguageTrait;

    protected $table = 'shipping_company_cities';
    protected $fillable = ['shipping_company_country_id' , 'city_id' , 'cash','calculation_type'];



    /*  scopes   */

    public function scopeInCompanyAndCity($query , $shipping_company , $city) {
        $query->whereHas('shipping_company_country' , function ($query) use($city , $shipping_company){
            $query->where('country_id' , '=' ,$city->country_id )->where('shipping_company_id' , '=' ,$shipping_company->id);
        })->where('city_id' , '=' , $city->id);
    }

    /* relations  */
    public function city() {
        return $this->belongsTo(City::class , 'city_id');
    }
    public function shipping_company_country() {
        return $this->belongsTo(ShippingCompanyCountry::class , 'shipping_company_country_id');
    }

    public function shipping_company_prices(){
        return $this->hasMany(ShippingCompanyPrice::class , 'shipping_company_city_id');
    }

    public function shipping_company_fixed_prices_for_product(){
        return $this->hasOne(ShippingCompanyPrice::class , 'shipping_company_city_id')->where('type','perpiece');
    }
    public function shipping_company_cash_prices(){
        return $this->hasMany(ShippingCompanyCashPrice::class , 'shipping_company_city_id');
    }

    /*  filters */

}
