<?php

namespace App\Http\Controllers;

use App\Models\Officer;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

use function Pest\Laravel\withCookie;

class ApplicationController extends Controller
{
    public function showLoginPage()
    {
        return view('login');
    }


    public function showHomePage(Request $request)
    {
        if ($request->hasCookie('user_token')) {
            return view('dashboard');
        } else {
            return view('login');
        }
    }

    public function showRegistrationPage(Request $request)
    {
        return view('registration');
    }

    public function completeOfficialRegistration(Request $request)
    {

        $jar = new CookieJar();

        $loginPage = Http::withOptions(['cookies' => $jar, 'verify' => false])
            ->get('https://bc.bdpowersectorerp.com:5533/Account/Login');

        preg_match('/name="__RequestVerificationToken" type="hidden" value="([^"]+)"/', $loginPage->body(), $matches);
        $csrfToken = $matches[1] ?? null;

        $loginResponse = Http::asForm()
            ->withOptions(['cookies' => $jar, 'verify' => false, 'allow_redirects' => false])
            ->withHeaders([
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                'User-Agent' => 'Mozilla/5.0',
                'Referer' => 'https://bc.bdpowersectorerp.com:5533/Account/Login'
            ])->post('https://bc.bdpowersectorerp.com:5533/Account/Login', [
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
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'User-Agent' => 'Mozilla/5.0',
            'Referer' => 'https://bc.bdpowersectorerp.com:5533'
        ])->post('https://bc.bdpowersectorerp.com:5533/api/erpemployee/get-all', $data);

        if (empty($dataResponse->json()['data'])) {
            return redirect()->back()->withErrors([
                'erp_id' => $request->input('erp_id') . ' ' . 'is not valid ERP ID'
            ])->withInput();
        } else {
            $validated = $request->validate([
                'erp_id' => 'required|integer|unique:officers,erp_id',
                'name' => 'required|string|max:255',
                'designation' => 'required|in:AD,SAD,DD',
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
                'password' => Hash::make($request->input('password'))
            ]);
            return redirect()->back()->with([
                'name' => $request->input('name'),
                'erp_id' => $request->input('erp_id'),
                'designation' => $request->input('designation'),
                'role' => $request->input('role')
            ]);
        }
    }

    public function loginOfficer(Request $request)
    {
        $validated = $request->validate([
            'erp_id' => 'required|integer',
            'password' => [
                'required',
                'string',
                'max:15',
                'regex:/[@$!%*#?&]/',
            ]
        ], [
            'password.max' => 'Password cannot be longer than 15 characters',
            'password.regex' => 'Password must contain at least one special character',
        ]);

        $officer = Officer::where('erp_id', $validated['erp_id'])->first();

        if (!$officer || !Hash::check($validated['password'], $officer->password)) {
            return redirect()->back()
                ->withErrors(['erp_id' => 'Invalid ERP ID or password'])
                ->withInput();
        } else {
            return redirect()->back()->with([
                'erp_id' => $validated['erp_id'],
                'password' => $validated['password']
            ])->withCookie(cookie('user_token', $validated['erp_id'], 10, '/', null, true, true));
        }
    }

    public function showAddPensionerSection()
    {
        return view('addpensioner');
    }
}
