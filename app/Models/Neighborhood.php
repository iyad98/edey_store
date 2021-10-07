<?php

namespace App\Models;

use App\Filters\CategoryFilter;
use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Neighborhood extends Model
{
    use SoftDeletes , LanguageTrait;

    protected $table = 'neighborhoods';
    protected $fillable = [
        'name_en' , 'name_ar' ,'city_id', 'status'
    ];

    protected $appends = ['name' ];

    public function getNameAttribute() {
        return $this->getName($this);
    }

    // scopes
    public function scopeActive($query) {
        $query->where('status' , '=' , 1);
    }
}
