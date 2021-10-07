<?php

namespace App\Models;

use App\Filters\CategoryFilter;
use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Product;
use App\User;

class Rate extends Model
{
    use LanguageTrait;

    protected $table = 'rates';
    protected $fillable = [
        'user_id', 'product_id','rate'
    ];


    // relations
    public function product() {
        return $this->belongsTo(Product::class , 'product_id');
    }
    public function user() {
        return $this->belongsTo(User::class , 'user_id')->withTrashed();
    }
}
