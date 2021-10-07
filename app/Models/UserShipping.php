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

class UserShipping extends Model
{
    use SoftDeletes ;

    protected $table = 'user_shipping';

    protected $fillable = ['id','user_id', 'first_name', 'last_name', 'phone', 'country', 'city', 'city2',
        'state',
        'street',
        'avenue',
        'building_number',
        'floor_number',
        'apartment_number',
        'address', 'email', 'billing_shipping_type', 'billing_national_address', 'billing_building_number',
        'billing_postalcode_number', 'billing_unit_number', 'billing_extra_number', 'platform', 'delivared_name',
        'delivared_lat', 'delivared_lng' ,'is_gift' ,'gift_first_name' , 'gift_last_name' , 'gift_target_phone' ,
        'gift_target_email' , 'gift_text','is_default','code','is_verified'];

    public $appends = ['phone_code'];

    public function __get($key)
    {
        if (in_array($key, $this->fillable)) {
            return $this->attributes[$key] == null ? "" : $this->attributes[$key];
        } else {
            return parent::__get($key);
        }
    }
    public function getPhoneCodeAttribute()
    {

        $city = City::find($this->city);
        $country = $city ? $city->country : null;
        $country_phone_code = $country ? $country->phone_code : null;
       return $country_phone_code;
    }

    /*  scopes   */


    /* relations  */

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function shipping_city()
    {
        return $this->belongsTo(City::class, 'city')->withTrashed();
    }

    public function shipping_country()
    {
        return $this->belongsTo(Country::class, 'country')->withTrashed();
    }

    public function billing_shipping_type_() {
        return $this->belongsTo(ShippingCompany::class, 'billing_shipping_type')->withTrashed();

    }


    public function empty_shipping() {
        $data = [];
        foreach ( $this->fillable as $key) {
            if($key != "user_id") {
                $data[$key] = null;
            }

        }
        return $data;
    }
    /*  filters */

}
