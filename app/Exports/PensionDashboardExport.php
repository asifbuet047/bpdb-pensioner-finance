<?php

namespace App\Exports;

use App\Models\Pension;
use App\Models\Pensioner;
use App\Models\Pensionerspension;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PensionDashboardExport implements FromCollection, WithHeadings
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
    public function collection()
    {
        $pension = Pension::find($this->id);
        $pensionerspensions = Pensionerspension::where('pension_id', $pension->id)->with(['pensioner'])->get();
        $exportdata =  $pensionerspensions->map(function ($pensionerspension, $key) {
            return [
                'NO' => $key + 1,
                'ERP ID' => $pensionerspension->pensioner->name,
                'NET PENSION' => $pensionerspension->net_pension,
                'MEDICAL_ALLOWANCE' => $pensionerspension->medical_allowance,
                'SPECIAL_ALLOWANCE' => $pensionerspension->special_allowance,
                'FESTIVAL_BONUS' => $pensionerspension->festival_bonus,
                'BANGLA_NEW_YEAR_BONUS' => $pensionerspension->bangla_new_year_bonus,
                'TOTAL' => $pensionerspension->net_pension + $pensionerspension->medical_allowance + $pensionerspension->special_allowance + $pensionerspension->festival_bonus + $pensionerspension->bangla_new_year_bonus,
            ];
        });

        $exportdata->push([
            'NO' => '',
            'ERP ID' => '',
            'NET PENSION' => $pension->sum_of_net_pension,
            'MEDICAL_ALLOWANCE' => $pension->sum_of_medical_allowance,
            'SPECIAL_ALLOWANCE' => $pension->sum_of_special_allowance,
            'FESTIVAL_BONUS' => $pension->sum_of_festival_bonus,
            'BANGLA_NEW_YEAR_BONUS' => $pension->sum_of_bangla_new_year_bonus,
            'TOTAL' => $pension->totalPensionAmount(),
        ]);
        return new Collection($exportdata);
    }

    public function headings(): array
    {
        return ['NO', 'ERP ID', 'NET PENSION', 'MEDICAL ALLOWANCE', 'SPECIAL ALLOWANCE', 'FESTIVAL BONUS', 'BANGLA NEW YEAR BONUS', 'TOTAL'];
    }
}
