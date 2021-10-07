<?php

namespace App\Models;

use App\Filters\CategoryFilter;
use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

//models
use App\Models\Attribute;
use App\Models\ProductAttribute;


class AttributeValue extends Model
{
    use SoftDeletes , LanguageTrait;

    protected $table = 'attribute_values';
    protected $fillable = ['id','name_en' , 'name_ar' , 'value' , 'attribute_id' ];

    protected $appends = ['name'];
    protected $filters = [];

    public function getNameAttribute() {
        return $this->getName($this);
    }

    /*  scopes   */



    /* relations  */
    public function attribute() {
        return $this->belongsTo( Attribute::class, 'attribute_id');
    }

    public function product_attributes()
    {
        return $this->belongsToMany(ProductAttribute::class, 'product_attribute_values', 'attribute_value_id' , 'product_attribute_id');
    }
    /*  filters */

}
