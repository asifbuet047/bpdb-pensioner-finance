<?php

namespace App\Http\Controllers;

use App\Models\Pensioner;
use App\Models\PensionerCredential;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PensionerCredentialController extends Controller
{
    public function addPensionerCredentialIntoDB(Request $request)
    {
        $validated = $request->validate([
            'erp_id' => 'required|integer',
            'password' => [
                'required',
                'string',
                'max:15',
                'confirmed'
            ]
        ], [
            'password.max' => 'Password cannot be longer than 15 characters',
        ]);

        $pensioner = Pensioner::where('erp_id', $validated['erp_id'])->first();

        if (!$pensioner) {
            return redirect()->back()
                ->withErrors(['erp_id' => 'Please talk to Your RAO office for registration as pensioner'])
                ->withInput();
        } else {
            $pensioner_credentail = PensionerCredential::create([
                'pensioner_id' => $pensioner->id,
                'password' => Hash::make($validated['password'])
            ]);

            return redirect()->back()->with(['erp_id' => $request->input('erp_id'), 'password' => $request->input('password')]);
        }
    }
}
