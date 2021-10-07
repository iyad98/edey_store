<?php

namespace App\Models;

use App\Filters\CategoryFilter;
use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// models
use App\Models\City;
use App\Models\ShippingCompanyCity;

class ShippingCompanyPrice extends Model
{
    use LanguageTrait ;
    /*
     * type :-
     * percent
     * fixed
     */

    protected $table = 'shipping_company_prices';
    protected $fillable = ['shipping_company_id' ,'name_ar' , 'name_en','from' , 'to' , 'price' , 'type' ];

    protected $appends = ['name'];

    public function getNameAttribute() {
        return $this->getName($this);
    }


    /*  scopes   */



    /* relations  */

    public function shipping_company_city(){
        return $this->belongsTo(ShippingCompanyCity::class , 'shipping_company_city_id');
    }
    /*  filters */

}
