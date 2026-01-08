<?php

namespace App\Http\Controllers;

use App\Services\GpCmpSmsService;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    protected GpCmpSmsService $sms;

    public function __construct(GpCmpSmsService $sms)
    {
        $this->sms = $sms;
    }

    public function sendSingleSms(Request $request)
    {
        $validated = $request->validate([
            'msisdn' => ['required', 'regex:/^01[3-9]\d{8}$/'],
            'message' => ['required', 'string', 'max:1000'],
            'cli' => ['required', 'string', 'max:20'],
        ]);
        $response = $this->sms->sendSingle(
            $validated['msisdn'],
            $validated['message'],
            'GP ICT'
        );

        return response()->json($response);
    }

    public function sendBulkSms(Request $request)
    {
        $validated = $request->validate([
            'numbers' => ['required', 'array', 'min:1', 'max:999'],
            'numbers.*' => ['required', 'regex:/^01[3-9]\d{8}$/'],
            'message' => ['required', 'string', 'max:1000'],
        ]);

        $response = $this->sms->sendBulk(
            $validated['numbers'],
            $validated['message'],
        );

        return response()->json($response);
    }

    public function checkBalance()
    {
        $response = $this->sms->checkBalance();
        if (($response['statusInfo']['statusCode'] === '1000') && ($response['statusInfo']['errordescription'] === 'Success')) {
            return response()->json([
                'status' => true,
                'message' => 'Check balance is successful',
                'data' => [
                    'tanxId' => $response['statusInfo']['clienttransid'],
                    'balanceInTaka' => (float) $response['statusInfo']['availablebalance'] / 100.00
                ]
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Check balance is unsuccessful',
                'data' => []
            ]);
        }
    }

    public function delivery()
    {
        return response()->json(
            $this->sms->checkDelivery(
                ['01301027976'],
                'GP ICT',
                'GP20230327122340-01313704545-1332116341679898220785308'
            )
        );
    }

    public function logs(Request $request) {}
}
