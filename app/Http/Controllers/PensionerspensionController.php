<?php

namespace App\Http\Controllers;

use App\Models\Officer;
use App\Models\Pension;
use App\Models\Pensioner;
use App\Models\Pensionerspension;
use Illuminate\Http\Request;

class PensionerspensionController extends Controller
{
    public function savePensionBlockingStatus(Request $request)
    {
        $erp_id = $request->cookie('user_id');
        $pensionId = $request->input('pension_id');
        $pensionerId = $request->input('pensioner_id');
        $block = $request->boolean('block', false);
        $message = $request->input('message');
        $officer = Officer::with(['role', 'designation', 'office'])->where('erp_id', '=', $erp_id)->first();
        $pension = Pension::find($pensionId);
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
        if (!$pension) {
            return response()->json([
                'success' => false,
                'message' => 'No valid pension',
                'data' => []
            ], 404);
        }

        $pensionerspension = Pensionerspension::where('pension_id', $pensionId)->where('pensioner_id', $pensionerId)->first();

        if (!$pensionerspension) {
            return response()->json([
                'success' => false,
                'message' => 'No valid pensionerspension',
                'data' => []
            ], 405);
        }

        $pensionerspension->update([
            'is_block' => $block,
            'message' => $message
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pensioners pension successfully updated with block comment',
            'data' => $pensionerspension
        ], 200);
    }
}
