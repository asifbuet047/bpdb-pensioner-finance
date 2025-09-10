<?php

namespace App\Http\Controllers;

use App\Models\Officer;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class OfficerController extends Controller
{
    public function addOfficerIntoDB(Request $request)
    {
        try {
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
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Officer creation unsuccessful',
                'data' => []
            ]);
        }


        $newOfficer = Officer::create($validated);

        return response()->json(['status' => true, 'message' => 'Officer creation successful', 'data' => $newOfficer], 201);
    }


    public function getOfficerFromDB(Request $request) {}

    public function showAllOfficer()
    {
        return response()->json(['status' => true, 'message' => 'All officer info retrived successfull', 'data' => Officer::all()]);
    }
}
