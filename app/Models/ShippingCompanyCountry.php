<?php

namespace App\Models;

use App\Filters\CategoryFilter;
use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// models
use App\Models\Country;
use App\Models\ShippingCompanyPrice;
use App\Models\ShippingCompany;
use App\Models\ShippingCompanyCity;

class ShippingCompanyCountry extends Model
{
    use  LanguageTrait;

    protected $table = 'shipping_company_countries';
    protected $fillable = ['shipping_company_id' , 'country_id'];

    /*  scopes   */


    /* relations  */
    public function country() {
        return $this->belongsTo(Country::class , 'country_id');
    }
    public function shipping_company() {
        return $this->belongsTo(ShippingCompany::class , 'shipping_company_id');
    }

    public function shipping_company_country_cities() {
        return $this->hasMany(ShippingCompanyCity::class , 'shipping_company_country_id');

    }


    /*  filters */

}
