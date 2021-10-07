<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class ProductExport implements FromCollection , WithHeadings , WithStrictNullComparison
{


    public $products;

    public function __construct($products)
    {

        $this->products = $products;
    }

    public function collection()
    {
        return $this->products;
    }



    public function headings(): array
    {
        return [
            'المعرف',
            'sku',
            'صوره المنتج',
            'الاسم ',
            'الوصف ',
            'التصنيفات',
            'امكانيه الاسترجاع',
            'امكانيه الاهداء',
            'رقم المنتج',
            'السعر ',
            'سعر العرض',

            'العملة',
            'اقل كميه',
            'اكثر كمية',

            'كمية المخزون',
            'السمات',
            'رقم السمة',
            'الصور',

        ];
    }


}
