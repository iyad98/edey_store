<?php

namespace App\Models;

use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
    use SoftDeletes, LanguageTrait;

    protected $table = 'areas';
    protected $guarded = [''];

    /*  scopes   */

    public function scopeActive($query)
    {
        $query->where('status', '=', 1);
    }
}
