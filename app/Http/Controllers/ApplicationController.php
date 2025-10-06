<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\Officer;
use App\Models\Pensioner;
use App\Models\PensionerCredential;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use function Pest\Laravel\withCookie;

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
        if ($request->hasCookie('user_id')) {
            if ($request->cookie('user_role') === 'SUPER_ADMIN') {
                $officeCount = Office::count();
                $officerCount = Officer::count();
                $pensionerCount = Pensioner::count();
                return view('dashboard', compact('officeCount', 'officerCount', 'pensionerCount'));
            } else {
                $pensionerCount = Pensioner::count();
                return view('dashboard', compact('pensionerCount'));
            }
        } else {
            return view('login');
        }
    }

    public function logout()
    {
        Cookie::queue(Cookie::forget('user_id'));
        Cookie::queue(Cookie::forget('user_role'));
        Cookie::queue(Cookie::forget('user_name'));
        return redirect()->route('login.page', ['type' => 'officer']);
    }

    public function showAddOfficerSection()
    {
        $offices = Office::all();
        return view('addofficer', ['offices' => $offices]);
    }

    public function showAddofficeSection()
    {
        return view('addoffice');
    }

    public function showAddPensionerSection()
    {
        $offices = Office::all();
        return view('addpensioner', compact('offices'));
    }

    public function showUpdatePensionerSection(Request $request)
    {
        $id = (int)$request->route('id');
        $pensioner = Pensioner::with('office')->find($id);
        $offices = Office::orderBy('officeCode')->get();
        if ($pensioner) {
            return view('updatepensioner', compact('pensioner', 'offices'));
        } else {
            return response()->json(['id' => $id]);
        }
    }
    public function showUpdateOfficerSection(Request $request)
    {
        $id = (int)$request->route('id');
        $officer = Officer::with('office')->find($id);
        $offices = Office::all();
        if ($officer) {
            return view('updateofficer', compact('officer', 'offices'));
        } else {
            return response()->json(['id' => $id]);
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

            $officer = Officer::where('erp_id', $validated['erp_id'])->first();

            if (!$officer || !Hash::check($validated['password'], $officer->password)) {
                return redirect()->back()
                    ->withErrors(['erp_id' => 'Invalid ERP ID or password'])
                    ->withInput();
            } else {
                return redirect()->back()->with([
                    'erp_id' => $validated['erp_id'],
                    'password' => $validated['password']
                ])->withCookies([cookie('user_id', $validated['erp_id'], 10, '/', null, true, true), cookie('user_role', $officer->role, 10, '/', null, true, true), cookie('user_name', $officer->name, 10, '/', null, true, true)]);
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

            if (!Hash::check($validated['password'], $pensioner_credential->password)) {
                return redirect()->back()
                    ->withErrors(['password' => 'Password mismatch'])
                    ->withInput();
            } else {
                return redirect()->back()->with([
                    'erp_id' => $validated['erp_id'],
                    'password' => $validated['password']
                ])->withCookies([cookie('user_id', $validated['erp_id'], 10, '/', null, true, true), cookie('user_role', 'user', 10, '/', null, true, true), cookie('user_name', $pensioner->name, 10, '/', null, true, true)]);
            }
        }
    }
}
