<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\Officer;
use App\Models\Pension;
use App\Models\Pensioner;
use App\Models\Pensionerspension;
use App\Models\Pensionworkflow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

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
        $month = $request->integer('month');
        $year  = $request->integer('year');
        $onlybonus = $request->boolean('onlybonus');

        $festivalbonuses = [
            'muslim_bonus' => $request->boolean('muslim_bonus'),
            'hindu_bonus' => $request->boolean('hindu_bonus'),
            'christian_bonus' => $request->boolean('christian_bonus'),
            'buddhist_bonus' => $request->boolean('buddhist_bonus'),
        ];
        $banglanewyearbonus = $request->boolean('bangla_new_year_bonus');

        $officer = Officer::with(['role', 'designation', 'office'])->where('erp_id', '=', $erp_id)->first();
        $officer_id = $officer->id;
        if ($officer) {
            $officer_role = $officer->role->role_name;
            $officer_name = $officer->name;
            $officer_office = $officer->office->name_in_english;
            $officer_designation = $officer->designation->description_english;

            $officer_office_code = $officer->office->office_code;
            $office_ids = Office::where('payment_office_code', $officer_office_code)->pluck('id');

            $pensioners = Pensioner::whereIn('office_id', $office_ids)->where('status', 'approved')->orderBy('id')->get();

            $religionBonusMap = [
                'Islam' => $festivalbonuses['muslim_bonus'] ?? false,
                'Hinduism' => $festivalbonuses['hindu_bonus'] ?? false,
                'Christianity' => $festivalbonuses['christian_bonus'] ?? false,
                'Buddhism' => $festivalbonuses['buddhist_bonus'] ?? false,
            ];

            $sumOfNetpension = $pensioners->sum(fn($pensioner) => $pensioner->net_pension);
            $sumOfMedicalAllowance = $pensioners->sum(fn($pensioner) => $pensioner->medical_allowance);
            $sumOfSpecialAllowance = $pensioners->sum(fn($pensioner) => $pensioner->special_allowance);
            $sumOfFestivalbonus = $pensioners->sum(function ($pensioner) use ($religionBonusMap) {
                if ($religionBonusMap[$pensioner->religion] ?? false) {
                    return $pensioner->festival_bonus;
                }
                return 0;
            });
            $sumOfbanglaNewYearBonus = $banglanewyearbonus ? $pensioners->sum(fn($pensioner) => $pensioner->bangla_new_year_bonus) : 0.0;
            $numberOfpensioners = $pensioners->count();
            $officerOfficeId = $officer->office->id;

            $pensionData = [
                'month' => $month,
                'year' => $year,
                'onlybonus' => $onlybonus,
                'banglanewyearbonus' => $banglanewyearbonus,
                'muslim_bonus' => $festivalbonuses['muslim_bonus'],
                'hindu_bonus' => $festivalbonuses['hindu_bonus'],
                'christian_bonus' => $festivalbonuses['christian_bonus'],
                'buddhist_bonus' => $festivalbonuses['buddhist_bonus'],
            ];
            return view('viewgeneratedpension', compact('pensionData', 'pensioners', 'month', 'year', 'festivalbonuses', 'sumOfNetpension', 'sumOfSpecialAllowance', 'sumOfMedicalAllowance', 'sumOfFestivalbonus', 'sumOfbanglaNewYearBonus', 'banglanewyearbonus', 'onlybonus', 'officer_name', 'officer_office', 'officer_designation', 'officer_role', 'officer_id'));
        } else {
            return view('login');
        }
    }

    public function calculatePensionAndInitiateWorkflow(Request $request)
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
        $religionBonusMap = [
            'Islam' => $festivalbonuses['muslim_bonus'] ?? false,
            'Hinduism' => $festivalbonuses['hindu_bonus'] ?? false,
            'Christianity' => $festivalbonuses['christian_bonus'] ?? false,
            'Buddhism' => $festivalbonuses['buddhist_bonus'] ?? false,
        ];
        $banglanewyearbonus = $request->boolean('bangla_new_year_bonus');


        $officer = Officer::with(['role', 'designation', 'office'])->where('erp_id', '=', $erp_id)->first();
        if ($officer) {
            $officer_role = $officer->role->role_name;
            $officer_name = $officer->name;
            $officer_office = $officer->office->name_in_english;
            $officer_designation = $officer->designation->description_english;
            if ($officer_role === 'initiator') {
                $officer_office_code = $officer->office->office_code;
                $office_ids = Office::where('payment_office_code', $officer_office_code)->pluck('id');
                $pensioners = Pensioner::whereIn('office_id', $office_ids)->where('status', 'approved')->orderBy('id')->get();

                $sumOfNetpension = $onlybonus ? 0 : (int)round($pensioners->sum(fn($pensioner) => $pensioner->net_pension));
                $sumOfMedicalAllowance = $onlybonus ? 0 : (int)round($pensioners->sum(fn($pensioner) => $pensioner->medical_allowance));
                $sumOfSpecialAllowance = $onlybonus ? 0 : (int)round($pensioners->sum(fn($pensioner) => $pensioner->special_benifit));

                $sumOfFestivalbonus = $pensioners->sum(function ($pensioner) use ($religionBonusMap) {
                    if ($religionBonusMap[$pensioner->religion] ?? false) {
                        return (int)round($pensioner->festival_bonus);
                    }
                    return 0;
                });
                $sumOfbanglaNewYearBonus = $banglanewyearbonus ? (int)round($pensioners->sum(fn($pensioner) => $pensioner->bangla_new_year_bonus)) : 0;
                $sumOfAllSums = $sumOfNetpension + $sumOfMedicalAllowance + $sumOfSpecialAllowance + $sumOfFestivalbonus + $sumOfbanglaNewYearBonus;

                $numberOfpensioners = $pensioners->count();
                $officerOfficeId = $officer->office->id;

                DB::beginTransaction();
                try {
                    $pension = Pension::create([
                        'office_id' => $officerOfficeId,
                        'month' => $month,
                        'year' => $year,
                        'sum_of_net_pension' => $sumOfNetpension,
                        'sum_of_medical_allowance' => $sumOfMedicalAllowance,
                        'sum_of_special_allowance' => $sumOfSpecialAllowance,
                        'sum_of_festival_bonus' => $sumOfFestivalbonus,
                        'sum_of_bangla_new_year_bonus' => $sumOfbanglaNewYearBonus,
                        'number_of_pensioners' => $numberOfpensioners,
                        'status' => 'floated'
                    ]);
                    $pensionId = $pension->id;

                    foreach ($pensioners as $pensioner) {
                        $pension_id = $pensionId;
                        $pensioner_id = $pensioner->id;
                        $net_pension = $onlybonus ? 0 : $pensioner->net_pension;
                        $medical_allowance = $onlybonus ? 0 : $pensioner->medical_allowance;
                        $special_allowance = $onlybonus ? 0 : $pensioner->special_allowance;
                        $festival_bonus = $religionBonusMap[$pensioner->religion] ? $pensioner->festival_bonus : 0;
                        $bangla_new_year_bonus = $banglanewyearbonus ? $pensioner->bangla_new_year_bonus : 0;
                        $is_block = false;
                        $message = null;

                        $eachPensionerspension = Pensionerspension::create([
                            'pension_id' => $pension_id,
                            'pensioner_id' => $pensioner_id,
                            'net_pension' => $net_pension,
                            'medical_allowance' => $medical_allowance,
                            'special_allowance' => $special_allowance,
                            'festival_bonus' => $festival_bonus,
                            'bangla_new_year_bonus' => $bangla_new_year_bonus,
                            'is_block' => false,
                            'message' => $message
                        ]);
                    }
                    DB::commit();
                    return view('viewpension', compact('pensioners', 'month', 'year', 'festivalbonuses', 'sumOfNetpension', 'sumOfSpecialAllowance', 'sumOfMedicalAllowance', 'sumOfFestivalbonus', 'sumOfbanglaNewYearBonus', 'banglanewyearbonus', 'onlybonus', 'officer_name', 'officer_office', 'officer_designation', 'officer_role', 'officer_id'));
                } catch (Throwable $e) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => $e->getMessage(),
                        'data' => []
                    ], 403);
                }
            } else {
                return view('accessdeniedpage', compact('officer_designation', 'officer_role', 'officer_name', 'officer_office'));
            }
        } else {
            return view('login');
        }
    }

    public function showAllGeneratedPensions(Request $request)
    {
        $erp_id = $request->cookie('user_id');
        $officer = Officer::with(['role', 'designation', 'office'])->where('erp_id', '=', $erp_id)->first();
        if ($officer) {
            $officer_role = $officer->role->role_name;
            $officer_name = $officer->name;
            $officer_office = $officer->office->name_in_english;
            $officer_designation = $officer->designation->description_english;
            if ($officer_role === 'initiator') {
                $pensions = Pension::where('office_id', $officer->office->id)->get();
                return view('viewpension', compact('pensions', 'officer_designation', 'officer_role', 'officer_name', 'officer_office'));
            } else {
                return view('accessdeniedpage', compact('officer_designation', 'officer_role', 'officer_name', 'officer_office'));
            }
        } else {
            return view('login');
        }
    }
}
