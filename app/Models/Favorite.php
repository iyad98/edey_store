<?php

namespace App\Models;

use App\Filters\CategoryFilter;
use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Product;

class Favorite extends Model
{
    use  LanguageTrait;

    protected $table = 'favorites';
    protected $fillable = [
        'user_id', 'product_id'
    ];



    // relations
    public function product() {
        return $this->belongsTo(Product::class , 'product_id');
    }
}
