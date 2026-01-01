<?php

namespace App\Http\Controllers;

use App\Models\Officer;
use App\Models\Pension;
use App\Models\Pensioner;
use App\Models\Pensionerspension;
use App\Models\Pensionerspensionblockmessage;
use Illuminate\Http\Request;

class PensionerspensionController extends Controller
{
    public function savePensionBlockingStatus(Request $request)
    {
        $erp_id = $request->cookie('user_id');
        $pensionerId = $request->input('pensioner_id');
        $message = $request->input('message');
        $officer = Officer::with(['role', 'designation', 'office'])->where('erp_id', '=', $erp_id)->first();
        $blockmesg = Pensionerspensionblockmessage::where('id', $pensionerId)->first();
        $pensioner = Pensioner::find($pensionerId);

        if (!$erp_id) {
            return response()->json([
                'success' => false,
                'message' => 'Pleae login as valid officer',
                'data' => []
            ], 401);
        }

        if (!$officer) {
            return response()->json([
                'success' => false,
                'message' => 'No valid officer',
                'data' => []
            ], 402);
        }

        if (!$pensioner) {
            return response()->json([
                'success' => false,
                'message' => 'No valid pensioner',
                'data' => []
            ], 403);
        }

        if ($blockmesg) {
            return response()->json([
                'success' => false,
                'message' => $blockmesg->message,
                'data' => []
            ], 404);
        }

        $pensionerblockmessage = Pensionerspensionblockmessage::create([
            'id' => $pensionerId,
            'is_block' => true,
            'message' => $message
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pensioners pension block message successfully added',
            'data' => $pensionerblockmessage
        ], 200);
    }
}
