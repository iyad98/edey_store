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

class OrderPayment extends Model
{

    protected $table = 'order_payment';

    protected $fillable = ['order_id', 'payment_reference','reference_no', 'payment_reference_at', 'transaction_id'];

    /*  scopes   */


    /* relations  */

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /*  filters */

}
