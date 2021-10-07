<?php

namespace App\Models;

use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes , LanguageTrait;

    protected $table = 'services';
    protected $fillable = ['image','title_en' , 'title_ar' , 'description_en' , 'description_ar' ];

    protected $appends = ['title' , 'description' ];
    protected $filters = [];

    public function getTitleAttribute() {
        return $this->getTitle($this);
    }

    public function getDescriptionAttribute() {
        return $this->getDescription($this);
    }

    public function getImageAttribute($value) {
        return getImage('' , true , $value);
    }
}
