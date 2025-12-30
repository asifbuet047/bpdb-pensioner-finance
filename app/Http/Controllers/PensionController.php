<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\Officer;
use App\Models\Pensioner;
use Illuminate\Http\Request;

class PensionController extends Controller
{
    public function showGeneratePensionSection(Request $request)
    {
        $erp_id = $request->cookie('user_id');
        $officer = Officer::with(['role', 'designation', 'office'])->where('erp_id', '=', $erp_id)->first();
        if ($officer) {
            $officer_role = $officer->role->role_name;
            $officer_name = $officer->name;
            $officer_office = $officer->office->name_in_english;
            $officer_designation = $officer->designation->description_english;
            if (($officer_role === 'initiator' || ($officer_role === 'super_admin'))) {
                return view('generatepension', compact('officer_designation', 'officer_role', 'officer_name', 'officer_office'));
            } else {
                return view('accessdeniedpage', compact('officer_designation', 'officer_role', 'officer_name', 'officer_office'));
            }
        } else {
            return view('login');
        }
    }

    public function showGenratePensionPage(Request $request)
    {
        $erp_id = $request->cookie('user_id');
        $month = $request->query('month');
        $year  = $request->query('year');
        $onlybonus = $request->boolean('onlybonus');

        $festivalbonuses = [
            'muslim_bonus' => $request->boolean('muslim_bonus'),
            'hindu_bonus' => $request->boolean('hindu_bonus'),
            'christian_bonus' => $request->boolean('christian_bonus'),
            'buddhist_bonus' => $request->boolean('buddhist_bonus'),
        ];
        $banglanewyearbonus = $request->boolean('bangla_new_year_bonus');

        $officer = Officer::with(['role', 'designation', 'office'])->where('erp_id', '=', $erp_id)->first();
        if ($officer) {
            $officer_role = $officer->role->role_name;
            $officer_name = $officer->name;
            $officer_office = $officer->office->name_in_english;
            $officer_designation = $officer->designation->description_english;
            switch ($officer_role) {
                case 'initiator':
                    $officer_office_code = $officer->office->office_code;
                    $office_ids = Office::where('payment_office_code', $officer_office_code)->pluck('id');
                    $pensioners = Pensioner::whereIn('office_id', $office_ids)->where('status', 'approved')->orderBy('id')->get();

                    $sumOfNetpension = $pensioners->sum(fn($pensioner) => $pensioner->net_pension);
                    $sumOfMedicalAllowance = $pensioners->sum(fn($pensioner) => $pensioner->medical_allowance);
                    $sumOfSpecialbenifit = $pensioners->sum(fn($pensioner) => $pensioner->special_benifit);

                    $religionBonusMap = [
                        'Islam' => $festivalbonuses['muslim_bonus']    ?? false,
                        'Hinduism' => $festivalbonuses['hindu_bonus']     ?? false,
                        'Christianity' => $festivalbonuses['christian_bonus'] ?? false,
                        'Buddhism' => $festivalbonuses['buddhist_bonus']  ?? false,
                    ];

                    $sumOfFestivalbonus = $pensioners->sum(function ($pensioner) use ($religionBonusMap) {
                        if ($religionBonusMap[$pensioner->religion] ?? false) {
                            return $pensioner->festival_bonus;
                        }
                        return 0;
                    });
                    $sumOfbanglaNewYearBonus = $banglanewyearbonus ? $pensioners->sum(fn($pensioner) => $pensioner->bangla_new_year_bonus) : 0.0;
                    return view('viewgeneratedpension', compact('pensioners', 'month', 'year', 'festivalbonuses', 'sumOfNetpension', 'sumOfSpecialbenifit', 'sumOfMedicalAllowance', 'sumOfFestivalbonus', 'sumOfbanglaNewYearBonus', 'banglanewyearbonus', 'onlybonus', 'officer_name', 'officer_office', 'officer_designation', 'officer_role'));
                    break;
                default:
                    return view('login');
                    break;
            }
        } else {
            return view('login');
        }
    }

    
}
