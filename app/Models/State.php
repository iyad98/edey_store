<?php

namespace App\Models;

use App\Filters\CategoryFilter;
use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model
{
    use SoftDeletes , LanguageTrait;

    protected $table = 'states';
    protected $fillable = [
        'name_en' , 'name_ar' ,'country_id', 'status'
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
