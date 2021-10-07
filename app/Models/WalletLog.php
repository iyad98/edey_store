<?php

namespace App\Models;

use App\Filters\CategoryFilter;
use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WalletLog extends Model
{

    protected $table = 'wallet_logs';
    protected $fillable = ['user_id','order_id' , 'type' ,'points','pricepoints'  ];

    /* relations  */



    /*  filters */

}
