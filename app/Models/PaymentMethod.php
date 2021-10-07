<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LanguageTrait;

use App\Models\Country;

class PaymentMethod extends Model
{
    use LanguageTrait;

    protected $table = 'payment_methods';
    protected $fillable = ['image','name_en' , 'name_ar' ,'status','note_ar' , 'note_en' , 'text_en' , 'text_ar'];

    public $appends = ['name' , 'text' , 'note'];

    public function getNameAttribute() {
        return $this->getName($this);
    }
    public function getTextAttribute() {
        return $this->getText($this);
    }
    public function getNoteAttribute() {
        return $this->getNote($this);
    }
    public function getImageAttribute($value) {
        return add_full_path($value , 'payments');
    }

    /*  scopes */
    public function scopeActive($query) {
        return $query->where('status' , '=' , 1);
    }
    public function scopeInCountry($query , $country_id) {
        $query->whereHas('countries' , function ($query2) use($country_id){
            $query2->where('countries.id' , '=' , $country_id);
        });
    }
    /* relations */
    public function countries() {
        return $this->belongsToMany(Country::class , 'country_payment_methods'  , 'payment_method_id' , 'country_id');

    }
}
