<?php

namespace App\Models;

use App\Filters\CategoryFilter;
use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Currency;
use App\Models\PaymentMethod;

class Country extends Model
{
    use SoftDeletes , LanguageTrait;

    protected $table = 'countries';
    protected $fillable = [
        'name_en' , 'name_ar' , 'flag' , 'iso3' , 'iso2' ,'phone_code' ,'currency_id' ,
        'capital_en' ,'capital_ar' , 'status'
    ];

    protected $appends = ['name' , 'capital'];

    public function getNameAttribute() {
        return $this->getName($this);
    }

    public function getCapitalAttribute() {
        return $this->getCapital($this);
    }
    public function getFlagAttribute($value) {
        return add_full_path($value , 'countries');
    }

    // scopes
    public function scopeActive($query) {
        $query->where('status' , '=' , 1);
    }
    public function scopeGeneralData($query) {
        $query->orderBy('name_ar' , 'asc');
    }

    // relations
    public function currency(){
        return $this->belongsTo(Currency::class , 'currency_id');
    }
    public function payment_methods() {
        return $this->belongsToMany(PaymentMethod::class , 'country_payment_methods' , 'country_id' , 'payment_method_id');

    }
}
