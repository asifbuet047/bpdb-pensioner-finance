<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function showLoginPage()
    {
        return view('login');
    }


    public function showHomePage(Request $request)
    {
        if ($request->hasCookie('user_token')) {
            return view('dashboard');
        } else {
            return view('login');
        }
    }

    public function showRegistrationPage(Request $request)
    {
        return view('registration');
    }

    public function completeOfficialRegistration(Request $request) {}
}
