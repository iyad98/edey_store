<?php

namespace App\Models;

use App\Filters\CategoryFilter;
use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// models
use App\Models\DiscountType;

class Category extends Model
{
    use SoftDeletes , LanguageTrait;

    protected $table = 'categories';
    protected $fillable = ['id','image','guide_image','name_en' , 'name_ar' ,'nickname_ar' , 'nickname_en','website_nickname_ar' ,'website_nickname_en' ,'slug_ar' ,'slug_en', 'description_en' , 'description_ar' , 'parent' , 'discount_type_id', 'discount_price'];

    protected $appends = ['name' , 'description' ,'nickname' ,'slug','product_count'];
    protected $filters = ['parent'];

    public function getNameAttribute() {
        return $this->getName($this);
    }
    public function getNickNameAttribute() {
        return $this->getNickName($this);
    }

    public function getDescriptionAttribute() {
        return $this->getDescription($this);
    }
    public function getProductCountAttribute() {
        return ProductCategory::where('category_id',$this->id)->count();

    }

    public function getSlugAttribute() {
        return $this->getSlug($this);
    }
    public function getImageAttribute($value) {
        return getImage('' , true , $value);
    }
    public function getGuideImageAttribute($value) {
        return getImage('' , true , $value);
    }
    /*  scopes   */

    public function scopeParents($query)
    {
       return $query->whereNull('parent');
    }
    public function scopeSubss($query)
    {
        return $query->whereNotNull('parent');
    }

    public function getParentsAttribute()
    {

        $parents = collect([$this]);

        $parent = $this->parent_;

        while(!is_null($parent)) {
            $parents->push($parent);
            $parent = $parent->parent_;
        }

        return $parents;
    }
    /* relations  */

    public function scopeInWebsiteHome($query) {
        $query->whereIn('id' , function ($query2){
            $query2->from('website_home')->whereIn('type' , [1])->select('type_id');
        });
    }
    public function products() {
        return $this->belongsToMany(Product::class , 'product_categories', 'category_id' , 'product_id');
    }

    public function parent() {
        return $this->belongsTo(Category::class , 'parent')->withDefault([
            'id' => -1 ,
            'name_ar' => trans('admin.main_category')
        ]);
    }

    public function parent_() {
        return $this->belongsTo(Category::class , 'parent');
    }

    public function children() {
        return $this->hasMany(Category::class , 'parent');
    }
    public function website_children() {
        return $this->hasMany(Category::class , 'parent_website')->orderBy('in_website_sidebar_order');
    }
    public function app_children() {
        return $this->hasMany(Category::class , 'parent_app')->orderBy('in_sidebar_order');
    }
    public function discount_type() {
        return $this->belongsTo( DiscountType::class, 'discount_type_id');
    }


    /*  filters */
    public function scopeFilter($builder ,$filters) {
        return $this->apply_filters($builder ,$filters );
    }
    public function apply_filters($builder ,$get_filters) {
        $filters = [];
        $user_filter = new CategoryFilter($builder);

        foreach ($get_filters as $key=>$value) {
            if(in_array($key , $this->filters)) {
                $get_method =  $user_filter->get_filters()[$key];
                $filters[$key] = $user_filter->$get_method($value);
            }
        }
    }
}
