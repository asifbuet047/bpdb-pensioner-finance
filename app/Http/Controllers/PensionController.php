<?php

namespace App\Http\Controllers;

use App\Exports\PensionDashboardExport;
use App\Models\Bank;
use App\Models\Office;
use App\Models\Officer;
use App\Models\PaymentOfficesBank;
use App\Models\Pension;
use App\Models\Pensioner;
use App\Models\Pensionerspension;
use App\Models\Pensionworkflow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
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
        $months = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December',
        ];
        $erp_id = $request->cookie('user_id');
        $month = $months[$request->integer('month')];
        $erp_id = $request->cookie('user_id');
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
        $month = $request->input('month');
        $year  = $request->input('year');
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
                $sumOfSpecialAllowance = $onlybonus ? 0 : (int)round($pensioners->sum(fn($pensioner) => $pensioner->special_allowance));

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
                $officerId = $officer->id;

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

                        Pensionerspension::create([
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
                    return response()->json([
                        'success' => true,
                        'message' => 'Pension id is generated ' . $pensionId . ' and pensioners pension id is generated',
                        'data' => $pension
                    ], 200);
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
        $pension_type = $request->query('type');
        $action_buttons = $request->boolean('action', true);
        $print_button = $request->boolean('print', false);
        $officer = Officer::with(['role', 'designation', 'office'])->where('erp_id', '=', $erp_id)->first();
        if ($officer) {
            $officer_role = $officer->role->role_name;
            $officer_name = $officer->name;
            $officer_office = $officer->office->name_in_english;
            $officer_designation = $officer->designation->description_english;
            if ($pension_type) {
                $pensions = Pension::where('office_id', $officer->office->id)->where('status', $pension_type)->get();
                return view('viewpension', compact('print_button', 'pensions', 'officer_designation', 'action_buttons', 'officer_role', 'officer_name', 'officer_office'));
            }

            $pensions = Pension::where('office_id', $officer->office->id)->get();
            return view('viewpension', compact('print_button', 'pensions', 'officer_designation', 'action_buttons', 'officer_role', 'officer_name', 'officer_office'));
        } else {
            return view('login');
        }
    }


    public function deletePensionFromDB(Request $request, $id)
    {
        $erp_id = $request->cookie('user_id');
        if (!$erp_id) {
            return response()->json(['status' => false, 'message' => 'please login', 'data' => []], 401);
        }
        $officer = Officer::with('role')
            ->where('erp_id', $erp_id)
            ->first();
        if (!$officer) {
            return response()->json(['status' => false, 'message' => 'no valid officer', 'data' => []], 402);
        }
        if ($officer->role->role_name !== 'initiator') {
            return response()->json(['status' => false, 'message' => 'Forbidden request', 'data' => []], 403);
        }
        $pension = Pension::find($id);
        if (!$pension) {
            return response()->json(['status' => false, 'message' => 'Pension not found', 'data' => []], 404);
        }
        $pension->delete();
        return response()->json([
            'success' => true,
            'message' => 'Pension deleted successfully',
            'data' => $pension
        ], 200);
    }


    public function showPensionsVariantSection(Request $request)
    {
        $erp_id = $request->cookie('user_id');
        $officer = Officer::with(['role', 'designation', 'office'])->where('erp_id', '=', $erp_id)->first();
        if ($officer) {
            $officer_role = $officer->role->role_name;
            $officer_name = $officer->name;
            $officer_office = $officer->office->name_in_english;
            $officer_designation = $officer->designation->description_english;
            $officer_office_code = $officer->office->office_code;
            switch ($officer_role) {
                case 'super_admin':
                    $initiatedPensionsCount = Pension::where('status', 'initiated')->count();
                    $certifiedPensionsCount = Pension::where('status', 'certified')->count();
                    $approvedPensionsCount = Pension::where('status', 'approved')->count();
                    return view('showpensionsvariant', compact('initiatedPensionsCount', 'certifiedPensionsCount', 'approvedPensionsCount', 'officer_name', 'officer_office', 'officer_designation', 'officer_role'));
                    break;
                case 'approver':
                    $certifiedPensionsCount = Pension::where('status', 'certified')->count();
                    $approvedPensionsCount = Pension::where('status', 'approved')->count();
                    return view('showpensionsvariant', compact('certifiedPensionsCount', 'approvedPensionsCount', 'officer_name', 'officer_office', 'officer_designation', 'officer_role'));
                    break;
                case 'certifier':
                    $initiatedPensionsCount = Pension::where('status', 'initiated')->count();
                    $approvedPensionsCount = Pension::where('status', 'approved')->count();
                    return view('showpensionsvariant', compact('initiatedPensionsCount', 'approvedPensionsCount', 'officer_name', 'officer_office', 'officer_designation', 'officer_role'));
                    break;
                case 'initiator':
                    $floatedPensionsCount = Pension::where('status', 'floated')->count();
                    $approvedPensionsCount = Pension::where('status', 'approved')->count();
                    return view('showpensionsvariant', compact('floatedPensionsCount', 'approvedPensionsCount', 'officer_name', 'officer_office', 'officer_designation', 'officer_role'));
                    break;

                default:

                    break;
            }
        } else {
            return view('login');
        }
        if ($request->hasCookie('user_id')) {
        } else {
            return view('login');
        }
    }


    public function isPensionExits(Request $request)
    {
        $erp_id = $request->cookie('user_id');
        $id = $request->query('id');
        $officer = Officer::with(['role', 'designation', 'office'])->where('erp_id', '=', $erp_id)->first();
        $pension = Pension::find($id);

        if (!$erp_id) {
            return response()->json([
                'success' => false,
                'message' => 'Pleae login as valid officer',
                'data' => []
            ], 401);
        }

        if (!$officer) {
            return response()->json([
                'success' => false,
                'message' => 'No valid officer',
                'data' => []
            ], 402);
        }

        if (!$pension) {
            return response()->json([
                'success' => false,
                'message' => 'No valid pension',
                'data' => []
            ], 403);
        }

        if ($pension->office_id != $officer->office->id) {
            return response()->json([
                'success' => false,
                'message' => 'You dont have permission',
                'data' => []
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Pension is successfully retrived',
            'data' => $pension
        ], 200);
    }


    public function isPensionApproved(Request $request)
    {
        $erp_id = $request->cookie('user_id');
        $id = $request->query('id');
        $officer = Officer::with(['role', 'designation', 'office'])->where('erp_id', '=', $erp_id)->first();
        $pension = Pension::find($id);

        if (!$erp_id) {
            return response()->json([
                'success' => false,
                'message' => 'Pleae login as valid officer',
                'data' => []
            ], 401);
        }

        if (!$officer) {
            return response()->json([
                'success' => false,
                'message' => 'No valid officer',
                'data' => []
            ], 402);
        }

        if (!$pension) {
            return response()->json([
                'success' => false,
                'message' => 'No valid pension',
                'data' => []
            ], 403);
        }

        if ($pension->status != 'approved') {
            return response()->json([
                'success' => false,
                'message' => 'Pension is not approved',
                'data' => []
            ], 404);
        }

        if ($pension->office_id != $officer->office->id) {
            return response()->json([
                'success' => false,
                'message' => 'You dont have permission',
                'data' => []
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Pension is successfully approved',
            'data' => $pension
        ], 200);
    }

    public function showPensionDashboard(Request $request, $id)
    {
        $erp_id = $request->cookie('user_id');
        $officer = Officer::with(['role', 'designation', 'office'])->where('erp_id', '=', $erp_id)->first();
        if ($officer) {
            $officer_role = $officer->role->role_name;
            $officer_name = $officer->name;
            $officer_office = $officer->office->name_in_english;
            $officer_designation = $officer->designation->description_english;
            $officer_office_code = $officer->office->office_code;
            $pension = Pension::find($id);
            $pensionerspensions = Pensionerspension::with(['pensioner'])->where('pension_id', $id)->get();
            return view('viewpensiondashboard', compact('pension', 'id', 'pensionerspensions', 'officer_name', 'officer_office', 'officer_designation', 'officer_role'));
        } else {
            return view('login');
        }
    }


    public function exportPensionDashboard(Request $request)
    {
        $id = $request->query('id');
        return Excel::download(new PensionDashboardExport($id), 'pension.xlsx');
    }


    public function generateInvoice(Request $request)
    {
        $erp_id = $request->cookie('user_id');
        $pensionid = $request->query('id');
        $officer = Officer::with(['role', 'designation', 'office'])->where('erp_id', '=', $erp_id)->first();
        $paymentOfficeBank = PaymentOfficesBank::with(['office'])->where('office_id', $officer->office->id)->first();
        $bank_details = Bank::where('routing_number', $paymentOfficeBank->routing_number)->first();
        if ($officer) {
            $pension = Pension::find($pensionid);
            $totalPension = $pension->totalPensionAmount();
            $pensionerspension_info = [];
            if ($pension) {
                $pensionerspensions = Pensionerspension::with(['pensioner'])->where('pension_id', $pension->id)->get();
                $pdf = PDF::loadView('viewpensionersinvoice', compact('totalPension', 'pensionerspensions', 'officer', 'bank_details', 'paymentOfficeBank'))
                    ->setPaper('a4')->setOption('encoding', 'utf-8');
                return $pdf->inline('invoice.pdf');
            } else {
                return view('login');
            }
        } else {
            return view('login');
        }
    }
}
