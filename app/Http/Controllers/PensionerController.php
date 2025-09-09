<?php

namespace App\Http\Controllers;

use App\Models\Pensioner;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;


class PensionerController extends Controller
{
    public function addPensionerIntoDB(Request $request)
    {
        try {
            $validated = $request->validate([
                'erp_id'           => 'required|integer|unique:pensioners,erp_id',
                'name'             => 'required|string|max:255',
                'register_no'      => 'required|string|max:50|unique:pensioners,register_no',
                'basic_salary'     => 'required|integer|min:0',
                'medical_allowance' => 'required|integer|min:0',
                'incentive_bonus'  => 'required|numeric|min:0',
                'bank_name'        => 'required|string|max:255',
                'account_number'   => 'required|string|max:255|unique:pensioners,account_number',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Pensioner creation unsuccessful',
                'data' => []
            ]);
        }

        $pensioner = Pensioner::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Pensioner created successfully',
            'data' => $pensioner
        ], 201);
    }

    public function showAllPensioner()
    {
        return response()->json(['status' => true, 'message' => 'All pensioner info retrived successfull', 'data' => Pensioner::all()]);
    }
}
