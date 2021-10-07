<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InvoiceExport implements FromCollection, WithHeadings
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
            "LineNum" ,
            "ItemCode" ,
            "Description" ,
            "Quantity" ,
            "Price" ,
            "Currency" ,
            "DiscPrcnt" ,
            "WhsCode" ,
            "UseBaseUn" ,
            "VatGroup" ,
            "UnitMsr" ,
            "NumPerMsr" ,
            "LineTotal" ,
            "CogsAcct" ,
            "OcrCode2" ,

        ];
    }
}
