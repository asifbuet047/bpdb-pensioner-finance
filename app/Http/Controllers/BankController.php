<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function getBankDetailsByRoutingNumber(Request $request)
    {
        $routing_number = $request->query('routing');
        $bank = Bank::where('routing_number', '=', $routing_number)->first();
        if ($bank) {
            return response()->json(['data' => $bank, 'status' => true], 200);
        } else {
            return response()->json(['data' => 'No record found', 'status' => false], 400);
        }
    }
}
