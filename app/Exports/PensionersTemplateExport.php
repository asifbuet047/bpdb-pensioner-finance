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
        return [
            'NO',

            // Identity
            'NAME',
            'NAME_BANGLA',
            'ERP_ID',
            'REGISTER_NO',

            // Office & Designation
            'DESIGNATION',
            'OFFICE_ID',
            'OFFICE',

            // Dates
            'BIRTH_DATE',
            'JOINING_DATE',
            'PRL_START_DATE',
            'PRL_END_DATE',
            'SERVICE_LIFE',

            // Contact
            'PHONE_NUMBER',
            'EMAIL',
            'NID',

            // Financial
            'BASIC_SALARY',
            'MEDICAL_ALLOWANCE',
            'INCENTIVE_BONUS',

            // Bank
            'BANK_NAME',
            'BANK_BRANCH_NAME',
            'BANK_ROUTING_NUMBER',
            'ACCOUNT_NUMBER',

            // Family
            'FATHER_NAME',
            'MOTHER_NAME',
            'SPOUSE_NAME',
            'RELIGION',

            // Pension Flags
            'IS_SELF_PENSION',
            // 'STATUS',
            // 'VERIFIED',
            // 'BIOMETRIC_VERIFIED',
            // 'BIOMETRIC_VERIFICATION_TYPE',

            // PPO
            'PENSION_PAYMENT_ORDER',
        ];
    }
}
