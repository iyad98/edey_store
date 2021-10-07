<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compare extends Model
{
    protected $table = 'compare';
    protected $fillable = ['user_id','session_id' ,'product_id'];
}
