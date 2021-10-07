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

class Attribute extends Model
{
    use SoftDeletes , LanguageTrait;

    protected $table = 'attributes';
    protected $fillable = ['id','name_en' , 'name_ar' , 'description_en' , 'description_ar' , 'attribute_type_id' ];

    protected $appends = ['name' , 'description'];
    protected $filters = [];

    public function getNameAttribute() {
        return $this->getName($this);
    }

    public function getDescriptionAttribute() {
        return $this->getDescription($this);
    }

    /*  scopes   */



    /* relations  */

    public function attribute_type() {
        return $this->belongsTo( AttributeType::class, 'attribute_type_id')->withTrashed();
    }

    public function attribute_values() {
        return $this->hasMany( AttributeValue::class, 'attribute_id');
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_attributes', 'attribute_id' , 'product_id');
    }
    /*  filters */

}
