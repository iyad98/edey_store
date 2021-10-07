<?php

namespace App\Models;

use App\Filters\CategoryFilter;
use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockStatus extends Model
{
    use LanguageTrait;

    protected $table = 'stock_status';
    protected $fillable = ['key','name_en' , 'name_ar'];

    protected $appends = ['name' ];
    protected $filters = [];

    public function getNameAttribute() {
        return $this->getName($this);
    }


    /*  scopes   */
    public function scopeActive($query) {
        $query->where('status' , '=' , 1);
    }


    /* relations  */



    /*  filters */

}
