<?php

namespace App\Models;

use App\Filters\CategoryFilter;
use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// models
use App\Models\Product;
use App\User;

class Comment extends Model
{
    use SoftDeletes, LanguageTrait;

    protected $table = 'comments';
    protected $fillable = [
        'user_id', 'product_id', 'comment' ,'status'
    ];


    public function product() {
        return $this->belongsTo(Product::class , 'product_id');
    }
    public function user() {
        return $this->belongsTo(User::class , 'user_id')->withTrashed();
    }

    public function scopeGetGeneralData($query) {
        $query->with(['user' , 'product'])->Approve();
    }

    // scopes
    public function scopePending($query) {
        $query->where('comments.status' , '=' , 0);
    }
    public function scopeApprove($query) {
        $query->where('comments.status' , '=' , 1);
    }
    public function scopeDisApprove($query) {
        $query->where('comments.status' , '=' , 2);
    }
}
