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

class OrderBank extends Model
{
    use SoftDeletes;

    protected $table = 'order_bank';

    protected $fillable = ['order_id', 'bank_id', 'status', 'name','account_number' , 'file' ,'price'];

    public function getFileAttribute($value) {
        if(is_null($value)) {
            return "";
        }
        return add_full_path($value , 'order_bank');
    }
    /*  scopes   */


    /* relations  */

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /*  filters */

}
