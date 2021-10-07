<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CouponExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public $coupons;

    public function __construct($coupons)
    {
        $this->coupons = $coupons;
    }

    public function collection()
    {
        return $this->coupons;
    }

    public function headings(): array
    {
        return [
            trans('admin.coupon_code'),
            trans('admin.discount_rate'),
            trans('admin.user_famous_rate'),
            trans('admin.total_orders'),
            trans('admin.coupon_checked_count'),
            trans('admin.total_discounts'),
            trans('admin.pending_orders'),
            trans('admin.pending_orders_price'),
            trans('admin.confirm_orders'),
            trans('admin.confirm_orders_price'),
            trans('admin.user_famous_total_price')
        ];
    }
}
