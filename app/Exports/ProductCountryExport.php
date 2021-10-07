<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Product;

class ProductCountryExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public $product;
    public function __construct($product)
    {
        $this->product = $product;
    }
    public function collection()
    {

        return $this->product;
    }

    public function headings(): array
    {
        return [
            "رقم المنتج"
        ];
    }
}
