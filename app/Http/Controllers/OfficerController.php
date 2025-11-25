<?php

namespace App\Http\Controllers;

use App\Exports\OfficersExport;
use App\Models\Designation;
use App\Models\Office;
use App\Models\Officer;
use App\Models\Role;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
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

            $officer = Officer::create([
                'name' => $dataResponse->json()['data'][0]['name'],
                'erp_id' => $dataResponse->json()['data'][0]['code'],
                'designation_id' => Designation::where('designation_code', '=', $dataResponse->json()['data'][0]['designationCode'])->value('id'),
                'office_id' => Office::where('office_code', '=', $dataResponse->json()['data'][0]['officeCode'])->value('id'),
                'role_id' => Role::where('role_name', '=', 'initiator')->value('id'),
                'password' => Hash::make($request->input('password'))
            ]);

            return redirect()->back()->with([
                'name' => $dataResponse->json()['data'][0]['name'],
                'erp_id' => $dataResponse->json()['data'][0]['code'],
                'designation' => $dataResponse->json()['data'][0]['designation'],
                'office' => $dataResponse->json()['data'][0]['officeName'],
                'role' => Role::where('role_name', '=', 'initiator')->value('id')
            ]);
        }
    }

    public function getAllOfficersFromDB(Request $request)
    {
        if ($request->hasCookie('user_id')) {
            $officers = Officer::orderBy('name')->get();
            return view('viewofficers', compact('officers'));
        } else {
            return view('login');
        }
    }

    public function updateOfficerIntoDB(Request $request)
    {
        if ($request->cookie('user_role') === 'SUPER_ADMIN') {
            // $validated = $request->validate([
            //     'erp_id' => 'required|integer|unique:officers,erp_id',
            //     'name' => 'required|string|max:255',
            //     'designation' => 'required|in:AD,SAD,DD',
            //     'office_id' => 'required|integer|exists:offices,id',
            //     'role' => 'required|in:ADMIN,USER,SUPER_ADMIN',
            // ]);

            $editedOfficer = $request->all();
            $exitingOfficer = Officer::find($editedOfficer['id']);
            if ($exitingOfficer) {
                $exitingOfficer->name = $editedOfficer['name'];
                $exitingOfficer->designation = $editedOfficer['designation'];
                $exitingOfficer->role = $editedOfficer['role'];
                $exitingOfficer->erp_id = $editedOfficer['erp_id'];
                $exitingOfficer->office_id = $editedOfficer['office_id'];
                $exitingOfficer->save();

                $officers = Officer::orderBy('name')->get();
                return redirect()->route('show.officers')->with(compact('officers'));
            } else {
                return response()->json(['message' => $editedOfficer['id']]);
            }
        } else {
            return view('login');
        }
    }

    public function removeOfficerFromDB(Request $request)
    {
        if ($request->cookie('user_role') === 'SUPER_ADMIN') {;
            $id = (int)$request->input('id');
            $officer = Officer::find($id);
            if ($officer) {
                $officer->delete();
                $officers = Officer::orderBy('name')->get();
                return redirect()->route('show.officers')->with(compact('officers'));
            } else {
                return response()->json(['message' => $id]);
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
