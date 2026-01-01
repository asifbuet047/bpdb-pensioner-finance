<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\Officer;
use App\Models\Pensioner;
use App\Models\Pensionerworkflow;
use Illuminate\Http\Request;

class PensionerworkflowController extends Controller
{
    public function initiatePensionerWorkflow(Request $request)
    {
        $erp_id = $request->cookie('user_id');
        $workflow_type = $request->input('workflow', 'forward');
        $id = $request->input('id', '1');
        $message = $request->input('message');
        $officer = Officer::with(['role', 'designation', 'office'])->where('erp_id', '=', $erp_id)->first();
        $officer_office_code = $officer->office->office_code;
        $office_ids = Office::where('payment_office_code', $officer_office_code)->pluck('id');
        $pensioner = Pensioner::whereIn('office_id', $office_ids)->where('id', $id)->first();

        if (!$erp_id) {
            return response()->json(['message' => 'please login'], 401);
        }

        if (!$officer) {
            return response()->json(['message' => 'no valid officer'], 402);
        }

        if (!$pensioner) {
            return response()->json(['message' => 'Pensioner is not under Your RAO office'], 403);
        }

        switch ($workflow_type) {
            case 'forward':
                if ($pensioner->status === 'floated') {
                    if ($officer->role->role_name !== 'initiator') {
                        return response()->json([
                            'success' => false,
                            'message' => 'Officer is not initiator'
                        ], 403);
                    }

                    Pensionerworkflow::create([
                        'pensioner_id' => $pensioner->id,
                        'officer_id' => $officer->id,
                        'status_from' => 'floated',
                        'status_to' => 'initiated',
                        'message' => $message
                    ]);

                    $pensioner->update(['status' => 'initiated']);

                    return response()->json([
                        'success' => true,
                        'message' => $pensioner->name . ' is successfully initiated'
                    ], 200);
                }

                if ($pensioner->status === 'initiated') {

                    if ($officer->role->role_name !== 'certifier') {
                        return response()->json([
                            'success' => false,
                            'message' => 'Officer is not certifier'
                        ], 403);
                    }

                    Pensionerworkflow::create([
                        'pensioner_id' => $pensioner->id,
                        'officer_id' => $officer->id,
                        'status_from' => 'initiated',
                        'status_to' => 'certified',
                        'message' => $message
                    ]);

                    $pensioner->update(['status' => 'certified']);

                    return response()->json([
                        'success' => true,
                        'message' => $pensioner->name . ' is successfully certified'
                    ], 200);
                }

                return response()->json([
                    'success' => false,
                    'message' => 'Invalid pensioner status for forward workflow'
                ], 422);
                break;

            case 'return':
                if ($pensioner->status === 'initiated') {
                    if ($officer->role->role_name !== 'certifier') {
                        return response()->json([
                            'success' => false,
                            'message' => 'Officer is not certifier'
                        ], 403);
                    }

                    Pensionerworkflow::create([
                        'pensioner_id' => $pensioner->id,
                        'officer_id' => $officer->id,
                        'status_from' => 'initiated',
                        'status_to' => 'floated',
                        'message' => $message
                    ]);

                    $pensioner->update(['status' => 'floated']);

                    return response()->json([
                        'success' => true,
                        'message' => $pensioner->name . ' is successfully floated'
                    ], 200);
                }

                if ($pensioner->status === 'certified') {
                    if ($officer->role->role_name !== 'approver') {
                        return response()->json([
                            'success' => false,
                            'message' => 'Officer is not approver'
                        ], 403);
                    }

                    Pensionerworkflow::create([
                        'pensioner_id' => $pensioner->id,
                        'officer_id' => $officer->id,
                        'status_from' => 'certified',
                        'status_to' => 'initiated',
                        'message' => $message
                    ]);

                    $pensioner->update(['status' => 'initiated']);

                    return response()->json([
                        'success' => true,
                        'message' => $pensioner->name . ' is successfully initiated'
                    ], 200);
                }

                return response()->json([
                    'success' => false,
                    'message' => 'Invalid pensioner status for return workflow'
                ], 422);

                break;
            case 'approve':
                if ($pensioner->status !== 'certified') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Pensioner current status is not certified'
                    ], 422);
                }

                if ($officer->role->role_name !== 'approver') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Officer is not approver'
                    ], 403);
                }

                Pensionerworkflow::create([
                    'pensioner_id' => $pensioner->id,
                    'officer_id' => $officer->id,
                    'status_from' => 'certified',
                    'status_to' => 'approved',
                    'message' => $message
                ]);

                $pensioner->update(['status' => 'approved']);

                return response()->json([
                    'success' => true,
                    'message' => $pensioner->name . ' is successfully approved'
                ], 200);

                break;
        }
    }


    public function isPensionerWorkflowExits(Request $request, $id)
    {
        $erp_id = $request->cookie('user_id');
        $officer = Officer::with(['role', 'designation', 'office'])->where('erp_id', '=', $erp_id)->first();
        $officer_office_code = $officer->office->office_code;
        $office_ids = Office::where('payment_office_code', $officer_office_code)->pluck('id');
        $pensioner = Pensioner::whereIn('office_id', $office_ids)->where('id', $id)->first();
        $pensioner_workflow_count = Pensionerworkflow::where('pensioner_id', $id)->count();

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
                'message' => 'No valid officer',
                'data' => []
            ], 403);
        }
        if ($pensioner_workflow_count == 0) {
            return response()->json([
                'success' => true,
                'message' => 'Pensioner workflow number successfully retrived',
                'data' => 0
            ], 200);
        }

        return response()->json([
            'success' => true,
            'message' => 'Pensioner workflow number successfully retrived',
            'data' => $pensioner_workflow_count
        ], 200);
    }

    public function showPensionerWorkflow(Request $request)
    {
        $erp_id = $request->cookie('user_id');
        $pensioner_id = $request->query('id');
        $officer = Officer::with(['role', 'designation', 'office'])->where('erp_id', '=', $erp_id)->first();
        if ($officer) {
            $officer_role = $officer->role->role_name;
            $officer_name = $officer->name;
            $officer_office = $officer->office->name_in_english;
            $officer_designation = $officer->designation->description_english;
            $pensioner_workflows = Pensionerworkflow::with(['officer', 'pensioner'])->where('pensioner_id', $pensioner_id)->orderBy('created_at', 'asc')->get();
            if ($pensioner_workflows) {
                return view('viewpensionerapprovalworkflow', compact('pensioner_workflows', 'officer_designation', 'officer_role', 'officer_name', 'officer_office'));
            } else {
                return view('login');
            }
        } else {
            return view('login');
        }
    }
}
