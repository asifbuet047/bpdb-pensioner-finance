<?php

namespace App\Http\Controllers;

use App\Models\Office;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    public function addOfficeIntoDB(Request $request) {}

    public function getAllOfficesFromDB(Request $request)
    {
        if ($request->cookie('user_role') === "SUPER_ADMIN") {
            $offices = Office::orderBy('officeName')->get();
            return view('viewoffices', compact('offices'));
        } else {
            return view('login');
        }
    }

    public function removeOfficeFromDB(Request $request) {}

    public function updateOfficeIntoDB(Request $request) {}
}
