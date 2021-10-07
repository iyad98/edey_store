<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Invoice2Export implements FromCollection, WithHeadings
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
            "DocNum" ,
            "DocEntry" ,
            "DocType" ,
            "Handwrtten" ,
            "DocDate" ,
            "DocDueDate" ,
            "CardCode" ,
            "DocTotal" ,
            "DocCur" ,
            "Ref1" ,
            "Ref2" ,
            "Comments" ,
            "JrnlMemo" ,
            "SlpCode" ,
            "DiscPrcnt" ,
        ];
    }
}
