<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrderExport implements FromCollection
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

    public function headings() : array
    {
        return [
            'رقم الطلب',
            'طريقة الدفغ',
            'السعر',
            'AAA',
        ];
    }
}
