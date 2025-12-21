<?php

namespace App\Http\Controllers;

use App\Exports\PensionersExport;
use App\Exports\PensionersTemplateExport;
use App\Imports\PensionersImport;
use App\Models\Bank;
use App\Models\Designation;
use App\Models\Office;
use App\Models\Officer;
use App\Models\Payscale;
use App\Models\Pensioner;
use App\Models\Role;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class PensionerController extends Controller
{
    public function addPensionerIntoDB(Request $request)
    {
        $erp_id = $request->cookie('user_id');
        $officer = Officer::with(['role', 'designation', 'office'])->where('erp_id', '=', $erp_id)->first();
        if ($officer) {
            $officer_role = $officer->role->role_name;
            $officer_name = $officer->name;
            $officer_office = $officer->office->name_in_english;
            $officer_designation = $officer->designation->description_english;
            if (($officer_role === 'initiator' || ($officer_role === 'super_admin'))) {
                $pensioner_info = $request->validate([
                    'erp_id' => [
                        'required',
                        'integer',
                        'min:1',
                        Rule::unique('pensioners', 'erp_id'),
                    ],
                    'name' => 'required|string|max:255',
                    'name_bangla' => 'required|string|max:255',
                    'register_no' => 'required|string|max:50',
                    'last_basic_salary' => 'required|integer|min:0',
                    'account_number' => 'required|string|max:255',
                    'office_id' => [
                        'required',
                        'integer',
                        Rule::exists('offices', 'id'),
                    ],
                    'designation' => 'required|string|max:255',
                    'pension_payment_order' => 'required|integer|min:1',
                    'father_name' => 'required|string|max:255',
                    'mother_name' => 'required|string|max:255',
                    'spouse_name' => 'required|string|max:255',
                    'birth_date' => 'required|date|before:today',
                    'joining_date' => 'required|date|after:birth_date',
                    'prl_start_date' => 'required|date|after_or_equal:joining_date',
                    'prl_end_date' => 'required|date|after:prl_start_date',
                    'is_self_pension' => 'required|boolean',
                    'phone_number' => 'required|string|max:20',
                    'email' => 'required|email|max:255',
                    'nid' => 'required|string|max:20',
                    'bank_routing_number' => 'required|string|max:20',
                    'status' => [
                        'required',
                        Rule::in(['initiated', 'certified', 'approved']),
                    ],
                    'verified' => 'required|boolean',
                    'biometric_verified' => 'required|boolean',
                    'biometric_verification_type' => [
                        'required',
                        Rule::in(['face', 'fingerprint']),
                    ],
                ]);

                Pensioner::create($pensioner_info);
                $success = true;
                if ($pensioner_info) {
                    return view('addpensionerbyerp', compact('success', 'pensioner_info', 'officer_designation', 'officer_role', 'officer_name', 'officer_office'));
                } else {
                }
            } else {
                return view('accessdeniedpage', compact('officer_designation', 'officer_role', 'officer_name', 'officer_office'));
            }
        } else {
            return view('login');
        }
    }

    public function searchPensionerByErp(Request $request)
    {
        $erp_id = $request->cookie('user_id');
        $officer = Officer::with(['role', 'designation', 'office'])->where('erp_id', '=', $erp_id)->first();
        if ($officer) {
            $officer_role = $officer->role->role_name;
            $officer_name = $officer->name;
            $officer_office = $officer->office->name_in_english;
            $officer_designation = $officer->designation->description_english;
            if (($officer_role === 'initiator' || ($officer_role === 'super_admin'))) {
                $validated = $request->validate([
                    'erp_id' => [
                        'required',
                        'digits:9',
                        function ($attribute, $value, $fail) {
                            $existsInPensioners = DB::table('pensioners')
                                ->where('erp_id', $value)
                                ->exists();

                            $existsInOfficers = DB::table('officers')
                                ->where('erp_id', $value)
                                ->exists();

                            if ($existsInPensioners) {
                                $fail('This Pensioners ERP ID already exists in the pensioner database.');
                            }
                            if ($existsInOfficers) {
                                $fail('This Officer ERP ID is already posted as Payment Officer.');
                                $fail('Release this Officer from Payment role then try again.');
                            }
                        },
                    ],
                ], [
                    'erp_id.digits' => 'ERP ID must be exactly 9 digits.',
                    'erp_id.required' => 'ERP ID is required.',
                ]);

                $pensioner_info = Http::withOptions(['verify' => false, 'allow_redirects' => false])->withHeaders([
                    'Authorization' => 'Basic ' . base64_encode(
                        config('custom.BC_USERNAME') . ':' . config('custom.BC_PASSWORD')
                    ),
                    'Accept' => 'application/json',
                    'User-Agent' => config('custom.ERP_USER_AGENT_HEADER'),
                ])->get(config('custom.BC_EMPLOYEE_INFO_URL'), [
                    '$filter' => "No eq '" . $validated['erp_id'] . "'",
                    '$top' => '1'
                ])->json();

                $pensioner_parent_info = Http::withOptions(['verify' => false, 'allow_redirects' => false])->withHeaders([
                    'Authorization' => 'Basic ' . base64_encode(
                        config('custom.BC_USERNAME') . ':' . config('custom.BC_PASSWORD')
                    ),
                    'Accept' => 'application/json',
                    'User-Agent' => config('custom.ERP_USER_AGENT_HEADER'),
                ])->get(config('custom.BC_EMPLOYEE_PARENT_INFO_URL'), [
                    '$filter' => "Employee_Id eq '" . $validated['erp_id'] . "'",
                    '$top' => '1'
                ])->json();

                $pensioner_spouses_info = Http::withOptions(['verify' => false, 'allow_redirects' => false])->withHeaders([
                    'Authorization' => 'Basic ' . base64_encode(
                        config('custom.BC_USERNAME') . ':' . config('custom.BC_PASSWORD')
                    ),
                    'Accept' => 'application/json',
                    'User-Agent' => config('custom.ERP_USER_AGENT_HEADER'),
                ])->get(config('custom.BC_EMPLOYEE_SPOUSES_INFO_URL'), [
                    '$filter' => "Employee_Id eq '" . $validated['erp_id'] . "'",
                    '$top' => '1'
                ])->json();

                $pensioner_bank_info = Http::withOptions(['verify' => false, 'allow_redirects' => false])->withHeaders([
                    'Authorization' => 'Basic ' . base64_encode(
                        config('custom.BC_USERNAME') . ':' . config('custom.BC_PASSWORD')
                    ),
                    'Accept' => 'application/json',
                    'User-Agent' => config('custom.ERP_USER_AGENT_HEADER'),
                ])->get(config('custom.BC_EMPLOYEE_BANK_INFO_URL'), [
                    '$filter' => "No eq '" . $validated['erp_id'] . "'",
                    '$top' => '1'
                ])->json();

                if (is_array($pensioner_info['value']) && !empty($pensioner_info['value'])) {
                    $pensioner_information = $pensioner_info['value'][0];
                    if (Carbon::parse($pensioner_information['Employment_Date'])->diff(Carbon::now())->y <= 25) {
                        return redirect()->back()->withErrors(['error' => 'Pensioner named ' . $pensioner_information['First_Name'] . ' having ERP no ' . $pensioner_information['No'] . ' age is not elligible for pension']);
                    }
                    $pensioner_payment_office_code = Office::where('name_in_english', 'LIKE', "%{$pensioner_information['Office_Name']}%")->value('payment_office_code');
                    $officer_office_code = $officer->office->office_code;
                    if ($pensioner_payment_office_code == $officer_office_code) {
                        $pensioner_parent_information = $pensioner_parent_info['value'][0] ?? null;
                        $pensioner_spouse_inforamtion = $pensioner_spouses_info['value'][0] ?? null;
                        $pensioner_bank_information = $pensioner_bank_info['value'][0] ?? null;
                        $pensioner_info = [
                            // ERP / Identity
                            'erp_id' => $pensioner_information['No'],
                            'name' => $pensioner_information['First_Name'],
                            'name_bangla' => $pensioner_information['Name_in_Bangla'],
                            'register_no' => $pensioner_information['Employee_Code'],

                            // Office & Designation
                            'designation' => $pensioner_information['Designation'],
                            'office_id' => Office::where('name_in_english', 'LIKE', "%{$pensioner_information['Office_Name']}%")->value('id') ?? 0,
                            'office' => $pensioner_information['Office_Name'],

                            // Dates
                            'birth_date' => $pensioner_information['Birth_Date'] ?? '',
                            'joining_date' => $pensioner_information['Employment_Date'] ?? '',
                            'prl_start_date' => $pensioner_information['Retirement_Date'] ?? '',
                            'prl_end_date' => Carbon::parse($pensioner_information['Retirement_Date'])->addYear()->toDateString() ?? '',
                            'service_life' => Carbon::parse($pensioner_information['Employment_Date'])->diffForHumans([
                                'parts' => 4
                            ]),

                            // Contact
                            'phone_number' => $pensioner_information['Phone_No'] ?? '',
                            'email' => $pensioner_information['E_Mail'] ?? '',
                            'nid' => $pensioner_information['NID'] ?? '',

                            // Financial 
                            'last_basic_salary' => Payscale::where('grade', 'LIKE', "%{$pensioner_information['Grade_Code']}%")
                                ->whereRaw(
                                    'LOWER(step) LIKE ?',
                                    ['%' . strtolower($pensioner_information['Pay_Grade_Step']) . '%']
                                )
                                ->value('basic') ?? 0,
                            // Bank info (NOT in response)
                            'bank_name' => $pensioner_bank_information['EmpBankName'] ?? '',
                            'bank_branch_name' => $pensioner_bank_information['EmpBranchName'] ?? '',
                            'bank_routing_number' => $pensioner_bank_information['Bank_Routing_Number'] ?? '',
                            'account_number' => $pensioner_bank_information['Bank_Account_No'] ?? '',

                            // Family info (partially available)
                            'father_name' => $pensioner_parent_information['Fathers_Name'] ?? '',
                            'mother_name' => $pensioner_parent_information['Mothers_Name'] ?? '',
                            'spouse_name' => $pensioner_spouse_inforamtion['Spouse_Name'] ?? '',

                            // Pension flags
                            'is_self_pension' => true,
                            'status' => 'pending',
                            'verified' => true,
                            'biometric_verified' => false,
                            'biometric_verification_type' => 'fingerprint',

                            'pension_payment_order' => '',
                        ];

                        return view('addpensionerbyerp', compact('pensioner_info', 'officer_designation', 'officer_role', 'officer_name', 'officer_office'));
                    } else {
                        return redirect()->back()->withErrors([
                            ['error' => 'Pensioner named ' . $pensioner_information['First_Name'] . ' having ERP no ' . $pensioner_information['No'] . ' under office of ' . $pensioner_information['Office_Name'] . ' is not under Your juridiction']
                        ])->withInput();
                    }
                } else {
                    return redirect()->back()->withErrors([
                        'erp_id' => $request->input('erp_id') . ' ' . 'is not valid ERP ID'
                    ])->withInput();
                }
            } else {
                return view('accessdeniedpage', compact('officer_designation', 'officer_role', 'officer_name', 'officer_office'));
            }
        } else {
            return view('login');
        }
    }

    public function getAllPensionersFromDB(Request $request)
    {
        $erp_id = $request->cookie('user_id');
        $officer = Officer::with(['role', 'designation', 'office'])->where('erp_id', '=', $erp_id)->first();
        if ($officer) {
            $officer_role = $officer->role->role_name;
            $officer_name = $officer->name;
            $officer_office = $officer->office->name_in_english;
            $officer_designation = $officer->designation->description_english;
            switch ($officer_role) {
                case 'super_admin':
                    $pensioners = Pensioner::orderBy('erp_id')->with('office')->get();
                    return view('viewpensioner')->with(compact('pensioners', 'officer_name', 'officer_office', 'officer_designation', 'officer_role'));
                    break;
                case 'initiator':
                    $officer_office_code = $officer->office->office_code;
                    $office_ids = Office::where('payment_office_code', $officer_office_code)->pluck('id');
                    $pensioners = Pensioner::whereIn('office_id', $office_ids)->get();
                    return view('viewpensioner')->with(compact('pensioners', 'officer_name', 'officer_office', 'officer_designation', 'officer_role'));
                    break;
                default:
                    return view('login');
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

    public function removePensionerFromDB(Request $request)
    {
        $erp_id = $request->cookie('user_id');
        $officer = Officer::with(['role', 'designation', 'office'])->where('erp_id', '=', $erp_id)->first();
        if ($officer) {
            $officer_role = $officer->role->role_name;
            if ($officer_role === 'initiator') {
                $officer_name = $officer->name;
                $officer_office = $officer->office->name_in_english;
                $officer_designation = $officer->designation->description_english;
                $id = (int)$request->input('id');
                $pensioner = Pensioner::find($id);
                if ($pensioner) {
                    $pensioner->delete();
                    $pensioners = Pensioner::orderBy('name')->get();
                    return redirect()->route('show.pensioner.section')->with(compact('pensioners'));
                } else {
                    return response()->json(['message' => $id]);
                }
            } else {
                return view('login');
            }
        } else {
            return view('login');
        }
    }


    public function updatePensionerIntoDB(Request $request)
    {
        if ($request->cookie('user_role') === 'super_admin') {;
            // $validated = $request->validate([
            //     'erp_id'           => 'required|integer|unique:pensioners,erp_id',
            //     'name'             => 'required|string|max:255',
            //     'register_no'      => 'required|string|max:50|unique:pensioners,register_no',
            //     'basic_salary'     => 'required|integer|min:0',
            //     'medical_allowance' => 'required|integer|min:0',
            //     'incentive_bonus'  => 'required|numeric|min:0',
            //     'bank_name'        => 'required|string|max:255',
            //     'account_number'   => 'required|string|max:255|unique:pensioners,account_number',
            // ]);

            $editedPensioner = $request->all();
            $exitingPensioner = Pensioner::find($editedPensioner['id']);
            if ($exitingPensioner) {
                $exitingPensioner->name = $editedPensioner['name'];
                $exitingPensioner->register_no = $editedPensioner['register_no'];
                $exitingPensioner->basic_salary = $editedPensioner['basic_salary'];
                $exitingPensioner->medical_allowance = $editedPensioner['medical_allowance'];
                $exitingPensioner->incentive_bonus = $editedPensioner['incentive_bonus'];
                $exitingPensioner->bank_name = $editedPensioner['bank_name'];
                $exitingPensioner->account_number = $editedPensioner['account_number'];
                $exitingPensioner->office_id = $editedPensioner['office_id'];
                $exitingPensioner->save();
                $pensioners = Pensioner::orderBy('name')->get();
                return redirect()->route('show.pensioner.section')->with(compact('pensioners'));
            } else {
                return response()->json(['message' => $editedPensioner['id']]);
            }
        } else {
            return view('login');
        }
    }

    public function exportPensioners(Request $request)
    {
        return Excel::download(new PensionersExport, 'pensioners.xlsx');
    }

    public function exportPensionersTemplate()
    {
        return Excel::download(new PensionersTemplateExport, 'penioners.xlsx');
    }

    public function importPensioner(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new PensionersImport, $request->file('file'));
        return back()->with('success', 'Pensioners imported successfully!');
    }

    public function showImportPensionerSection(Request $request)
    {
        return view('importpensioners');
    }


    public function showInvoiceBank(Request $request)
    {
        if ($request->hasCookie('user_id')) {
            $banks = Pensioner::select('bank_name')->distinct()->pluck('bank_name');
            return view('viewbanks')->with(compact('banks'));
        } else {
            return view('login');
        }
    }

    public function showSelectedBankPensionersForInvoiceGeneration(Request $request)
    {
        if ($request->hasCookie('user_id')) {
            if ($request->query('bank_name')) {
                $banks = Pensioner::select('bank_name')->distinct()->pluck('bank_name')->toArray();
                $bank_name = $request->query('bank_name');
                if (in_array($bank_name, $banks)) {
                    $pensioners = Pensioner::where('bank_name', '=', $bank_name)->get();
                    return view('viewselectedbankpensioners')->with(compact('pensioners', 'bank_name'));
                } else {
                }
            } else {
                return view('login');
            }
        } else {
            return view('login');
        }
    }

    public function generateInvoice(Request $request)
    {
        if ($request->hasCookie('user_id')) {
            if ($request->query('bank_name')) {
                $banks = Pensioner::select('bank_name')->distinct()->pluck('bank_name')->toArray();
                $bank_name = $request->query('bank_name');
                $pensioners = Pensioner::where('bank_name', '=', $bank_name)->get();
                if (in_array($bank_name, $banks)) {

                    /* $pdf = Pdf::setOptions([
                        'isHtml5ParserEnabled' => true,
                        'isRemoteEnabled' => true,
                        'defaultFont' => 'nikosh',
                    ]);
                    $pdf->loadView('viewpensionersinvoice', compact('pensioners', 'bank_name'))->setPaper('a4', 'portrait');
                    return $pdf->stream('invoice.pdf'); */


                    /*  $defaultConfig = (new ConfigVariables())->getDefaults();
                    $fontDirs = $defaultConfig['fontDir'];
                    $defaultFontConfig = (new FontVariables())->getDefaults();
                    $fontData = $defaultFontConfig['fontdata'];
                    $mpdf = new Mpdf([
                        'mode' => 'utf-8',
                        'format' => 'A4',
                        'fontDir' => array_merge($fontDirs, [
                            storage_path('fonts'),
                        ]),
                        'fontdata' => $fontData + [
                            'nikosh' => [
                                'R' => 'Nikosh.ttf',
                            ],
                            'siyamrupali' => [
                                'R' => 'SiyamRupali.ttf',
                            ]
                        ],
                        'default_font' => 'siyamrupali',
                    ]);
                    $html = view('viewpensionersinvoice', compact('pensioners', 'bank_name'))->render();
                    $mpdf->WriteHTML($html);
                    $mpdf->Output('pensioners.pdf', 'I'); */

                    $pdf = PDF::loadView('viewpensionersinvoice', compact('pensioners', 'bank_name'))
                        ->setPaper('a4')->setOption('encoding', 'utf-8');

                    return $pdf->inline('invoice.pdf');
                } else {
                }
            } else {
                return view('login');
            }
        } else {
            return view('login');
        }
    }
}
