<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserPointsExport implements FromCollection , WithHeadings
{
    public $users;
    public function __construct($users)
    {
        $this->users = $users;
    }

    public function collection()
    {
        return $this->users;
    }

    public function headings() : array
    {
        return [
            'المعرف',
            'الاسم',
            'رقم الهاتف',

            'عدد النقاط',

        ];
    }
}
