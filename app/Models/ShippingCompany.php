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
use App\Models\ShippingCompanyCountry;

class ShippingCompany extends Model
{
    use SoftDeletes , LanguageTrait;

    protected $table = 'shipping_companies';
    protected $fillable = ['image','image_web','name_en' , 'name_ar' ,'phone' ,'tracking_url' ,'status' ,'can_cash' , 'cash_value' ,
        'billing_national_address' , 'billing_building_number' , 'billing_postalcode_number' ,
        'billing_unit_number' , 'billing_extra_number' , 'show_for_user','accept_user_shipping_address','note'];

    protected $appends = ['name'];
    protected $filters = [];

    public function getNameAttribute() {
        return $this->getName($this);
    }

    public function getImageAttribute($value) {
        return add_full_path($value , 'shipping_companies');
    }
    public function getImageWebAttribute($value) {
        return add_full_path($value , 'shipping_companies');
    }

    /*  scopes   */


    public function scopeActive($query) {
        $query->where('status' , '=' , 1);
    }

    public function scopeShowForUser($query) {
        $query->where('show_for_user' , '=' , 1);
    }

    public function scopeInCity($query , $city_id){
        $query->where(function ($query0) use($city_id){
            $query0->whereHas('shipping_company_countries' , function ($query1) use($city_id) {
                $query1->whereHas('shipping_company_country_cities' , function ($query2) use($city_id){
                    $query2->where('city_id' , '=' ,$city_id);
                });
            });
        });
    }
    public function InCountry($query , $country_id){
        $query->where(function ($query0) use($country_id){
            $query0->whereHas('countries' , function ($query1) use($country_id) {
                $query1->where('countries.id' , '=' ,$country_id );
            });
        });
    }
    /* relations  */
    public function cities() {
        return $this->belongsToMany(City::class , 'shipping_company_cities' , 'shipping_company_id' , 'city_id');
    }
    public function countries() {
        return $this->belongsToMany(Country::class , 'shipping_company_countries' , 'shipping_company_id' , 'country_id')
            ->select('countries.*' , 'shipping_company_countries.id as shipping_company_country_id');
    }
    public function shipping_company_countries() {
        return $this->hasMany(ShippingCompanyCountry::class , 'shipping_company_id');

    }


    /*  filters */

}
