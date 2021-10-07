<?php

namespace App\Models;

use App\Filters\CategoryFilter;
use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Product;

class Brand extends Model
{
    use SoftDeletes , LanguageTrait;

    protected $table = 'brands';
    protected $fillable = ['image','name_en' , 'name_ar', 'slug_ar' ,'slug_en' , 'description_en' , 'description_ar' ];

    protected $appends = ['name' , 'description' , 'slug'];
    protected $filters = [];

    public function getNameAttribute() {
        return $this->getName($this);
    }

    public function getDescriptionAttribute() {
        return $this->getDescription($this);
    }
    public function getSlugAttribute() {
        return $this->getSlug($this);
    }
    public function getImageAttribute($value) {
        return getImage('' , true , $value);
    }
    /*  scopes   */

    public function scopeSearchSlug($query , $slug) {
        $query->where(function ($q1) use($slug) {
            $q1->where('slug_ar' , '=' , $slug)->orWhere('slug_en' , '=' , $slug);
        });
    }



    /* relations  */

    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id');
    }

    /*  filters */

}
