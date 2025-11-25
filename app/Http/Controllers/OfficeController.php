<?php

namespace App\Http\Controllers;

use App\Models\Office;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    public function addOfficeIntoDB(Request $request)
    {
        if ($request->cookie('user_role') === 'SUPER_ADMIN') {
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
        if ($request->cookie('user_role') === "SUPER_ADMIN") {
            $offices = Office::orderBy('office_code')->get();
            return view('viewoffices', compact('offices'));
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
