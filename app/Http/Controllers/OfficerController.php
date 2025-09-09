<?php

namespace App\Http\Controllers;

use App\Models\Officer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
}
