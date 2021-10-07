<?php

namespace App\Models;

use App\Filters\CategoryFilter;
use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use SoftDeletes , LanguageTrait;

    protected $table = 'packages';
    protected $fillable = ['image','name_en' , 'name_ar','price_from' ,'price_to' , 'discount_rate' ,'replace_hours' ,'free_shipping'];

    protected $appends = ['name' ];
    protected $filters = [];

    public function getNameAttribute() {
        return $this->getName($this);
    }

    public function getImageAttribute($value) {
        return add_full_path($value , 'packages');
    }
    /*  scopes   */

    public function scopeActive($query) {
        $query->where('status' , '=' , 1);
    }

    /* relations  */



    /*  filters */

}
