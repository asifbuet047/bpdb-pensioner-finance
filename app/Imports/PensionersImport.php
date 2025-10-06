<?php

namespace App\Imports;

use App\Models\Pensioner;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PensionersImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Pensioner([
            'name' => $row['name'],
            'basic_salary' => $row['basic_salary'],
            'erp_id' => $row['erp_id'],
            'medical_allowance' => $row['medical_allowance'],
            'incentive_bonus' => $row['incentive_bonus'],
            'register_no' => $row['register_no'],
            'bank_name' => $row['bank_name'],
            'account_number' => $row['account_number'],
            'office_id' => $row['office_id'],
            'designation' => $row['designation']
        ]);
    }
}
