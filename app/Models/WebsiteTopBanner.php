<?php

namespace App\Models;

use App\Filters\CategoryFilter;
use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Category;
use App\Models\Product;

class WebsiteTopBanner extends Model
{
    use  LanguageTrait;

    protected $table = 'website_top_banner';
    protected $fillable = ['image_ar' , 'image_en' , 'text_ar' ,'text_en' , 'category_id' ,'product_id' , 'url' , 'status','text_color','background_color'];

    protected $appends = ['image','text','url_pointer'];
    protected $filters = [];


    public function getImageArAttribute($value) {
        return add_full_path($value , 'website_top_banner');
    }
    public function getImageEnAttribute($value) {
        return add_full_path($value , 'website_top_banner');
    }

    public function getImageAttribute() {

        return $this->getImage($this);
    }

    public function getTextAttribute() {
        return $this->getText($this);
    }

    public function getUrlPointerAttribute() {
        return get_pointer_top_banner_url($this);
    }

    /*  scopes   */



    /* relations  */

    public function category() {
        return $this->belongsTo(Category::class , 'category_id');
    }
    public function product() {
        return $this->belongsTo(Product::class , 'product_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status' , '=' , 1);
    }

    /*  filters */

}
