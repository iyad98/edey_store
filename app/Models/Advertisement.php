<?php

namespace App\Models;

use App\Filters\CategoryFilter;
use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// models
use App\Models\AttributeType;
use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\Category;

class Advertisement extends Model
{
    use  LanguageTrait;

    protected $table = 'advertisements';
    protected $fillable = ['name_en' , 'name_ar' , 'key' , 'image' , 'point_type' ,'point_id' ];

    protected $appends = ['name'];
    protected $filters = [];

    public function getNameAttribute() {
        return $this->getName($this);
    }
    public function getImageAttribute($value) {
        return getImage('' , true , $value);
    }


    public function product() {
        return $this->belongsTo(Product::class , 'point_id');
    }
    public function category() {
        return $this->belongsTo(Category::class , 'point_id');
    }
}
