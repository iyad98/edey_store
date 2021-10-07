<?php

namespace App\Models;

use App\Filters\CategoryFilter;
use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\City;

class Store extends Model
{
    use LanguageTrait;

    protected $table = 'stores';
    protected $fillable = [
        'city_id','phone','name_en' , 'name_ar' , 'address_en' ,'address_ar' ,'lat' , 'lng'
    ];

    protected $appends = ['name' ,'address'];

    public function getNameAttribute() {
        return $this->getName($this);
    }
    public function getAddressAttribute() {
        return $this->getAddress($this);
    }

    // scopes

    // relations
    public function city() {
        return $this->belongsTo(City::class , 'city_id');
    }
}
