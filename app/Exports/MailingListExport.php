<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MailingListExport implements FromCollection , WithHeadings
{
    public $mailing_list;
    public function __construct($mailing_list)
    {
        $this->mailing_list = $mailing_list;
    }

    public function collection()
    {
        return $this->mailing_list;
    }

    public function headings() : array
    {
        return [
            'المعرف',

            'الايميل',
            ' تاريخ التسجيل',

        ];
    }
}
