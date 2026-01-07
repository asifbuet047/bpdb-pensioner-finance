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
            // Basic Identity
            'name' => $row['name'] ?? null,
            'name_bangla' => $row['name_bangla'] ?? null,
            'register_no' => $row['register_no'] ?? null,

            // Office & Designation
            'designation' => $row['designation'] ?? null,
            'office_id' => $row['office_id'] ?? null,
            'office' => $row['office'] ?? null,

            // Dates
            'birth_date' => $row['birth_date'] ?? null,
            'joining_date' => $row['joining_date'] ?? null,
            'prl_start_date' => $row['prl_start_date'] ?? null,
            'prl_end_date' => $row['prl_end_date'] ?? null,
            'service_life' => $row['service_life'] ?? null,

            // Contact
            'phone_number' => $row['phone_number'] ?? null,
            'email' => $row['email'] ?? null,
            'nid' => $row['nid'] ?? null,

            // Financial
            'last_basic_salary' => $row['basic_salary'] ?? $row['last_basic_salary'] ?? 0,
            'medical_allowance' => $row['medical_allowance'] ?? 0,
            'incentive_bonus' => $row['incentive_bonus'] ?? 0,

            // Bank Information
            'bank_name' => $row['bank_name'] ?? null,
            'bank_branch_name' => $row['bank_branch_name'] ?? null,
            'bank_routing_number' => $row['bank_routing_number'] ?? null,
            'account_number'   => $row['account_number'] ?? null,

            // Family Information
            'father_name' => $row['father_name'] ?? null,
            'mother_name' => $row['mother_name'] ?? null,
            'spouse_name' => $row['spouse_name'] ?? null,
            'religion'    => $row['religion'] ?? null,

            // Pension Flags
            'is_self_pension' => $row['is_self_pension'] ?? null,

            // PPO
            'pension_payment_order' => $row['pension_payment_order'] ?? null,

            'status' => 'floated',
            'verified' => false,
            'biometric_verified' => false,
            'biometric_verification_type' => 'fingerprint',

        ]);
    }
}
