<?php

namespace App\Models;

use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use LanguageTrait;

    protected $table = 'galleries';
    protected $fillable = ['src' , 'type_id' , 'name_ar' , 'name_en' ,'size' ,'mime_type' ,'num_used'];
    public $appends = ['name'];

    public function getSrcAttribute($value) {
        return getImage('' , true , $value);
    }

    public function getNameAttribute() {
        return $this->getName($this);
    }

    // scope
    public function scopeSearch($query , $search){
        $query->where(function ($query1) use($search){
            $query1->where('name_ar' , 'LIKE' , "%$search%")->orWhere('name_en' , 'LIKE' , "%$search%");
        });
    }
    public function scopeType($query , $type_id) {
        if(!is_null($type_id) && !empty($type_id) && $type_id != -1) {
            $query->where('type_id' , '=' , $type_id);
        }
    }
}
