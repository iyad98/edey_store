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

class OrderUserShipping extends Model
{

    protected $table = 'order_user_shipping';

    protected $fillable = ['order_id', 'first_name', 'last_name', 'phone', 'country', 'city', 'city2',
        'state',
        'street',
        'avenue',
        'building_number',
        'floor_number',
        'apartment_number',
        'address', 'email', 'billing_shipping_type', 'billing_national_address', 'billing_building_number',
        'billing_postalcode_number', 'billing_unit_number', 'billing_extra_number', 'platform', 'delivared_name',
        'delivared_lat', 'delivared_lng' , 'is_gift', 'gift_first_name' , 'gift_last_name' , 'gift_target_phone' ,
        'gift_target_email' , 'gift_text'];

    public function __get($key)
    {
        if (in_array($key, $this->fillable)) {
            return $this->attributes[$key] == null ? "" : $this->attributes[$key];
        } else {
            return parent::__get($key);

        }
    }


    /*  scopes   */


    /* relations  */

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function shipping_city()
    {
        return $this->belongsTo(City::class, 'city')->withTrashed();
    }
    public function billing_shipping_type_() {
        return $this->belongsTo(ShippingCompany::class, 'billing_shipping_type')->withTrashed();

    }
    /*  filters */

}
