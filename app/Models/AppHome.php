<?php

namespace App\Models;

use App\Filters\CategoryFilter;
use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Banner;
use App\Models\Category;

class AppHome extends Model
{
    use LanguageTrait;

    protected $table = 'app_home';
    protected $fillable = ['type_id' , 'type','product_counts' ,'order','name_ar' , 'name_en' ];
    protected $appends = ['name'];

    public function getNameAttribute() {
        return $this->getName($this);
    }
    
    public function banner() {
        return $this->belongsTo(Banner::class , 'type_id');
    }

    public function category() {
        return $this->belongsTo(Category::class , 'type_id');
    }

}
