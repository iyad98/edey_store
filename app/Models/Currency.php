<?php

namespace App\Models;

use App\Filters\CategoryFilter;
use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model
{
    use  LanguageTrait;

    protected $table = 'currencies';
    protected $fillable = ['name_ar','name_en' , 'symbol_ar', 'symbol_en' , 'code' , 'statys' ];

    protected $appends = ['name' ,'symbol' ];
    protected $filters = [];

    public function getNameAttribute() {
        return $this->getName($this);
    }
    public function getSymbolAttribute() {
        return $this->getSymbol($this);
    }


    /*  scopes   */

    public function scopeActive($query) {
        $query->where('status' , '=' , 1);
    }

    /* relations  */



    /*  filters */

}
