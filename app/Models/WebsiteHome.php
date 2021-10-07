<?php

namespace App\Models;

use App\Filters\CategoryFilter;
use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Banner;
use App\Models\Category;

class WebsiteHome extends Model
{
    use LanguageTrait;
    /*
     * type :-
     *  1 >> category
     *  2 >> banner one image
     *  3 >> banner two image
     *  4 >> banner slider
     *  5 >> latest products
     *  6 >> most sales
     *  7 >> website 4 banner
     *  8 >> website section
     *  9 >> coupons
     *
     * type_id :-
     * this point id of category or banner
     * -1 >> latest product
     * -2 >> most sales
     */

    protected $table = 'website_home';
    protected $fillable = ['type_id' , 'type','product_counts' ,'order' ,'name_ar' , 'name_en'];
    protected $appends = ['name'];

    public function banner() {
        return $this->belongsTo(Banner::class , 'type_id');
    }

    public function category() {
        return $this->belongsTo(Category::class , 'type_id');
    }

    public function widget() {
        return $this->belongsTo(Widget::class , 'id','website_home_id');
    }
    public function getNameAttribute() {
        return $this->getName($this);
    }

   
}
