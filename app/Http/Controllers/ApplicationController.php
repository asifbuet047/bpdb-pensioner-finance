<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\Officer;
use App\Models\Pensioner;
use App\Models\PensionerCredential;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class ApplicationController extends Controller
{
    public function showLoginPage(Request $request)
    {
        if ($request->query('type') === 'officer') {
            return view('login');
        } else {
            return view('loginpensioner');
        }
    }



    public function showHomePage(Request $request)
    {
        $erp_id = $request->cookie('user_id');
        $user_type = $request->cookie('user_type');
        if ($user_type === 'officer') {
            $officer = Officer::with(['role', 'designation', 'office'])->where('erp_id', '=', $erp_id)->first();
            if ($officer) {
                $officer_role = $officer->role->role_name;
                $officer_name = $officer->name;
                $officer_office = $officer->office->name_in_english;
                $officer_office_code = $officer->office->office_code;
                $officer_designation = $officer->designation->description_english;
                switch ($officer_role) {
                    case "super_admin":
                        $officeCount = Office::count();
                        $officerCount = Officer::count();
                        $pensionerCount = Pensioner::count();
                        $paymentOfficeCount = Office::where('is_payment_office', '=', true)->count();
                        return view('dashboard', compact('officeCount', 'officerCount', 'pensionerCount', 'paymentOfficeCount', 'officer_designation', 'officer_role', 'officer_name', 'officer_office'));
                        break;
                    case "admin":
                        $pensionerCount = Pensioner::count();
                        return view('dashboard', compact('pensionerCount'));
                        break;
                    case "approver":
                        $officeCount = Office::count();
                        $officerCount = Officer::count();
                        $pensionerCount = Pensioner::count();
                        $paymentOfficeCount = Office::where('is_payment_office', '=', true)->count();
                        $designation = Officer::with('designation')->where('erp_id', $request->cookie('user_id'))->first();
                        return view('dashboard', compact('officeCount', 'officerCount', 'pensionerCount', 'paymentOfficeCount', 'designation'));
                        break;
                    case "certifier":
                        $officer_office_id = $officer->office->id;
                        $office_ids = Office::where('payment_office_code', $officer_office_code)->pluck('id');
                        $pensionerCount = Pensioner::whereIn('office_id', $office_ids)->get()->count();
                        $officers = Officer::where('office_id', $officer_office_id)->get();
                        $officerCount = $officers->count();
                        $unitOffices = Office::where('payment_office_code', $officer->office->office_code)->get();
                        $unitofficeCount = $unitOffices->count();
                        return view('dashboard', compact('pensionerCount', 'officerCount', 'unitofficeCount', 'officer_designation', 'officer_role', 'officer_name', 'officer_office'));
                        break;
                    case "initiator":
                        $officer_office_id = $officer->office->id;
                        $office_ids = Office::where('payment_office_code', $officer_office_code)->pluck('id');
                        $pensionerCount = Pensioner::whereIn('office_id', $office_ids)->get()->count();
                        $officers = Officer::where('office_id', $officer_office_id)->get();
                        $officerCount = $officers->count();
                        $unitOffices = Office::where('payment_office_code', $officer->office->office_code)->get();
                        $unitofficeCount = $unitOffices->count();
                        return view('dashboard', compact('pensionerCount', 'officerCount', 'unitofficeCount', 'officer_designation', 'officer_role', 'officer_name', 'officer_office'));
                        break;
                    default:
                        return view('login');
                        break;
                }
            } else {
                Cookie::queue(Cookie::forget('user_id'));
                Cookie::queue(Cookie::forget('user_type'));
                return view('login');
            }
        } else if ($user_type === 'pensioner') {
            $erp_id = $request->cookie('user_id');
            $name = $request->cookie('user_name');
            $pensionerDetails = Pensioner::where('erp_id', $erp_id)->with('office')->first();
            return view('dashboardpensioner', compact('erp_id', 'name', 'pensionerDetails'));
        } else {
            return view('login');
        }
    }

    public function logout()
    {
        Cookie::queue(Cookie::forget('user_id'));
        Cookie::queue(Cookie::forget('user_type'));
        return redirect()->route('login.page', ['type' => 'officer']);
    }

    public function showAddOfficerSection()
    {
        return view('addvalidofficer');
    }

    public function showAddofficeSection()
    {
        return view('addoffice');
    }

    public function showAddPensionerByErpSection(Request $request)
    {
        $erp_id = $request->cookie('user_id');
        $officer = Officer::with(['role', 'designation', 'office'])->where('erp_id', '=', $erp_id)->first();
        if ($officer) {
            $officer_role = $officer->role->role_name;
            $officer_name = $officer->name;
            $officer_office = $officer->office->name_in_english;
            $officer_designation = $officer->designation->description_english;
            if (($officer_role === 'initiator' || ($officer_role === 'super_admin'))) {
                return view('addpensionerbyerp', compact('officer_designation', 'officer_role', 'officer_name', 'officer_office'));
            } else {
                return view('accessdeniedpage', compact('officer_designation', 'officer_role', 'officer_name', 'officer_office'));
            }
        } else {
            return view('login');
        }
    }

    public function showAddPensionerByFillingFormSection(Request $request)
    {
        $offices = Office::all();
        $erp_id = $request->cookie('user_id');
        $officer = Officer::with(['role', 'designation', 'office'])->where('erp_id', '=', $erp_id)->first();
        if ($officer) {
            $officer_role = $officer->role->role_name;
            $officer_name = $officer->name;
            $officer_office = $officer->office->name_in_english;
            $officer_designation = $officer->designation->description_english;
            $latest_erp = (int)Officer::latest()->first()->value('erp_id');
            if (($officer_role === 'initiator') || ($officer_role === 'super_admin')) {
                $offices = Office::get();
                $pensioner_info = [
                    // ERP / Identity
                    'erp_id' => $latest_erp + 1,
                    'name' => '',
                    'name_bangla' => '',
                    'register_no' => '',

                    // Office & Designation
                    'designation' => '',
                    'office_id' => '',
                    'office' => '',

                    // Dates
                    'birth_date' =>  '',
                    'joining_date' =>  '',
                    'prl_start_date' =>  '',
                    'prl_end_date' =>  '',
                    'service_life' => '',

                    // Contact
                    'phone_number' => '',
                    'email' => '',
                    'nid' =>  '',

                    // Financial 
                    'last_basic_salary' => '',
                    // Bank info (NOT in response)
                    'bank_name' => '',
                    'bank_branch_name' => '',
                    'bank_routing_number' => '',
                    'account_number' =>  '',

                    // Family info (partially available)
                    'father_name' => '',
                    'mother_name' => '',
                    'spouse_name' => '',

                    // Pension flags
                    'is_self_pension' => '',
                    'status' => '',
                    'verified' => '',
                    'biometric_verified' => '',
                    'biometric_verification_type' => '',

                    'pension_payment_order' => '',
                ];
                return view('addpensionerbyform', compact('offices', 'pensioner_info', 'officer_designation', 'officer_role', 'officer_name', 'officer_office'));
            } else {
                return view('accessdeniedpage', compact('officer_designation', 'officer_role', 'officer_name', 'officer_office'));
            }
        } else {
            return view('login');
        }
    }

    public function showAddPensionerVariantSection(Request $request)
    {
        $erp_id = $request->cookie('user_id');
        $officer = Officer::with(['role', 'designation', 'office'])->where('erp_id', '=', $erp_id)->first();
        if ($officer) {
            $officer_role = $officer->role->role_name;
            $officer_name = $officer->name;
            $officer_office = $officer->office->name_in_english;
            $officer_designation = $officer->designation->description_english;
            if (($officer_role === 'initiator' || ($officer_role === 'super_admin'))) {
                return view('addpensioner', compact('officer_designation', 'officer_role', 'officer_name', 'officer_office'));
            } else {
                return view('accessdeniedpage', compact('officer_designation', 'officer_role', 'officer_name', 'officer_office'));
            }
        } else {
            return view('login');
        }
    }

    public function showOfficerSearchSection(Request $request)
    {
        $erp_id = $request->cookie('user_id');
        $officer = Officer::with(['role', 'designation', 'office'])->where('erp_id', '=', $erp_id)->first();
        if ($officer) {
            $officer_role = $officer->role->role_name;
            $officer_name = $officer->name;
            $officer_office = $officer->office->name_in_english;
            $officer_designation = $officer->designation->description_english;
            if (($officer_role === 'initiator' || ($officer_role === 'super_admin'))) {
                return view('searchofficer', compact('officer_designation', 'officer_role', 'officer_name', 'officer_office'));
            } else {
                return view('accessdeniedpage', compact('officer_designation', 'officer_role', 'officer_name', 'officer_office'));
            }
        } else {
            return view('login');
        }
    }

    public function showPensionerSearchSection(Request $request)
    {
        $erp_id = $request->cookie('user_id');
        $officer = Officer::with(['role', 'designation', 'office'])->where('erp_id', '=', $erp_id)->first();
        if ($officer) {
            $officer_role = $officer->role->role_name;
            $officer_name = $officer->name;
            $officer_office = $officer->office->name_in_english;
            $officer_designation = $officer->designation->description_english;
            if (($officer_role === 'initiator' || ($officer_role === 'super_admin'))) {
                return view('searchpensioner', compact('officer_designation', 'officer_role', 'officer_name', 'officer_office'));
            } else {
                return view('accessdeniedpage', compact('officer_designation', 'officer_role', 'officer_name', 'officer_office'));
            }
        } else {
            return view('login');
        }
    }

    public function showUpdatePensionerSection(Request $request)
    {
        $erp_id = $request->cookie('user_id');
        $officer = Officer::with(['role', 'designation', 'office'])->where('erp_id', '=', $erp_id)->first();
        if ($officer) {
            $officer_role = $officer->role->role_name;
            $officer_name = $officer->name;
            $officer_office = $officer->office->name_in_english;
            $officer_designation = $officer->designation->description_english;
            if ($officer_role === 'initiator') {
                $id = (int)$request->route('id');
                $pensioner = Pensioner::with('office')->find($id);
                $offices = Office::orderBy('officeCode')->get();
                if ($pensioner) {
                    return view('updatepensioner', compact('pensioner', 'offices', 'officer_designation', 'officer_role', 'officer_name', 'officer_office'));
                } else {
                    return response()->json(['id' => $id]);
                }
            } else {
                return view('accessdeniedpage', compact('officer_designation', 'officer_role', 'officer_name', 'officer_office'));
            }
        } else {
            return view('login');
        }
    }
    public function showUpdateOfficerSection(Request $request)
    {
        $erp_id = $request->cookie('user_id');
        $officer = Officer::with(['role', 'designation', 'office'])->where('erp_id', '=', $erp_id)->first();
        if ($officer) {
            $officer_role = $officer->role->role_name;
            $officer_name = $officer->name;
            $officer_office = $officer->office->name_in_english;
            $officer_designation = $officer->designation->description_english;
            if ($officer_role === 'super_admin') {
                $id = (int)$request->route('id');
                $officer = Officer::with(['role', 'designation', 'office'])->find($id);
                return view('updateofficer', compact('officer', 'officer_designation', 'officer_role', 'officer_name', 'officer_office'));
            } else {
                return view('accessdeniedpage', compact('officer_designation', 'officer_role', 'officer_name', 'officer_office'));
            }
        } else {
            return view('login');
        }
    }

    public function login(Request $request)
    {
        if ($request->query('type') === 'officer') {
            $validated = $request->validate([
                'erp_id' => 'required|integer',
                'password' => [
                    'required',
                    'string',
                    'max:15',
                    'regex:/[@$!%*#?&]/',
                ]
            ], [
                'password.max' => 'Password cannot be longer than 15 characters',
                'password.regex' => 'Password must contain at least one special character',
            ]);

            $officer = Officer::with(['designation', 'office', 'role'])->where('erp_id', $validated['erp_id'])->first();

            if (!$officer) {
                return redirect()->back()
                    ->withErrors(['erp_id' => 'Your ERP no as Officer is not register in our database. Please register first then log in'])
                    ->withInput();
            } else if (!Hash::check($validated['password'], $officer->password)) {
                return redirect()->back()
                    ->withErrors(['erp_id' => 'Password mismatched please try again'])
                    ->withInput();
            } else {
                return redirect()->back()->with([
                    'erp_id' => $validated['erp_id'],
                    'password' => $validated['password']
                ])->withCookies([cookie('user_id', $officer->erp_id, 10, '/', null, false, true), cookie('user_type', 'officer', 10, '/', null, false, true)]);
            }
        } else {
            $validated = $request->validate([
                'erp_id' => 'required|integer',
                'password' => [
                    'required',
                    'string',
                    'max:15',
                ]
            ], [
                'password.max' => 'Password cannot be longer than 15 characters',
            ]);

            $pensioner = Pensioner::where('erp_id', $validated['erp_id'])->first();

            if (!$pensioner) {
                return redirect()->back()
                    ->withErrors(['erp_id' => 'Please talk to Your RAO office for registration as pensioner'])
                    ->withInput();
            }
            $pensioner_credential = PensionerCredential::where('pensioner_id', $pensioner->id)->first();

            if ($pensioner_credential) {
                if (!Hash::check($validated['password'], $pensioner_credential->password)) {
                    return redirect()->back()
                        ->withErrors(['password' => 'Password mismatched please try again'])
                        ->withInput();
                } else {
                    return redirect()->back()->with([
                        'erp_id' => $validated['erp_id'],
                        'password' => $validated['password']
                    ])->withCookies([cookie('user_id', $pensioner->erp_id, 10, '/', null, false, true), cookie('user_type', 'pensioner', 10, '/', null, false, true), cookie('user_name', $pensioner->name, 10, '/', null, false, true), cookie('user_designation', $pensioner->designation, 10, '/', null, false, true)]);
                }
            } else {
                return redirect()->back()
                    ->withErrors(['password' => 'You do not set password yet'])
                    ->withInput();
            }
        }
    }

    public function showSetPasswordForPensionerPage(Request $request)
    {
        return view('setpasswordforpensioner');
    }
}
