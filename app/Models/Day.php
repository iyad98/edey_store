<?php

namespace App\Models;

use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Day extends Model
{
    use LanguageTrait;

    protected $table = 'days';
    protected $fillable = ['name_en','name_ar' ];

    public function getNameAttribute() {
        return $this->getName($this);
    }
}
