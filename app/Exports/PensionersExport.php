<?php

namespace App\Exports;

use App\Models\Pensioner;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PensionersExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $pensioners = Pensioner::select(['name', 'erp_id', 'basic_salary', 'medical_allowance', 'incentive_bonus', 'register_no', 'bank_name', 'account_number'])->get();

        $refinedPensioners = $pensioners->map(function ($pensioner, $key) {
            return [
                'NO' => $key + 1,
                'NAME' => $pensioner->name,
                'ERP_ID' => $pensioner->erp_id,
                'BASIC_SALARY' => $pensioner->basic_salary,
                'MEDICAL_ALLOWANCE' => $pensioner->medical_allowance,
                'INCENTIVE_BONUS' => $pensioner->incentive_bonus,
                'REGISTER_NO' => $pensioner->register_no,
                'BANK_NAME' => $pensioner->bank_name,
                'ACCOUNT_NUMBER' => $pensioner->account_number,
            ];
        });

        return new Collection($refinedPensioners);
    }

    public function headings(): array
    {
        return ['NO', 'NAME', 'ERP_ID', 'BASIC_SALARY', 'MEDICAL_ALLOWANCE', 'INCENTIVE_BONUS', 'REGISTER_NO', 'BANK_NAME', 'ACCOUNT_NUMBER'];
    }
}
