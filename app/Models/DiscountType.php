<?php

namespace App\Models;

use App\Filters\CategoryFilter;
use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiscountType extends Model
{
    use LanguageTrait;

    protected $table = 'discount_types';
    protected $fillable = ['name_en' , 'name_ar' , 'key'];

    protected $appends = ['name' ];

    public function getNameAttribute() {
        return $this->getName($this);
    }


    /*  scopes   */


    /* relations  */



    /*  filters */

}
