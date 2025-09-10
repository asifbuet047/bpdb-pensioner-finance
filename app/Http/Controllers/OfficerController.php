<?php

namespace App\Http\Controllers;

use App\Models\Officer;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class OfficerController extends Controller
{

    public function getOfficerFromDB(Request $request) {}

    public function showAllOfficer()
    {
        return response()->json(['status' => true, 'message' => 'All officer info retrived successfull', 'data' => Officer::all()]);
    }
}
