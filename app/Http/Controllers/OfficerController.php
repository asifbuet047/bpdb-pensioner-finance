<?php

namespace App\Http\Controllers;

use App\Models\Officer;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

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
                'name' => 'required|string|max:255',
                'designation' => 'required|in:AD,SAD,DD',
                'office_id' => 'required|integer|exists:offices,id',
                'role' => 'required|in:ADMIN,USER,SUPER_ADMIN',
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
                'name' => $request->input('name'),
                'erp_id' => $request->input('erp_id'),
                'designation' => $request->input('designation'),
                'role' => $request->input('role'),
                'office_id' => $request->input('office_id'),
                'password' => Hash::make($request->input('password'))
            ]);

            return redirect()->back()->with([
                'name' => $request->input('name'),
                'erp_id' => $request->input('erp_id'),
                'designation' => $request->input('designation'),
                'office' => $request->input('office_name'),
                'role' => $request->input('role')
            ]);
        }
    }

    public function getAllOfficersFromDB(Request $request)
    {
        if ($request->cookie('user_role') === "SUPER_ADMIN") {
            $officers = Officer::orderBy('name')->get();
            return view('viewofficers', compact('officers'));
        } else {
            return view('login');
        }
    }
    
}
