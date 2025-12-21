<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\Officer;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    public function addOfficeIntoDB(Request $request)
    {
        if ($request->cookie('user_role') === "super_admin") {
            $validated = $request->validate([
                'office_name'              => 'required|string|max:255',
                'office_name_bangla'       => 'required|string|max:255',
                'office_code'              => 'required|string|max:50|unique:offices,officeCode',
            ]);

            $pensioner = Office::create([
                'officeName' => $validated['office_name'],
                'officeNameInBangla' => $validated['office_name_bangla'],
                'officeCode' => $validated['office_code']
            ]);
            return redirect()->back()->with($validated);
        } else {
            return view('login');
        }
    }

    public function getAllOfficesFromDB(Request $request)
    {
        $erp_id = $request->cookie('user_id');
        $officer = Officer::with(['role', 'designation', 'office'])->where('erp_id', '=', $erp_id)->first();
        if ($officer) {
            $officer_role = $officer->role->role_name;
            $officer_name = $officer->name;
            $officer_office = $officer->office->name_in_english;
            $officer_designation = $officer->designation->description_english;
            switch ($officer_role) {
                case 'super_admin':
                    $offices = Office::orderBy('office_code')->get();
                    return view('viewoffices', compact('offices', 'officer_designation', 'officer_role', 'officer_name', 'officer_office'));
                    break;
                default:
                    $offices = Office::where('payment_office_code', $officer->office->office_code)->get();
                    return view('viewoffices', compact('offices', 'officer_designation', 'officer_role', 'officer_name', 'officer_office'));
                    break;
            }
        } else {
            return view('login');
        }
    }

    public function getAllPaymentOfficesFromDB(Request $request)
    {
        $erp_id = $request->cookie('user_id');
        $officer = Officer::with(['role', 'designation', 'office'])->where('erp_id', '=', $erp_id)->first();
        if ($officer) {
            $officer_role = $officer->role->role_name;
            $officer_name = $officer->name;
            $officer_office = $officer->office->name_in_english;
            $officer_designation = $officer->designation->description_english;
            if ($officer_role === 'super_admin') {
                $offices = Office::where('is_payment_office', true)->orderBy('office_code')->get();
                return view('viewpaymentoffices', compact('offices', 'officer_designation', 'officer_role', 'officer_name', 'officer_office'));
            } else {
                return view('accessdeniedpage', compact('officer_designation', 'officer_role', 'officer_name', 'officer_office'));
            }
        } else {
            return view('login');
        }
    }

    public function getAllUnitOfficesFromDB(Request $request)
    {
        $erp_id = $request->cookie('user_id');
        $officer = Officer::with(['role', 'designation', 'office'])->where('erp_id', '=', $erp_id)->first();
        if ($officer) {
            $officer_role = $officer->role->role_name;
            $officer_name = $officer->name;
            $officer_office = $officer->office->name_in_english;
            $officer_designation = $officer->designation->description_english;
            if ($officer_role === 'super_admin') {
                $code = $request->query('code');
                $offices = Office::where('payment_office_code', '=', $code)->orderBy('office_code')->get();
                return view('viewunitoffices', compact('offices', 'code', 'officer_designation', 'officer_role', 'officer_name', 'officer_office'));
            } else {
                return view('accessdeniedpage', compact('officer_designation', 'officer_role', 'officer_name', 'officer_office'));
            }
        } else {
            return view('login');
        }
    }



    public function removeOfficeFromDB(Request $request) {}

    public function updateOfficeIntoDB(Request $request) {}

    public function search(Request $request)
    {
        $q = $request->get('q');
        return Office::where('name_in_english', 'LIKE', "%{$q}%")
            ->limit(10)
            ->get(['id', 'name_in_english']);
    }
}
