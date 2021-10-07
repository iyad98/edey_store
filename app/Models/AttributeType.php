<?php

namespace App\Models;

use App\Filters\CategoryFilter;
use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttributeType extends Model
{
    use SoftDeletes, LanguageTrait;

    protected $table = 'attribute_types';
    protected $fillable = ['name_en', 'name_ar', 'key', 'status'];

    protected $appends = ['name'];
    protected $filters = [];

    public function getNameAttribute()
    {
        return $this->getName($this);
    }


    /*  scopes   */

    public function scopeActive($query)
    {
        $query->where('status', '=', 1);
    }

    public function attribute(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Attribute::class, 'attribute_type_id', 'id');
    }


}
