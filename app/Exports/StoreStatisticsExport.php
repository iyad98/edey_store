<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StoreStatisticsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public $orders;

    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    public function collection()
    {
        return $this->orders;
    }

    public function headings(): array
    {
        return [
            trans('admin.bill_date'),
            trans('admin.user_name'),
            trans('admin.phone'),
            trans('admin.bill_number'),
            trans('admin.shipping_policy'),
            trans('admin.products_count'),
            trans('admin.order_price_before_discount'),
            trans('admin.total_discount_coupon'),
            trans('admin.price_after_discount_coupon_'),
            trans('admin.shipping'),
            trans('admin.tax'),
            trans('admin.receiving_fees'),
            trans('admin.total_price'),
            trans('admin.shipping_type'),
            trans('admin.shipping_date'),
            trans('admin.payment'),

        ];
    }
}
