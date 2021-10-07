<?php

namespace App\Models;

use App\Filters\CategoryFilter;
use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImage extends Model
{

    protected $table = 'product_images';
    protected $fillable = ['product_id','image' ];

    public function getImageAttribute($value) {
        return getImage('' , true , $value);
    }
    /*  scopes   */



    /* relations  */



    /*  filters */

}
