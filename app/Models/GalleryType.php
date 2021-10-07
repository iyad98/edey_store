<?php

namespace App\Models;

use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;

class GalleryType extends Model
{
    use LanguageTrait;

    protected $table = 'gallery_types';
    protected $fillable = ['name_ar' , 'name_en'];
    public $appends = ['name'];

    public function getNameAttribute() {
        return $this->getName($this);
    }
}
