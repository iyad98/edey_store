<?php

namespace App\Models;

use App\Filters\CategoryFilter;
use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use SoftDeletes , LanguageTrait;

    protected $table = 'branches';
    protected $fillable = ['name_en' , 'name_ar' , 'city_id','phone' ,'lat' , 'lng' ];

    protected $appends = ['name'];
    protected $filters = [];

    public function getNameAttribute() {
        return $this->getName($this);
    }
    
    /*  scopes   */



    /* relations  */



    /*  filters */

}
