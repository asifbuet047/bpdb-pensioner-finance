<?php

use App\Http\Controllers\OfficerController;
use App\Http\Controllers\PensionerController;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

use function Pest\Laravel\withHeaders;

Route::get('/pensioners', [PensionerController::class, 'showAllPensioner']);

Route::get('/officers', [OfficerController::class, 'showAllOfficer']);

Route::get('/auth', function (Request $request) {
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
            'username' => 'BPDBAdmin',
            'password' => 'CompanyAdmin@123',
            '__RequestVerificationToken' => $csrfToken
        ]);

    $data = [
        "page" => 1,
        "PageSize" => 18,
        "searchModel" => [
            "columnFilter" => [
                [
                    "columnName" => "code",
                    "columnValue" => $request->query('erp_id'),
                    "columnValueType" => "string"
                ]
            ]
        ]
    ];

    $dataResponse = Http::withOptions(['cookies' => $jar, 'verify' => false])->withHeaders([
        'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
        'User-Agent' => 'Mozilla/5.0',
        'Referer' => 'https://bc.bdpowersectorerp.com:5533'
    ])->post('https://bc.bdpowersectorerp.com:5533/api/erpemployee/get-all', [
        "page" => 1,
        "PageSize" => 18,
        "searchModel" => [
            "columnFilter" => [
                [
                    "columnName" => "code",
                    "columnValue" => $request->query('erp_id'),
                    "columnValueType" => "string"
                ]
            ]
        ]
    ]);



    return response()->json([
        'data' => $dataResponse->json()['data']
    ]);
});
