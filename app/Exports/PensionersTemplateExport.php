<?php

namespace App\Exports;

use App\Models\Pensioner;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PensionersTemplateExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return new Collection([]);
    }

    public function headings(): array
    {
        return ['NO', 'NAME', 'ERP_ID', 'BASIC_SALARY', 'MEDICAL_ALLOWANCE', 'INCENTIVE_BONUS', 'REGISTER_NO', 'BANK_NAME', 'ACCOUNT_NUMBER'];
    }
}
