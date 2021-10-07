<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    protected $guarded = [''];


    protected $hidden = [
        'password', 'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    public function getImageBanarStoreAttribute($val)
    {
        return ($val !== null) ? asset('assets/' . $val) : "";
    }

    public function getLogoStoreAttribute($val)
    {
        return ($val !== null) ? asset('assets/' . $val) : "";

    }

    public function products()
    {
        return $this->hasMany(Product::class, 'merchant_id', 'id');
    }




}
