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

class OrderPackage extends Model
{

    protected $table = 'order_package';

    protected $fillable = ['order_id', 'package_id', 'package_discount', 'package_price','replace_hours' , 'free_shipping'];

    /*  scopes   */


    /* relations  */


    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    /*  filters */

}
