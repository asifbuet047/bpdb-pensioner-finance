<?php

namespace App\Exports;

use App\Models\Officer;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpParser\Node\Stmt\Return_;

class OfficersExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $officers = Officer::with('office')->get();

        $refinedOfficers = $officers->map(function ($officer, $key) {
            return [
                'NO' => $key + 1,
                'NAME' => $officer->name,
                'ERP_ID' => $officer->erp_id,
                'DESIGNATION' => $officer->designation,
                'ROLE' => $officer->role,
                'OFFICE_NAME' => $officer->office ? $officer->office->officeName : '-',
                'OFFICE_NAME_BANGLA' => $officer->office ? $officer->office->officeNameInBangla : '-',
                'OFFICE_CODE' => $officer->office ? $officer->office->officeCode : '-',
            ];
        });

        return new Collection($refinedOfficers);
    }

    public function headings(): array
    {
        return ['NO', 'NAME', 'ERP_ID', 'DESIGNATION', 'ROLE', 'OFFICE_NAME', 'OFFICE_NAME_BANGLA', 'OFFICE_CODE'];
    }
}
