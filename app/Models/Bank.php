<?php

namespace App\Models;

use App\Filters\CategoryFilter;
use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bank extends Model
{
    use SoftDeletes , LanguageTrait;

    protected $table = 'banks';
    protected $fillable = ['image','name_en' , 'name_ar','account_number' ,'iban' ];

    protected $appends = ['name' , ];
    protected $filters = [];

    public function getNameAttribute() {
        return $this->getName($this);
    }

    public function getImageAttribute($value) {
        return add_full_path($value , 'banks');
    }
    /*  scopes   */

    public function scopeActive($query) {
        $query->where('status' , '=' , 1);
    }

    /* relations  */



    /*  filters */

}
