<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LanguageTrait;

class Setting extends Model
{
    use  LanguageTrait;

    protected $table = 'settings';
    protected $fillable = ['key','name_en' , 'name_ar' , 'value_en' , 'value_ar' , 'status'];

    protected $appends = ['name' , 'value'];

    public function getNameAttribute() {
        return $this->getName($this);
    }

    public function getValueAttribute() {
        return $this->getValue($this);
    }


}
