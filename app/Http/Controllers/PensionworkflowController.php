<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\Officer;
use App\Models\Pension;
use App\Models\Pensioner;
use App\Models\Pensionerworkflow;
use App\Models\Pensionworkflow;
use Illuminate\Http\Request;

class PensionworkflowController extends Controller
{
    public function showPensionWorkflow(Request $request)
    {
        $erp_id = $request->cookie('user_id');
        $pension_id = $request->query('id');
        $officer = Officer::with(['role', 'designation', 'office'])->where('erp_id', '=', $erp_id)->first();
        if ($officer) {
            $officer_role = $officer->role->role_name;
            $officer_name = $officer->name;
            $officer_office = $officer->office->name_in_english;
            $officer_designation = $officer->designation->description_english;

            $pension_workflows = Pensionworkflow::with(['pension', 'officer'])->where('pension_id', $pension_id)->orderBy('created_at', 'asc')->get();
            if ($pension_workflows) {
                return view('viewpensionapprovalworkflow', compact('pension_workflows', 'pension_id', 'officer_designation', 'officer_role', 'officer_name', 'officer_office'));
            } else {
                return view('login');
            }
        } else {
            return view('login');
        }
    }

    public function initiatePensionWorkflow(Request $request)
    {
        $erp_id = $request->cookie('user_id');
        $workflow_type = $request->input('workflow', 'forward');
        $id = $request->input('id', '1');
        $message = $request->input('message');

        $officer = Officer::with(['role', 'designation', 'office'])->where('erp_id', '=', $erp_id)->first();
        $pension = Pension::find($id);

        if (!$erp_id) {
            return response()->json(['status' => false, 'message' => 'please login', 'data' => []], 401);
        }

        if (!$officer) {
            return response()->json(['status' => false, 'message' => 'no valid officer', 'data' => []], 402);
        }

        if (!$pension) {
            return response()->json(['status' => false, 'message' => 'No pension is genereted under this id', 'data' => []], 403);
        }

        switch ($workflow_type) {
            case 'forward':
                if ($pension->status === 'floated') {
                    if ($officer->role->role_name !== 'initiator') {
                        return response()->json([
                            'success' => false,
                            'message' => 'Officer is not initiator'
                        ], 403);
                    }

                    Pensionworkflow::create([
                        'pension_id' => $id,
                        'officer_id' => $officer->id,
                        'status_from' => 'floated',
                        'status_to' => 'initiated',
                        'message' => $message
                    ]);

                    $pension->update(['status' => 'initiated']);

                    return response()->json([
                        'success' => true,
                        'message' => $pension->id . ' is successfully initiated'
                    ], 200);
                }

                if ($pension->status === 'initiated') {

                    if ($officer->role->role_name !== 'certifier') {
                        return response()->json([
                            'success' => false,
                            'message' => 'Officer is not certifier'
                        ], 403);
                    }

                    Pensionworkflow::create([
                        'pension_id' => $id,
                        'officer_id' => $officer->id,
                        'status_from' => 'initiated',
                        'status_to' => 'certified',
                        'message' => $message
                    ]);

                    $pension->update(['status' => 'certified']);

                    return response()->json([
                        'success' => true,
                        'message' => $pension->id . ' is successfully certified'
                    ], 200);
                }

                return response()->json([
                    'success' => false,
                    'message' => 'Invalid pension status for forward workflow'
                ], 422);
                break;

            case 'return':
                if ($pension->status === 'initiated') {
                    if ($officer->role->role_name !== 'certifier') {
                        return response()->json([
                            'success' => false,
                            'message' => 'Officer is not certifier'
                        ], 403);
                    }

                    Pensionworkflow::create([
                        'pension_id' => $id,
                        'officer_id' => $officer->id,
                        'status_from' => 'initiated',
                        'status_to' => 'floated',
                        'message' => $message
                    ]);

                    $pension->update(['status' => 'floated']);

                    return response()->json([
                        'success' => true,
                        'message' => $pension->id . ' is successfully floated'
                    ], 200);
                }

                if ($pension->status === 'certified') {
                    if ($officer->role->role_name !== 'approver') {
                        return response()->json([
                            'success' => false,
                            'message' => 'Officer is not approver'
                        ], 403);
                    }

                    Pensionworkflow::create([
                        'pension_id' => $id,
                        'officer_id' => $officer->id,
                        'status_from' => 'certified',
                        'status_to' => 'initiated',
                        'message' => $message
                    ]);

                    $pension->update(['status' => 'initiated']);

                    return response()->json([
                        'success' => true,
                        'message' => $pension->id . ' is successfully initiated'
                    ], 200);
                }

                return response()->json([
                    'success' => false,
                    'message' => 'Invalid pension status for return workflow'
                ], 422);

                break;
            case 'approve':
                if ($pension->status !== 'certified') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Pension current status is not certified'
                    ], 422);
                }

                if ($officer->role->role_name !== 'approver') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Officer is not approver'
                    ], 403);
                }

                Pensionworkflow::create([
                    'pension_id' => $id,
                    'officer_id' => $officer->id,
                    'status_from' => 'certified',
                    'status_to' => 'approved',
                    'message' => $message
                ]);

                $pension->update(['status' => 'approved']);

                return response()->json([
                    'success' => true,
                    'message' => $pension->id . ' is successfully approved'
                ], 200);

                break;
        }
    }

    public function isPensionWorkflowExits(Request $request, $id)
    {
        $erp_id = $request->cookie('user_id');
        $officer = Officer::with(['role', 'designation', 'office'])->where('erp_id', '=', $erp_id)->first();
        $pension = Pension::find($id)->get();
        $pension_workflow_count = Pensionworkflow::where('pension_id', $id)->count();

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

        if (!$pension) {
            return response()->json([
                'success' => false,
                'message' => 'No valid pension',
                'data' => []
            ], 403);
        }
        if ($pension_workflow_count == 0) {
            return response()->json([
                'success' => true,
                'message' => 'Pension workflow number successfully retrived',
                'data' => 0
            ], 200);
        }

        return response()->json([
            'success' => true,
            'message' => 'Pension workflow number successfully retrived',
            'data' => $pension_workflow_count
        ], 200);
    }
}
