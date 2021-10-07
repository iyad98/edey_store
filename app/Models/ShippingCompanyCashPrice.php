<?php

namespace App\Models;

use App\Filters\CategoryFilter;
use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// models
use App\Models\City;
use App\Models\ShippingCompanyCity;

class ShippingCompanyCashPrice extends Model
{
    /*
     * type :-
     * percent
     * fixed
     */

    protected $table = 'shipping_company_cash_prices';
    protected $fillable = ['shipping_company_id','from' , 'to' , 'price' , 'type' ];




    /*  scopes   */



    /* relations  */

    public function shipping_company_city(){
        return $this->belongsTo(ShippingCompanyCity::class , 'shipping_company_city_id');
    }
    /*  filters */

}
