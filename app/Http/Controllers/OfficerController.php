<?php

namespace App\Http\Controllers;

use App\Exports\OfficersExport;
use App\Models\Designation;
use App\Models\Office;
use App\Models\Officer;
use App\Models\Pensioner;
use App\Models\Role;
use Carbon\Carbon;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;

class OfficerController extends Controller
{
    public function addOfficerIntoDB(Request $request)
    {
        $jar = new CookieJar();

        $loginPage = Http::withOptions(['cookies' => $jar, 'verify' => false])
            ->get(config('custom.ERP_LOGIN_URL'));

        preg_match('/name="__RequestVerificationToken" type="hidden" value="([^"]+)"/', $loginPage->body(), $matches);
        $csrfToken = $matches[1] ?? null;

        Http::asForm()
            ->withOptions(['cookies' => $jar, 'verify' => false, 'allow_redirects' => false])
            ->withHeaders([
                'Accept' => config('custom.ERP_ACCEPT_HEADER'),
                'User-Agent' => config('custom.ERP_USER_AGENT_HEADER'),
                'Referer' => config('custom.ERP_LOGIN_URL')
            ])->post(config('custom.ERP_LOGIN_URL'), [
                'username' => config('custom.ERP_USERNAME'),
                'password' => config('custom.ERP_PASSWORD'),
                '__RequestVerificationToken' => $csrfToken
            ]);

        $data = [
            "page" => 1,
            "PageSize" => 18,
            "searchModel" => [
                "columnFilter" => [
                    [
                        "columnName" => "code",
                        "columnValue" => $request->input('erp_id'),
                        "columnValueType" => "string"
                    ]
                ]
            ]
        ];

        $dataResponse = Http::withOptions(['cookies' => $jar, 'verify' => false])->withHeaders([
            'Accept' => config('custom.ERP_ACCEPT_HEADER'),
            'User-Agent' => config('custom.ERP_USER_AGENT_HEADER'),
            'Referer' => config('custom.ERP_LOGIN_URL')
        ])->post(config('custom.ERP_GET_ALL_URL'), $data);

        if (empty($dataResponse->json()['data'])) {
            return redirect()->back()->withErrors([
                'erp_id' => $request->input('erp_id') . ' ' . 'is not valid ERP ID'
            ])->withInput();
        } else {
            $validated = $request->validate([
                'erp_id' => 'required|integer|unique:officers,erp_id',
                'password' => [
                    'required',
                    'string',
                    'max:15',
                    'regex:/[@$!%*#?&]/',
                    'confirmed'
                ]
            ], [
                'password.max' => 'Password cannot be longer than 15 characters',
                'password.regex' => 'Password must contain at least one special character',
            ]);

            $name = $dataResponse->json()['data'][0]['name'];
            $erp_id = $dataResponse->json()['data'][0]['code'];
            $designation_id = Designation::where('designation_code', '=', $dataResponse->json()['data'][0]['designationCode'])->value('id') ?? 0;
            $office_id = Office::where('office_code', '=', $dataResponse->json()['data'][0]['officeCode'])->value('id') ?? 0;
            $role_id = Role::where('role_name', '=', 'initiator')->value('id');

            if ($designation_id == 0) {
                return redirect()->back()->withErrors([
                    'cause' => $dataResponse->json()['data'][0]['designation'] . ' is not finance cadre in BPDB'
                ])->withInput();
            }


            $officer = Officer::create([
                'name' => $name,
                'erp_id' => $erp_id,
                'designation_id' => $designation_id,
                'office_id' => $office_id,
                'role_id' => $role_id,
                'password' => Hash::make($request->input('password'))
            ]);

            return redirect()->back()->with([
                'name' => $dataResponse->json()['data'][0]['name'],
                'erp_id' => $dataResponse->json()['data'][0]['code'],
                'designation' => $dataResponse->json()['data'][0]['designation'],
                'office' => $dataResponse->json()['data'][0]['officeName'],
                'role' => 'initiator'
            ]);
        }
    }

    public function registerOfficerIntoDB(Request $request)
    {
        $validated = $request->validate([
            'erp_id' => 'required|integer|unique:officers,erp_id',
            'password' => [
                'required',
                'string',
                'max:15',
                'regex:/[@$!%*#?&]/',
                'confirmed'
            ]
        ], [
            'password.max' => 'Password cannot be longer than 15 characters',
            'password.regex' => 'Password must contain at least one special character',
        ]);

        $response = Http::withOptions(['verify' => false, 'allow_redirects' => false])->withHeaders([
            'Authorization' => 'Basic ' . base64_encode(
                config('custom.BC_USERNAME') . ':' . config('custom.BC_PASSWORD')
            ),
            'Accept'        => 'application/json',
            'User-Agent' => config('custom.ERP_USER_AGENT_HEADER'),
        ])->get(config('custom.BC_EMPLOYEE_INFO_URL'), [
            '$filter' => "No eq '" . $validated['erp_id'] . "'",
            '$top' => '1'
        ])->json();

        if (is_array($response['value']) && !empty($response['value'])) {
            $name = $response['value'][0]['First_Name'];
            $erp_id = $response['value'][0]['No'];
            $designation_id = Designation::where('description_english', 'LIKE', "%{$response['value'][0]['Designation']}%")->value('id') ?? 0;
            $office_id = Office::where('is_payment_office', true)->where('name_in_english', 'LIKE', "%{$response['value'][0]['Office_Name']}%")->value('id') ?? 0;
            $role_id = Role::where('role_name', '=', 'initiator')->value('id');
            $officers_age = Carbon::parse($response['value'][0]['Birth_Date'])->diff(Carbon::now())->y;

            if ($officers_age >= 59) {
                return redirect()->back()->withErrors([
                    'cause' => $response['value'][0]['First_Name'] . ' having erp no ' . $response['value'][0]['No'] . ' and posted as ' . $response['value'][0]['Designation'] . ' in office of ' . $response['value'][0]['Office_Name'] . ' age is 59 or above can not register as payment office in this system ',
                ])->withInput();
            }

            if ($designation_id == 0) {
                return redirect()->back()->withErrors([
                    'cause' => $response['value'][0]['First_Name'] . ' having erp no ' . $response['value'][0]['No'] . ' and posted as ' . $response['value'][0]['Designation'] . ' in office of ' . $response['value'][0]['Office_Name'] . ' is not finance cadre in BPDB ',
                ])->withInput();
            }
            if ($office_id == 0) {
                return redirect()->back()->withErrors([
                    'cause' => $response['value'][0]['First_Name'] . ' having erp no ' . $response['value'][0]['No'] . ' and posted as ' . $response['value'][0]['Designation'] . ' in office of ' . $response['value'][0]['Office_Name'] . ' is not valid payment office (RAO) in BPDB ',
                ])->withInput();
            }


            $officer = Officer::create([
                'name' => $name,
                'erp_id' => $erp_id,
                'designation_id' => $designation_id,
                'office_id' => $office_id,
                'role_id' => $role_id,
                'password' => Hash::make($request->input('password'))
            ]);

            return redirect()->back()->with([
                'name' => $name,
                'erp_id' => $erp_id,
                'designation' => $response['value'][0]['Designation'],
                'office' => $response['value'][0]['Office_Name'],
                'role' => 'initiator'
            ]);
        } else {
            return redirect()->back()->withErrors([
                'erp_id' => $request->input('erp_id') . ' ' . 'is not valid ERP ID'
            ])->withInput();
        }
    }

    public function getAllOfficersFromDB(Request $request)
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
                    $officers = Officer::with(['office', 'designation', 'role'])->paginate(5);
                    return view('viewofficers', compact('officers', 'officer_name', 'officer_office', 'officer_designation', 'officer_role'));
                    break;
                default:
                    $officer_office_id = $officer->office->id;
                    $officers = Officer::with(['office', 'designation', 'role'])->where('office_id', $officer_office_id)->paginate(5);
                    return view('viewofficers', compact('officers', 'officer_name', 'officer_office', 'officer_designation', 'officer_role'));
                    break;
            }
        } else {
            return view('login');
        }
    }

    public function getSpecificOfficerFromDB(Request $request)
    {
        $erp_id = $request->cookie('user_id');
        $officer = Officer::with(['role', 'designation', 'office'])->where('erp_id', '=', $erp_id)->first();
        if ($officer) {
            $officer_role = $officer->role->role_name;
            if ($officer_role === 'super_admin') {
                $officer_name = $officer->name;
                $officer_office = $officer->office->name_in_english;
                $officer_designation = $officer->designation->description_english;
                $officers = Officer::with(['office', 'designation', 'role'])->where('erp_id', 'LIKE', "%{$request->input('erp_id')}%")->orderBy('erp_id')->get();
                return view('viewofficers', compact('officers', 'officer_name', 'officer_office', 'officer_designation', 'officer_role'));
            } else {
                return view('login');
            }
        } else {
            return view('login');
        }
    }

    public function getOfficerPendingTaskCount(Request $request)
    {
        $erp_id = $request->cookie('user_id');
        $officer = Officer::with(['role', 'designation', 'office'])->where('erp_id', '=', $erp_id)->first();
        $officer_office_code = $officer->office->office_code;
        $officer_role_name = $officer->role->role_name;
        $office_ids = Office::where('payment_office_code', $officer_office_code)->pluck('id');
        $pendingTasks = 0;
        switch ($officer_role_name) {
            case 'initiator':
                $pendingTasks = Pensioner::whereIn('office_id', $office_ids)->where('status', 'floated')->count();
                break;
            case 'certifier':
                $pendingTasks = Pensioner::whereIn('office_id', $office_ids)->where('status', 'initiated')->count();
                break;
            case 'approver':
                $pendingTasks = Pensioner::whereIn('office_id', $office_ids)->where('status', 'certified')->count();
                break;
        }

        if (!$erp_id) {
            return response()->json(['success' => false, 'message' => 'please login'], 401);
        }

        if (!$officer) {
            return response()->json(['success' => false, 'message' => 'no valid officer'], 402);
        }

        return response()->json([
            'success' => true,
            'message' => 'Pending tasks successfully retrived',
            'data' => $pendingTasks
        ], 200);
    }

    public function updateOfficerIntoDB(Request $request)
    {
        $erp_id = $request->cookie('user_id');
        $officer = Officer::with(['role', 'designation', 'office'])->where('erp_id', '=', $erp_id)->first();
        if ($officer) {
            $officer_role = $officer->role->role_name;
            if ($officer_role === 'super_admin') {
                $officer_name = $officer->name;
                $officer_office = $officer->office->name_in_english;
                $officer_designation = $officer->designation->description_english;
                $editedOfficer = $request->all();
                $exitingOfficer = Officer::with(['role'])->find($editedOfficer['id']);
                if ($exitingOfficer) {
                    $exitingOfficer->role_id = Role::where('role_name', '=', $editedOfficer['role'])->value('id');
                    $exitingOfficer->save();
                    $updatedOfficers = Officer::with(['office', 'designation', 'role'])->orderBy('name')->get();
                    return redirect()->route('show.officers', compact('updatedOfficers', 'officer_name', 'officer_office', 'officer_designation', 'officer_role'));
                } else {
                    return response()->json(['message' => $editedOfficer['id']]);
                }
            } else {
                return view('login');
            }
        } else {
            return view('login');
        }
    }

    public function removeOfficerFromDB(Request $request)
    {
        $erp_id = $request->cookie('user_id');
        $officer = Officer::with(['role', 'designation', 'office'])->where('erp_id', '=', $erp_id)->first();
        if ($officer) {
            $officer_role = $officer->role->role_name;
            if ($officer_role === 'super_admin') {
                $officer_name = $officer->name;
                $officer_office = $officer->office->name_in_english;
                $officer_designation = $officer->designation->description_english;
                $id = (int)$request->input('id');
                $deletedOfficer = Officer::find($id);
                if ($deletedOfficer) {
                    $deletedOfficer->delete();
                    $updatedOfficers = Officer::with(['office', 'designation', 'role'])->orderBy('name')->get();
                    return redirect()->route('show.officers', compact('updatedOfficers', 'officer_name', 'officer_office', 'officer_designation', 'officer_role'));
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

    public function exportOfficers()
    {
        return Excel::download(new OfficersExport, 'officers.xlsx');
    }
}
