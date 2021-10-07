<?php

namespace App\Models;

use App\Filters\CategoryFilter;
use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use DB;

class CouponChecked extends Model
{

    protected $table = 'coupon_checked';
    protected $fillable = ['coupon_id'];


    public function scopeDateRange($query, $get_date_filter)
    {

        if ($get_date_filter['date_from'] != -1 && $get_date_filter['date_to'] != -1) {
            $query->where(DB::raw('date(coupon_checked.created_at)'), '>=', $get_date_filter['date_from'])
                ->where(DB::raw('date(coupon_checked.created_at)'), '<=', $get_date_filter['date_to']);
        }
    }
}
