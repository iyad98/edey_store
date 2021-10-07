<?php

namespace App\Models;

use App\Filters\CategoryFilter;
use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// models
use App\User;
use App\Models\CartProduct;

class Cart extends Model
{

    protected $table = 'carts';
    protected $fillable = ['user_id' , 'session_id','tax' , 'shipping' ];



    /*  scopes   */

    public function scopeCheckSessionId($query , $session_id) {
        $query->whereNotNull('session_id')->where('session_id' , '=' ,$session_id);
    }
    public function scopeCheckUserId($query , $user_id) {
        $query->whereNotNull('user_id')->where('user_id' , '=' ,$user_id);
    }

    /* relations  */
    public function user() {
        return $this->belongsTo(User::class , 'user_id');
    }

// relations
    public function products() {
        return $this->hasMany(CartProduct::class , 'cart_id');
    }
    /*  filters */

}
