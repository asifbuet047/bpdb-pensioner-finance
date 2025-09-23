<?php

namespace App\Http\Controllers;

use App\Models\Pensioner;
use Illuminate\Http\Request;


class PensionerController extends Controller
{
    public function addPensionerIntoDB(Request $request)
    {

        if ($request->hasCookie('user_id')) {
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

    public function getAllPensionersFromDB(Request $request)
    {
        if ($request->hasCookie('user_id')) {
            $pensioners = Pensioner::orderBy('name')->get();
            return view('viewpensioner')->with(compact('pensioners'));
        } else {
            return view('login');
        }
    }

    public function removePensionerFromDB(Request $request)
    {
        if ($request->cookie('user_role') === 'SUPER_ADMIN') {;
            $id = (int)$request->input('id');
            $pensioner = Pensioner::find($id);
            if ($pensioner) {
                $pensioner->delete();
                $pensioners = Pensioner::orderBy('name')->get();
                return redirect()->route('show.pensioner.section')->with(compact('pensioners'));
            } else {
                return response()->json(['message' => $id]);
            }
        } else {
            return view('login');
        }
    }


    public function updatePensionerIntoDB(Request $request)
    {
        if ($request->cookie('user_role') === 'SUPER_ADMIN') {;
            $editedPensioner = $request->all();
            $exitingPensioner = Pensioner::find($editedPensioner['id']);
            if ($exitingPensioner) {
                $exitingPensioner->name = $editedPensioner['name'];
                $exitingPensioner->register_no = $editedPensioner['register_no'];
                $exitingPensioner->basic_salary = $editedPensioner['basic_salary'];
                $exitingPensioner->medical_allowance = $editedPensioner['medical_allowance'];
                $exitingPensioner->incentive_bonus = $editedPensioner['incentive_bonus'];
                $exitingPensioner->bank_name = $editedPensioner['bank_name'];
                $exitingPensioner->account_number = $editedPensioner['account_number'];
                $exitingPensioner->save();
                $pensioners = Pensioner::orderBy('name')->get();
                return redirect()->route('show.pensioner.section')->with(compact('pensioners'));
            } else {
                return response()->json(['message' => $editedPensioner['id']]);
            }
        } else {
            return view('login');
        }
    }
}
