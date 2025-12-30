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
use App\Models\Pensionerworkflow;
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
                    'religion' =>  [
                        'required',
                        Rule::in(['Islam', 'Hinduism', 'Christianity', 'Buddhism', 'Others']),
                    ],
                    'bank_routing_number' => 'required|string|max:20',
                    'status' => [
                        'required',
                        Rule::in(['floated', 'initiated', 'certified', 'approved']),
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
                            // Bank info
                            'bank_name' => Bank::where('routing_number', $pensioner_bank_information['Bank_Routing_Number'])->value('bank_name') ?? $pensioner_bank_information['EmpBankName'],
                            'bank_branch_name' => Bank::where('routing_number', $pensioner_bank_information['Bank_Routing_Number'])->value('branch_name') ?? $pensioner_bank_information['EmpBranchName'],
                            'bank_branch_address' => Bank::where('routing_number', $pensioner_bank_information['Bank_Routing_Number'])->value('branch_address') ?? $pensioner_bank_information['EmpBranchName'],
                            'bank_routing_number' => $pensioner_bank_information['Bank_Routing_Number'] ?? '',
                            'account_number' => $pensioner_bank_information['Bank_Account_No'] ?? '',

                            // Family info (partially available)
                            'father_name' => $pensioner_parent_information['Fathers_Name'] ?? '',
                            'mother_name' => $pensioner_parent_information['Mothers_Name'] ?? '',
                            'spouse_name' => $pensioner_spouse_inforamtion['Spouse_Name'] ?? '',
                            'religion' => $pensioner_information['Religion'] ?? '',

                            // RAO specific code
                            'pension_payment_order' => '',
                            'register_no' => '',

                            // Pension flags
                            'is_self_pension' => true,
                            'status' => 'floated',
                            'verified' => false,
                            'biometric_verified' => false,
                            'biometric_verification_type' => 'fingerprint',

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
        $pensioner_type = $request->query('type');
        $officer = Officer::with(['role', 'designation', 'office'])->where('erp_id', '=', $erp_id)->first();
        if ($officer) {
            $officer_role = $officer->role->role_name;
            $officer_name = $officer->name;
            $officer_office = $officer->office->name_in_english;
            $officer_designation = $officer->designation->description_english;
            if ($pensioner_type) {
                $officer_office_code = $officer->office->office_code;
                $office_ids = Office::where('payment_office_code', $officer_office_code)->pluck('id');
                $pensioners = Pensioner::whereIn('office_id', $office_ids)->where('status', 'approved')->orderBy('id')->get();
                return view('viewpensioner', compact('pensioners', 'officer_name', 'officer_office', 'officer_designation', 'officer_role'));
            }
            switch ($officer_role) {
                case 'super_admin':
                    $officer_office_code = $officer->office->office_code;
                    $pensioners = Pensioner::orderBy('erp_id')->get();
                    return view('viewpensioner', compact('pensioners', 'officer_name', 'officer_office', 'officer_designation', 'officer_role'));
                case 'approver':
                    $officer_office_code = $officer->office->office_code;
                    $office_ids = Office::where('payment_office_code', $officer_office_code)->pluck('id');
                    $pensioners = Pensioner::whereIn('office_id', $office_ids)->whereIn('status', ['floated', 'initiated', 'certified'])->orderBy('id')->get();
                    return view('viewpensioner', compact('pensioners', 'officer_name', 'officer_office', 'officer_designation', 'officer_role'));
                    break;
                case 'certifier':
                    $officer_office_code = $officer->office->office_code;
                    $office_ids = Office::where('payment_office_code', $officer_office_code)->pluck('id');
                    $pensioners = Pensioner::whereIn('office_id', $office_ids)->whereIn('status', ['floated', 'initiated', 'certified'])->orderBy('id')->get();
                    return view('viewpensioner', compact('pensioners', 'officer_name', 'officer_office', 'officer_designation', 'officer_role'));
                    break;
                case 'initiator':
                    $officer_office_code = $officer->office->office_code;
                    $office_ids = Office::where('payment_office_code', $officer_office_code)->pluck('id');
                    $pensioners = Pensioner::whereIn('office_id', $office_ids)->whereIn('status', ['floated', 'initiated', 'certified'])->orderBy('id')->get();
                    return view('viewpensioner', compact('pensioners', 'officer_name', 'officer_office', 'officer_designation', 'officer_role'));
                    break;
                default:
                    return view('login');
                    break;
            }
        } else {
            return view('login');
        }
    }



    public function showPensionersVariantSection(Request $request)
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
                    $initiatedPensionersCount = Pensioner::where('status', 'initiated')->count();
                    $certifiedPensionersCount = Pensioner::where('status', 'certified')->count();
                    $approvedPensionersCount = Pensioner::where('status', 'approved')->count();
                    return view('showpensionersvariant', compact('initiatedPensionersCount', 'certifiedPensionersCount', 'approvedPensionersCount', 'officer_name', 'officer_office', 'officer_designation', 'officer_role'));
                    break;
                case 'approver':
                    $office_ids = Office::where('payment_office_code', $officer_office_code)->pluck('id');
                    $certifiedPensionersCount = Pensioner::whereIn('office_id', $office_ids)->where('status', 'certified')->count();
                    $approvedPensionersCount = Pensioner::whereIn('office_id', $office_ids)->where('status', 'approved')->count();
                    return view('showpensionersvariant', compact('certifiedPensionersCount', 'approvedPensionersCount', 'officer_name', 'officer_office', 'officer_designation', 'officer_role'));
                    break;
                case 'certifier':
                    $office_ids = Office::where('payment_office_code', $officer_office_code)->pluck('id');
                    $initiatedPensionersCount = Pensioner::whereIn('office_id', $office_ids)->where('status', 'initiated')->count();
                    $approvedPensionersCount = Pensioner::whereIn('office_id', $office_ids)->where('status', 'approved')->count();
                    return view('showpensionersvariant', compact('initiatedPensionersCount', 'approvedPensionersCount', 'officer_name', 'officer_office', 'officer_designation', 'officer_role'));
                    break;
                case 'initiator':
                    $office_ids = Office::where('payment_office_code', $officer_office_code)->pluck('id');
                    $floatedPensionersCount = Pensioner::whereIn('office_id', $office_ids)->where('status', 'floated')->count();
                    $approvedPensionersCount = Pensioner::whereIn('office_id', $office_ids)->where('status', 'approved')->count();
                    return view('showpensionersvariant', compact('floatedPensionersCount', 'approvedPensionersCount', 'officer_name', 'officer_office', 'officer_designation', 'officer_role'));
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

    public function deletePensionerFromDB(Request $request, $id)
    {
        $erp_id = $request->cookie('user_id');
        if (!$erp_id) {
            return response()->json(['message' => 'please login'], 401);
        }
        $officer = Officer::with('role')
            ->where('erp_id', $erp_id)
            ->first();
        if (!$officer) {
            return response()->json(['message' => 'no valid officer'], 402);
        }
        if ($officer->role->role_name !== 'initiator') {
            return response()->json(['message' => 'Forbidden request'], 403);
        }
        $pensioner = Pensioner::find($id);
        if (!$pensioner) {
            return response()->json(['message' => 'Pensioner not found'], 404);
        }
        $pensioner->delete();
        return response()->json([
            'success' => true,
            'message' => 'Pensioner deleted successfully'
        ], 200);
    }


    public function initiatePensionerWorkflow(Request $request)
    {
        $erp_id = $request->cookie('user_id');
        $workflow_type = $request->input('workflow', 'forward');
        $id = $request->input('id', '1');
        $message = $request->input('message');
        $officer = Officer::with(['role', 'designation', 'office'])->where('erp_id', '=', $erp_id)->first();
        $officer_office_code = $officer->office->office_code;
        $office_ids = Office::where('payment_office_code', $officer_office_code)->pluck('id');
        $pensioner = Pensioner::whereIn('office_id', $office_ids)->where('id', $id)->first();

        if (!$erp_id) {
            return response()->json(['message' => 'please login'], 401);
        }

        if (!$officer) {
            return response()->json(['message' => 'no valid officer'], 402);
        }

        if (!$pensioner) {
            return response()->json(['message' => 'Pensioner is not under Your RAO office'], 403);
        }

        switch ($workflow_type) {
            case 'forward':
                if ($pensioner->status === 'floated') {
                    if ($officer->role->role_name !== 'initiator') {
                        return response()->json([
                            'success' => false,
                            'message' => 'Officer is not initiator'
                        ], 403);
                    }

                    Pensionerworkflow::create([
                        'pensioner_id' => $pensioner->id,
                        'officer_id' => $officer->id,
                        'status_from' => 'floated',
                        'status_to' => 'initiated',
                        'message' => $message
                    ]);

                    $pensioner->update(['status' => 'initiated']);

                    return response()->json([
                        'success' => true,
                        'message' => $pensioner->name . ' is successfully initiated'
                    ], 200);
                }

                if ($pensioner->status === 'initiated') {

                    if ($officer->role->role_name !== 'certifier') {
                        return response()->json([
                            'success' => false,
                            'message' => 'Officer is not certifier'
                        ], 403);
                    }

                    Pensionerworkflow::create([
                        'pensioner_id' => $pensioner->id,
                        'officer_id' => $officer->id,
                        'status_from' => 'initiated',
                        'status_to' => 'certified',
                        'message' => $message
                    ]);

                    $pensioner->update(['status' => 'certified']);

                    return response()->json([
                        'success' => true,
                        'message' => $pensioner->name . ' is successfully certified'
                    ], 200);
                }

                return response()->json([
                    'success' => false,
                    'message' => 'Invalid pensioner status for forward workflow'
                ], 422);
                break;

            case 'return':
                if ($pensioner->status === 'initiated') {
                    if ($officer->role->role_name !== 'certifier') {
                        return response()->json([
                            'success' => false,
                            'message' => 'Officer is not certifier'
                        ], 403);
                    }

                    Pensionerworkflow::create([
                        'pensioner_id' => $pensioner->id,
                        'officer_id' => $officer->id,
                        'status_from' => 'initiated',
                        'status_to' => 'floated',
                        'message' => $message
                    ]);

                    $pensioner->update(['status' => 'floated']);

                    return response()->json([
                        'success' => true,
                        'message' => $pensioner->name . ' is successfully floated'
                    ], 200);
                }

                if ($pensioner->status === 'certified') {
                    if ($officer->role->role_name !== 'approver') {
                        return response()->json([
                            'success' => false,
                            'message' => 'Officer is not approver'
                        ], 403);
                    }

                    Pensionerworkflow::create([
                        'pensioner_id' => $pensioner->id,
                        'officer_id' => $officer->id,
                        'status_from' => 'certified',
                        'status_to' => 'initiated',
                        'message' => $message
                    ]);

                    $pensioner->update(['status' => 'initiated']);

                    return response()->json([
                        'success' => true,
                        'message' => $pensioner->name . ' is successfully initiated'
                    ], 200);
                }

                return response()->json([
                    'success' => false,
                    'message' => 'Invalid pensioner status for return workflow'
                ], 422);

                break;
            case 'approve':
                if ($pensioner->status !== 'certified') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Pensioner current status is not certified'
                    ], 422);
                }

                if ($officer->role->role_name !== 'approver') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Officer is not approver'
                    ], 403);
                }

                Pensionerworkflow::create([
                    'pensioner_id' => $pensioner->id,
                    'officer_id' => $officer->id,
                    'status_from' => 'certified',
                    'status_to' => 'approved',
                    'message' => $message
                ]);

                $pensioner->update(['status' => 'approved']);

                return response()->json([
                    'success' => true,
                    'message' => $pensioner->name . ' is successfully approved'
                ], 200);

                break;
        }
    }

    public function showPensionerWorkflow(Request $request)
    {
        $erp_id = $request->cookie('user_id');
        $pensioner_id = $request->query('id');
        $officer = Officer::with(['role', 'designation', 'office'])->where('erp_id', '=', $erp_id)->first();
        if ($officer) {
            $officer_role = $officer->role->role_name;
            $officer_name = $officer->name;
            $officer_office = $officer->office->name_in_english;
            $officer_designation = $officer->designation->description_english;
            $pensioner_name = Pensioner::find($pensioner_id)->get()->value('name');
            $pensioner_workflows = Pensionerworkflow::with(['officer', 'pensioner'])->where('pensioner_id', $pensioner_id)->orderBy('created_at', 'asc')->get();
            if ($pensioner_workflows) {
                return view('viewpensionerapprovalworkflow', compact('pensioner_workflows', 'pensioner_name', 'officer_designation', 'officer_role', 'officer_name', 'officer_office'));
            } else {
                return view('login');
            }
        } else {
            return view('login');
        }
    }

    public function isPensionerExits(Request $request, $id)
    {
        $erp_id = $request->cookie('user_id');
        $officer = Officer::with(['role', 'designation', 'office'])->where('erp_id', '=', $erp_id)->first();
        $officer_office_code = $officer->office->office_code;
        $office_ids = Office::where('payment_office_code', $officer_office_code)->pluck('id');
        $pensioner = Pensioner::whereIn('office_id', $office_ids)->where('id', $id)->first();

        if (!$erp_id) {
            return response()->json(['message' => 'please login'], 401);
        }

        if (!$officer) {
            return response()->json(['message' => 'no valid officer'], 402);
        }
        if ($officer->role->role_name !== 'initiator') {
            return response()->json(['message' => 'Forbidden request'], 403);
        }

        if (!$pensioner) {
            return response()->json(['message' => 'Pensioner is not under Your RAO office'], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Pensioner successfully retrived'
        ], 200);
    }

    public function isPensionerWorkflowExits(Request $request, $id)
    {
        $erp_id = $request->cookie('user_id');
        $officer = Officer::with(['role', 'designation', 'office'])->where('erp_id', '=', $erp_id)->first();
        $officer_office_code = $officer->office->office_code;
        $office_ids = Office::where('payment_office_code', $officer_office_code)->pluck('id');
        $pensioner = Pensioner::whereIn('office_id', $office_ids)->where('id', $id)->first();
        $pensioner_workflow_count = Pensionerworkflow::where('pensioner_id', $id)->count();

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

        if (!$pensioner) {
            return response()->json([
                'success' => false,
                'message' => 'No valid officer',
                'data' => []
            ], 403);
        }
        if ($pensioner_workflow_count == 0) {
            return response()->json([
                'success' => true,
                'message' => 'Pensioner workflow number successfully retrived',
                'data' => 0
            ], 200);
        }

        return response()->json([
            'success' => true,
            'message' => 'Pensioner workflow number successfully retrived',
            'data' => $pensioner_workflow_count
        ], 200);
    }

    public function getApprovedPensioners(Request $request)
    {
        $erp_id = $request->cookie('user_id');
        $officer = Officer::with(['role', 'designation', 'office'])->where('erp_id', '=', $erp_id)->first();
        $officer_office_code = $officer->office->office_code;
        $office_ids = Office::where('payment_office_code', $officer_office_code)->pluck('id');
        $approvedPensioners = Pensioner::whereIn('office_id', $office_ids)->where('status', 'approved')->get();

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

        if ($approvedPensioners->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No approved pensioners found',
                'data' => []
            ], 403);
        }

        return response()->json([
            'success' => true,
            'message' => 'Total ' . $approvedPensioners->count() . ' Approved pensioners are successfully retrived',
            'data' => $approvedPensioners
        ], 200);
    }

    public function getSpecificPensionerFromDB(Request $request, $id)
    {
        $erp_id = $request->cookie('user_id');
        $officer = Officer::with(['role', 'designation', 'office'])->where('erp_id', '=', $erp_id)->first();
        if ($officer) {
            $officer_role = $officer->role->role_name;
            $officer_name = $officer->name;
            $officer_office = $officer->office->name_in_english;
            $officer_designation = $officer->designation->description_english;
            if (($officer_role === 'initiator' || ($officer_role === 'super_admin'))) {
                $pensioner = Pensioner::where('id', $id)->first();
                if ($pensioner) {
                    $pensioner_payment_office_code = Office::where('name_in_english', 'LIKE', "%{$pensioner->office_name}%")->value('payment_office_code');
                    $officer_office_code = $officer->office->office_code;
                    if ($pensioner_payment_office_code == $officer_office_code) {
                        $pensioner_info = [
                            // ERP / Identity
                            'erp_id' => $pensioner->erp_id,
                            'name' => $pensioner->name,
                            'name_bangla' => $pensioner->name_bangla,

                            // Office & Designation
                            'designation' => $pensioner->designation,
                            'office_id' => $pensioner->office_id,
                            'office' => Office::where('name_in_english', 'LIKE', "%{$pensioner->office_name}%")->value('name_in_english') ?? 0,

                            // Dates
                            'birth_date' => $pensioner->birth_date ?? '',
                            'joining_date' => $pensioner->joining_date ?? '',
                            'prl_start_date' => $pensioner->prl_start_date ?? '',
                            'prl_end_date' => $pensioner->prl_end_date  ?? '',
                            'service_life' => Carbon::parse($pensioner->joining_date)->diffForHumans([
                                'parts' => 4
                            ]),

                            // Contact
                            'phone_number' => $pensioner->phone_number ?? '',
                            'email' => $pensioner->email ?? '',
                            'nid' => $pensioner->nid ?? '',

                            // Financial 
                            'last_basic_salary' => $pensioner->last_basic_salary ?? 0,
                            // Bank info
                            'bank_name' => Bank::where('routing_number', $pensioner->bank_routing_number)->value('bank_name') ?? '',
                            'bank_branch_name' => Bank::where('routing_number', $pensioner->bank_routing_number)->value('branch_name') ?? '',
                            'bank_branch_address' => Bank::where('routing_number', $pensioner->bank_routing_number)->value('branch_address') ?? '',
                            'bank_routing_number' => $pensioner->bank_routing_number ?? '',
                            'account_number' => $pensioner->account_number ?? '',

                            // Family info (partially available)
                            'father_name' => $pensioner->father_name ?? '',
                            'mother_name' => $pensioner->mother_name ?? '',
                            'spouse_name' => $pensioner->spouse_name ?? '',
                            'religion' => $pensioner->religion ?? '',

                            // RAO specific code
                            'pension_payment_order' => $pensioner->pension_payment_order ?? '',
                            'register_no' => $pensioner->register_no ?? '',

                            // Pension flags
                            'is_self_pension' => $pensioner->is_self_pension ?? true,
                            'status' => $pensioner->status ?? 'floated',
                            'verified' => $pensioner->verified ?? false,
                            'biometric_verified' => $pensioner->biometric_verified ?? false,
                            'biometric_verification_type' => $pensioner->biometric_verification_type ?? 'fingerprint',
                        ];

                        return view('updatepensioner', compact('pensioner_info', 'officer_designation', 'officer_role', 'officer_name', 'officer_office'));
                    } else {
                        return redirect()->back()->withErrors([
                            ['error' => 'Pensioner named ' . $pensioner->name . ' having ERP no ' . $pensioner->erp_id . ' under office of ' . $pensioner->office_name . ' is not under Your juridiction']
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



    public function updatePensionerIntoDB(Request $request)
    {
        $erp_id = $request->cookie('user_id');
        $pensioner_erp_id = $request->query('erp_id');
        $officer = Officer::with(['role', 'designation', 'office'])->where('erp_id', '=', $erp_id)->first();
        if ($officer) {
            $officer_role = $officer->role->role_name;
            $officer_name = $officer->name;
            $officer_office = $officer->office->name_in_english;
            $officer_designation = $officer->designation->description_english;
            if (($officer_role === 'initiator' || ($officer_role === 'super_admin'))) {
                $pensioner_info = $request->validate([
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
                        Rule::in(['floated', 'initiated', 'certified', 'approved']),
                    ],
                    'verified' => 'required|boolean',
                    'biometric_verified' => 'required|boolean',
                    'biometric_verification_type' => [
                        'required',
                        Rule::in(['face', 'fingerprint']),
                    ],
                ]);

                $pensioner = Pensioner::where('erp_id', $pensioner_erp_id)->firstOrFail();
                $pensioner->update($pensioner_info);
                $success = true;
                if ($pensioner_info) {
                    return view('updatepensioner', compact('success', 'pensioner_info', 'officer_designation', 'officer_role', 'officer_name', 'officer_office'));
                } else {
                }
            } else {
                return view('accessdeniedpage', compact('officer_designation', 'officer_role', 'officer_name', 'officer_office'));
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
