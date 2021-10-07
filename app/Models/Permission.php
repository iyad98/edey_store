<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LanguageTrait;

class Permission extends Model
{
    use LanguageTrait;

    protected $table = 'permissions';
    protected $fillable = [
        'name_ar', 'name_en', 'key' , 'parent_ar','parent_en' , 'status' , 'order',
    ];

    protected $appends = ['name'];
    public function getNameAttribute()
    {
        return $this->getName($this);
    }

    public function scopeActive($query) {
        $query->where('status' ,'=' , 1);
    }

}