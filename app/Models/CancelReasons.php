<?php

namespace App\Models;

use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CancelReasons extends Model
{
    use SoftDeletes , LanguageTrait;

    protected $table = 'cancel_reasons';
    protected $fillable = ['title_en' , 'title_ar'];

    protected $appends = ['title'  ];
    protected $filters = [];

    public function getTitleAttribute() {
        return $this->getTitle($this);
    }
}
