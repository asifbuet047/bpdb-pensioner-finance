<?php

namespace App\Http\Controllers;

use App\Models\Pensioner;
use Illuminate\Http\Request;


class PensionerController extends Controller
{
    public function addPensionerIntoDB(Request $request)
    {

        if ($request->hasCookie('user_token')) {
            $validated = $request->validate([
                'erp_id'           => 'required|integer|unique:pensioners,erp_id',
                'name'             => 'required|string|max:255',
                'register_no'      => 'required|string|max:50|unique:pensioners,register_no',
                'basic_salary'     => 'required|integer|min:0',
                'medical_allowance' => 'required|integer|min:0',
                'incentive_bonus'  => 'required|numeric|min:0',
                'bank_name'        => 'required|string|max:255',
                'account_number'   => 'required|string|max:255|unique:pensioners,account_number',
            ]);

            $pensioner = Pensioner::create($validated);

            return redirect()->back()->with($validated);
        } else {
            return view('login');
        }
    }

    public function showAllPensioner()
    {
        return response()->json(['status' => true, 'message' => 'All pensioner info retrived successfull', 'data' => Pensioner::all()]);
    }
}
