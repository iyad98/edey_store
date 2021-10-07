<?php

namespace App\Models;

use App\Filters\CategoryFilter;
use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Country;
use App\Models\Store;
use App\Models\OrderUserShipping;

class City extends Model
{
    use SoftDeletes , LanguageTrait;

    protected $table = 'cities';
    protected $fillable = [
        'name_en' , 'name_ar' , 'country_id'
    ];

    protected $appends = ['name' ];

    public function getNameAttribute() {
        return $this->getName($this);
    }

    // scopes
    public function scopeActive($query) {
        $query->where('status' , '=' , 1);
    }
    public function scopeInCountry($query , $country_id) {
        $query->where('country_id' , '=' , $country_id);
    }
    public function scopeNotInShippingCompanyCountry($query , $shipping_company_country_id) {
        $query->whereNotIn('cities.id',function ($query2) use($shipping_company_country_id) {
            $query2->from('shipping_company_cities')->where('shipping_company_country_id' , '=' , $shipping_company_country_id)
                    ->select('city_id');
        });
    }

    // relation
    public function country() {
        return $this->belongsTo(Country::class , 'country_id');
    }

    public function stores() {
        return $this->hasMany(Store::class , 'city_id');
    }
    public function order_shipping() {
        return $this->hasMany( OrderUserShipping::class, 'city');
    }
}
