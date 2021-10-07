<?php

namespace App\Models;

use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;

class Widget extends Model
{
    use  LanguageTrait;

    protected $table = 'widget';
    protected $fillable = ['id' , 'website_home_id','widget_type' ,'image_ar' ,'image_en','image_mobile_ar'];
//    protected $appends = ['name'];

    public function getImageArAttribute($value) {
        return add_full_path($value , 'ads');
    }


    public function getImageMobileArAttribute($value) {
        return add_full_path($value , 'ads');
    }
    public function getImageEnAttribute($value) {
        return add_full_path($value , 'ads');
    }

}
