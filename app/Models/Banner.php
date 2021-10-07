<?php

namespace App\Models;

use App\Filters\CategoryFilter;
use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Category;
use App\Models\Product;

class Banner extends Model
{
    use SoftDeletes , LanguageTrait;

    protected $table = 'banners';
    protected $fillable = ['image_ar' , 'image_en' , 'image_website_ar' , 'image_website_en','name_en' , 'name_ar', 'category_id' ,'product_id' , 'parent_id' , 'status'];

    protected $appends = ['name','image' , 'image_website'];
    protected $filters = [];

    public function getNameAttribute() {
        return $this->getName($this);
    }

    public function getImageArAttribute($value) {
        return getImage('' , true , $value);
    }
    public function getImageEnAttribute($value) {
        return getImage('' , true , $value);
    }
    public function getImageWebsiteArAttribute($value) {
        return getImage('' , true , $value);
    }
    public function getImageWebsiteEnAttribute($value) {
        return getImage('' , true , $value);
    }

    public function getImageAttribute() {

        return $this->getImage($this);
    }
    public function getImageWebsiteAttribute() {
        return $this->getImageWebsite($this);
    }
    /*  scopes   */



    /* relations  */

    public function category() {
        return $this->belongsTo(Category::class , 'category_id');
    }
    public function product() {
        return $this->belongsTo(Product::class , 'product_id');
    }
    public function scopeInWebsiteHome($query) {
        $query->whereIn('id' , function ($query2){
            $query2->from('website_home')->whereIn('type' , [2,3,4])->select('type_id');
        });
    }

    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }
    public function scopeActive($query)
    {
        return $query->where('status' , '=' , 1);
    }
    public function children() {
        return $this->hasMany(Banner::class , 'parent_id');
    }
    public function parent() {
        return $this->belongsTo(Banner::class , 'parent_id')->withDefault([
            'id' => -1 ,
            'name_ar' => trans('admin.banner_parent'),
            'name_en' => trans('admin.banner_parent')
        ]);
    }
    /*  filters */

}
